<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Evaluasi;
use App\Models\KelasModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * GuruController
 *
 * Dashboard khusus Guru. Guru dapat:
 * - Melihat dashboard rekap kelas yang diajarnya
 * - Input absensi harian per kelas (batch mode, ala SIAKAD)
 * - Melihat riwayat absensi
 */
class GuruController extends Controller
{
    /**
     * Dashboard Guru – Rekap kehadiran hari ini + statistik kelas
     */
    public function dashboard(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $today = Carbon::today()->toDateString();

        // Ambil semua kelas untuk filter
        $kelasList = KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $kelasFilter = $request->get('kelas', null);

        // Total santri aktif
        $totalSantri = Santri::where('status', 'aktif')
            ->when($kelasFilter, fn($q) => $q->where('kelas', $kelasFilter))
            ->count();

        // Rekap absensi hari ini
        $absensiHariIni = Absensi::whereDate('tanggal', $today)
            ->whereHas('santri', fn($q) => $q->where('status', 'aktif')
                ->when($kelasFilter, fn($q2) => $q2->where('kelas', $kelasFilter)))
            ->with('santri')
            ->get();

        $hadirHariIni = $absensiHariIni->where('status', 'Hadir')->count();
        $izinHariIni  = $absensiHariIni->where('status', 'Izin')->count();
        $sakitHariIni = $absensiHariIni->where('status', 'Sakit')->count();
        $alpaHariIni  = $absensiHariIni->where('status', 'Alpa')->count();

        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
        $sekolahSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah'];

        // Cek apakah sudah ada absensi hari ini (per jenis)
        $sudahAbsenPengajian = Absensi::whereDate('tanggal', $today)
            ->whereIn('jenis_kegiatan', $pengajianSubjects)
            ->when($kelasFilter, fn($q) => $q->whereHas('santri', fn($q2) => $q2->where('kelas', $kelasFilter)))
            ->exists();

        $sudahAbsenSekolah = Absensi::whereDate('tanggal', $today)
            ->whereIn('jenis_kegiatan', $sekolahSubjects)
            ->when($kelasFilter, fn($q) => $q->whereHas('santri', fn($q2) => $q2->where('kelas', $kelasFilter)))
            ->exists();

        // Statistik bulan ini
        $evaluasis = Evaluasi::with('santri')
            ->whereHas('santri', function ($q) use ($kelasFilter) {
                $q->where('status', 'aktif');
                if ($kelasFilter) $q->where('kelas', $kelasFilter);
            })
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $avgPengajian = $evaluasis->count() > 0
            ? round($evaluasis->avg('persentase_pengajian'), 1) : 0;
        $avgSekolah = $evaluasis->count() > 0
            ? round($evaluasis->avg('persentase_sekolah'), 1) : 0;

        // Distribusi kategori bulan ini
        $distribusi = [
            'Tinggi' => $evaluasis->where('kategori_disiplin', 'Tinggi')->count(),
            'Sedang' => $evaluasis->where('kategori_disiplin', 'Sedang')->count(),
            'Rendah' => $evaluasis->where('kategori_disiplin', 'Rendah')->count(),
        ];

        // Nama bulan Indonesia
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $periodeTeks = ($namaBulan[(int)$bulan] ?? '') . ' ' . $tahun;

        // Riwayat 5 absensi terakhir
        $riwayat = Absensi::with('santri')
            ->whereHas('santri', fn($q) => $q->where('status', 'aktif')
                ->when($kelasFilter, fn($q2) => $q2->where('kelas', $kelasFilter)))
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('guru.dashboard', compact(
            'bulan', 'tahun', 'periodeTeks',
            'kelasList', 'kelasFilter',
            'totalSantri', 'hadirHariIni', 'izinHariIni', 'sakitHariIni', 'alpaHariIni',
            'sudahAbsenPengajian', 'sudahAbsenSekolah',
            'avgPengajian', 'avgSekolah', 'distribusi',
            'today', 'riwayat'
        ));
    }

