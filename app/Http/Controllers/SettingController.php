<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\KelasModel;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        // Parameter Forward Chaining
        $fcTinggi = Setting::getVal('fc_tinggi', 90);
        $fcSedang = Setting::getVal('fc_sedang', 75);
        $hariEfektif = Setting::getVal('hari_efektif', 30);

        // Identitas Pesantren & Yayasan
        $namaYayasanId = Setting::getVal('nama_yayasan_id', 'YAYASAN PENDIDIKAN AL-FURQONIYAH');
        $namaPondokAr = Setting::getVal('nama_pondok_ar', 'معهد الفرقانية الإسلامي');
        $namaPondokId = Setting::getVal('nama_pondok_id', 'Pondok Pesantren Alfurqoniyah');
        $alamatLengkap = Setting::getVal('alamat_lengkap', 'Jl. Raya Pesantren, Kabupaten Tasikmalaya, Jawa Barat');
        $telepon = Setting::getVal('telepon', '0812-3456-7890');
        $email = Setting::getVal('email', 'info@alfurqoniyah.com');
        $logoPath = Setting::getVal('logo_path');

        // Master Data Kelas & Kamar (untuk tab CRUD di Pengaturan)
        $kelasList = KelasModel::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $kamarList = Room::withCount('santris')->orderBy('nama_kamar')->get();

        // Simpan tab aktif agar setelah redirect tetap di tab yg sama
        $activeTab = $request->get('tab', 'sistem');

        // Master Data Wali Kelas & Ruang Pengajian (textarea CSV/newline)
        $listWaliKelas = Setting::getVal('list_wali_kelas', 'Ustadz Ahmad, Ustadz Budi');
        $listRuangPengajian = Setting::getVal('list_ruang_pengajian', 'Halaqah A, Halaqah B');

        return view('setting.index', compact(
            'fcTinggi', 'fcSedang', 'hariEfektif', 
            'namaYayasanId', 'namaPondokAr', 'namaPondokId', 
            'alamatLengkap', 'telepon', 'email', 'logoPath',
            'kelasList', 'kamarList', 'activeTab',
            'listWaliKelas', 'listRuangPengajian'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'fc_tinggi' => 'required|numeric|min:0|max:100',
            'fc_sedang' => 'required|numeric|min:0|max:100',
            'hari_efektif' => 'required|numeric|min:1|max:1000',
            'nama_yayasan_id' => 'required|string|max:255',
            'nama_pondok_ar' => 'required|string', // Mendukung Unicode Arab
            'nama_pondok_id' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'telepon' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // max 2MB
        ]);

        Setting::updateOrCreate(['key' => 'fc_tinggi'], ['value' => $request->fc_tinggi]);
        Setting::updateOrCreate(['key' => 'fc_sedang'], ['value' => $request->fc_sedang]);
        Setting::updateOrCreate(['key' => 'hari_efektif'], ['value' => $request->hari_efektif]);
        
        Setting::updateOrCreate(['key' => 'nama_yayasan_id'], ['value' => $request->nama_yayasan_id]);
        Setting::updateOrCreate(['key' => 'nama_pondok_ar'], ['value' => $request->nama_pondok_ar]);
        Setting::updateOrCreate(['key' => 'nama_pondok_id'], ['value' => $request->nama_pondok_id]);
        Setting::updateOrCreate(['key' => 'alamat_lengkap'], ['value' => $request->alamat_lengkap]);
        Setting::updateOrCreate(['key' => 'telepon'], ['value' => $request->telepon]);
        Setting::updateOrCreate(['key' => 'email'], ['value' => $request->email]);
        
        if ($request->has('list_wali_kelas')) {
            Setting::updateOrCreate(['key' => 'list_wali_kelas'], ['value' => $request->list_wali_kelas]);
        }
        if ($request->has('list_ruang_pengajian')) {
            Setting::updateOrCreate(['key' => 'list_ruang_pengajian'], ['value' => $request->list_ruang_pengajian]);
        }

        if ($request->hasFile('logo_path')) {
            $path = $request->file('logo_path')->store('images', 'public');
            $url = 'storage/' . $path;
            Setting::updateOrCreate(['key' => 'logo_path'], ['value' => $url]);
        }

        return redirect()->route('setting.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function storeList(Request $request)
    {
        $request->validate([
            'key' => 'required|in:list_wali_kelas,list_ruang_pengajian',
            'value' => 'required|string|max:255'
        ]);

        $key = $request->key;
        $newValue = trim($request->value);

        $currentRaw = Setting::getVal($key, '');
        $currentArray = array_filter(array_map('trim', explode(',', $currentRaw)));

        if (!in_array($newValue, $currentArray)) {
            $currentArray[] = $newValue;
            Setting::updateOrCreate(['key' => $key], ['value' => implode(', ', $currentArray)]);
        }

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroyList(Request $request)
    {
        $request->validate([
            'key' => 'required|in:list_wali_kelas,list_ruang_pengajian',
            'value' => 'required|string|max:255'
        ]);

        $key = $request->key;
        $targetValue = trim($request->value);

        $currentRaw = Setting::getVal($key, '');
        $currentArray = array_filter(array_map('trim', explode(',', $currentRaw)));

        // Remove the specific item
        $newArray = array_filter($currentArray, function($item) use ($targetValue) {
            return $item !== $targetValue;
        });

        Setting::updateOrCreate(['key' => $key], ['value' => implode(', ', $newArray)]);

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
