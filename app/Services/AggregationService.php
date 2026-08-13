<?php

namespace App\Services;

use App\Models\Santri;
use App\Models\AktivitasHarian;
use App\Models\Pelanggaran;
use Carbon\Carbon;

class AggregationService
{
    /**
     * Mengambil raw data aktivitas dan mengonversinya menjadi metric
     * 
     * @param int $santriId
     * @param string $periode YYYY-MM
     * @return array
     */
    public function getMetrics(int $santriId, string $periode)
    {
        $startDate = Carbon::createFromFormat('Y-m', $periode)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m', $periode)->endOfMonth()->format('Y-m-d');

        // Ambil data absensi
        $aktivitas = AktivitasHarian::where('santri_id', $santriId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $totalHariAktif = $aktivitas->count();
        $totalKewajiban = $totalHariAktif; // 1 kewajiban per hari: Aktivitas Kehadiran (sekolah)

        $totalHadir = 0;
        $totalKeterlambatan = 0;

        foreach ($aktivitas as $akt) {
            if ($akt->sekolah == 'hadir') {
                $totalHadir++;
            } elseif ($akt->sekolah == 'terlambat') {
                $totalHadir++; // Tetap dihitung hadir secara fisik, tapi tercatat sebagai aktivitas keterlambatan
                $totalKeterlambatan++;
            }
        }

        $persentaseKehadiran = $totalKewajiban > 0 ? round(($totalHadir / $totalKewajiban) * 100, 2) : 100;

        // Ambil data pelanggaran
        $pelanggarans = Pelanggaran::where('santri_id', $santriId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $totalPelanggaranRingan = $pelanggarans->where('kategori', 'ringan')->count();
        $totalPelanggaranSedang = $pelanggarans->where('kategori', 'sedang')->count();
        $totalPelanggaranBerat = $pelanggarans->where('kategori', 'berat')->count();
        $totalPoinPelanggaran = $pelanggarans->sum('poin');

        return [
            'persentase_kehadiran' => $persentaseKehadiran,
            'total_keterlambatan' => $totalKeterlambatan,
            'total_pelanggaran_ringan' => $totalPelanggaranRingan,
            'total_pelanggaran_sedang' => $totalPelanggaranSedang,
            'total_pelanggaran_berat' => $totalPelanggaranBerat,
            'total_poin_pelanggaran' => $totalPoinPelanggaran
        ];
    }
}
