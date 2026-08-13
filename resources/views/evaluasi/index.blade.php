@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">


    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--af-positive)">
                <i class="bi bi-file-earmark-bar-graph me-2"></i>Evaluasi & Laporan <span class="badge bg-secondary ms-2 fs-6">{{ ucfirst($jenis) }}</span>
            </h3>
            <p class="text-muted mb-0">Klasifikasi Kedisiplinan Santri - Fokus: {{ ucfirst($jenis) }}</p>
        </div>
    </div>

    <!-- Proses Evaluasi Bulanan -->
    <div class="neo-card p-4 mb-4" style="background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0.1) 100%);">
        <h5 class="fw-bold mb-3"><i class="bi bi-cpu me-2"></i>Jalankan Proses Klasifikasi</h5>
        <form id="formEvaluasi" method="POST" action="{{ route('evaluasi.proses') }}" class="row m-0 g-3 align-items-end">
            @csrf
            <input type="hidden" name="jenis" value="{{ $jenis }}">
            <div class="col-12 col-md-3">
                <label class="form-label fw-bold">Periode Bulan</label>
                <select name="bulan" class="form-select neo-input" required>
                    @php
                        $namaBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ (int)$bulan == $i ? 'selected' : '' }}>
                            {{ $namaBulan[$i] }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label fw-bold">Periode Tahun</label>
                <select name="tahun" class="form-select neo-input" required>
                    @for($y = (int)date('Y') + 10; $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ (int)$tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-12 col-md-3">
                @if($jenis === 'sekolah')
                    <label class="form-label fw-bold">Target Kelas <span class="text-danger">*</span></label>
                    <select name="kelas" id="selectTarget" class="form-select neo-input" required>
                        <option value="">-- Pilih Target Kelas --</option>
                        @foreach($listKelas as $k)
                            <option value="{{ $k }}" {{ trim($kelasFilter) == trim($k) ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                @else
                    <label class="form-label fw-bold">Target Ruang <span class="text-danger">*</span></label>
                    <select name="kamar" id="selectTarget" class="form-select neo-input" required>
                        <option value="">-- Pilih Target Ruang --</option>
                        @foreach($listKamar as $k)
                            <option value="{{ $k }}" {{ trim($kamarFilter) == trim($k) ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="col-12 col-md-3 d-flex flex-column flex-md-row gap-2">
                <button type="button" id="btnProses" onclick="bukaModalSimulasi()" class="neo-btn neo-btn-primary flex-grow-1 d-flex align-items-center justify-content-center text-center" style="min-height: 45px; padding: 0.5rem 1rem; opacity: 0.5; cursor: not-allowed; pointer-events: none;" disabled>
                    <i class="bi bi-gear-fill me-1"></i> Proses
                </button>
                <button type="button" class="neo-btn flex-grow-1 d-flex align-items-center justify-content-center text-center" style="min-height: 45px; padding: 0.5rem 1rem; background: rgba(229, 62, 62, 0.1); color: var(--af-negative); border: 1px solid rgba(229, 62, 62, 0.2);" onclick="if(confirm('Apakah Anda yakin ingin mereset/menghapus hasil evaluasi {{ ucfirst($jenis) }} untuk periode ini?')) document.getElementById('resetForm').submit();" title="Reset Evaluasi Bulan Ini">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </button>
            </div>
        </form>
        <form id="resetForm" method="POST" action="{{ route('evaluasi.reset') }}" style="display: none;">
            @csrf
            <input type="hidden" name="jenis" value="{{ $jenis }}">
            <input type="hidden" name="bulan" id="resetBulan" value="{{ date('m') }}">
            <input type="hidden" name="tahun" id="resetTahun" value="{{ date('Y') }}">
        </form>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectTarget = document.getElementById('selectTarget');
                const btnProses = document.getElementById('btnProses');

                function updateProsesButtonState() {
                    if (selectTarget && btnProses) {
                        if (selectTarget.value && selectTarget.value.trim() !== '') {
                            btnProses.disabled = false;
                            btnProses.style.opacity = '1';
                            btnProses.style.cursor = 'pointer';
                            btnProses.style.pointerEvents = 'auto';
                        } else {
                            btnProses.disabled = true;
                            btnProses.style.opacity = '0.5';
                            btnProses.style.cursor = 'not-allowed';
                            btnProses.style.pointerEvents = 'none';
                        }
                    }
                }

                if (selectTarget) {
                    selectTarget.addEventListener('change', updateProsesButtonState);
                    updateProsesButtonState();
                }

                // Sync reset form fields with proses form fields
                const selectBulan = document.querySelector('#formEvaluasi select[name="bulan"]');
                const selectTahun = document.querySelector('#formEvaluasi select[name="tahun"]');
                if (selectBulan) {
                    selectBulan.addEventListener('change', function() {
                        const resetB = document.getElementById('resetBulan');
                        if (resetB) resetB.value = this.value;
                    });
                }
                if (selectTahun) {
                    selectTahun.addEventListener('change', function() {
                        const resetT = document.getElementById('resetTahun');
                        if (resetT) resetT.value = this.value;
                    });
                }
            });
        </script>
    </div>

    <!-- Filter Tampilan (Poin 5: Filter Kelas/Kamar) -->
    <div class="neo-card p-3 mb-4">
        <form method="GET" action="{{ route('evaluasi.index') }}" class="row m-0 g-2 align-items-center">
            <input type="hidden" name="jenis" value="{{ $jenis }}">
            
            <div class="col-12 col-md-auto">
                <span class="fw-bold" style="color: var(--af-dark);">Lihat Hasil:</span>
            </div>
            
            <div class="col-6 col-md-2">
                <select name="bulan" class="form-select neo-input w-100">
                    @php
                        $namaBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ (int)$bulan == $i ? 'selected' : '' }}>
                            {{ $namaBulan[$i] }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div class="col-6 col-md-2">
                <select name="tahun" class="form-select neo-input w-100">
                    @for($y = (int)date('Y') + 10; $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ (int)$tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            
            <div class="col-12 col-md-2">
                <select name="jenjang" class="form-select neo-input w-100">
                    <option value="">Semua Jenjang</option>
                    <option value="MTs" {{ ($filterJenjang ?? '') == 'MTs' ? 'selected' : '' }}>MTs</option>
                    <option value="MA" {{ ($filterJenjang ?? '') == 'MA' ? 'selected' : '' }}>MA</option>
                </select>
            </div>
            
            {{-- Filter per Kelas (Hanya untuk BK / Sekolah) --}}
            @if($jenis === 'sekolah')
            <div class="col-12 col-md-2">
                <select name="kelas" class="form-select neo-input w-100">
                    <option value="">Semua Kelas</option>
                    @foreach($listKelas as $k)
                        <option value="{{ $k }}" {{ $kelasFilter == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Filter per Kamar/Ruang Pengajian (Hanya untuk Kesantrian) --}}
            @if($jenis === 'pengajian')
            <div class="col-12 col-md-2">
                <select name="kamar" class="form-select neo-input w-100">
                    <option value="">Semua Ruang</option>
                    @foreach($listKamar as $k)
                        <option value="{{ $k }}" {{ $kamarFilter == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="col-12 col-md d-flex flex-wrap gap-2">
                <button type="submit" class="neo-btn flex-grow-1 px-3 text-center" style="height: 42px;">
                    <i class="bi bi-funnel-fill me-1"></i> Tampilkan
                </button>
                
                @if($kelasFilter || $kamarFilter)
                    <a href="{{ route('evaluasi.index', ['bulan' => $bulan, 'tahun' => $tahun, 'jenis' => $jenis]) }}" class="neo-btn flex-grow-1 px-3 text-center text-danger" style="height: 42px;">
                        <i class="bi bi-x-lg me-1"></i> Reset Filter
                    </a>
                @endif

                @if($evaluasis->count() > 0)
                    <a href="javascript:void(0);" 
                       onclick="window.open('{{ route('evaluasi.cetak-pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}', 'PDFPreviewGlobal', 'width=1000,height=700,left='+(screen.width-1000)/2+',top='+(screen.height-700)/2+',menubar=no,toolbar=no,location=no,status=no');"
                       class="neo-btn ms-md-auto flex-grow-1 px-3 text-center" style="height: 42px; color: var(--af-negative);" 
                       title="Preview Rekap Laporan PDF">
                        <i class="bi bi-printer-fill me-1"></i> Cetak PDF
                    </a>
                @endif
            </div>
        </form>
    </div>


    <!-- Tabel Hasil Evaluasi -->
    <div class="neo-card p-0">
        @php
            $bermasalah = $evaluasis->filter(function($e) {
                return in_array($e->kategori_disiplin, ['Kurang Disiplin', 'Rendah', 'Cukup Disiplin', 'Sedang']);
            })->values();
            
            $targetPortal = $jenis === 'sekolah' ? 'Guru BK' : 'Pengurus Kesantrian';
        @endphp
        <div class="p-4" style="border-bottom: 2px solid rgba(163,177,198,0.2);">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="mb-0 fw-bold" style="color: var(--af-positive);">
                        <i class="bi bi-table me-2"></i>Hasil Klasifikasi ({{ ucfirst($jenis) }})
                    </h5>
                    <small class="text-muted">Periode: {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
                        @if($jenis === 'sekolah' && $kelasFilter) — Kelas: {{ $kelasFilter }} @endif
                        @if($jenis === 'pengajian' && $kamarFilter) — Ruang: {{ $kamarFilter }} @endif
                    </small>
                </div>
                @if($evaluasis->count() > 0 && $bermasalah->count() > 0)
                    <button type="button" onclick="kirimKePortal(this)" class="neo-btn" style="background-color: #3182CE; color: white; border: none; padding: 8px 16px; font-size: 0.9rem; font-weight: bold;">
                        <i class="bi bi-send-fill me-2"></i>Kirim ke {{ $targetPortal }}
                    </button>
                    
                    <script>
                        function kirimKePortal(btn) {
                            let originalText = btn.innerHTML;
                            btn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Mengirim...';
                            btn.disabled = true;
                            
                            const payload = {
                                _token: '{{ csrf_token() }}',
                                bulan: '{{ $bulan }}',
                                tahun: '{{ $tahun }}',
                                jenis: '{{ $jenis }}'
                            };

                            fetch("{{ route('evaluasi.kirim-portal') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Berhasil Diteruskan!';
                                    btn.style.backgroundColor = '#38A169'; // Green success
                                    
                                    Swal.fire({
                                        title: 'Berhasil Diteruskan!',
                                        text: data.count + ' data santri bermasalah (Kategori Rendah/Sedang) telah masuk ke antrean Dasbor {{ $targetPortal }}.',
                                        icon: 'success',
                                        confirmButtonText: 'Selesai',
                                        confirmButtonColor: '#38A169'
                                    });
                                } else {
                                    throw new Error(data.message || 'Terjadi kesalahan');
                                }
                            })
                            .catch(error => {
                                btn.innerHTML = originalText;
                                btn.disabled = false;
                                Swal.fire('Gagal!', 'Tidak dapat meneruskan data ke portal.', 'error');
                            });
                        }
                    </script>
                @endif
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="table table-borderless table-hover align-middle" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="padding: 1rem 1.25rem;">No</th>
                        <th style="padding: 1rem 1.25rem;">NIS</th>
                        <th style="padding: 1rem 1.25rem;">Nama Santri</th>
                        <th style="padding: 1rem 1.25rem;">L/P</th>
                        @if($jenis === 'sekolah')
                            <th class="text-center" style="padding: 1rem 1.25rem;">Kelas</th>
                            <th class="text-center" style="padding: 1rem 1.25rem;">
                                <span title="Hadir / Total Hari Efektif">% Sekolah</span>
                            </th>
                        @else
                            <th class="text-center" style="padding: 1rem 1.25rem;">Ruang Pengajian</th>
                            <th class="text-center" style="padding: 1rem 1.25rem;">
                                <span title="Hadir / Total Hari Efektif">% Pengajian</span>
                            </th>
                        @endif
                        <th class="text-center" style="padding: 1rem 1.25rem;">Kategori</th>
                        <th class="text-center" style="padding: 1rem 1.25rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluasis as $index => $eval)
                    <tr>
                        <td style="padding: 0.85rem 1.25rem;" class="fw-bold text-muted">{{ $index + 1 }}</td>
                        <td style="padding: 0.85rem 1.25rem;">
                            <span class="text-muted">{{ $eval->santri->nis ?? '-' }}</span>
                        </td>
                        <td style="padding: 0.85rem 1.25rem;">
                            <span class="fw-bold" style="color: var(--af-positive);">{{ $eval->santri->nama ?? '-' }}</span>
                        </td>
                        <td style="padding: 0.85rem 1.25rem;">
                            @if(($eval->santri->jenis_kelamin ?? '') == 'Putra')
                                <span class="badge" style="background:#EBF8FF;color:#2B6CB0;"><i class="bi bi-gender-male"></i> L</span>
                            @elseif(($eval->santri->jenis_kelamin ?? '') == 'Putri')
                                <span class="badge" style="background:#FFF5F5;color:#C53030;"><i class="bi bi-gender-female"></i> P</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        @if($jenis === 'sekolah')
                            <td class="text-center" style="padding: 0.85rem 1.25rem;">{{ $eval->santri->kelas ?? '-' }}</td>
                            <td class="text-center" style="padding: 0.85rem 1.25rem;">
                                <span class="fw-bold {{ $eval->persentase_sekolah >= 90 ? 'text-success' : ($eval->persentase_sekolah >= 75 ? 'text-warning' : 'text-danger') }}">
                                    {{ $eval->persentase_sekolah }}%
                                </span>
                                <br><small class="text-muted">({{ $eval->total_hadir_sekolah }}/{{ $eval->total_hari_sekolah }})</small>
                            </td>
                        @else
                            <td class="text-center" style="padding: 0.85rem 1.25rem;">{{ $eval->santri->ruang_pengajian ?? '-' }}</td>
                            <td class="text-center" style="padding: 0.85rem 1.25rem;">
                                <span class="fw-bold {{ $eval->persentase_pengajian >= 90 ? 'text-success' : ($eval->persentase_pengajian >= 75 ? 'text-warning' : 'text-danger') }}">
                                    {{ $eval->persentase_pengajian }}%
                                </span>
                                <br><small class="text-muted">({{ $eval->total_hadir_pengajian }}/{{ $eval->total_hari_pengajian }})</small>
                            </td>
                        @endif
                        <td class="text-center" style="padding: 0.85rem 1.25rem;">
                            @if(in_array($eval->kategori_disiplin, ['Disiplin', 'Tinggi']))
                                <span class="badge rounded-pill px-3 py-2" style="background: #38A169; color: white; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(56,161,105,0.3);">
                                    <i class="bi bi-check-circle-fill me-1"></i>DISIPLIN
                                </span>
                            @elseif(in_array($eval->kategori_disiplin, ['Cukup Disiplin', 'Sedang']))
                                <span class="badge rounded-pill px-3 py-2" style="background: #D69E2E; color: white; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(214,158,46,0.3);">
                                    <i class="bi bi-dash-circle-fill me-1"></i>CUKUP DISIPLIN
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2" style="background: #E53E3E; color: white; font-size: 0.85rem; box-shadow: 0 2px 6px rgba(229,62,62,0.3);">
                                    <i class="bi bi-exclamation-circle-fill me-1"></i>KURANG DISIPLIN
                                </span>
                            @endif
                        </td>
                        <td class="text-center" style="padding: 0.85rem 1.25rem;">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="javascript:void(0);" 
                                   onclick="window.open('{{ route('evaluasi.download-pdf', ['santri_id' => $eval->santri_id, 'bulan' => $bulan, 'tahun' => $tahun, 'jenis' => $jenis]) }}', 'PDFPreview', 'width=1000,height=700,left='+(screen.width-1000)/2+',top='+(screen.height-700)/2+',menubar=no,toolbar=no,location=no,status=no');"
                                   class="neo-btn" 
                                   style="padding: 0.35rem 0.75rem; font-size: 0.75rem; color: var(--af-negative); white-space: nowrap;" 
                                   title="Preview Laporan Individu PDF">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                </a>
                                <button type="button" class="neo-btn" 
                                        style="padding: 0.35rem 0.75rem; font-size: 0.75rem; color: #805AD5; background: #FAF5FF; border: 1px solid #D6BCFA; white-space: nowrap;"
                                        onclick="openDiagnosis({{ $eval->id }}, '{{ $jenis }}')" title="Penjelasan Hasil Analisis">
                                    <i class="bi bi-magic me-1"></i>Penjelasan
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada hasil evaluasi untuk periode ini.<br>
                                <small>Tekan tombol <strong>"Proses Evaluasi"</strong> di atas untuk memulai klasifikasi.</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($evaluasis->hasPages())
        <div style="padding: 1.5rem; background: white; border-top: 1px solid rgba(0,0,0,0.05);" class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Menampilkan {{ $evaluasis->firstItem() }}–{{ $evaluasis->lastItem() }}
                dari <strong>{{ $evaluasis->total() }}</strong> hasil evaluasi
            </div>
            <div>
                @php
                    $prev = $evaluasis->currentPage() > 1;
                    $next = $evaluasis->hasMorePages();
                @endphp
                <div class="d-flex gap-1 align-items-center">
                    {{-- Prev --}}
                    @if($prev)
                        <a href="{{ $evaluasis->appends(request()->query())->previousPageUrl() }}" class="neo-btn px-3 py-1" style="font-size:0.85rem;">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @else
                        <span class="neo-btn px-3 py-1" style="font-size:0.85rem;opacity:0.4;cursor:not-allowed;">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @endif

                    {{-- Page numbers --}}
                    @foreach($evaluasis->getUrlRange(max(1, $evaluasis->currentPage()-2), min($evaluasis->lastPage(), $evaluasis->currentPage()+2)) as $page => $url)
                        <a href="{{ $url . '&' . http_build_query(request()->except('page')) }}"
                           class="neo-btn px-3 py-1 {{ $page == $evaluasis->currentPage() ? 'neo-btn-primary' : '' }}"
                           style="font-size:0.85rem;min-width:36px;text-align:center;">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Next --}}
                    @if($next)
                        <a href="{{ $evaluasis->appends(request()->query())->nextPageUrl() }}" class="neo-btn px-3 py-1" style="font-size:0.85rem;">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="neo-btn px-3 py-1" style="font-size:0.85rem;opacity:0.4;cursor:not-allowed;">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Simulasi & Verifikasi Data (CRISP-DM) -->
<div class="modal fade" id="modalSimulasiForward" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); background-color: #F8FAFC;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(163,177,198,0.2); padding: 1.25rem 1.5rem; background-color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title fw-bold" style="color: var(--af-dark);">
                    <i class="bi bi-cpu text-primary me-2"></i>Rekap data & Perhitungan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <!-- Info Section -->
                <div class="p-4 bg-white" style="border-bottom: 1px dashed #CBD5E0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 rounded-circle" style="background: rgba(49, 130, 206, 0.1); color: #3182CE;">
                            <i class="bi bi-info-circle-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--af-dark);">Fase Rekaputulasi Data Absensi & Perhitungan</h6>
                            <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                               Tabel berikut menampilkan hasil rekapitulasi data absensi. Sebelum proses klasifikasi dilakukan terhadap seluruh data santri, sistem melakukan verifikasi terhadap hasil perhitungan guna memastikan validitas dan ketepatan pengolahan data. Rumus dasar: <strong>Persentase = (Total Hadir / Total Pertemuan) × 100</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Simulation Table -->
                <div class="p-4" style="background-color: #EDF2F7;">
                    <div class="table-responsive neo-card p-0" style="background: white; border: 1px solid #E2E8F0; border-radius: 10px; max-height: 50vh; overflow-y: auto;">
                        <table class="table table-borderless table-hover align-middle mb-0" style="font-size: 0.9rem;">
                            <thead style="background-color: #F7FAFC; border-bottom: 2px solid #E2E8F0; position: sticky; top: 0; z-index: 1;">
                                <tr>
                                    <th colspan="6" class="text-center" style="border-right: 2px dashed #CBD5E0; color: #4A5568;">REKAPUTULASI</th>
                                    <th colspan="2" class="text-center" style="color: #2B6CB0;">PERHITUNGAN</th>
                                </tr>
                                <tr style="color: #718096; font-size: 0.8rem; letter-spacing: 0.5px;">
                                    <th class="py-3 px-3">NAMA SANTRI</th>
                                    <th class="py-3 px-3 text-center">TOTAL PERTEMUAN</th>
                                    <th class="py-3 px-3 text-center text-success">HADIR</th>
                                    <th class="py-3 px-3 text-center text-warning">IZIN</th>
                                    <th class="py-3 px-3 text-center text-info">SAKIT</th>
                                    <th class="py-3 px-3 text-center text-danger" style="border-right: 2px dashed #CBD5E0;">ALPA</th>
                                    <th class="py-3 px-3 bg-light">PROSES PERHITUNGAN <span class="text-muted text-lowercase font-monospace ms-2"></span></th>
                                    <th class="py-3 px-3 text-center bg-light">PERSENTASE (P)</th>
                                </tr>
                            </thead>
                            <tbody id="simulasiTableBody">
                                <!-- Loading State -->
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="spinner-border text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                                        <h6 class="fw-bold text-muted mb-0">Sistem Sedang Menarik & Memproses Data...</h6>
                                        <small class="text-muted">Mohon Ditunggu</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer d-flex justify-content-between" style="border-top: 1px solid rgba(163,177,198,0.2); padding: 1rem 1.5rem; background-color: white; border-radius: 0 0 12px 12px;">
                <button type="button" class="btn btn-light fw-bold text-muted px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="neo-btn neo-btn-primary px-4" id="btnEksekusiSimulasi" onclick="submitEvaluasiForm()" style="font-weight: bold; opacity: 0.5; pointer-events: none;" disabled>
                    <i class="bi bi-gear-wide-connected me-2 btn-spinner-icon"></i> Klasifikasi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Diagnosis BK (Backward Chaining) -->
<style>
.custom-scroll::-webkit-scrollbar { width: 6px; }
.custom-scroll::-webkit-scrollbar-track { background: rgba(163,177,198,0.1); border-radius: 10px; }
.custom-scroll::-webkit-scrollbar-thumb { background: rgba(163,177,198,0.4); border-radius: 10px; }
.custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(163,177,198,0.6); }

.timeline-item-neo {
    position: relative;
    margin-bottom: 1.25rem;
}
.timeline-icon-neo {
    position: absolute;
    left: -1.35rem;
    top: 0.1rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: bold;
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>

<div class="modal fade" id="modalDiagnosis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: var(--neo-shadow-outer); background-color: #EDF2F7;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(163,177,198,0.2); padding: 1.5rem;">
                <h5 class="modal-title fw-bold" style="color: #805AD5;">
                    <i class="bi bi-magic me-2"></i>Penjelasan Hasil Analisis
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4" id="diagnosisBody">
                <!-- Loading State -->
                <div class="text-center py-5" id="diagnosisLoading">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <p class="text-muted fw-bold" style="letter-spacing: 1px; font-size: 0.85rem; text-transform: uppercase;">Memproses Hasil Analisis...</p>
                </div>

                <!-- Content State -->
                <div id="diagnosisContent" style="display: none;">
                    <div class="row g-4">
                        
                        <!-- Bagian Kiri: Stats & Hasil (7 Kolom) -->
                        <div class="col-lg-7 d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center mb-1 px-2">
                                <h5 class="fw-bold mb-0" id="diagSantri" style="color: var(--af-dark);">Nama Santri</h5>
                                <span id="diagKategoriBadge" class="badge bg-secondary" style="font-size: 0.85rem; padding: 0.5em 1em; border-radius: 50px; box-shadow: var(--neo-shadow-sm);">
                                    Kategori: Rendah
                                </span>
                            </div>

                            <!-- Stats Grid -->
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="neo-card text-center p-3 h-100">
                                        <h3 class="fw-bold mb-1" id="diagHadir" style="color: #2F855A;">0</h3>
                                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Hadir</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="neo-card text-center p-3 h-100">
                                        <h3 class="fw-bold mb-1" id="diagIzin" style="color: #D69E2E;">0</h3>
                                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Izin</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="neo-card text-center p-3 h-100" style="border: 1px solid rgba(229,62,62,0.2); position: relative; overflow: hidden;">
                                        <div style="position: absolute; top: -10px; right: -10px; width: 30px; height: 30px; background: rgba(229,62,62,0.1); border-radius: 50%;"></div>
                                        <h3 class="fw-bold mb-1" id="diagAlpa" style="color: #E53E3E;">0</h3>
                                        <small class="text-danger text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Alpa</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Diagnosis Section -->
                            <div class="neo-card p-3 d-flex flex-grow-1 align-items-start gap-3">
                                <div class="rounded p-2" style="background: rgba(49, 130, 206, 0.1); color: #3182CE;">
                                    <i class="bi bi-search fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px; color: var(--af-dark);">Kesimpulan Sistem</h6>
                                    <p id="diagKesimpulan" class="mb-0 text-muted" style="font-size: 0.9rem; line-height: 1.5;"></p>
                                </div>
                            </div>

                            <!-- Action Section -->
                            <div class="neo-card p-3 d-flex align-items-start gap-3" style="background: rgba(128, 90, 213, 0.05); border: 1px dashed rgba(128, 90, 213, 0.3);">
                                <div class="rounded p-2" style="background: rgba(128, 90, 213, 0.1); color: #805AD5;">
                                    <i class="bi bi-lightbulb-fill fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-uppercase" style="color: #805AD5; font-size: 0.85rem; letter-spacing: 0.5px;">Rekomendasi Tindakan</h6>
                                    <p id="diagSaran" class="mb-0 text-muted" style="font-size: 0.9rem; line-height: 1.5;"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Kanan: Trace Log (5 Kolom) -->
                        <div class="col-lg-5">
                            <div class="neo-card p-4 h-100 d-flex flex-column" style="max-height: 420px; background: rgba(255,255,255,0.4);">
                                <h6 class="fw-bold text-muted text-uppercase mb-3 pb-2" style="font-size: 0.75rem; letter-spacing: 1px; border-bottom: 1px solid rgba(163,177,198,0.2);">
                                    Penjelasan Hasil Analisis
                                </h6>
                                <div class="overflow-auto pe-2 flex-grow-1 custom-scroll" style="position: relative;">
                                    <div class="ps-3 ms-2 mt-2" style="border-left: 2px solid rgba(163,177,198,0.3);" id="diagTrace">
                                        <!-- Injected Timeline Items -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="modal-footer d-flex justify-content-between" style="border-top: 1px solid rgba(163,177,198,0.2); padding: 1rem 1.5rem;">
                <button type="button" class="neo-btn text-muted" style="background: #E2E8F0; box-shadow: none;" data-bs-dismiss="modal">Tutup</button>
                <a id="btnCetakSP" href="#" target="_blank" class="neo-btn" style="background: #3182CE; color: white; padding: 10px 20px; font-size: 0.85rem; text-transform: uppercase; font-weight: bold;">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Unduh Laporan
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function bukaModalSimulasi() {
        const selectTarget = document.getElementById('selectTarget');
        if (selectTarget && (!selectTarget.value || selectTarget.value.trim() === '')) {
            alert('Harap pilih Target Kelas/Ruang terlebih dahulu.');
            return;
        }
        var modal = new bootstrap.Modal(document.getElementById('modalSimulasiForward'));
        modal.show();
        
        // Disable button while loading
        const btnSubmit = document.getElementById('btnEksekusiSimulasi');
        const tbody = document.getElementById('simulasiTableBody');
        
        btnSubmit.disabled = true;
        btnSubmit.style.opacity = '0.5';
        btnSubmit.style.pointerEvents = 'none';
        
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <h6 class="fw-bold text-muted mb-0">Sistem Sedang Menarik & Memproses Data...</h6>
                    <small class="text-muted">Menerapkan kriteria kedisiplinan otomatis</small>
                </td>
            </tr>
        `;
        
        // Ambil filter
        let bulan = document.querySelector('#formEvaluasi select[name="bulan"]').value;
        let tahun = document.querySelector('#formEvaluasi select[name="tahun"]').value;
        let jenis = document.querySelector('#formEvaluasi input[name="jenis"]').value;
        
        let kelas = document.querySelector('#formEvaluasi select[name="kelas"]') ? document.querySelector('#formEvaluasi select[name="kelas"]').value : '';
        let kamar = document.querySelector('#formEvaluasi select[name="kamar"]') ? document.querySelector('#formEvaluasi select[name="kamar"]').value : '';
        
        // Fetch data absensi riil dari DB
        fetch("{{ route('evaluasi.simulasi') }}?bulan=" + encodeURIComponent(bulan) + "&tahun=" + encodeURIComponent(tahun) + "&jenis=" + encodeURIComponent(jenis) + "&kelas=" + encodeURIComponent(kelas) + "&kamar=" + encodeURIComponent(kamar))
            .then(res => res.json())
            .then(data => {
                if(data.error || data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="8" class="text-center text-danger py-4">Data Tidak Ditemukan. Pastikan ada data absensi pada bulan tersebut.</td></tr>`;
                    return;
                }
                
                let rows = '';
                data.forEach((s, index) => {
                    let totalP = s.total_pertemuan || s.total_hari;
                    let sakitCount = s.sakit || 0;
                    rows += `
                        <tr class="bg-white" style="border-bottom: 1px solid #E2E8F0;">
                            <td class="py-3 px-3 fw-bold" style="color: var(--af-dark);">
                                ${s.nis} - ${s.santri_nama}
                            </td>
                            <td class="py-3 px-3 text-center fw-bold text-muted">${totalP}</td>
                            <td class="py-3 px-3 text-center fw-bold text-success">${s.hadir}</td>
                            <td class="py-3 px-3 text-center fw-bold text-warning">${s.izin}</td>
                            <td class="py-3 px-3 text-center fw-bold text-info">${sakitCount}</td>
                            <td class="py-3 px-3 text-center fw-bold text-danger" style="border-right: 2px dashed #CBD5E0;">${s.alpa}</td>
                            
                            <td class="py-3 px-3 bg-light font-monospace" style="color: #4A5568;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-gear text-primary spinner-border-sm" style="animation-duration: 3s;"></i>
                                    <span>(${s.hadir} / ${totalP}) * 100 = <span style="color:#3182CE">${s.desimal} * 100</span></span>
                                </div>
                            </td>
                            <td class="py-3 px-3 text-center bg-light">
                                <span class="badge" style="background-color: #C6F6D5; color: #22543D; font-size: 0.9rem; padding: 0.5em 1em; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    ${s.persentase}%
                                </span>
                            </td>
                        </tr>
                    `;
                });
                
                // Add tiny delay for effect
                setTimeout(() => {
                    tbody.innerHTML = rows;
                    // Enable button
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.pointerEvents = 'auto';
                }, 800);
                
            }).catch(err => {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4">Gagal memuat data dari server.</td></tr>`;
            });
    }

    function submitEvaluasiForm() {
        document.getElementById('formEvaluasi').submit();
    }

    function openDiagnosis(evaluasiId, jenis) {
        var myModal = new bootstrap.Modal(document.getElementById('modalDiagnosis'));
        myModal.show();
        
        document.getElementById('diagnosisLoading').style.display = 'block';
        document.getElementById('diagnosisContent').style.display = 'none';

        fetch("{{ url('evaluasi/diagnosis') }}?id=" + evaluasiId + "&jenis=" + jenis)
            .then(response => response.json())
            .then(data => {
                document.getElementById('diagnosisLoading').style.display = 'none';
                document.getElementById('diagnosisContent').style.display = 'block';
                
                document.getElementById('diagSantri').innerText = data.santri;
                
                // Set Badge Style Based on Category
                const badge = document.getElementById('diagKategoriBadge');
                badge.innerText = 'Kategori: ' + data.kategori;
                if(data.kategori === 'Tinggi') {
                    badge.className = 'badge';
                    badge.style.backgroundColor = '#38A169'; // Green
                    badge.style.color = '#F0FFF4';
                } else if(data.kategori === 'Sedang') {
                    badge.className = 'badge';
                    badge.style.backgroundColor = '#D69E2E'; // Yellow
                    badge.style.color = '#FFFFF0';
                } else {
                    badge.className = 'badge';
                    badge.style.backgroundColor = '#E53E3E'; // Red
                    badge.style.color = '#FFF5F5';
                }

                // Stats Grid
                if(data.stats) {
                    document.getElementById('diagHadir').innerText = data.stats.hadir;
                    document.getElementById('diagIzin').innerText = data.stats.izin;
                    document.getElementById('diagAlpa').innerText = data.stats.alpa;
                }
                
                const diag = data.diagnosis;
                document.getElementById('diagKesimpulan').innerText = diag.kesimpulan;
                document.getElementById('diagSaran').innerText = diag.saran;
                
                // Parse Penjelasan into Vertical Timeline
                let traceHtml = '';
                if (diag.trace && diag.trace.length > 0) {
                    diag.trace.forEach((item, index) => {
                        let isLast = index === diag.trace.length - 1;
                        let iconColor = isLast ? '#3182CE' : '#A0AEC0';
                        let iconClass = isLast ? 'bi-check2-circle' : 'bi-info-circle';
                        let textColor = isLast ? 'color: #2B6CB0; font-weight: bold;' : 'color: #4A5568;';
                        
                        traceHtml += `
                        <div class="timeline-item-neo">
                            <div class="timeline-icon-neo" style="background: ${iconColor}; color: white;"><i class="bi ${iconClass}"></i></div>
                            <p class="mb-0" style="font-size: 0.85rem; line-height: 1.5; ${textColor}">${item}</p>
                        </div>`;
                    });
                } else {
                    traceHtml = '<p class="text-muted">Penjelasan tidak tersedia.</p>';
                }
                document.getElementById('diagTrace').innerHTML = traceHtml;
                
                const btnSp = document.getElementById('btnCetakSP');
                btnSp.style.display = 'inline-block';
                btnSp.onclick = function(e) {
                    e.preventDefault();
                    window.open("{{ url('evaluasi/download-pdf') }}?santri_id="+data.santri_id+"&bulan={{$bulan}}&tahun={{$tahun}}&jenis="+jenis, 'PDFPreview', 'width=1000,height=700,left='+(screen.width-1000)/2+',top='+(screen.height-700)/2+',menubar=no,toolbar=no,location=no,status=no');
                };
            })
            .catch(error => {
                alert('Terjadi kesalahan sistem saat mendiagnosis.');
                myModal.hide();
            });
    }
</script>
@endsection
