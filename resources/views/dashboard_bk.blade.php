@extends('layouts.bk')

@section('content')
<div style="max-width: 1100px;">

    {{-- ══════════════════════════════════════
        HEADER
    ══════════════════════════════════════ --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1.5rem; margin-bottom:2rem;">
        <div>
            <p style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:var(--muted-fg); margin-bottom:0.25rem;">
                Early Warning System
            </p>
            <h1 style="font-family:'Fraunces',serif; font-weight:700; font-size:2rem; color:var(--fg); line-height:1.2; margin-bottom:0.25rem;">
                Dashboard Guru BK
            </h1>
            <p style="color:var(--muted-fg); font-size:0.88rem;">
                Pantau kedisiplinan & jadwalkan konseling santri
            </p>
        </div>

        {{-- Filter Periode --}}
        <form action="{{ route('dashboard') }}" method="GET"
            style="display:flex; gap:0.6rem; align-items:center; flex-wrap:wrap;">
            <select name="bulan" class="org-input" style="width:auto; min-width:130px;">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="org-input" style="width:auto; min-width:90px;">
                @for($y = (int)date('Y') + 10; $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="org-btn org-btn-primary">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </form>
    </div>

    {{-- ══════════════════════════════════════
        EWS CARD — PRIORITAS KONSELING
    ══════════════════════════════════════ --}}
    <div class="org-card" style="margin-bottom:1.75rem;">
        {{-- Card Header --}}
        <div style="padding:1.5rem 1.75rem; border-bottom:1px solid rgba(222,216,207,0.5); background:linear-gradient(135deg, rgba(232,168,56,0.06) 0%, rgba(193,140,93,0.04) 100%); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:44px;height:44px;border-radius:14px;background:rgba(232,168,56,0.15);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-clipboard2-pulse-fill" style="color:#B7791F; font-size:1.2rem;"></i>
                </div>
                <div>
                    <h2 style="font-family:'Fraunces',serif; font-size:1.1rem; font-weight:700; color:var(--fg); margin-bottom:2px;">
                        Bahan Evaluasi BK
                    </h2>
                    <p style="font-size:0.75rem; color:var(--muted-fg); margin:0;">
                        Santri butuh konseling — Kehadiran Sekolah Formal kritis
                    </p>
                </div>
            </div>
            <span class="org-badge org-badge-warning">
                <i class="bi bi-exclamation-triangle-fill"></i> Prioritas Konseling
            </span>
        </div>

        {{-- EWS Table --}}
        <div style="overflow-x:auto;">
            <table class="org-table">
                <thead>
                    <tr>
                        <th>Nama Santri</th>
                        <th>Kelas Formal</th>
                        <th style="min-width:220px;">Tingkat Kehadiran</th>
                        <th>Tindak Lanjut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ewsBK as $item)
                    <tr>
                        <td>
                            <div style="font-weight:700; color:var(--fg);">{{ $item->santri->nama ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="org-badge org-badge-muted">{{ $item->santri->kelas ?? '-' }}</span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="org-progress" style="flex:1;">
                                    <div class="org-progress-fill" style="width:{{ $item->persentase_sekolah }}%;"></div>
                                </div>
                                <span style="font-size:0.78rem; font-weight:700; color:#8A6400; white-space:nowrap;">
                                    {{ $item->persentase_sekolah }}% Waspada
                                </span>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                <button type="button" class="org-btn org-btn-warning"
                                    style="font-size:0.78rem; padding:0.4rem 1rem;"
                                    data-bs-toggle="modal" data-bs-target="#modalKonseling"
                                    data-nama="{{ $item->santri->nama ?? '-' }}"
                                    data-kelas="{{ $item->santri->kelas ?? '-' }}"
                                    data-persentase="{{ $item->persentase_sekolah }}"
                                    data-link="{{ url(route('evaluasi.download-pdf', ['santri_id' => $item->santri_id, 'bulan' => $bulan, 'tahun' => $tahun, 'jenis' => 'sekolah'])) }}">
                                    <i class="bi bi-chat-heart-fill"></i> Jadwalkan Konseling
                                </button>
                                <a href="javascript:void(0);" 
                                   onclick="window.open('{{ route('evaluasi.download-pdf', ['santri_id' => $item->santri_id, 'bulan' => $bulan, 'tahun' => $tahun, 'jenis' => 'sekolah']) }}', 'PDFPreview', 'width=1000,height=700');"
                                   class="org-btn org-btn-dark"
                                   style="font-size:0.78rem; padding:0.4rem 1rem;">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> Lihat PDF
                                </a>
                                <form action="{{ route('evaluasi.selesai', ['id' => $item->id, 'type' => 'bk']) }}" method="POST" class="m-0" id="form-selesai-{{ $item->id }}">
                                    @csrf
                                    <button type="button" class="org-btn" style="font-size:0.78rem; padding:0.4rem 1rem; background: #059669; border: none; color: white;" onclick="confirmSelesai({{ $item->id }}, '{{ addslashes($item->santri->nama ?? 'Santri') }}')">
                                        <i class="bi bi-check-circle-fill"></i> Selesai
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:3rem 1rem; color:var(--muted-fg);">
                            <div style="width:56px;height:56px;border-radius:50%;background:var(--muted);display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                                <i class="bi bi-shield-check" style="font-size:1.5rem;color:var(--primary);"></i>
                            </div>
                            <p style="font-weight:600; color:var(--fg); margin-bottom:4px;">Semua Santri Aman</p>
                            <small>Belum ada santri dengan kehadiran sekolah di bawah 75%</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         LIVE FEED AKTIVITAS
    ══════════════════════════════════════ --}}
    <div class="org-card">
        {{-- Feed Header --}}
        <div style="padding:1.25rem 1.75rem; border-bottom:1px solid rgba(222,216,207,0.5); display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:44px;height:44px;border-radius:14px;background:rgba(93,112,82,0.1);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-activity" style="color:var(--primary); font-size:1.2rem;"></i>
                </div>
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <h2 style="font-family:'Fraunces',serif; font-size:1.05rem; font-weight:700; color:var(--fg); margin:0;">
                            Aktivitas Guru Sekolah
                        </h2>
                        <span class="pulse-dot"></span>
                    </div>
                    <p style="font-size:0.72rem; color:var(--muted-fg); margin:0;">Live · Auto-refresh setiap 30 detik</p>
                </div>
            </div>
        </div>

        {{-- Feed Items --}}
        <div id="liveFeedContainer" style="max-height:400px; overflow-y:auto;">
            @forelse($liveFeed as $item)
            @php
                $isHadir = $item->status === 'Hadir';
                $isIzin  = $item->status === 'Izin';
                $avatarBg  = $isHadir ? 'rgba(93,112,82,0.15)'  : ($isIzin ? 'rgba(232,168,56,0.15)' : 'rgba(168,84,72,0.12)');
                $avatarClr = $isHadir ? 'var(--primary)'        : ($isIzin ? '#8A6400'              : 'var(--destructive)');
                $badgeBg   = $isHadir ? 'rgba(93,112,82,0.12)'  : ($isIzin ? 'rgba(232,168,56,0.12)' : 'rgba(168,84,72,0.1)');
                $badgeClr  = $isHadir ? 'var(--primary)'        : ($isIzin ? '#8A6400'              : 'var(--destructive)');
            @endphp
            <div class="org-feed-item">
                <div class="org-feed-avatar" style="background:{{ $avatarBg }}; color:{{ $avatarClr }};">
                    {{ substr($item->santri->nama ?? 'S', 0, 1) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:700; font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $item->santri->nama ?? '-' }}
                    </div>
                    <div style="font-size:0.72rem; color:var(--muted-fg);">
                        {{ $item->jenis_kegiatan }} &middot; {{ $item->santri->kelas ?? '' }} &middot; {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </div>
                </div>
                <span style="padding:3px 12px; border-radius:50px; font-size:0.72rem; font-weight:700; white-space:nowrap; background:{{ $badgeBg }}; color:{{ $badgeClr }};">
                    {{ $item->status }}
                </span>
            </div>
            @empty
            <div style="text-align:center; padding:3rem 1rem; color:var(--muted-fg);">
                <i class="bi bi-inbox" style="font-size:2.5rem; opacity:0.25; display:block; margin-bottom:0.5rem;"></i>
                <small>Belum ada aktivitas absensi hari ini</small>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════
     MODAL KONSELING WHATSAPP
══════════════════════════════════════ --}}
<div class="modal fade" id="modalKonseling" tabindex="-1" aria-labelledby="modalKonselingLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
    <div class="modal-content" style="border-radius:2rem; border:1px solid var(--border); box-shadow:var(--shadow-float); background:var(--bg); overflow:hidden;">
      {{-- Modal Header --}}
      <div style="padding:1.5rem 1.75rem 1rem; background:linear-gradient(135deg,rgba(93,112,82,0.06),rgba(193,140,93,0.04)); border-bottom:1px solid rgba(222,216,207,0.5);">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:42px;height:42px;border-radius:14px;background:rgba(37,211,102,0.12);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-whatsapp" style="color:#25D366;font-size:1.2rem;"></i>
                </div>
                <div>
                    <h5 id="modalKonselingLabel" style="font-family:'Fraunces',serif;font-weight:700;font-size:1.1rem;color:var(--fg);margin:0;">
                        Kirim Undangan Konseling
                    </h5>
                    <p style="font-size:0.72rem;color:var(--muted-fg);margin:0;">Draf pesan terisi otomatis dari data santri</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>

      {{-- Modal Body --}}
      <div style="padding:1.5rem 1.75rem;">
        <div style="margin-bottom:1rem;">
            <label style="display:block;font-weight:700;font-size:0.8rem;color:var(--fg);margin-bottom:0.4rem;">
                Pesan WhatsApp <span style="color:var(--muted-fg);font-weight:500;">(dapat diedit)</span>
            </label>
            <textarea id="waMessageText" class="org-textarea" rows="6" placeholder="Draf pesan akan muncul otomatis..."></textarea>
        </div>
        <div>
            <label style="display:block;font-weight:700;font-size:0.8rem;color:var(--fg);margin-bottom:0.4rem;">
                Nomor WA Tujuan
            </label>
            <div style="position:relative;">
                <input type="text" id="waPhoneNumber" class="org-input"
                       placeholder="Contoh: 6281234567890"
                       style="padding-right:3rem;">
                <button type="button" id="btnPickContact"
                        title="Pilih dari Kontak Perangkat"
                        style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--primary);cursor:pointer;padding:4px;font-size:1.1rem;">
                    <i class="bi bi-person-lines-fill"></i>
                </button>
            </div>
            <small style="color:var(--muted-fg);font-size:0.7rem;margin-top:4px;display:block;">
                * Format 62 tanpa awalan 0. Fitur pilih kontak tersedia di browser mobile.
            </small>
        </div>
      </div>

      {{-- Modal Footer --}}
      <div style="padding:1rem 1.75rem 1.5rem; display:flex; justify-content:flex-end; gap:0.75rem; border-top:1px solid rgba(222,216,207,0.4);">
        <button type="button" class="org-btn org-btn-ghost" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="org-btn"
                style="background:#25D366;color:white;box-shadow:0 4px 16px -2px rgba(37,211,102,0.3);"
                onclick="sendWhatsApp()">
            <i class="bi bi-send-fill"></i> Kirim via WhatsApp
        </button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Live Feed Auto-Refresh ──
    function refreshLiveFeed() {
        fetch('{{ route("dashboard.live-feed") }}')
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('liveFeedContainer');
                if (!container) return;

                if (!data.length) {
                    container.innerHTML = `
                        <div style="text-align:center;padding:3rem 1rem;color:var(--muted-fg);">
                            <i class="bi bi-inbox" style="font-size:2.5rem;opacity:0.25;display:block;margin-bottom:0.5rem;"></i>
                            <small>Belum ada aktivitas absensi hari ini</small>
                        </div>`;
                    return;
                }

                const clr = {
                    'Hadir': { bg: 'rgba(93,112,82,0.15)',  txt: 'var(--primary)' },
                    'Izin':  { bg: 'rgba(232,168,56,0.15)', txt: '#8A6400' },
                    'Alpa':  { bg: 'rgba(168,84,72,0.12)',  txt: 'var(--destructive)' }
                };

                container.innerHTML = data.map(item => {
                    const c = clr[item.status] || clr['Alpa'];
                    return `
                        <div class="org-feed-item">
                            <div class="org-feed-avatar" style="background:${c.bg};color:${c.txt};">
                                ${item.santri.charAt(0)}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-weight:700;font-size:0.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${item.santri}</div>
                                <div style="font-size:0.72rem;color:var(--muted-fg);">${item.jenis} &middot; ${item.kelas} &middot; ${item.tanggal}</div>
                            </div>
                            <span style="padding:3px 12px;border-radius:50px;font-size:0.72rem;font-weight:700;white-space:nowrap;background:${c.bg};color:${c.txt};">${item.status}</span>
                        </div>`;
                }).join('');
            })
            .catch(() => {});
    }

    setTimeout(refreshLiveFeed, 5000);
    setInterval(refreshLiveFeed, 30000);

    function formatPersen(val) {
        if (!val) return '0%';
        let numStr = val.toString().replace('%', '').trim();
        let num = parseFloat(numStr);
        if (isNaN(num)) return val;
        if (num % 1 === 0) {
            return num.toFixed(0) + '%';
        }
        let formatted = num.toFixed(2);
        if (formatted.endsWith('.00')) {
            formatted = num.toFixed(0);
        } else if (formatted.endsWith('0')) {
            formatted = num.toFixed(1);
        }
        return formatted.replace('.', ',') + '%';
    }

    // ── Modal: Auto-fill draft pesan ──
    const modalKonseling = document.getElementById('modalKonseling');
    if (modalKonseling) {
        modalKonseling.addEventListener('show.bs.modal', function (event) {
            const btn        = event.relatedTarget;
            const nama       = btn.getAttribute('data-nama');
            const kelas      = btn.getAttribute('data-kelas');
            const persentase = btn.getAttribute('data-persentase');
            const link       = btn.getAttribute('data-link');

            const formattedPersen = formatPersen(persentase);

            const draft =
`*Assalamu'alaikum, Ustadz/Ustadzah Wali Kelas ${kelas}.*

Mohon bantuannya untuk mengarahkan santri berikut:

👤 *Nama:* ${nama}
📚 *Kelas:* ${kelas}
📊 *Kehadiran Sekolah:* ${formattedPersen}
⚠️ *Status:* Zona Waspada

Mohon santri tersebut diarahkan untuk *menghadap ke Ruang BK saat waktu istirahat hari ini* untuk mendapatkan tindak lanjut dan konseling.

📎 *Hasil Evaluasi:*
${link}

Terima kasih atas kerja samanya.

*Wassalamu'alaikum.*`;

            document.getElementById('waMessageText').value = draft;
        });
    }

    // ── Contact Picker API ──
    document.getElementById('btnPickContact')?.addEventListener('click', async () => {
        if ('contacts' in navigator && 'ContactsManager' in window) {
            try {
                const contacts = await navigator.contacts.select(['name', 'tel'], { multiple: false });
                if (contacts.length > 0 && contacts[0].tel?.length > 0) {
                    let phone = contacts[0].tel[0].replace(/\D/g, '');
                    if (phone.startsWith('0')) phone = '62' + phone.substring(1);
                    document.getElementById('waPhoneNumber').value = phone;
                }
            } catch (ex) {
                console.error('Gagal mengakses kontak', ex);
            }
        } else {
            alert('Maaf, browser atau perangkat Anda belum mendukung fitur akses kontak otomatis. Harap ketik nomor secara manual.');
        }
    });
});

