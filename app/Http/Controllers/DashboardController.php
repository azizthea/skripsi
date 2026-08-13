<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Evaluasi;
use App\Models\Absensi;
use Illuminate\Http\Request;

/**
 * DashboardController
 *
 * Menampilkan dashboard analitik admin beserta:
 * - Summary Cards (total santri, total dievaluasi, rata-rata persentase)
 * - Pie Chart: distribusi kategori disiplin (Tinggi/Sedang/Rendah)
 * - Bar Chart: rata-rata persentase Pengajian vs Sekolah per kelas
 * - Live Feed: absensi terbaru yang diinput guru (real-time)
 * - Stats Hari Ini: Hadir/Izin/Alpa hari ini
 */
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));
        $today = now()->toDateString();

        // =============================================
        // 1. Summary Cards
        // =============================================
        $totalSantri = Santri::where('status', 'aktif')->count();

        $evaluasis = Evaluasi::with('santri')
            ->whereHas('santri', fn($q) => $q->where('status', 'aktif'))
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $totalEvaluasi = $evaluasis->count();

        $avgPengajian = $totalEvaluasi > 0
            ? round($evaluasis->avg('persentase_pengajian'), 2) : 0;
        $avgSekolah = $totalEvaluasi > 0
            ? round($evaluasis->avg('persentase_sekolah'), 2) : 0;

        // =============================================
        // 2. Distribusi Kategori (Pie Chart)
        // =============================================
        $distribusi = [
            'Tinggi' => $evaluasis->where('kategori_disiplin', 'Tinggi')->count(),
            'Sedang' => $evaluasis->where('kategori_disiplin', 'Sedang')->count(),
            'Rendah' => $evaluasis->where('kategori_disiplin', 'Rendah')->count(),
        ];

        // =============================================
        // 3. Data per Kelas (Bar Chart)
        // =============================================
        $kelasAverages = [];
        foreach ($evaluasis as $eval) {
            if ($eval->santri) {
                $kelas = $eval->santri->kelas;
                if (!isset($kelasAverages[$kelas])) {
                    $kelasAverages[$kelas] = ['pengajian_total' => 0, 'sekolah_total' => 0, 'count' => 0];
                }
                $kelasAverages[$kelas]['pengajian_total'] += $eval->persentase_pengajian;
                $kelasAverages[$kelas]['sekolah_total']   += $eval->persentase_sekolah;
                $kelasAverages[$kelas]['count']++;
            }
        }

        $kelasLabels = $kelasPengajianData = $kelasSekolahData = [];
        foreach ($kelasAverages as $kelas => $data) {
            $kelasLabels[]        = $kelas;
            $kelasPengajianData[] = round($data['pengajian_total'] / $data['count'], 2);
            $kelasSekolahData[]   = round($data['sekolah_total']   / $data['count'], 2);
        }

        // =============================================
        // 4. Statistik Absensi Bulan Ini
        // =============================================
        $totalAbsensi = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->count();

        // =============================================
        // 5. Santri per kategori (untuk modal onclick)
        // =============================================
        $santriPerKategori = [
            'Tinggi' => $evaluasis->where('kategori_disiplin', 'Tinggi')->map(fn($e) => $e->santri)->filter(),
            'Sedang' => $evaluasis->where('kategori_disiplin', 'Sedang')->map(fn($e) => $e->santri)->filter(),
            'Rendah' => $evaluasis->where('kategori_disiplin', 'Rendah')->map(fn($e) => $e->santri)->filter(),
        ];

        // =============================================
        // 6. LIVE FEED & EWS (Sesuai Role)
        // =============================================
        $role = auth()->user()->role;
        $kegiatanFilter = [];
        if ($role === 'bk') {
            $kegiatanFilter = ['Sekolah Formal'];
        } elseif ($role === 'pengurus') {
            $kegiatanFilter = ['Pengajian', 'Tahfidz'];
        }

        $liveFeedQuery = Absensi::with('santri')->orderBy('created_at', 'desc')->limit(15);
        if (!empty($kegiatanFilter)) {
            $liveFeedQuery->whereIn('jenis_kegiatan', $kegiatanFilter);
        }
        $liveFeed = $liveFeedQuery->get();

        // Data EWS Pengurus (Dari Evaluasi yang dikirim)
        $ewsPengurus = [];
        if (in_array($role, ['admin', 'pengurus'])) {
            $ewsPengurus = \App\Models\Evaluasi::with('santri')
                ->where('bulan', $bulan)->where('tahun', $tahun)
                ->where('is_sent_to_pengurus', true)
                ->get();
        }

        // Data EWS BK (Dari Evaluasi yang dikirim)
        $ewsBK = [];
        if (in_array($role, ['admin', 'bk'])) {
            $ewsBK = \App\Models\Evaluasi::with('santri')
                ->where('bulan', $bulan)->where('tahun', $tahun)
                ->where('is_sent_to_bk', true)
                ->get();
        }

        // =============================================
        // 7. STATS HARI INI (real-time)
        // =============================================
        $absensiHariIniQuery = Absensi::whereDate('tanggal', $today);
        if (!empty($kegiatanFilter)) {
            $absensiHariIniQuery->whereIn('jenis_kegiatan', $kegiatanFilter);
        }
        $absensiHariIni = $absensiHariIniQuery->get();
        $hadirHariIni      = $absensiHariIni->where('status', 'Hadir')->count();
        $izinHariIni       = $absensiHariIni->where('status', 'Izin')->count();
        $sakitHariIni      = $absensiHariIni->where('status', 'Sakit')->count();
        $alpaHariIni       = $absensiHariIni->where('status', 'Alpa')->count();
        $totalAbsenHariIni = $absensiHariIni->count();

        // Nama bulan Indonesia
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April',   5 => 'Mei',      6 => 'Juni',
            7 => 'Juli',    8 => 'Agustus',  9 => 'September',
            10 => 'Oktober',11 => 'November',12 => 'Desember',
        ];
        $periodeTeks = ($namaBulan[(int)$bulan] ?? '') . ' ' . $tahun;

        if ($role === 'bk') {
            return view('dashboard_bk', compact(
                'bulan', 'tahun', 'periodeTeks', 'today',
                'ewsBK', 'liveFeed'
            ));
        } elseif ($role === 'pengurus') {
            return view('dashboard_pengurus', compact(
                'bulan', 'tahun', 'periodeTeks', 'today',
                'ewsPengurus', 'liveFeed'
            ));
        }

        return view('dashboard', compact(
            'bulan', 'tahun', 'periodeTeks', 'today',
            'totalSantri', 'totalEvaluasi', 'totalAbsensi',
            'avgPengajian', 'avgSekolah',
            'distribusi', 'santriPerKategori',
            'kelasLabels', 'kelasPengajianData', 'kelasSekolahData',
            'liveFeed', 'ewsPengurus', 'ewsBK',
            'hadirHariIni', 'izinHariIni', 'sakitHariIni', 'alpaHariIni', 'totalAbsenHariIni'
        ));
    }

    /**
     * Endpoint JSON untuk auto-refresh live feed di admin dashboard
     */
    public function liveFeedJson()
    {
        $feed = Absensi::with('santri')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get()
            ->map(fn($a) => [
                'santri'     => $a->santri->nama ?? '-',
                'kelas'      => $a->santri->kelas ?? '-',
                'jenis'      => $a->jenis_kegiatan,
                'status'     => $a->status,
                'tanggal'    => \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d M Y'),
                'waktu'      => $a->created_at->diffForHumans(),
            ]);

        return response()->json($feed);
    }
}
