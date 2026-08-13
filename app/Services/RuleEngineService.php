<?php

namespace App\Services;

use App\Models\AturanRule;

class RuleEngineService
{
    /**
     * Mengevaluasi metrics santri dengan IF-THEN JSON Rule Base (Forward Chaining)
     * 
     * @param array $metrics
     * @return array
     */
    public function evaluateRules(array $metrics)
    {
        // 1. Load all active rules, sorted by priority (1 is highest)
        $rules = AturanRule::where('is_active', true)
            ->orderBy('prioritas', 'asc')
            ->get();

        $triggeredRules = [];
        $finalCategory = null;

        // 2. Evaluate all rules
        foreach ($rules as $rule) {
            $eval = $this->evaluateJsonCondition($metrics, $rule->kondisi_json);
            
            if ($eval['is_matched']) {
                $triggeredRules[] = [
                    'id' => $rule->id,
                    'nama_rule' => $rule->nama_rule,
                    'prioritas' => $rule->prioritas,
                    'hasil_kategori' => $rule->hasil_kategori,
                    'trace' => $eval['trace'] // Include Explainability Trace
                ];

                if (is_null($finalCategory)) {
                    $finalCategory = $rule->hasil_kategori;
                }
            }
        }

        // Default fallback if no rules matched
        if (is_null($finalCategory)) {
            $finalCategory = 'Kurang Disiplin';
        }

        return [
            'kategori_sistem' => $finalCategory,
            'triggered_rules' => $triggeredRules,
        ];
    }

    /**
     * Mem-parsing dan mengevaluasi JSON Multi-Condition dan mengembalikan Trace Explainability
     */
    private function evaluateJsonCondition(array $metrics, array $json)
    {
        $logic = $json['logic'] ?? 'AND';
        $conditions = $json['conditions'] ?? [];

        if (empty($conditions)) {
            return ['is_matched' => false, 'trace' => []];
        }

        $results = [];
        $trace = [];
        
        foreach ($conditions as $cond) {
            $metricName = $cond['metric'];
            $operator = $cond['operator'];
            $targetValue = $cond['value'];

            $actualValue = isset($metrics[$metricName]) ? $metrics[$metricName] : null;
            $isMatched = $this->compare($actualValue, $operator, $targetValue);
            
            $results[] = $isMatched;
            
            $trace[] = [
                'metric' => $metricName,
                'condition' => "{$operator} {$targetValue}",
                'actual_value' => $actualValue,
                'status' => $isMatched ? 'MATCH' : 'NOT MATCH'
            ];
        }

        // Kombinasikan hasil dengan AND / OR
        $finalMatch = false;
        if (strtoupper($logic) === 'AND') {
            $finalMatch = !in_array(false, $results, true);
        } elseif (strtoupper($logic) === 'OR') {
            $finalMatch = in_array(true, $results, true);
        }

        return ['is_matched' => $finalMatch, 'trace' => $trace];
    }

    /**
     * Operator komparasi logika
     */
    private function compare($actual, $operator, $target)
    {
        switch ($operator) {
            case '>': return $actual > $target;
            case '<': return $actual < $target;
            case '>=': return $actual >= $target;
            case '<=': return $actual <= $target;
            case '=': 
            case '==': return $actual == $target;
            case '!=': return $actual != $target;
            case 'between': 
                return $actual >= $target[0] && $actual <= $target[1];
            default: return false;
        }
    }
    
    /**
     * Menghitung Skor Numerik sebagai Data Pendukung (BUKAN Penentu Utama)
     */
    public function calculateNumericScore(array $metrics)
    {
        // Pembobotan: Kehadiran (40%), Keterlambatan (20%), Pelanggaran (40% - dibagi ringan/sedang/berat)
        $scoreKehadiran = $metrics['persentase_kehadiran'] * 0.40;
        
        $scoreKeterlambatan = max(0, 100 - ($metrics['total_keterlambatan'] * 5)) * 0.20;
        
        $poinPelanggaran = ($metrics['total_pelanggaran_ringan'] * 5) + 
                           ($metrics['total_pelanggaran_sedang'] * 15) + 
                           ($metrics['total_pelanggaran_berat'] * 50);
        $scorePelanggaran = max(0, 100 - $poinPelanggaran) * 0.40;
        
        return round($scoreKehadiran + $scoreKeterlambatan + $scorePelanggaran, 2);
    }

    /**
     * Men-generate kalimat saran (Decision Support)
     */
    public function generateRecommendation(array $metrics, string $kategori)
    {
        $recs = [];
        
        if (in_array($kategori, ['Kurang Disiplin', 'Tidak Disiplin'])) {
            $recs[] = "Santri memerlukan pembinaan intensif atau panggilan orang tua.";
            
            if ($metrics['total_pelanggaran_berat'] >= 1) {
                $recs[] = "Monitoring ekstra atas kasus pelanggaran berat.";
            }
            if ($metrics['persentase_kehadiran'] < 80) {
                $recs[] = "Perlu teguran khusus terkait masalah absensi yang kronis.";
            }
            if ($metrics['total_keterlambatan'] >= 5) {
                $recs[] = "Manajemen waktu buruk, santri disarankan mengikuti bimbingan kedisiplinan pagi.";
            }
        } else {
            if ($kategori === 'Sangat Disiplin') {
                $recs[] = "Pertahankan! Santri layak direkomendasikan untuk penghargaan atau posisi ketua kamar.";
            } else {
                $recs[] = "Kondisi baik, teruskan pemantauan rutin.";
            }
        }
        
        return $recs;
    }
}
