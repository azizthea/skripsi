@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 style="color: var(--af-positive); font-weight: 700;">Laporan Evaluasi Keputusan</h3>
    
    <div class="neo-card" style="padding: 10px 20px; margin-bottom: 0;">
        <form class="d-flex align-items-center" method="GET" action="{{ route('laporan.index') }}">
            <span style="font-weight:600; margin-right:15px; color:var(--af-dark);">Filter Siklus:</span>
            <select name="bulan" class="neo-input me-3" style="width:150px; padding:8px 15px;">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == $i ? 'selected' : '' }}>
                        Bulan {{ $i }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="neo-input me-3" style="width:120px; padding:8px 15px;">
                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                <option value="{{ date('Y')-1 }}">{{ date('Y')-1 }}</option>
            </select>
            <button type="submit" class="neo-btn" style="padding: 8px 15px;">Terapkan</button>
        </form>
    </div>
</div>

<div class="neo-card p-0">
    <div class="p-4" style="border-bottom: 2px solid rgba(163,177,198,0.2);">
        <h5 style="margin:0; color:var(--af-positive);">Output Rule-Based System</h5>
        <small class="text-muted">Hasil kalkulasi algoritma disiplin untuk siklus {{ $bulan }}/{{ $tahun }}</small>
    </div>
    <div class="table-container m-3 mt-0">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Identitas Subjek</th>
                    <th class="text-center">Kumulatif Pelanggaran</th>
                    <th class="text-end">Rekomendasi / Status Evaluasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $row)
                @php 
                    $badgeClass = '';
                    if($row['status_kedisiplinan'] == 'Sangat Disiplin') $badgeClass = 'badge-positive';
                    elseif($row['status_kedisiplinan'] == 'Disiplin') $badgeClass = 'badge-positive" style="opacity:0.8; box-shadow:none;';
                    elseif($row['status_kedisiplinan'] == 'Kurang Disiplin') $badgeClass = 'badge-warning';
                    elseif($row['status_kedisiplinan'] == 'Tidak Disiplin') $badgeClass = 'badge-negative';
                @endphp
                <tr>
                    <td style="font-weight:600;">{{ $row['santri']->nis }}</td>
                    <td><span style="font-weight:600; color:var(--af-positive);">{{ $row['santri']->nama }}</span> <br> <small>{{ $row['santri']->kelas }}</small></td>
                    
                    @php $total_pelanggaran = $row['santri']->aktivitasHarians->where('tanggal', '>=', "$tahun-$bulan-01")->where('tanggal', '<=', "$tahun-$bulan-31")->sum('jumlah_pelanggaran'); @endphp
                    
                    <td class="text-center">
                        <span class="badge" style="background-color:var(--af-bg); color:var(--af-dark); box-shadow:var(--neo-shadow-inner); border-radius:10px; padding:8px 12px; font-size:0.9rem;">{{ $total_pelanggaran }}</span>
                    </td>
                    
                    <td class="text-end">
                        <span class="badge {!! $badgeClass !!}">{{ strtoupper($row['status_kedisiplinan']) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
