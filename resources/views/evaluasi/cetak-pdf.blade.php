<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Evaluasi Santri — {{ $periodeTeks }}</title>
    <style>
        /* ===================================================
           Print-Friendly Stylesheet
           Template ini didesain untuk dicetak menggunakan
           window.print() sehingga tidak memerlukan library
           PDF eksternal seperti DomPDF/TCPDF
        =================================================== */
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.5;
        }

        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap');

        /* Header Surat Resmi Pesantren */
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
            margin-bottom: 20px;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h2 {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: underline;
        }

        .info-periode {
            margin-bottom: 15px;
            font-size: 12px;
        }
        .info-periode strong {
            display: inline-block;
            min-width: 120px;
        }

        /* Tabel Utama */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 10px;
            text-align: left;
        }
        th {
            background-color: #2F855A;
            color: white;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        td.center {
            text-align: center;
        }

        /* Badge Kategori untuk cetak */
        .badge-tinggi {
            background-color: #38A169;
            color: white;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 700;
        }
        .badge-sedang {
            background-color: #D69E2E;
            color: white;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 700;
        }
        .badge-rendah {
            background-color: #E53E3E;
            color: white;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 700;
        }

        /* Ringkasan */
        .summary-box {
            display: inline-block;
            border: 1px solid #ccc;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 6px;
            text-align: center;
            min-width: 120px;
        }
        .summary-box .count {
            font-size: 20px;
            font-weight: 700;
        }
        .summary-box .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #666;
        }

        /* TTD Section */
        .ttd-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .ttd-box {
            text-align: center;
            min-width: 200px;
        }
        .ttd-box .line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 4px;
        }

        /* Print controls (hidden saat cetak) */
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .print-controls button {
            background: #2F855A;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .print-controls button:hover {
            background: #276749;
        }

        @media print {
            .print-controls { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<!-- Tombol cetak (tersembunyi saat print) -->
<div class="print-controls no-print" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; gap: 8px;">
    <button onclick="window.print()" style="background: #2F855A; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        🖨️ Cetak
    </button>
    <button onclick="downloadPDF()" style="background: #3182CE; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        💾 Simpan (Device)
    </button>
    <button onclick="window.close()" style="background: #718096; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        ✕ Tutup
    </button>
</div>

<div id="content-to-download">
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
        <h2>Laporan Evaluasi Klasifikasi Aktivitas Santri</h2>
    </div>

<!-- Info Periode -->
<div class="info-periode">
    <div><strong>Periode Evaluasi:</strong> {{ $periodeTeks }}</div>
    <div><strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('l, d F Y — H:i') }} WIB</div>
    <div><strong>Total Santri Dievaluasi:</strong> {{ $evaluasis->count() }} santri</div>
</div>

<!-- Ringkasan Distribusi -->
<div style="margin-bottom: 20px;">
    <div class="summary-box" style="border-color: #38A169;">
        <div class="count" style="color: #38A169;">{{ $distribusi['Tinggi'] }}</div>
        <div class="label">Disiplin Tinggi</div>
    </div>
    <div class="summary-box" style="border-color: #D69E2E;">
        <div class="count" style="color: #D69E2E;">{{ $distribusi['Sedang'] }}</div>
        <div class="label">Disiplin Sedang</div>
    </div>
    <div class="summary-box" style="border-color: #E53E3E;">
        <div class="count" style="color: #E53E3E;">{{ $distribusi['Rendah'] }}</div>
        <div class="label">Disiplin Rendah</div>
    </div>
</div>

<!-- Tabel Hasil Evaluasi -->
<table>
    <thead>
        <tr>
            <th style="width: 30px;">No</th>
            <th>NIS</th>
            <th>Nama Santri</th>
            <th>Kelas</th>
            <th>Kamar</th>
            <th style="text-align: center;">Hadir Pengajian</th>
            <th style="text-align: center;">Pengajian</th>
            <th style="text-align: center;">Hadir Sekolah</th>
            <th style="text-align: center;">Sekolah</th>
            <th style="text-align: center;">Kategori</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($evaluasis as $index => $eval)
        <tr>
            <td class="center">{{ $index + 1 }}</td>
            <td class="center">{{ $eval->santri->nis ?? '-' }}</td>
            <td style="font-weight: 600;">{{ $eval->santri->nama ?? '-' }}</td>
            <td class="center">{{ $eval->santri->kelas ?? '-' }}</td>
            <td class="center">{{ $eval->santri->kamar ?? '-' }}</td>
            <td class="center">{{ $eval->total_hadir_pengajian }}/{{ $eval->total_hari_pengajian }}</td>
            <td class="center" style="font-weight: 700;">{{ $eval->persentase_pengajian }}%</td>
            <td class="center">{{ $eval->total_hadir_sekolah }}/{{ $eval->total_hari_sekolah }}</td>
            <td class="center" style="font-weight: 700;">{{ $eval->persentase_sekolah }}%</td>
            <td class="center">
                @if(in_array($eval->kategori_disiplin, ['Disiplin', 'Tinggi']))
                    <span class="badge badge-success">Disiplin</span>
                @elseif(in_array($eval->kategori_disiplin, ['Cukup Disiplin', 'Sedang']))
                    <span class="badge badge-warning">Cukup Disiplin</span>
                @else
                    <span class="badge badge-danger">Kurang Disiplin</span>
                @endif
            </td>
            <td style="font-size: 9px; max-width: 200px;">{{ $eval->triggered_rule ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="center" style="padding: 20px; color: #999;">Tidak ada data evaluasi untuk periode ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Keterangan Kategori -->
<div style="margin-bottom: 30px; font-size: 10px; border: 1px solid #ddd; padding: 10px; border-radius: 6px;">
    <strong>Keterangan Kategori Kedisiplinan</strong><br>
    <span class="badge-tinggi">DISIPLIN TINGGI</span> : Kehadiran sangat baik, memenuhi standar pesantren di atas rata-rata.<br>
    <span class="badge-sedang">DISIPLIN SEDANG</span> : Kehadiran cukup, namun memiliki beberapa ketidakhadiran yang perlu diperhatikan.<br>
    <span class="badge-rendah">DISIPLIN RENDAH</span> : Kehadiran di bawah standar yang ditetapkan, wajib mendapatkan pembinaan khusus.
</div>

<!-- Tanda Tangan -->
<div class="ttd-section">
    <div class="ttd-box">
        <div>Mengetahui,</div>
        <div><strong>Pengasuh Pondok Pesantren</strong></div>
        <div class="line">( ________________________ )</div>
    </div>
    <div class="ttd-box">
        <div>Dibuat oleh,</div>
        <div><strong>Bagian Kepengasuhan</strong></div>
        <div class="line">( ________________________ )</div>
    </div>
</div>

</div> <!-- End content-to-download -->

<!-- Script HTML2PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        const element = document.getElementById('content-to-download');
        const opt = {
            margin:       10,
            filename:     'Laporan_Evaluasi_{{ $periodeTeks }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save();
    }
</script>
</body>
</html>
