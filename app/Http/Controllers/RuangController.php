<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Setting;
use App\Models\KelasModel;

class RuangController extends Controller
{
    /**
     * Display the room data page (santri yang SUDAH punya ruangan).
     */
    public function index(Request $request)
    {
        // jenis_ruang: 'sekolah' or 'pengajian'
        $jenisRuang = $request->get('jenis_ruang', 'sekolah');
        
        $santris = collect();
        $ruangList = [];
        $selectedRuang = $request->get('ruang', null);
        $filterGender  = $request->get('jenis_kelamin', null);
        $filterJenjang = $request->get('jenjang', null);

        if ($jenisRuang === 'sekolah') {
            $ruangList = Santri::where('status', 'aktif')
                ->whereNotNull('kelas')
                ->where('kelas', '!=', '')
                ->pluck('kelas')
                ->unique()
                ->sort()
                ->values();

            $query = Santri::where('status', 'aktif')->whereNotNull('kelas')->where('kelas', '!=', '');
            if ($selectedRuang) {
                $query->where('kelas', $selectedRuang);
            }
            if ($filterGender) {
                $query->where('jenis_kelamin', $filterGender);
            }
            if ($filterJenjang) {
                $query->where('jenjang', $filterJenjang);
            }
            $santris = $query->orderBy('nama')->paginate(15)->withQueryString();

        } else {
            $ruangList = Santri::where('status', 'aktif')
                ->whereNotNull('ruang_pengajian')
                ->where('ruang_pengajian', '!=', '')
                ->pluck('ruang_pengajian')
                ->unique()
                ->sort()
                ->values();

            $query = Santri::where('status', 'aktif')->whereNotNull('ruang_pengajian')->where('ruang_pengajian', '!=', '');
            if ($selectedRuang) {
                $query->where('ruang_pengajian', $selectedRuang);
            }
            if ($filterGender) {
                $query->where('jenis_kelamin', $filterGender);
            }
            if ($filterJenjang) {
                $query->where('jenjang', $filterJenjang);
            }
            $santris = $query->orderBy('nama')->paginate(15)->withQueryString();
        }

        return view('ruang.index', compact('jenisRuang', 'ruangList', 'selectedRuang', 'santris', 'filterGender', 'filterJenjang'));
    }

    /**
     * Halaman khusus "Atur Ruangan" (dedicated page).
     * Menampilkan HANYA santri yang BELUM punya ruangan.
     */
    public function aturRuangan(Request $request)
    {
        $jenisRuang = $request->get('jenis_ruang', 'sekolah');
        $filterJenjang = $request->get('jenjang', null);
        $filterGender = $request->get('jenis_kelamin', null);

        // Query santri yang BELUM memiliki ruangan
        $column = $jenisRuang === 'sekolah' ? 'kelas' : 'ruang_pengajian';
        
        $query = Santri::where('status', 'aktif')
            ->where(function($q) use ($column) {
                $q->whereNull($column)->orWhere($column, '');
            });

        // Filter jenjang jika dipilih
        $query->when($filterJenjang, function($q) use ($filterJenjang) {
            $q->where('jenjang', $filterJenjang);
        });

        // Filter gender jika dipilih
        $query->when($filterGender, function($q) use ($filterGender) {
            $q->where('jenis_kelamin', $filterGender);
        });

        $unassignedSantris = $query->orderBy('nama')->get();

        // Dropdown data dari Settings
        $rawWaliKelas = Setting::getVal('list_wali_kelas', '');
        $listWaliKelas = array_filter(array_map('trim', explode(',', $rawWaliKelas)));

        $rawRuangPengajian = Setting::getVal('list_ruang_pengajian', '');
        $listRuangPengajian = array_filter(array_map('trim', explode(',', $rawRuangPengajian)));

        $listKelasSekolah = KelasModel::orderBy('nama_kelas')->pluck('nama_kelas')->toArray();

        return view('ruang.atur-ruangan', compact(
            'jenisRuang', 'filterJenjang', 'filterGender', 'unassignedSantris',
            'listWaliKelas', 'listRuangPengajian', 'listKelasSekolah'
        ));
    }

    /**
     * Proses simpan penempatan santri ke ruangan (dari halaman dedicated).
     */
    public function simpanPenempatan(Request $request)
    {
        $request->validate([
            'santri_ids' => 'required|array',
            'santri_ids.*' => 'integer',
            'jenis_ruang' => 'required|in:sekolah,pengajian',
            'nama_ruang' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
        ]);

        $column = $request->jenis_ruang === 'sekolah' ? 'kelas' : 'ruang_pengajian';

        Santri::whereIn('id', $request->santri_ids)
              ->update([
                  $column => $request->nama_ruang,
                  'wali_kelas' => $request->wali_kelas,
              ]);

        $count = count($request->santri_ids);

        return redirect()
            ->route('ruangan.index', ['jenis_ruang' => $request->jenis_ruang])
            ->with('success', $count . ' santri berhasil ditempatkan ke ruangan "' . $request->nama_ruang . '" dengan wali "' . $request->wali_kelas . '".');
    }

    /**
     * Legacy assign (tetap dipertahankan untuk backward compatibility).
     */
    public function assign(Request $request)
    {
        $request->validate([
            'santri_ids' => 'required|array',
            'santri_ids.*' => 'integer',
            'jenis_ruang' => 'required|in:sekolah,pengajian',
            'nama_ruang' => 'required|string|max:255',
            'wali_kelas' => 'nullable|string|max:255',
        ]);

        $column = $request->jenis_ruang === 'sekolah' ? 'kelas' : 'ruang_pengajian';
        
        $updateData = [$column => $request->nama_ruang];
        if ($request->filled('wali_kelas')) {
            $updateData['wali_kelas'] = $request->wali_kelas;
        }

        Santri::whereIn('id', $request->santri_ids)
              ->update($updateData);

        return redirect()->back()->with('success', count($request->santri_ids) . ' santri berhasil dimasukkan ke ' . $request->nama_ruang);
    }
}