    /**
     * Form Input Absensi Batch (ala SIAKAD)
     * Menampilkan semua santri aktif dalam satu form untuk input absensi per kelas
     */
    public function inputAbsensi(Request $request)
    {
        $jenisKegiatan = $request->get('jenis_kegiatan', 'Pengajian');
        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
        $isPengajian = in_array($jenisKegiatan, $pengajianSubjects);

        $kelasList    = KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $ruangList    = Santri::where('status', 'aktif')
                            ->whereNotNull('ruang_pengajian')
                            ->where('ruang_pengajian', '!=', '')
                            ->pluck('ruang_pengajian')
                            ->unique()
                            ->sort()
                            ->values();

        // Variabel kelasFilter bisa berisi nama Kelas (untuk sekolah) ATAU nama Ruang (untuk pengajian)
        $kelasFilter  = $request->get('kelas') ? trim($request->get('kelas')) : null;
        $tanggal      = $request->get('tanggal', date('Y-m-d'));

        $santris = collect();
        $existingAbsensi = collect();

        if ($kelasFilter) {
            $query = Santri::where('status', 'aktif');
            if ($isPengajian) {
                $query->where(function($q) use ($kelasFilter) {
                    $q->where('ruang_pengajian', $kelasFilter)
                      ->orWhere(\Illuminate\Support\Facades\DB::raw('TRIM(ruang_pengajian)'), $kelasFilter);
                });
            } else {
                $query->where(function($q) use ($kelasFilter) {
                    $q->where('kelas', $kelasFilter)
                      ->orWhere(\Illuminate\Support\Facades\DB::raw('TRIM(kelas)'), $kelasFilter);
                });
            }
            
            $santris = $query->orderBy('nama')->get();

            // Ambil data absensi yang sudah ada untuk tanggal & jenis ini
            $existingAbsensi = Absensi::where('jenis_kegiatan', $jenisKegiatan)
                ->whereDate('tanggal', $tanggal)
                ->whereIn('santri_id', $santris->pluck('id'))
                ->get()
                ->keyBy('santri_id');
        }

        return view('guru.input-absensi', compact(
            'kelasList', 'ruangList', 'kelasFilter', 'jenisKegiatan',
            'tanggal', 'santris', 'existingAbsensi', 'isPengajian'
        ));
    }

