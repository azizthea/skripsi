<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

/**
 * Controller: KamarController
 * 
 * Mengelola CRUD Master Data Kamar.
 * Ketika kamar baru ditambahkan di sini, dropdown "Kamar" pada form
 * registrasi santri akan otomatis memunculkan pilihan tersebut.
 */
class KamarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_kamar' => 'required|string|max:100|unique:rooms,nama_kamar',
            'kapasitas'  => 'required|integer|min:1|max:999',
        ]);

        Room::create($request->only('nama_kamar', 'kapasitas'));

        return redirect()->route('setting.index', ['tab' => 'kamar'])
            ->with('success', "Kamar '{$request->nama_kamar}' berhasil ditambahkan.");
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $nama = $room->nama_kamar;
        $room->delete();

        return redirect()->route('setting.index', ['tab' => 'kamar'])
            ->with('success', "Kamar '{$nama}' berhasil dihapus.");
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'nama_kamar' => 'required|string|max:100|unique:rooms,nama_kamar,' . $id,
            'kapasitas'  => 'required|integer|min:1|max:999',
        ]);

        $room->update($request->only('nama_kamar', 'kapasitas'));

        return redirect()->route('setting.index', ['tab' => 'kamar'])
            ->with('success', "Kamar '{$request->nama_kamar}' berhasil diperbarui.");
    }
}