function sendWhatsApp() {
    let phone   = document.getElementById('waPhoneNumber').value;
    const msg   = document.getElementById('waMessageText').value;

    if (!phone) {
        Swal.fire({
            icon: 'warning',
            title: 'Nomor Belum Diisi',
            text: 'Silakan masukkan nomor WhatsApp tujuan terlebih dahulu.',
            confirmButtonColor: '#059669'
        });
        return;
    }
    phone = phone.replace(/\D/g, '');
    if (phone.startsWith('0')) phone = '62' + phone.substring(1);

    // Tutup modal bootstrap
    const modalEl = document.getElementById('modalKonseling');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    // Tampilkan loading
    Swal.fire({
        title: 'Mengirim Pesan...',
        html: `Mengirimkan pesan ke <strong>+${phone}</strong>...`,
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    // Panggil Fonnte API langsung dari browser (lebih cepat)
    const formData = new FormData();
    formData.append('target', phone);
    formData.append('message', msg);
    formData.append('countryCode', '62');

    fetch('https://api.fonnte.com/send', {
        method: 'POST',
        headers: {
            'Authorization': 'Eb7QCv1ycJSNTKmexzb7'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === true) {
            Swal.fire({
                icon: 'success',
                title: 'Pesan Berhasil Terkirim!',
                html: `Pesan undangan konseling telah dikirimkan ke nomor <strong>+${phone}</strong> tanpa perlu berpindah aplikasi.`,
                confirmButtonColor: '#059669'
            });
        } else {
            Swal.fire('Gagal', 'Gateway menolak permintaan: ' + (data.reason || 'Pastikan perangkat Fonnte aktif.'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Gagal menghubungi server Fonnte. Periksa koneksi internet.', 'error');
    });
}

function confirmSelesai(id, nama) {
    Swal.fire({
        title: 'Tandai Selesai?',
        html: `Apakah Anda yakin sudah menindaklanjuti santri bernama <strong>${nama}</strong>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#A85448',
        confirmButtonText: 'Ya, Selesai!',
        cancelButtonText: 'Batal',
        shape: 'pill'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-selesai-' + id).submit();
        }
    });
}
</script>

@endsection
