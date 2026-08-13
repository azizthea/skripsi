<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Santri;
use App\Models\Evaluasi;
use App\Models\KelasModel;
use App\Models\Room;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $filterJenjang = $request->get('jenjang');   // 'MTs' | 'MA' | null
        $filterKelas   = $request->get('kelas');     // nama_kelas | null
        $filterGender  = $request->get('jenis_kelamin'); // 'Putra' | 'Putri' | null

        $query = Santri::where('status', 'aktif')
            ->orderByRaw("CASE jenjang WHEN 'MTs' THEN 1 WHEN 'MA' THEN 2 ELSE 3 END")
            ->orderBy('kelas')
            ->orderBy('nama');

        if ($filterJenjang) {
            $query->where('jenjang', $filterJenjang);
        }
        if ($filterKelas) {
            $query->where('kelas', $filterKelas);
        }
        if ($filterGender) {
            $query->where('jenis_kelamin', $filterGender);
        }

        $santris = $query->paginate(15)->withQueryString();

        // Untuk keperluan modal Kenaikan Kelas (perlu semua santri aktif)
        $semuaSantriAktif = Santri::where('status', 'aktif')->get();

        $bulan = (int) date('m');
        $tahun = (int) date('Y');
        $evaluatedSantriIds = Evaluasi::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->pluck('santri_id')
            ->toArray();

        // Master kelas untuk filter tab & modal kenaikan kelas
        $kelasList = KelasModel::orderByRaw("CASE jenjang WHEN 'MTs' THEN 1 WHEN 'MA' THEN 2 ELSE 3 END")
            ->orderBy('nama_kelas')
            ->get();

        return view('santri.index', compact(
            'santris', 'semuaSantriAktif',
            'evaluatedSantriIds', 'bulan', 'tahun',
            'kelasList', 'filterJenjang', 'filterKelas', 'filterGender'
        ));
    }

    public function create()
    {
        // Ambil master data kelas & kamar untuk dropdown dinamis
        // Dengan ini, penambahan kelas/kamar baru di Pengaturan langsung
        // muncul sebagai pilihan di form ini tanpa mengubah kode.
        $kelasList = KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $kamarList = Room::withCount('santris')->orderBy('nama_kamar')->get();
        return view('santri.create', compact('kelasList', 'kamarList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'nullable|string|max:50|unique:santris,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Putra,Putri',
            'jenjang' => 'required|in:MTs,MA',
            'kelas' => 'nullable|string|max:50',
            'kamar' => 'nullable|string|max:50',
            'status' => 'required|in:aktif,lulus,keluar'
        ]);

        Santri::create($validated);
        return redirect()->route('santri.index')->with('success', 'Santri berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $santri = Santri::findOrFail($id);
        return view('santri.show', compact('santri'));
    }

    public function edit(string $id)
    {
        $santri = Santri::findOrFail($id);
        // Ambil master data kelas & kamar untuk dropdown dinamis
        $kelasList = KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $kamarList = Room::withCount('santris')->orderBy('nama_kamar')->get();
        return view('santri.edit', compact('santri', 'kelasList', 'kamarList'));
    }

    public function update(Request $request, string $id)
    {
        $santri = Santri::findOrFail($id);
        $validated = $request->validate([
            'nis' => 'nullable|string|max:50|unique:santris,nis,' . $id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Putra,Putri',
            'jenjang' => 'required|in:MTs,MA',
            'kelas' => 'nullable|string|max:50',
            'kamar' => 'nullable|string|max:50',
            'status' => 'required|in:aktif,lulus,keluar'
        ]);

        $santri->update($validated);
        return redirect()->route('santri.index')->with('success', 'Santri berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();
        return redirect()->route('santri.index')->with('success', 'Santri berhasil dihapus.');
    }

    /**
     * KENAIKAN KELAS PER KATEGORI
     *
     * Menerima:
     *   - kelas_asal  : nama kelas yang akan diproses
     *   - aksi        : 'naik' | 'lulus'
     *   - kelas_tujuan: nama kelas tujuan (hanya jika aksi = 'naik')
     *   - santri_ids[]: array ID santri yang akan diproses
     *
     * LOGIKA BISNIS:
     *   - Kelas 9 MTs → LULUS (tidak otomatis naik ke kelas 10 MA)
     *     karena masuk MA harus mendaftar ulang sebagai santri baru.
     *   - Kelas 12 MA → LULUS.
     *   - Kelas lain  → naik ke kelas tujuan yang dipilih admin.
     *
     * Mendukung SKALABILITAS: kelas diambil dari tabel master,
     * sehingga penambahan kelas baru tidak perlu mengubah kode ini.
     */
    public function naikKelas(Request $request)
    {
        $request->validate([
            'kelas_asal'   => 'required|string',
            'aksi'         => 'required|in:naik,lulus',
            'kelas_tujuan' => 'required_if:aksi,naik|nullable|string',
            'santri_ids'   => 'required|array|min:1',
            'santri_ids.*' => 'exists:santris,id',
            'target_kelas' => 'nullable|array',
        ]);

        $santriIds   = $request->santri_ids;
        $aksi        = $request->aksi;
        $kelasAsal   = $request->kelas_asal;
        $kelasTujuan = $request->kelas_tujuan;
        $targetKelas = $request->target_kelas ?? [];

        if ($aksi === 'lulus') {
            Santri::whereIn('id', $santriIds)->update(['status' => 'lulus']);
            $count = count($santriIds);
            return redirect()->route('santri.index')
                ->with('success', "{$count} santri dari kelas {$kelasAsal} telah dinyatakan Lulus.");
        }

        // Aksi naik kelas
        $defaultKelasObj = KelasModel::where('nama_kelas', $kelasTujuan)->first();
        if (!$defaultKelasObj) {
            return redirect()->route('santri.index')
                ->with('error', 'Kelas tujuan tidak ditemukan di master data.');
        }

        $allKelas = KelasModel::all()->keyBy('nama_kelas');

        $count = 0;
        foreach ($santriIds as $id) {
            // Ambil target kelas spesifik (jika override digunakan), jika tidak gunakan default
            $specificTarget = isset($targetKelas[$id]) ? $targetKelas[$id] : $kelasTujuan;
            $kObj = $allKelas->get($specificTarget) ?? $defaultKelasObj;
            
            Santri::where('id', $id)->update([
                'kelas'   => $kObj->nama_kelas,
                'jenjang' => $kObj->jenjang,
            ]);
            $count++;
        }

        return redirect()->route('santri.index')
            ->with('success', "{$count} santri dari kelas {$kelasAsal} berhasil naik kelas (termasuk yang dipindah/diacak secara spesifik).");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_import');
        $handle = fopen($file->getPathname(), "r");
        
        $header = true;
        $count = 0;
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($header) {
                $header = false;
                continue; // Skip header row
            }
            
            // Format CSV: Nama, Jenjang, Kelas, Kamar
            if (count($data) >= 4) {
                Santri::create([
                    'nama' => trim($data[0]),
                    'jenjang' => trim($data[1]),
                    'kelas' => trim($data[2]),
                    'kamar' => trim($data[3]),
                    'status' => 'aktif' // Default pendaftar baru
                ]);
                $count++;
            }
        }
        
        fclose($handle);
        return redirect()->route('santri.index')->with('success', "$count data santri baru berhasil diimport!");
    }
}