    /**
     * Simpan absensi batch dari form SIAKAD-style
     */
    public function storeAbsensiBatch(Request $request)
    {
        $request->validate([
            'tanggal'        => 'required|date',
            'jenis_kegiatan' => 'required|string',
            'kelas'          => 'required|string',
            'absensi'        => 'required|array',
            'absensi.*'      => 'required|in:Hadir,Izin,Sakit,Alpa',
            'keterangan'     => 'nullable|array',
            'keterangan.*'   => 'nullable|string|max:255',
            'bukti_izin'     => 'nullable|array',
            'bukti_izin.*'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $tanggal       = $request->tanggal;
        $jenisKegiatan = $request->jenis_kegiatan;
        $absensiData   = $request->absensi;
        $keteranganData = $request->keterangan ?? [];
        $count = 0;

        foreach ($absensiData as $santriId => $status) {
            $ket = ($status === 'Izin' && isset($keteranganData[$santriId])) ? $keteranganData[$santriId] : null;
            $buktiPath = null;
            
            // Check if there's an existing record to preserve old proof if not replacing
            $existing = Absensi::where('santri_id', $santriId)
                ->where('jenis_kegiatan', $jenisKegiatan)
                ->where('tanggal', $tanggal)
                ->first();
                
            if ($existing && $status === 'Izin') {
                $buktiPath = $existing->bukti_izin;
            }

            if ($status === 'Izin' && $request->hasFile("bukti_izin.{$santriId}")) {
                $file = $request->file("bukti_izin.{$santriId}");
                $buktiPath = $file->store('bukti_izin', 'public');
            } elseif ($status !== 'Izin' && $existing && $existing->bukti_izin) {
                // Hapus bukti lama jika status berubah dari Izin
                if (\Storage::disk('public')->exists($existing->bukti_izin)) {
                    \Storage::disk('public')->delete($existing->bukti_izin);
                }
                $buktiPath = null;
            }
            
            Absensi::updateOrCreate(
                [
                    'santri_id'      => $santriId,
                    'jenis_kegiatan' => $jenisKegiatan,
                    'tanggal'        => $tanggal,
                ],
                [
                    'status' => $status,
                    'keterangan' => $ket,
                    'bukti_izin' => $buktiPath,
                    'user_id' => auth()->id()
                ]
            );
            $count++;
        }

        return redirect()->route('guru.input-absensi')
            ->with('success', "Absensi {$jenisKegiatan} untuk {$count} santri berhasil disimpan!");
    }

    /**
     * Rekap absensi per santri (untuk guru melihat rekap)
     */
    public function rekapAbsensi(Request $request)
    {
        $bulan        = $request->get('bulan', date('m'));
        $tahun        = $request->get('tahun', date('Y'));
        $kelasFilter  = $request->get('kelas');
        $kelasList    = KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();

        $santris = Santri::where('status', 'aktif')
            ->when($kelasFilter, fn($q) => $q->where('kelas', $kelasFilter))
            ->orderBy('kelas')
            ->orderBy('nama')
            ->get();

        // Hitung rekap per santri
        $hariEfektif = \App\Models\Setting::getVal('hari_efektif', 30);

        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
        $sekolahSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah'];

        $rekap = $santris->map(function ($santri) use ($bulan, $tahun, $hariEfektif, $pengajianSubjects, $sekolahSubjects) {
            $absensi = Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            $hadirPengajian = $absensi->whereIn('jenis_kegiatan', $pengajianSubjects)->where('status', 'Hadir')->count();
            $hadirSekolah   = $absensi->whereIn('jenis_kegiatan', $sekolahSubjects)->where('status', 'Hadir')->count();
            $izinPengajian  = $absensi->whereIn('jenis_kegiatan', $pengajianSubjects)->where('status', 'Izin')->count();
            $izinSekolah    = $absensi->whereIn('jenis_kegiatan', $sekolahSubjects)->where('status', 'Izin')->count();
            $sakitPengajian = $absensi->whereIn('jenis_kegiatan', $pengajianSubjects)->where('status', 'Sakit')->count();
            $sakitSekolah   = $absensi->whereIn('jenis_kegiatan', $sekolahSubjects)->where('status', 'Sakit')->count();
            $alpaPengajian  = $absensi->whereIn('jenis_kegiatan', $pengajianSubjects)->where('status', 'Alpa')->count();
            $alpaSekolah    = $absensi->whereIn('jenis_kegiatan', $sekolahSubjects)->where('status', 'Alpa')->count();

            $pctPengajian = $hariEfektif > 0 ? round(($hadirPengajian / $hariEfektif) * 100, 1) : 0;
            $pctSekolah   = $hariEfektif > 0 ? round(($hadirSekolah / $hariEfektif) * 100, 1) : 0;

            // Evaluasi Forward Chaining
            $kategori = 'Belum Dievaluasi';
            $evalRecord = Evaluasi::where('santri_id', $santri->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();
            if ($evalRecord) $kategori = $evalRecord->kategori_disiplin;

            return (object)[
                'santri'          => $santri,
                'hadir_pengajian' => $hadirPengajian,
                'hadir_sekolah'   => $hadirSekolah,
                'izin_pengajian'  => $izinPengajian,
                'izin_sekolah'    => $izinSekolah,
                'sakit_pengajian' => $sakitPengajian,
                'sakit_sekolah'   => $sakitSekolah,
                'alpa_pengajian'  => $alpaPengajian,
                'alpa_sekolah'    => $alpaSekolah,
                'pct_pengajian'   => $pctPengajian,
                'pct_sekolah'     => $pctSekolah,
                'kategori'        => $kategori,
            ];
        });

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $periodeTeks = ($namaBulan[(int)$bulan] ?? '') . ' ' . $tahun;

        return view('guru.rekap', compact(
            'rekap', 'bulan', 'tahun', 'periodeTeks',
            'kelasList', 'kelasFilter', 'hariEfektif'
        ));
    }
}
