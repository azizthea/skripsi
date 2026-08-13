<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\AktivitasHarian;

class AktivitasController extends Controller
{
    public function index(Request $request)
    {
        // Fitur Filter/Search (Opsional jika mau mencari nama santri spesifik)
        $search = $request->get('search');
        
        $query = Santri::where('status', 'aktif')->orderBy('nama', 'asc');
        
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }
        
        $santris = $query->get();
        return view('aktivitas.index', compact('santris', 'search'));
    }

    public function show($id)
    {
        $santri = Santri::findOrFail($id);
        $aktivitas = AktivitasHarian::where('santri_id', $id)
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('aktivitas.show', compact('santri', 'aktivitas'));
    }

    public function create()
    {
        $santris = Santri::where('status', 'aktif')->get();
        return view('aktivitas.create', compact('santris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'tanggal' => 'required|date',
            'sholat_berjamaah' => 'required|in:hadir,tidak,terlambat',
            'mengaji' => 'required|in:hadir,tidak,terlambat',
            'sekolah' => 'required|in:hadir,tidak,terlambat',
            'jumlah_pelanggaran' => 'required|min:0|integer'
        ]);

        // Upsert based on santri_id and tanggal
        AktivitasHarian::updateOrCreate(
            ['santri_id' => $validated['santri_id'], 'tanggal' => $validated['tanggal']],
            $validated
        );

        return redirect()->route('aktivitas.index')->with('success', 'Aktivitas berhasil disimpan.');
    }

    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $santris = Santri::where('status', 'aktif')->with('aktivitasHarians')->get();
        
        $laporan = [];
        foreach($santris as $santri) {
            $laporan[] = [
                'santri' => $santri,
                'status_kedisiplinan' => $santri->getStatusKedisiplinan($bulan, $tahun)
            ];
        }

        return view('laporan.index', compact('laporan', 'bulan', 'tahun'));
    }
}
