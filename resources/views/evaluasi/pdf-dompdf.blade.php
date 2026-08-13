<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $namaFile }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        /* ================================
           PRINT MEDIA QUERY
        ================================ */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0 !important;
            }
        }

        /* ================================
           ACTION BUTTONS
        ================================ */
        .action-buttons {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-family: sans-serif;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }
        .btn-print { background-color: #3182ce; color: white; }
        .btn-back { background-color: #e2e8f0; color: #2d3748; }

        /* ================================
           KOP SURAT PESANTREN
        ================================ */
        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap');
        
        .kop-surat-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .kop-surat-table td {
            vertical-align: middle;
            border: none;
        }
        .kop-logo {
            width: 90px;
            text-align: left;
        }
        .kop-logo img {
            width: 80px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            padding-right: 90px; /* Penyeimbang agar teks benar-benar di tengah */
        }
        .kop-text .yayasan {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .kop-text .pesantren-ar {
            font-family: 'Amiri', 'DejaVu Sans', serif;
            font-size: 26px;
            font-weight: bold;
            margin: 4px 0;
        }
        .kop-text .pesantren {
            font-size: 18px;
            font-weight: bold;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .kop-text .alamat {
            font-size: 10px;
            color: #333;
            margin-top: 3px;
        }
        .garis-kop {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-bottom: 15px;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul-laporan u {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .judul-laporan div {
            font-size: 10px;
            margin-top: 3px;
        }

        /* ================================
           IDENTITAS SANTRI
        ================================ */
        .identitas-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .identitas-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .identitas-table .label {
            width: 120px;
            font-weight: bold;
        }
        .identitas-table .titik-dua {
            width: 10px;
        }

        /* ================================
           TABEL RIWAYAT
        ================================ */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            text-decoration: underline;
        }
        table.riwayat {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.riwayat th, table.riwayat td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        table.riwayat th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .hari-libur {
            background-color: #ffeaea !important;
            color: #cc0000;
        }

        /* ================================
           SUMMARY & FOOTER
        ================================ */
        .summary-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
        }
        .summary-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }
        .summary-content {
            width: 100%;
        }
        .summary-content td {
            vertical-align: top;
            width: 50%;
        }

        .badge-tinggi { background-color: #38A169; color: white; padding: 3px 8px; border-radius: 10px; font-weight: bold; }
        .badge-sedang { background-color: #D69E2E; color: white; padding: 3px 8px; border-radius: 10px; font-weight: bold; }
        .badge-rendah { background-color: #E53E3E; color: white; padding: 3px 8px; border-radius: 10px; font-weight: bold; }

        .ttd-box {
            width: 100%;
            margin-top: 60px; /* Diperbesar agar jauh dari tabel rekap */
        }
        .ttd-box td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
    </style>
</head>
<body>

    <!-- ACTION BUTTONS (Tidak Ikut Tercetak) -->
    <div class="no-print action-buttons" style="display: flex; justify-content: center; gap: 8px; margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #e2e8f0; font-family: sans-serif;">
        <button class="btn" onclick="window.print()" style="background: #2F855A; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            🖨️ Cetak
        </button>
        <button class="btn btn-save" onclick="saveAsPDF()" style="background: #3182CE; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            💾 Simpan (Device)
        </button>
        <button class="btn" onclick="window.close()" style="background: #718096; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            ✕ Tutup
        </button>
    </div>

    <div id="pdf-content">
        <!-- KOP SURAT -->
        <table class="kop-surat-table">
            <tr>
                <td class="kop-logo">
                    @if(isset($logo_path) && $logo_path != '')
                        <img src="{{ $logo_path }}" alt="Logo">
                    @endif
                </td>
                <td class="kop-text">
                    <div class="yayasan">{{ strtoupper($namaYayasanId ?? 'YAYASAN PENDIDIKAN') }}</div>
                    <div class="pesantren-ar" dir="rtl">
                        {{ $namaPondokAr ?? 'معهد الفرقانية الإسلامي' }}
                    </div>
                    <div class="pesantren">{{ strtoupper($namaPondokId ?? 'PONDOK PESANTREN ALFURQONIYAH') }}</div>
                    <div class="alamat">
                        {{ $alamatLengkap ?? '' }}<br>
                        Telp: {{ $telepon ?? '-' }} | Email: {{ $email ?? '-' }}
                    </div>
                </td>
            </tr>
        </table>
        <div class="garis-kop"></div>

        <div class="judul-laporan">
            <u>SURAT HASIL EVALUASI KEDISIPLINAN</u>
            <div>Periode: {{ $periodeTeks }}</div>
        </div>

        <!-- IDENTITAS & HASIL EVALUASI -->
        <table class="identitas-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="titik-dua">:</td>
                <td style="width: 200px;"><strong>{{ $santri->nama }}</strong></td>
                
                <td class="label">% Pengajian</td>
                <td class="titik-dua">:</td>
                <td><strong>{{ $evaluasi ? $evaluasi->persentase_pengajian . '%' : '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Kelas/Kamar/Gender</td>
                <td class="titik-dua">:</td>
                <td>{{ $santri->kelas }} / {{ $santri->kamar }} / {{ $santri->jenis_kelamin }}</td>
                
                <td class="label">% Sekolah</td>
                <td class="titik-dua">:</td>
                <td><strong>{{ $evaluasi ? $evaluasi->persentase_sekolah . '%' : '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="titik-dua">:</td>
                <td>{{ ucfirst($santri->status) }}</td>
                
                <td class="label">Kategori Disiplin</td>
                <td class="titik-dua">:</td>
                <td style="color: {{ $evaluasi && $evaluasi->kategori_akhir == 'Tinggi' ? 'green' : ($evaluasi && $evaluasi->kategori_akhir == 'Rendah' ? 'red' : 'orange') }}; font-weight: bold;">
                    {{ $evaluasi ? strtoupper($evaluasi->kategori_akhir) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Keterangan</td>
                <td class="titik-dua">:</td>
                <td colspan="4">{{ $evaluasi ? $evaluasi->keterangan : 'Belum dievaluasi' }}</td>
            </tr>
        </table>

    @if($jenis === 'sekolah')
    <!-- TABEL REKAPITULASI SEKOLAH -->
    <div class="section-title">REKAPITULASI KEHADIRAN SEKOLAH</div>
    <table class="riwayat">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Total Pertemuan</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alfa</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totSekolah = ['total'=>0, 'hadir'=>0, 'izin'=>0, 'sakit'=>0, 'alpa'=>0]; 
            @endphp
            @forelse($rekapSekolah as $rs)
                @php 
                    $totSekolah['total'] += $rs['total'];
                    $totSekolah['hadir'] += $rs['hadir'];
                    $totSekolah['izin'] += $rs['izin'];
                    $totSekolah['sakit'] += $rs['sakit'];
                    $totSekolah['alpa'] += $rs['alpa'];
                @endphp
                <tr>
                    <td style="text-align: left; padding-left: 10px;">{{ $rs['mapel'] }}</td>
                    <td>{{ $rs['total'] }}</td>
                    <td>{{ $rs['hadir'] }}</td>
                    <td>{{ $rs['izin'] }}</td>
                    <td>{{ $rs['sakit'] }}</td>
                    <td>{{ $rs['alpa'] }}</td>
                    <td>{{ $rs['persentase'] }}%</td>
                </tr>
            @empty
                <tr><td colspan="7">Tidak ada data kehadiran sekolah.</td></tr>
            @endforelse
            @if(count($rekapSekolah) > 0)
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td style="text-align: left; padding-left: 10px;">TOTAL</td>
                    <td>{{ $totSekolah['total'] }}</td>
                    <td>{{ $totSekolah['hadir'] }}</td>
                    <td>{{ $totSekolah['izin'] }}</td>
                    <td>{{ $totSekolah['sakit'] }}</td>
                    <td>{{ $totSekolah['alpa'] }}</td>
                    <td>{{ $totSekolah['total'] > 0 ? round(($totSekolah['hadir'] / $totSekolah['total']) * 100, 2) : 0 }}%</td>
                </tr>
            @endif
        </tbody>
    </table>
    @endif

    @if($jenis === 'pengajian')
    <!-- TABEL REKAPITULASI PENGAJIAN -->
    <div class="section-title">REKAPITULASI KEHADIRAN PENGAJIAN</div>
    <table class="riwayat">
        <thead>
            <tr>
                <th>Mata Pelajaran Pengajian</th>
                <th>Total Pertemuan</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alfa</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totPengajian = ['total'=>0, 'hadir'=>0, 'izin'=>0, 'sakit'=>0, 'alpa'=>0]; 
            @endphp
            @forelse($rekapPengajian as $rp)
                @php 
                    $totPengajian['total'] += $rp['total'];
                    $totPengajian['hadir'] += $rp['hadir'];
                    $totPengajian['izin'] += $rp['izin'];
                    $totPengajian['sakit'] += $rp['sakit'];
                    $totPengajian['alpa'] += $rp['alpa'];
                @endphp
                <tr>
                    <td style="text-align: left; padding-left: 10px;">{{ $rp['mapel'] }}</td>
                    <td>{{ $rp['total'] }}</td>
                    <td>{{ $rp['hadir'] }}</td>
                    <td>{{ $rp['izin'] }}</td>
                    <td>{{ $rp['sakit'] }}</td>
                    <td>{{ $rp['alpa'] }}</td>
                    <td>{{ $rp['persentase'] }}%</td>
                </tr>
            @empty
                <tr><td colspan="7">Tidak ada data kehadiran pengajian.</td></tr>
            @endforelse
            @if(count($rekapPengajian) > 0)
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td style="text-align: left; padding-left: 10px;">TOTAL</td>
                    <td>{{ $totPengajian['total'] }}</td>
                    <td>{{ $totPengajian['hadir'] }}</td>
                    <td>{{ $totPengajian['izin'] }}</td>
                    <td>{{ $totPengajian['sakit'] }}</td>
                    <td>{{ $totPengajian['alpa'] }}</td>
                    <td>{{ $totPengajian['total'] > 0 ? round(($totPengajian['hadir'] / $totPengajian['total']) * 100, 2) : 0 }}%</td>
                </tr>
            @endif
        </tbody>
    </table>
    @endif

    <!-- HASIL EVALUASI KEDISIPLINAN -->
    <div class="summary-box" style="margin-top: 20px;">
        <div class="summary-title" style="font-size: 13px; padding-bottom: 8px;">HASIL EVALUASI KEDISIPLINAN</div>
        <div style="padding: 10px;">
            <div style="font-size: 14px; text-align: center; margin-bottom: 15px;">
                Kategori Kedisiplinan: 
                @if($evaluasi)
                    @if(in_array($evaluasi->kategori_disiplin, ['Disiplin', 'Tinggi']))
                        <span class="badge-tinggi">DISIPLIN</span>
                    @elseif(in_array($evaluasi->kategori_disiplin, ['Cukup Disiplin', 'Sedang']))
                        <span class="badge-sedang">CUKUP DISIPLIN</span>
                    @else
                        <span class="badge-rendah">KURANG DISIPLIN</span>
                    @endif
                @else
                    <span style="font-weight: bold; color: gray;">BELUM DIEVALUASI</span>
                @endif
            </div>

            @if($evaluasi)
                <div style="font-weight: bold; margin-bottom: 5px;">Penjelasan Hasil:</div>
                <ul style="margin-top: 0; padding-left: 20px; line-height: 1.6;">
                    @if($jenis === 'sekolah')
                        <li>Persentase kehadiran sekolah ({{ $evaluasi->persentase_sekolah ?? 0 }}%) dinilai {{ $evaluasi->persentase_sekolah >= 80 ? 'memenuhi' : 'tidak memenuhi' }} standar kehadiran.</li>
                    @endif
                    
                    @if($jenis === 'pengajian')
                        <li>Persentase kehadiran pengajian ({{ $evaluasi->persentase_pengajian ?? 0 }}%) dinilai {{ $evaluasi->persentase_pengajian >= 80 ? 'memenuhi' : 'tidak memenuhi' }} standar kehadiran.</li>
                    @endif
                    
                    @php
                        // Menentukan penyebab utama ketidakhadiran berdasarkan jenis
                        $alpaTot  = $jenis === 'sekolah' ? $totSekolah['alpa'] : $totPengajian['alpa'];
                        $izinTot  = $jenis === 'sekolah' ? $totSekolah['izin'] : $totPengajian['izin'];
                        $sakitTot = $jenis === 'sekolah' ? $totSekolah['sakit'] : $totPengajian['sakit'];
                        
                        $maxAbsen = max($alpaTot, $izinTot, $sakitTot);
                        $alasanDominan = [];
                        if ($maxAbsen > 0) {
                            if ($alpaTot == $maxAbsen) $alasanDominan[] = 'alfa';
                            if ($izinTot == $maxAbsen) $alasanDominan[] = 'izin';
                            if ($sakitTot == $maxAbsen) $alasanDominan[] = 'sakit';
                        }
                    @endphp
                    
                    @if(count($alasanDominan) > 0)
                        <li>Ketidakhadiran lebih banyak disebabkan oleh <strong>{{ implode(' dan ', $alasanDominan) }}</strong>.</li>
                    @else
                        <li>Tingkat kehadiran sangat baik, tidak ada catatan ketidakhadiran yang signifikan.</li>
                    @endif
                    
                    <li>Berdasarkan hasil analisis rekapitulasi, sistem mengategorikan santri sebagai 
                        <strong>
                            {{ in_array($evaluasi->kategori_disiplin, ['Disiplin', 'Tinggi']) ? 'Disiplin' : (in_array($evaluasi->kategori_disiplin, ['Cukup Disiplin', 'Sedang']) ? 'Cukup Disiplin' : 'Kurang Disiplin') }}
                        </strong>.
                    </li>
                </ul>
            @endif
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <table class="ttd-box">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Wali Kelas / Pengurus Kamar</strong>
                <div style="height: 70px;"></div>
                ( ........................................................... )
            </td>
            <td>
                Tasikmalaya, {{ date('d F Y') }}<br>
                <strong>Kepala Bagian Kedisiplinan</strong>
                <div style="height: 70px;"></div>
                ( ........................................................... )
            </td>
        </tr>
    </table>
    </div>

    <!-- Script HTML2PDF untuk Download File Asli PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function saveAsPDF() {
            // Sembunyikan tombol sementara agar tidak glitch
            var btnSave = document.querySelector('.btn-save');
            var originalText = btnSave.innerHTML;
            btnSave.innerHTML = "⏳ Generating PDF...";
            
            var element = document.getElementById('pdf-content');
            var opt = {
                margin:       [10, 0, 10, 0], // top, left, bottom, right
                filename:     '{{ $namaFile }}',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Proses generate dan save
            html2pdf().set(opt).from(element).save().then(function() {
                // Kembalikan teks tombol
                btnSave.innerHTML = originalText;
            });
        }
    </script>
</body>
</html>
