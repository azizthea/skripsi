<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluasi;
use App\Models\Santri;
use App\Models\Absensi;
use App\Services\ForwardChainingService;
use App\Services\BackwardChainingService;

// EvaluasiController
class EvaluasiController extends Controller
{
    /**
     * Menampilkan halaman laporan evaluasi
     * Mendukung filter per Kelas dan Kamar
     */
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $kelasFilter = $request->get('kelas', '');
        $kamarFilter = $request->get('kamar', '');
        $filterJenjang = $request->get('jenjang', '');
        $jenis = $request->get('jenis', 'pengajian'); // Default to pengajian if not set

        // Base query
        $query = Evaluasi::with('santri')
            ->where('bulan', (int)$bulan)
            ->where('tahun', (int)$tahun);

        // Filter per Kelas
        if ($kelasFilter) {
            $kTrim = trim($kelasFilter);
            $query->whereHas('santri', function ($q) use ($kTrim) {
                $q->where('kelas', $kTrim)
                ->orWhere(\Illuminate\Support\Facades\DB::raw('TRIM(kelas)'), $kTrim);
            });
        }

        // Filter per Kamar/Ruang Pengajian
        if ($kamarFilter) {
            $kamarTrim = trim($kamarFilter);
            $query->whereHas('santri', function ($q) use ($kamarTrim) {
                $q->where(function ($sq) use ($kamarTrim) {
                    $sq->where('ruang_pengajian', $kamarTrim)
                ->orWhere('kamar', $kamarTrim)
                ->orWhere(\Illuminate\Support\Facades\DB::raw('TRIM(ruang_pengajian)'), $kamarTrim);
                });
            });
        }

        // Filter per Jenjang
        if ($filterJenjang) {
            $query->whereHas('santri', function ($q) use ($filterJenjang) {
                $q->where('jenjang', $filterJenjang);
            });
        }

        // Ambil SEMUA data (tanpa paginasi) HANYA untuk keperluan Chart Distribusi
        $semuaEvaluasi = clone $query;
        $evaluasisStats = $semuaEvaluasi->get();

        // Statistik distribusi kategori
        $distribusi = [
            'Disiplin' => $evaluasisStats->filter(fn($e) => in_array($e->kategori_disiplin, ['Disiplin', 'Tinggi']))->count(),
            'Cukup Disiplin' => $evaluasisStats->filter(fn($e) => in_array($e->kategori_disiplin, ['Cukup Disiplin', 'Sedang']))->count(),
            'Kurang Disiplin' => $evaluasisStats->filter(fn($e) => in_array($e->kategori_disiplin, ['Kurang Disiplin', 'Rendah']))->count(),
            'Tinggi' => $evaluasisStats->filter(fn($e) => in_array($e->kategori_disiplin, ['Disiplin', 'Tinggi']))->count(),
            'Sedang' => $evaluasisStats->filter(fn($e) => in_array($e->kategori_disiplin, ['Cukup Disiplin', 'Sedang']))->count(),
            'Rendah' => $evaluasisStats->filter(fn($e) => in_array($e->kategori_disiplin, ['Kurang Disiplin', 'Rendah']))->count(),
        ];

        // Eksekusi query dengan paginasi untuk ditampilkan di tabel
        $evaluasis = $query->paginate(15)->withQueryString();

        // Data untuk dropdown filter
        $listKelas = Santri::where('status', 'aktif')->whereNotNull('kelas')->where('kelas', '!=', '')->select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        
        if ($jenis === 'pengajian') {
            $listKamar = Santri::where('status', 'aktif')->whereNotNull('ruang_pengajian')->where('ruang_pengajian', '!=', '')->select('ruang_pengajian')->distinct()->orderBy('ruang_pengajian')->pluck('ruang_pengajian');
        } else {
            $listKamar = Santri::where('status', 'aktif')->whereNotNull('kamar')->where('kamar', '!=', '')->select('kamar')->distinct()->orderBy('kamar')->pluck('kamar');
        }

