<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Peringatan 1 - {{ $santri->nama }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; margin: 0; padding: 2cm 3cm; color: #000; background: #fff;}
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 15px; margin-bottom: 20px; position: relative; }
        .kop-surat img { position: absolute; left: 0; top: 0; width: 80px; height: auto; }
        .kop-surat h2 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat h4 { margin: 0; font-size: 14pt; }
        .kop-surat p { margin: 0; font-size: 11pt; }
        .clear { clear: both; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .tabel-identitas { margin-left: 20px; margin-top: 10px; margin-bottom: 10px; }
        .tabel-identitas td { padding: 3px 5px; vertical-align: top; }
        .signature-box { width: 100%; margin-top: 50px; }
        .signature-left { float: left; width: 45%; text-align: center; }
        .signature-right { float: right; width: 45%; text-align: center; }
        
        /* Print Controls */
        .print-controls { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        
        @media print {
            .print-controls, .no-print { display: none !important; }
            body { padding: 0; margin: 1.5cm; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body>
    <!-- Tombol cetak (tersembunyi saat print) -->
    <div class="print-controls no-print" style="display: flex; gap: 8px;">
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
    <!-- Kop Surat -->
    <div class="kop-surat">
        @if($logo_path)
        <img src="{{ $logo_path }}" alt="Logo">
        @endif
        <h4 style="font-family: 'Traditional Arabic', 'Amiri', serif; font-size: 18pt;">{{ $namaPondokAr }}</h4>
        <h2>{{ $namaPondokId }}</h2>
        <p>{{ $alamatLengkap }}</p>
        <p>Email: {{ $email }} | Telp: {{ $telepon }}</p>
    </div>

    <!-- Tanggal & Nomor Surat -->
    <div style="float: right;">Bandung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
    <div style="clear: both;"></div>

    <table style="width: 100%; margin-bottom: 20px; margin-top: 10px;">
        <tr>
            <td style="width: 80px;">Nomor</td>
            <td>: 015/SP1/KESAN/{{ \Carbon\Carbon::now()->format('m/Y') }}</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>: <strong>Surat Peringatan I (SP 1) & Panggilan Wali Santri</strong></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>: 1 Lembar Rekap Kehadiran</td>
        </tr>
    </table>

    <!-- Penerima Surat -->
    <p>Kepada Yth.<br>
    <strong>Bapak/Ibu Orang Tua / Wali Santri dari:</strong><br>
    {{ $santri->nama }}<br>
    Di Tempat</p>

    <p><em>Assalamu’alaikum Warahmatullahi Wabarakatuh,</em></p>

    <p>Segala puji bagi Allah SWT, Tuhan semesta alam. Teriring doa semoga Bapak/Ibu senantiasa dalam lindungan-Nya dan lancar dalam menjalankan aktivitas sehari-hari. Amin.</p>

    <p>Melalui surat ini, kami dari Bagian Kesantrian memberitahukan bahwa santri di bawah ini:</p>

    <!-- Identitas Santri -->
    <table class="tabel-identitas">
        <tr>
            <td style="width: 120px;">Nama</td>
            <td>: <strong>{{ $santri->nama }}</strong></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: {{ $santri->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $santri->kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kamar/Ruang</td>
            <td>: {{ $santri->kamar ?? $santri->ruang_pengajian ?? '-' }}</td>
        </tr>
    </table>

    <p>Telah melakukan pelanggaran tata tertib lembaga, yaitu tingkat kehadiran kegiatan sangat rendah dengan akumulasi Alpa sebanyak <strong>{{ $total_alpa }} kali</strong> pada bulan {{ \Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F') }} {{ $tahun }}.</p>

    <p>Oleh karena itu, lembaga mengeluarkan <strong>SURAT PERINGATAN I (SP 1)</strong>. Guna mencari solusi dan menindaklanjuti permasalahan kedisiplinan ini, kami mengharap kehadiran Bapak/Ibu pada:</p>

    <!-- Detail Pertemuan & Agenda -->
    <table class="tabel-identitas">
        <tr>
            <td style="width: 120px;">Hari, Tanggal</td>
            <td>: Senin, {{ \Carbon\Carbon::now()->addDays(2)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>: Pukul 09.00 WIB - Selesai</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>: Ruang Bimbingan Konseling / Kesantrian</td>
        </tr>
        <tr>
            <td>Agenda</td>
            <td>: Evaluasi Kedisiplinan Santri</td>
        </tr>
    </table>

    <p style="text-align: justify;">Mengingat pentingnya agenda ini, kami sangat memohon kehadiran Bapak/Ibu secara langsung (tidak dapat diwakilkan). Apabila pelanggaran ini terulang kembali, pihak lembaga akan menindaklanjuti dengan sanksi yang lebih berat sesuai buku tata tertib yang berlaku.</p>

    <p>Demikian surat peringatan dan pemanggilan ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.</p>

    <p><em>Wassalamu’alaikum Warahmatullahi Wabarakatuh.</em></p>

    <!-- Area Tanda Tangan -->
    <div class="signature-box">
        <div class="signature-left">
            <p>Mengetahui,<br>Kepala Bagian Kesantrian</p>
            <br><br><br>
            <p><strong>_______________________</strong></p>
        </div>
        <div class="signature-right">
            <p><br>Wali Kelas {{ $santri->kelas ?? '-' }}</p>
            <br><br><br>
            <p><strong>_______________________</strong></p>
        </div>
    </div>
    </div> <!-- End content-to-download -->

    <!-- Script PDF Download (Device) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.getElementById('content-to-download');
            const opt = {
                margin:       15,
                filename:     'Surat_Peringatan_{{ addslashes($santri->nama) }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>
