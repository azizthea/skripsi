<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;

// AbsensiController
class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar absensi dengan filter dan search
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal');
        $jenisKegiatan = $request->get('jenis_kegiatan');
        $filterGender = $request->get('jenis_kelamin');

        $query = Absensi::with('santri')->orderBy('tanggal', 'desc');

        // Filter berdasarkan nama santri
        if ($search) {
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }
        
        // Filter berdasarkan jenis kelamin
        if ($filterGender) {
            $query->whereHas('santri', function ($q) use ($filterGender) {
                $q->where('jenis_kelamin', $filterGender);
            });
        }

        // Filter berdasarkan tanggal
        if ($tanggal) {
            $query->where('tanggal', $tanggal);
        }

        // Filter berdasarkan jenis kegiatan
        if ($jenisKegiatan) {
            $query->where('jenis_kegiatan', $jenisKegiatan);
        }

        // Filter berdasarkan kategori kegiatan (Sekolah atau Pengajian)
        $jenis = $request->get('jenis');
        if ($jenis === 'pengajian') {
            $query->whereIn('jenis_kegiatan', ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian']);
        } elseif ($jenis === 'sekolah') {
            $query->whereIn('jenis_kegiatan', ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah']);
        }

        // Filter berdasarkan kelas atau ruang
        $kelasFilter = $request->get('kelas');
        if ($kelasFilter) {
            $query->whereHas('santri', function ($q) use ($kelasFilter, $jenis) {
                if ($jenis === 'pengajian') {
                    $q->where('ruang_pengajian', $kelasFilter);
                } else {
                    $q->where('kelas', $kelasFilter);
                }
            });
        }

        $kelasList = \App\Models\KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $ruangList = \App\Models\Santri::where('status', 'aktif')
            ->whereNotNull('ruang_pengajian')
            ->where('ruang_pengajian', '!=', '')
            ->pluck('ruang_pengajian')
            ->unique()
            ->sort()
            ->values();
            
        $absensis = $query->paginate(20);

        return view('absensi.index', compact('absensis', 'search', 'tanggal', 'jenisKegiatan', 'kelasList', 'ruangList', 'kelasFilter', 'jenis', 'filterGender'));
    }

    /**
     * Menampilkan form input absensi baru
     * kelasList & kamarList diambil dari tabel master (classes & rooms)
     * sehingga filter dropdown selalu sinkron dengan data Pengaturan Sistem.
     */
    public function create()
    {
        $santris    = Santri::where('status', 'aktif')->orderBy('nama')->get();
        $kelasList  = \App\Models\KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $kamarList  = \App\Models\Room::orderBy('nama_kamar')->get();
        return view('absensi.create', compact('santris', 'kelasList', 'kamarList'));
    }

    /**
     * Menyimpan data absensi baru ke database
     * Validasi unique constraint: santri_id + jenis_kegiatan + tanggal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id'      => 'required|exists:santris,id',
            'jenis_kegiatan' => 'required|string',
            'tanggal'        => 'required|date',
            'status'         => 'required|in:Hadir,Izin,Sakit,Alpa',
        ], [
            'santri_id.required'      => 'Santri wajib dipilih.',
            'jenis_kegiatan.required' => 'Mata pelajaran / kegiatan wajib dipilih.',
            'tanggal.required'        => 'Tanggal wajib diisi.',
            'status.required'         => 'Status kehadiran wajib dipilih.',
        ]);

        // Cek duplikasi: satu santri tidak boleh punya dua record
        // untuk jenis kegiatan dan tanggal yang sama
        $exists = Absensi::where('santri_id', $validated['santri_id'])
            ->where('jenis_kegiatan', $validated['jenis_kegiatan'])
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'duplicate' => 'Data absensi untuk santri ini pada tanggal dan jenis kegiatan tersebut sudah ada.'
            ])->withInput();
        }

        Absensi::create($validated);

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil disimpan.');
    }

    /**
     * Menampilkan form edit absensi
     */
    public function edit(string $id)
    {
        $absensi = Absensi::findOrFail($id);
        $santris = Santri::where('status', 'aktif')->orderBy('nama')->get();
        return view('absensi.edit', compact('absensi', 'santris'));
    }

    /**
     * Mengupdate data absensi
     */
    public function update(Request $request, string $id)
    {
        $absensi = Absensi::findOrFail($id);

        $validated = $request->validate([
            'santri_id'      => 'required|exists:santris,id',
            'jenis_kegiatan' => 'required|string',
            'tanggal'        => 'required|date',
            'status'         => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        // Cek duplikasi (kecuali record ini sendiri)
        $exists = Absensi::where('santri_id', $validated['santri_id'])
            ->where('jenis_kegiatan', $validated['jenis_kegiatan'])
            ->where('tanggal', $validated['tanggal'])
            ->where('id', '!=', $absensi->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'duplicate' => 'Data absensi untuk santri ini pada tanggal dan jenis kegiatan tersebut sudah ada.'
            ])->withInput();
        }

        $absensi->update($validated);

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil diupdate.');
    }

    /**
     * Menghapus data absensi
     */
    public function destroy(string $id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    /**
     * Batch Delete: Menghapus semua absensi pada bulan/tahun tertentu
     * Berguna saat terjadi salah input massal
     */
    public function batchDelete(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2099',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $jenis = $request->input('jenis');

        $query = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($jenis === 'pengajian') {
            $query->whereIn('jenis_kegiatan', ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak', 'Bahasa Arab', 'Pengajian']);
        } elseif ($jenis === 'sekolah') {
            $query->whereIn('jenis_kegiatan', ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'PKn', 'Sekolah']);
        }

        $deleted = $query->delete();

        $categoryText = $jenis ? ' (' . ucfirst($jenis) . ')' : '';

        return redirect()->route('absensi.index', $jenis ? ['jenis' => $jenis] : [])
            ->with('success', "Berhasil menghapus {$deleted} record absensi{$categoryText} pada periode {$bulan}/{$tahun}.");
    }

    // Import Rekap Absensi
    public function importRekap(Request $request)
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

        // Ambil Hari Efektif dari Pengaturan (misal: 30)
        $hariEfektif = \App\Models\Setting::getVal('hari_efektif', 30);

        // Hapus data lama di bulan/tahun yang sama jika ada, agar tidak conflict
        // (optional: tapi lebih aman dihapus saja atau dihandle unique constraint-nya)
        // Disini kita akan update atau create berdasarkan hari 1 sampai $hariEfektif

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($header) {
                $header = false;
                continue; // Skip header row
            }
            
            // Format CSV: Nama Santri, Hadir Pengajian, Hadir Sekolah (3 Kolom)
            if (count($data) >= 3) {
                $nama = trim($data[0]);
                $hadirPengajian     = (int) trim($data[1]);
                $hadirSekolah       = (int) trim($data[2]);

                $santri = Santri::where('nama', 'LIKE', "%{$nama}%")->first();

                if ($santri) {
                    // Generate data harian untuk Pengajian
                    for ($hari = 1; $hari <= $hariEfektif; $hari++) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);
                        
                        // Jika hari <= jumlah hadir, maka Hadir. Sisanya Alpa.
                        $statusPengajian = ($hari <= $hadirPengajian) ? 'Hadir' : 'Alpa';
                        $statusSekolah   = ($hari <= $hadirSekolah) ? 'Hadir' : 'Alpa';

                        // Simpan data absensi
                        Absensi::updateOrCreate(
                            [
                                'santri_id'      => $santri->id,
                                'jenis_kegiatan' => 'Pengajian',
                                'tanggal'        => $tanggal,
                            ],
                            ['status' => $statusPengajian]
                        );

                        Absensi::updateOrCreate(
                            [
                                'santri_id'      => $santri->id,
                                'jenis_kegiatan' => 'Sekolah',
                                'tanggal'        => $tanggal,
                            ],
                            ['status' => $statusSekolah]
                        );
                    }
                    $count++;
                }
            }
        }
        
        fclose($handle);
        return redirect()->route('absensi.index')->with('success', "Berhasil menyimpan {$count} data absensi santri ke database Absensi! Silakan ke halaman Evaluasi untuk menjalankan proses Forward Chaining.");
    }
}