        return view('evaluasi.index', compact(
            'evaluasis', 'bulan', 'tahun', 'distribusi',
            'kelasFilter', 'kamarFilter', 'filterJenjang', 'listKelas', 'listKamar', 'jenis'
        ));
    }

    /**
     * Menjalankan proses Forward Chaining untuk semua santri aktif
     * Dipanggil saat user menekan tombol "Proses Evaluasi"
     */
    public function proses(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2020|max:2099',
            'kelas' => 'nullable|string',
            'kamar' => 'nullable|string',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $kelas = $request->input('kelas');
        $kamar = $request->input('kamar');

        $jenis = $request->input('jenis', 'pengajian');

        // Inisialisasi service Forward Chaining
        $service = new ForwardChainingService();

        // Jalankan proses batch untuk semua santri aktif, terisolasi sesuai $jenis dan filter kelas/kamar
        $result = $service->prosesBatch($bulan, $tahun, $jenis, $kelas, $kamar);

        $msg = "Proses evaluasi berhasil! {$result['success']} santri telah diklasifikasikan menggunakan Forward Chaining.";
        if ($result['incomplete'] > 0) {
            $msg .= " Namun, terdapat {$result['incomplete']} santri yang datanya belum lengkap dan dilewati.";
        }

        return redirect()->route('evaluasi.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jenis' => $jenis,
            'kelas' => $kelas,
            'kamar' => $kamar,
        ])->with('success', $msg);
    }

    /**
     * Reset/Hapus semua hasil evaluasi untuk bulan/tahun tertentu
     * Berguna saat data absensi perlu diperbaiki sebelum evaluasi ulang
     */
    public function reset(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2099',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $jenis = $request->input('jenis', 'pengajian');

        $evaluasis = Evaluasi::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $count = 0;
        foreach ($evaluasis as $eval) {
            if ($jenis === 'pengajian') {
                $eval->update([
                    'total_hadir_pengajian' => 0,
                    'total_hari_pengajian' => 0,
                    'persentase_pengajian' => 0,
                ]);
                $count++;
            } elseif ($jenis === 'sekolah') {
                $eval->update([
                    'total_hadir_sekolah' => 0,
                    'total_hari_sekolah' => 0,
                    'persentase_sekolah' => 0,
                ]);
                $count++;
            }

            // Hapus record jika kedua sisi kosong (sudah direset semua)
            if ($eval->persentase_pengajian == 0 && $eval->persentase_sekolah == 0) {
                $eval->delete();
            } else {
                // Evaluasi ulang berdasarkan data yang tersisa
                $service = new \App\Services\ForwardChainingService();
                $ruleResult = $service->calculateInference($eval->persentase_pengajian, $eval->persentase_sekolah);
                $eval->update([
                    'kategori_disiplin' => $ruleResult['kategori'],
                    'triggered_rule' => $ruleResult['triggered_rule'],
                ]);
            }
        }

        return redirect()->route('evaluasi.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jenis' => $jenis,
        ])->with('success', "Berhasil mereset {$count} hasil evaluasi pada periode {$bulan}/{$tahun}. Silakan proses ulang setelah data absensi diperbaiki.");
    }

    /**
     * Mengubah status record evaluasi menjadi terkirim (push ke Portal terkait)
     */
    public function kirimKePortal(Request $request)
    {
        $bulan = (int) $request->input('bulan');
        $tahun = (int) $request->input('tahun');
        $jenis = $request->input('jenis'); // 'sekolah' atau 'pengajian'

        // Hanya teruskan data santri yang bermasalah
        $evaluasis = Evaluasi::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->whereIn('kategori_disiplin', ['Kurang Disiplin', 'Rendah', 'Cukup Disiplin', 'Sedang'])
            ->get();

        if ($jenis === 'sekolah') {
            foreach ($evaluasis as $e) {
                $e->update(['is_sent_to_bk' => true]);
            }
        } else {
            foreach ($evaluasis as $e) {
                $e->update(['is_sent_to_pengurus' => true]);
            }
        }

        return response()->json(['status' => 'success', 'count' => $evaluasis->count()]);
    }

    /**
     * Proses Backward Chaining untuk Mendiagnosis Akar Masalah Kedisiplinan
     */
    public function diagnosis(Request $request)
    {
        $evaluasiId = $request->query('id');
        $jenis = $request->query('jenis', 'pengajian');
        $evaluasi = Evaluasi::with('santri')->findOrFail($evaluasiId);

        $bcService = new BackwardChainingService();
        $hasilDiagnosis = $bcService->diagnose($evaluasi, $jenis);

        $absensis = \App\Models\Absensi::where('santri_id', $evaluasi->santri_id)
            ->whereMonth('tanggal', $evaluasi->bulan)
            ->whereYear('tanggal', $evaluasi->tahun)
            ->get();
            
        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
        $sekolahSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah'];
        $subjects = $jenis === 'sekolah' ? $sekolahSubjects : $pengajianSubjects;
        
        $hadir = $absensis->whereIn('jenis_kegiatan', $subjects)->where('status', 'Hadir')->count();
        $izin = $absensis->whereIn('jenis_kegiatan', $subjects)->where('status', 'Izin')->count();
        $alpa = $absensis->whereIn('jenis_kegiatan', $subjects)->where('status', 'Alpa')->count();

        return response()->json([
            'santri' => $evaluasi->santri->nama ?? '-',
            'santri_id' => $evaluasi->santri_id,
            'kategori' => $evaluasi->kategori_disiplin,
            'stats' => [
                'hadir' => str_pad($hadir, 2, '0', STR_PAD_LEFT),
                'izin' => str_pad($izin, 2, '0', STR_PAD_LEFT),
                'alpa' => str_pad($alpa, 2, '0', STR_PAD_LEFT)
            ],
            'diagnosis' => $hasilDiagnosis
        ]);
    }

    /**
     * Mengambil 1 sampel data absensi nyata untuk ditampilkan di popup simulasi
     */
    public function simulasiForward(Request $request)
    {
        $bulan = (int) $request->query('bulan');
        $tahun = (int) $request->query('tahun');
        $jenis = $request->query('jenis', 'pengajian');
        $kelas = $request->query('kelas');
        $kamar = $request->query('kamar');
        
        // Ambil SELURUH santri aktif untuk disimulasikan di tabel sesuai periode
        $query = Santri::where('status', 'aktif')->orderBy('nama', 'asc');
        
        if ($kelas) $query->where('kelas', $kelas);
        if ($kamar) {
            $query->where(function ($q) use ($kamar) {
                $q->where('ruang_pengajian', $kamar)
                  ->orWhere('kamar', $kamar);
            });
        }
        
        $santris = $query->get();
        
        if ($santris->isEmpty()) {
            return response()->json(['error' => 'Tidak ada data santri aktif untuk kelas/kamar terpilih.'], 404);
        }

        // Validasi: Pastikan bulan dan tahun tersebut memiliki data absensi
        $cekAbsensi = \App\Models\Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->exists();
            
        if (!$cekAbsensi) {
            return response()->json(['error' => 'Belum ada data absensi sama sekali pada periode ini.'], 404);
        }

        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian'];
        $sekolahSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah'];
        $subjects = $jenis === 'sekolah' ? $sekolahSubjects : $pengajianSubjects;
        
        $totalSetting = (int)\App\Models\Setting::getVal('hari_efektif', 30);

        $results = [];
        foreach ($santris as $santri) {
            $records = \App\Models\Absensi::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->whereIn('jenis_kegiatan', $subjects)
                ->get();

            $hadir = $records->where('status', 'Hadir')->count();
            $izin  = $records->where('status', 'Izin')->count();
            $sakit = $records->where('status', 'Sakit')->count();
            $alpa  = $records->where('status', 'Alpa')->count();
            
            $totalPertemuan = $totalSetting > 0 ? $totalSetting : max($records->count(), 1);

            $persentase = 0;
            $desimal = 0;
            if ($totalPertemuan > 0) {
                $persentase = round(($hadir / $totalPertemuan) * 100);
                $desimal = round(($hadir / $totalPertemuan), 4);
            }

            $results[] = [
                'santri_nama' => $santri->nama,
                'nis' => $santri->nis ?? '000',
                'total_pertemuan' => $totalPertemuan,
                'total_hari' => $totalPertemuan,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'desimal' => str_replace('.', ',', (string)$desimal),
                'persentase' => $persentase
            ];
        }

        return response()->json($results);
    }

    /**
     * Export rekap evaluasi semua santri ke PDF (print-friendly)
     * Menggunakan teknik window.print() sehingga tidak memerlukan library eksternal
     */
    public function cetakPdf(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $evaluasis = Evaluasi::with('santri')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        // Statistik distribusi
        $distribusi = [
            'Tinggi' => $evaluasis->where('kategori_disiplin', 'Tinggi')->count(),
            'Sedang' => $evaluasis->where('kategori_disiplin', 'Sedang')->count(),
            'Rendah' => $evaluasis->where('kategori_disiplin', 'Rendah')->count(),
        ];

        // Nama bulan dalam bahasa Indonesia
        $namaBulan = $this->getNamaBulan();
        $periodeTeks = ($namaBulan[(int)$bulan] ?? 'Unknown') . ' ' . $tahun;

        // Ambil Data Konfigurasi
        $namaYayasanId = \App\Models\Setting::getVal('nama_yayasan_id', 'YAYASAN PENDIDIKAN AL-FURQONIYAH');
        $namaPondokAr = \App\Models\Setting::getVal('nama_pondok_ar', 'معهد الفرقانية الإسلامي');
        $namaPondokId = \App\Models\Setting::getVal('nama_pondok_id', 'Pondok Pesantren Alfurqoniyah');
        $alamatLengkap = \App\Models\Setting::getVal('alamat_lengkap', 'Jl. Raya Pesantren, Kabupaten Tasikmalaya, Jawa Barat');
        $telepon = \App\Models\Setting::getVal('telepon', '0812-3456-7890');
        $email = \App\Models\Setting::getVal('email', 'info@alfurqoniyah.com');
        $logoPathSetting = \App\Models\Setting::getVal('logo_path');

        $logo_path = null;
        if ($logoPathSetting) {
            $logo_path = asset($logoPathSetting);
        } else {
            $logo_path = asset('images/logo.png');
        }

        $data = compact(
            'evaluasis', 'bulan', 'tahun', 'distribusi', 'periodeTeks',
            'namaYayasanId', 'namaPondokAr', 'namaPondokId', 
            'alamatLengkap', 'telepon', 'email', 'logo_path'
        );

        // KEMBALIKAN KE HTML BROWSER PRINT
        // Server-side DomPDF tidak mendukung teks Arab RTL dengan baik (huruf terbalik & terpisah).
        // Dengan mengembalikan view HTML biasa, browser (Chrome/Edge) akan merender 
        // teks Arab dan Logo dengan sangat sempurna.
        return view('evaluasi.cetak-pdf', $data);
    }

    /**
     * =========================================================================
     * DOWNLOAD PDF INDIVIDU — Laporan Kedisiplinan Per Santri
     * =========================================================================
     * 
     * Menghasilkan file PDF berisi riwayat absensi satu bulan penuh
     * untuk satu santri beserta hasil klasifikasi Forward Chaining.
     * 
     * ALUR PROSES:
     * 1. Validasi parameter santri_id, bulan, tahun
     * 2. Query data santri dari tabel `santris`
     * 3. Query riwayat absensi sebulan dari tabel `absensis`
     * 4. Query hasil evaluasi dari tabel `evaluasis`
     * 5. Susun data harian (tanggal 1-31) dengan status per kegiatan
     * 6. Render view blade menjadi PDF menggunakan DomPDF
     * 7. Download file dengan penamaan dinamis
     * 
     * @param Request $request  Berisi santri_id, bulan, tahun
     * @return \Illuminate\Http\Response  File PDF untuk diunduh
     */
    public function downloadPdf(Request $request)
    {
        // -------------------------------------------------------------------
        // LANGKAH 1: Validasi parameter input
        // Memastikan semua parameter yang dibutuhkan tersedia dan valid
        // -------------------------------------------------------------------
        // Ambil data dari query string
        $santriId = $request->query('santri_id');
        $bulan    = (int) $request->query('bulan');
        $tahun    = (int) $request->query('tahun');
        $jenis    = $request->query('jenis', 'sekolah');

        if (!$santriId || !$bulan || !$tahun) {
            abort(400, 'Parameter tidak lengkap. Pastikan santri_id, bulan, dan tahun tersedia.');
        }

        // -------------------------------------------------------------------
        // LANGKAH 2: Ambil data santri dari tabel `santris`
        // Menggunakan findOrFail agar otomatis return 404 jika tidak ditemukan
        // -------------------------------------------------------------------
        $santri = Santri::findOrFail($santriId);

        // -------------------------------------------------------------------
        // LANGKAH 3: Query riwayat absensi sebulan penuh
        // 
        // Query ini mengambil SEMUA record absensi milik santri tertentu
        // pada bulan dan tahun yang dipilih. Hasilnya mencakup kedua
        // jenis kegiatan (Pengajian dan Sekolah).
        //
        // whereMonth('tanggal', $bulan) → filter berdasarkan bulan
        // whereYear('tanggal', $tahun)  → filter berdasarkan tahun
        // orderBy('tanggal')            → urutkan dari tanggal terkecil
        //
        // Contoh: Jika bulan = 5 dan tahun = 2026, query akan mengambil
        // semua record absensi dari 1 Mei 2026 sampai 31 Mei 2026
        // -------------------------------------------------------------------
        $absensis = Absensi::where('santri_id', $santriId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        // -------------------------------------------------------------------
        // LANGKAH 4: Ambil hasil evaluasi Forward Chaining
        // 
        // Data evaluasi berisi persentase kehadiran dan kategori disiplin
        // yang sudah dihitung oleh ForwardChainingService sebelumnya.
        // Jika evaluasi belum dijalankan, variabel akan bernilai null.
        // -------------------------------------------------------------------
        $evaluasi = Evaluasi::where('santri_id', $santriId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        // -------------------------------------------------------------------
        // LANGKAH 5 & 6: Rekapitulasi per Mata Pelajaran (Sekolah & Pengajian)
        // -------------------------------------------------------------------
        $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian', 'Tahfidz'];
        
        $rekapPengajian = [];
        $rekapSekolah = [];
        
        foreach ($absensis->groupBy('jenis_kegiatan') as $kegiatan => $records) {
            $dataItem = [
                'mapel' => $kegiatan,
                'total' => $records->count(),
                'hadir' => $records->where('status', 'Hadir')->count(),
                'izin' => $records->where('status', 'Izin')->count(),
                'sakit' => $records->where('status', 'Sakit')->count(),
                'alpa' => $records->where('status', 'Alpa')->count(),
                'persentase' => $records->count() > 0 ? round(($records->where('status', 'Hadir')->count() / $records->count()) * 100, 2) : 0,
            ];
            
            if (in_array($kegiatan, $pengajianSubjects)) {
                $rekapPengajian[] = $dataItem;
            } else {
                $rekapSekolah[] = $dataItem;
            }
        }

        // Penggabungan Data Fakta & Data Konfigurasi
        $namaYayasanId = \App\Models\Setting::getVal('nama_yayasan_id', 'YAYASAN PENDIDIKAN AL-FURQONIYAH');
        $namaPondokAr = \App\Models\Setting::getVal('nama_pondok_ar', 'معهد الفرقانية الإسلامي');
        $namaPondokId = \App\Models\Setting::getVal('nama_pondok_id', 'Pondok Pesantren Alfurqoniyah');
        $alamatLengkap = \App\Models\Setting::getVal('alamat_lengkap', 'Jl. Raya Pesantren, Kabupaten Tasikmalaya, Jawa Barat');
        $telepon = \App\Models\Setting::getVal('telepon', '0812-3456-7890');
        $email = \App\Models\Setting::getVal('email', 'info@alfurqoniyah.com');
        $logoPathSetting = \App\Models\Setting::getVal('logo_path');

        $namaBulan = $this->getNamaBulan();
        $periodeTeks = ($namaBulan[$bulan] ?? 'Unknown') . ' ' . $tahun;

        $logo_path = null;
        if ($logoPathSetting) {
            $logo_path = asset($logoPathSetting);
        } else {
            $logo_path = asset('images/logo.png');
        }

        $namaFile = 'Laporan_Disiplin_'
            . str_replace(' ', '_', $santri->nama)
            . '_' . ($namaBulan[$bulan] ?? $bulan)
            . '_' . $tahun . '.pdf';

        $data = compact(
            'santri', 'absensis', 'evaluasi', 'rekapPengajian', 'rekapSekolah',
            'bulan', 'tahun', 'periodeTeks', 'namaFile', 'jenis',
            'namaYayasanId', 'namaPondokAr', 'namaPondokId', 
            'alamatLengkap', 'telepon', 'email', 'logo_path'
        );

        // KEMBALIKAN KE HTML BROWSER PRINT
        return view('evaluasi.pdf-dompdf', $data);
    }


    // (-) Method Private: Helper Nama Hari
    private function getNamaHari(int $dayOfWeek): string
    {
        $hari = [
            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis',
            5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
        ];
        return $hari[$dayOfWeek] ?? '-';
    }

    // (-) Method Private: Helper Nama Bulan
    private function getNamaBulan(): array
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
    }

    /**
     * IMPORT REKAP BULANAN
     * Mengunggah file CSV rekap bulanan, otomatis menghitung persentase,
     * dan mengeksekusi Forward Chaining.
     */
    public function importRekap(Request $request, \App\Services\ForwardChainingService $fcService)
    {
        $request->validate([
            'file_import' => 'required|mimes:csv,txt|max:2048',
            'bulan'       => 'required|integer|min:1|max:12',
            'tahun'       => 'required|integer'
        ]);

        $file = $request->file('file_import');
        $handle = fopen($file->getPathname(), "r");
        
        $header = true;
        $count = 0;
        
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($header) {
                $header = false;
                continue; // Skip header row
            }
            
            // Format CSV: Nama Santri, Total Hari Pengajian, Hadir Pengajian, Total Hari Sekolah, Hadir Sekolah
            if (count($data) >= 5) {
                $nama = trim($data[0]);
                $totalHariPengajian = (int) trim($data[1]);
                $hadirPengajian     = (int) trim($data[2]);
                $totalHariSekolah   = (int) trim($data[3]);
                $hadirSekolah       = (int) trim($data[4]);

                $santri = Santri::where('nama', 'LIKE', "%{$nama}%")->first();

                if ($santri) {
                    // Hitung Persentase
                    $pPengajian = $totalHariPengajian > 0 ? ($hadirPengajian / $totalHariPengajian) * 100 : 0;
                    $pSekolah   = $totalHariSekolah > 0 ? ($hadirSekolah / $totalHariSekolah) * 100 : 0;

                    // Evaluasi Rule (Forward Chaining)
                    $hasil = $fcService->evaluateRules($pPengajian, $pSekolah);

                    // Simpan ke Tabel Evaluasi
                    Evaluasi::updateOrCreate(
                        [
                            'santri_id' => $santri->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun
                        ],
                        [
                            'total_hadir_pengajian' => $hadirPengajian,
                            'total_hari_pengajian'  => $totalHariPengajian,
                            'total_hadir_sekolah'   => $hadirSekolah,
                            'total_hari_sekolah'    => $totalHariSekolah,
                            'persentase_pengajian'  => $pPengajian,
                            'persentase_sekolah'    => $pSekolah,
                            'kategori_disiplin'     => $hasil['kategori'],
                            'triggered_rule'        => $hasil['rule'] ?? $hasil['triggered_rule'] ?? null
                        ]
                    );

                    $count++;
                }
            }
        }
        
        fclose($handle);
        return redirect()->route('evaluasi.index')->with('success', "Berhasil memproses evaluasi kedisiplinan untuk $count santri dari file CSV Rekap Bulanan!");
    }

    /**
     * Mark an evaluation as 'done' / resolved on the BK or Pengurus dashboard.
     */
    public function markSelesai($id, Request $request)
    {
        $evaluasi = Evaluasi::findOrFail($id);
        $role = auth()->user()->role;

        if ($role === 'bk') {
            $evaluasi->update(['is_sent_to_bk' => false]);
        } elseif ($role === 'pengurus') {
            $evaluasi->update(['is_sent_to_pengurus' => false]);
        } else {
            // Admin can dismiss depending on the origin
            if ($request->get('type') === 'bk') {
                $evaluasi->update(['is_sent_to_bk' => false]);
            } elseif ($request->get('type') === 'pengurus') {
                $evaluasi->update(['is_sent_to_pengurus' => false]);
            } else {
                $evaluasi->update([
                    'is_sent_to_bk' => false,
                    'is_sent_to_pengurus' => false
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status santri telah diselesaikan dan dihapus dari daftar prioritas.');
    }
}
