<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use Illuminate\Http\Request;

/**
 * Controller: KelasController
 * 
 * Mengelola CRUD Master Data Kelas.
 * Semua perubahan di sini langsung terintegrasi dengan dropdown
 * pada form registrasi santri tanpa perlu menyentuh kode lain.
 */
class KelasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100|unique:classes,nama_kelas',
            'jenjang'    => 'required|in:MTs,MA',
        ]);

        KelasModel::create($request->only('nama_kelas', 'jenjang'));

        return redirect()->route('setting.index', ['tab' => 'kelas'])
            ->with('success', "Kelas '{$request->nama_kelas}' berhasil ditambahkan.");
    }

    public function destroy($id)
    {
        $kelas = KelasModel::findOrFail($id);
        $nama = $kelas->nama_kelas;
        $kelas->delete();

        return redirect()->route('setting.index', ['tab' => 'kelas'])
            ->with('success', "Kelas '{$nama}' berhasil dihapus.");
    }

    public function update(Request $request, $id)
    {
        $kelas = KelasModel::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:100|unique:classes,nama_kelas,' . $id,
            'jenjang'    => 'required|in:MTs,MA',
        ]);

        $kelas->update($request->only('nama_kelas', 'jenjang'));

        return redirect()->route('setting.index', ['tab' => 'kelas'])
            ->with('success', "Kelas '{$request->nama_kelas}' berhasil diperbarui.");
    }
}
