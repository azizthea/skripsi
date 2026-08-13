<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AturanRule;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            [
                'nama_rule' => 'Aktivitas Pelanggaran Berat Ditemukan',
                'prioritas' => 1,
                'hasil_kategori' => 'Tidak Disiplin',
                'kondisi_json' => [
                    'logic' => 'AND',
                    'conditions' => [
                        ['metric' => 'total_pelanggaran_berat', 'operator' => '>=', 'value' => 1]
                    ]
                ]
            ],
            [
                'nama_rule' => 'Tingkat Aktivitas Kehadiran Di Bawah Batas Minimal',
                'prioritas' => 2,
                'hasil_kategori' => 'Tidak Disiplin',
                'kondisi_json' => [
                    'logic' => 'AND',
                    'conditions' => [
                        ['metric' => 'persentase_kehadiran', 'operator' => '<', 'value' => 70]
                    ]
                ]
            ],
            [
                'nama_rule' => 'Aktivitas Kehadiran Sempurna Tanpa Pelanggaran Berarti',
                'prioritas' => 3,
                'hasil_kategori' => 'Sangat Disiplin',
                'kondisi_json' => [
                    'logic' => 'AND',
                    'conditions' => [
                        ['metric' => 'persentase_kehadiran', 'operator' => '>=', 'value' => 95],
                        ['metric' => 'total_pelanggaran_berat', 'operator' => '=', 'value' => 0],
                        ['metric' => 'total_pelanggaran_sedang', 'operator' => '=', 'value' => 0],
                        ['metric' => 'total_pelanggaran_ringan', 'operator' => '<=', 'value' => 1],
                        ['metric' => 'total_keterlambatan', 'operator' => '<=', 'value' => 2]
                    ]
                ]
            ],
            [
                'nama_rule' => 'Akumulasi Aktivitas Pelanggaran Sedang Terlampaui',
                'prioritas' => 4,
                'hasil_kategori' => 'Kurang Disiplin',
                'kondisi_json' => [
                    'logic' => 'AND',
                    'conditions' => [
                        ['metric' => 'total_pelanggaran_sedang', 'operator' => '>=', 'value' => 3]
                    ]
                ]
            ],
            [
                'nama_rule' => 'Frekuensi Aktivitas Keterlambatan Sangat Tinggi',
                'prioritas' => 5,
                'hasil_kategori' => 'Kurang Disiplin',
                'kondisi_json' => [
                    'logic' => 'AND',
                    'conditions' => [
                        ['metric' => 'total_keterlambatan', 'operator' => '>=', 'value' => 10]
                    ]
                ]
            ],
            [
                'nama_rule' => 'Aktivitas Disiplin Berada Pada Ambang Wajar',
                'prioritas' => 6,
                'hasil_kategori' => 'Disiplin',
                'kondisi_json' => [
                    'logic' => 'AND',
                    'conditions' => [
                        ['metric' => 'persentase_kehadiran', 'operator' => '>=', 'value' => 85],
                        ['metric' => 'total_pelanggaran_berat', 'operator' => '=', 'value' => 0],
                        ['metric' => 'total_pelanggaran_sedang', 'operator' => '<=', 'value' => 1],
                        ['metric' => 'total_keterlambatan', 'operator' => '<=', 'value' => 8]
                    ]
                ]
            ]
        ];

        foreach ($rules as $rule) {
            AturanRule::create($rule);
        }
    }
}
