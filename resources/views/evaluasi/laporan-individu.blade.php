<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- Judul halaman = nama file saat Save as PDF --}}
    <title>{{ $namaFile }}</title>
    <style>
        /* ===================================================================
           STYLESHEET LAPORAN INDIVIDU KEDISIPLINAN SANTRI
           ===================================================================
           Template print-friendly yang bisa langsung disimpan sebagai PDF
           via dialog print browser (Ctrl+P → Save as PDF).
           Tidak memerlukan library DomPDF/TCPDF.
        =================================================================== */

        @page {
            size: A4 portrait;
            margin: 12mm 10mm 12mm 10mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }

        /* ================================
           KOP SURAT PESANTREN BARU
        ================================ */
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
            width: 80px;
            text-align: left;
        }
        .kop-logo img {
            width: 70px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            padding-right: 80px; /* Penyeimbang agar teks benar-benar di tengah */
        }
        .kop-text .yayasan {
            font-size: 12px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            letter-spacing: 1px;
            color: #000;
        }
        .kop-text .pesantren {
            font-size: 18px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            margin-top: 2px;
            margin-bottom: 2px;
            color: #000;
        }
        .kop-text .alamat {
            font-size: 9px;
            font-family: 'Times New Roman', Times, serif;
            color: #333;
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
            font-family: 'Times New Roman', Times, serif;
            letter-spacing: 0.5px;
        }
        .judul-laporan div {
            font-size: 10px;
            margin-top: 3px;
        }

        /* ================================
           IDENTITAS SANTRI
        ================================ */
        .identitas {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px 12px;
            background-color: #fafafa;
        }
        .identitas table {
            border: none;
            width: auto;
            border-collapse: collapse;
        }
        .identitas table td {
            border: none;
            padding: 2px 8px 2px 0;
            font-size: 10px;
        }
        .identitas td.label {
            font-weight: 700;
            color: #2D3748;
            min-width: 120px;
        }

        /* ================================
           TABEL RIWAYAT ABSENSI HARIAN
        ================================ */
        table.riwayat {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8.5px;
        }
        table.riwayat th,
        table.riwayat td {
            border: 1px solid #bbb;
            padding: 3px 5px;
            text-align: center;
        }
        table.riwayat th {
            background-color: #1a4731;
            color: white;
            font-weight: 600;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.riwayat tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        /* Warna status kehadiran */
        .status-hadir { color: #276749; font-weight: 700; }
        .status-izin { color: #B7791F; font-weight: 600; }
        .status-alpa { color: #C53030; font-weight: 700; }
        .status-kosong { color: #CBD5E0; }

        /* Highlight hari Minggu */
        .hari-libur { background-color: #FFF5F5 !important; }

        /* ================================
           REKAPITULASI
        ================================ */
        table.rekap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9px;
        }
        table.rekap th,
        table.rekap td {
            border: 1px solid #bbb;
            padding: 4px 8px;
            text-align: center;
        }
        table.rekap th {
            background-color: #2D3748;
            color: white;
            font-weight: 600;
            font-size: 8px;
            text-transform: uppercase;
        }

        /* ================================
           HASIL KLASIFIKASI
        ================================ */
        .klasifikasi-box {
            border: 2px solid #1a4731;
            border-radius: 6px;
            padding: 8px 14px;
            margin-bottom: 12px;
            text-align: center;
        }
        .klasifikasi-box h3 {
            font-size: 9px;
            color: #2D3748;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .kategori-tinggi {
            background-color: #C6F6D5;
            color: #22543D;
            font-size: 16px;
            font-weight: 900;
            padding: 5px 18px;
            border-radius: 4px;
            display: inline-block;
            border: 2px solid #38A169;
        }
        .kategori-sedang {
            background-color: #FEFCBF;
            color: #744210;
            font-size: 16px;
            font-weight: 900;
            padding: 5px 18px;
            border-radius: 4px;
            display: inline-block;
            border: 2px solid #D69E2E;
        }
        .kategori-rendah {
            background-color: #FED7D7;
            color: #742A2A;
            font-size: 16px;
            font-weight: 900;
            padding: 5px 18px;
            border-radius: 4px;
            display: inline-block;
            border: 2px solid #E53E3E;
        }
        .keterangan-rule {
            margin-top: 4px;
            font-size: 8px;
            color: #718096;
            font-style: italic;
        }

        /* ================================
           TANDA TANGAN
        ================================ */
        .ttd-section {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .ttd-section td {
            border: none;
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
            font-size: 9px;
            width: 50%;
        }
        .ttd-line {
            margin-top: 50px;
            border-top: 1px solid #333;
            padding-top: 3px;
            font-weight: 600;
        }

        /* ================================
           SECTION TITLE
        ================================ */
        .section-title {
            font-size: 10px;
            font-weight: 700;
            color: #1a4731;
            margin-bottom: 5px;
            padding-bottom: 2px;
            border-bottom: 1px solid #1a4731;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ================================
           PRINT CONTROLS (hilang saat cetak)
        ================================ */
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            gap: 8px;
        }
        .print-controls button {
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.2s;
        }
        .btn-print {
            background: #2F855A;
            color: white;
        }
        .btn-print:hover { background: #276749; }
        .btn-close-page {
            background: #718096;
            color: white;
        }
        .btn-close-page:hover { background: #4A5568; }

        @media print {
            .print-controls { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <!-- ============================================================
         TOMBOL CETAK (tersembunyi saat print)
         window.print() memicu dialog print browser.
         User bisa pilih "Save as PDF" di dialog tersebut.
         Nama file otomatis diambil dari document.title.
    ============================================================ -->
    <div class="print-controls">
        <button class="btn-print" onclick="window.print()">
            🖨️ Cetak / Simpan PDF
        </button>
        <button class="btn-close-page" onclick="window.close()">
            ✕ Tutup
        </button>
    </div>

    <!-- ============================================================
         KOP SURAT RESMI PONDOK PESANTREN
    ============================================================ -->
    <table class="kop-surat-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Pesantren">
            </td>
            <td class="kop-text">
                <div class="yayasan">YAYASAN PENDIDIKAN ISLAM</div>
                <div class="pesantren">PONDOK PESANTREN ALFURQONIYAH</div>
                <div class="alamat">Jl. Raya Pesantren, Kabupaten Tasikmalaya, Jawa Barat</div>
            </td>
        </tr>
    </table>
    <div class="garis-kop"></div>

    <div class="judul-laporan">
        <u>SURAT HASIL EVALUASI KEDISIPLINAN</u>
        <div>Periode: {{ $periodeTeks }}</div>
    </div>

    <!-- ============================================================
         IDENTITAS SANTRI
         Nama dan Kelas/Kamar menjadi identitas utama (tanpa NIS)
    ============================================================ -->
    <div class="identitas">
        <table>
            <tr>
                <td class="label">Nama Lengkap</td>
                <td>: <strong>{{ $santri->nama }}</strong></td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>: {{ $santri->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>: {{ $santri->kelas }}</td>
            </tr>
            <tr>
                <td class="label">Kamar</td>
                <td>: {{ $santri->kamar }}</td>
            </tr>
            <tr>
                <td class="label">Periode Evaluasi</td>
                <td>: {{ $periodeTeks }}</td>
            </tr>
        </table>
    </div>

    <!-- ============================================================
         TABEL RIWAYAT ABSENSI HARIAN (Tanggal 1 s/d Akhir Bulan)
         
         Tabel ini menampilkan status kehadiran santri setiap hari
         untuk kedua jenis kegiatan. Kolom meliputi:
         - Tgl: nomor tanggal (1-31)
         - Hari: nama hari (Senin-Minggu)
         - Pengajian: status kehadiran kegiatan pengajian
         - Sekolah: status kehadiran kegiatan sekolah
    ============================================================ -->
    <div class="section-title">Riwayat Absensi Harian</div>
    <table class="riwayat">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="text-align: left;">Hari / Tanggal</th>
                <th>Status Pengajian</th>
                <th>Status Sekolah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatHarian as $index => $row)
            <tr class="{{ $row['hari'] === 'Minggu' ? 'hari-libur' : '' }}">
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left; white-space: nowrap;">{{ $row['tanggal_lengkap'] }}</td>
                <td>
                    @if($row['status_pengajian'] === 'Hadir')
                        <span class="status-hadir">✓ Hadir</span>
                    @elseif($row['status_pengajian'] === 'Izin')
                        <span class="status-izin">○ Izin</span>
                    @elseif($row['status_pengajian'] === 'Alpa')
                        <span class="status-alpa">✗ Alpa</span>
                    @else
                        <span class="status-kosong">—</span>
                    @endif
                </td>
                <td>
                    @if($row['status_sekolah'] === 'Hadir')
                        <span class="status-hadir">✓ Hadir</span>
                    @elseif($row['status_sekolah'] === 'Izin')
                        <span class="status-izin">○ Izin</span>
                    @elseif($row['status_sekolah'] === 'Alpa')
                        <span class="status-alpa">✗ Alpa</span>
                    @else
                        <span class="status-kosong">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ============================================================
         REKAPITULASI KEHADIRAN
         
         Merangkum total Hadir, Izin, Alpa, dan Persentase kehadiran
         untuk masing-masing kegiatan. Data ini berfungsi sebagai
         audit trail agar penguji dapat cross-check secara manual.
    ============================================================ -->
    <div class="section-title">Rekapitulasi Kehadiran</div>
    <table class="rekap">
        <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Alpa</th>
                <th>Total Sesi Pertemuan</th>
                <th>Persentase Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left; font-weight: 700;">Pengajian</td>
                <td class="status-hadir">{{ $rekap['pengajian']['hadir'] }}</td>
                <td class="status-izin">{{ $rekap['pengajian']['izin'] }}</td>
                <td class="status-alpa">{{ $rekap['pengajian']['alpa'] }}</td>
                <td>{{ $rekap['pengajian']['total'] }}</td>
                <td style="font-weight: 700;">
                    @if($evaluasi)
                        {{ $evaluasi->persentase_pengajian }}%
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: left; font-weight: 700;">Sekolah</td>
                <td class="status-hadir">{{ $rekap['sekolah']['hadir'] }}</td>
                <td class="status-izin">{{ $rekap['sekolah']['izin'] }}</td>
                <td class="status-alpa">{{ $rekap['sekolah']['alpa'] }}</td>
                <td>{{ $rekap['sekolah']['total'] }}</td>
                <td style="font-weight: 700;">
                    @if($evaluasi)
                        {{ $evaluasi->persentase_sekolah }}%
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ============================================================
         HASIL KLASIFIKASI KEDISIPLINAN
         
         Menampilkan kategori disiplin akhir yang dihasilkan oleh
         sistem evaluasi otomatis. Box ini diberi penekanan visual
         agar langsung terlihat saat laporan dicetak.
    ============================================================ -->
    <div class="klasifikasi-box">
        <h3>Hasil Klasifikasi Sistem</h3>
        @if($evaluasi)
            @if(in_array($evaluasi->kategori_disiplin, ['Disiplin', 'Tinggi']))
                <span class="badge badge-success">DISIPLIN</span>
            @elseif(in_array($evaluasi->kategori_disiplin, ['Cukup Disiplin', 'Sedang']))
                <span class="badge badge-warning">CUKUP DISIPLIN</span>
            @else
                <span class="badge badge-danger">KURANG DISIPLIN</span>
            @endif
            <div class="keterangan-rule">
                Keterangan: {{ $evaluasi->triggered_rule }}
            </div>
        @else
            <p style="color: #999; font-size: 10px;">Belum dievaluasi. Jalankan "Proses Evaluasi" terlebih dahulu.</p>
        @endif
    </div>

    <!-- ============================================================
         KETERANGAN ATURAN KLASIFIKASI
    ============================================================ -->
    <div style="font-size: 8px; border: 1px solid #ddd; padding: 6px 10px; border-radius: 4px; margin-bottom: 12px; color: #555;">
        <strong>Keterangan Kriteria Penilaian Kedisiplinan:</strong><br>
        <strong>Syarat Utama:</strong> Jika Kehadiran Pengajian ≥ 85% DAN Sekolah ≥ 85%, maka kategori ditetapkan <strong style="color: #276749;">TINGGI (DISIPLIN)</strong><br>
        <strong>Syarat Menengah:</strong> Jika Kehadiran Pengajian 60-84% ATAU Sekolah 60-84%, maka kategori ditetapkan <strong style="color: #B7791F;">SEDANG (CUKUP DISIPLIN)</strong><br>
        <strong>Syarat Kritis:</strong> Jika Kehadiran Pengajian &lt; 60% DAN Sekolah &lt; 60%, maka kategori ditetapkan <strong style="color: #C53030;">RENDAH (KURANG DISIPLIN)</strong><br>
        <strong>Rumus Perhitungan:</strong> Persentase = (Jumlah Hadir / Total Sesi Pertemuan) × 100
    </div>

    <!-- ============================================================
         TANDA TANGAN
    ============================================================ -->
    <table class="ttd-section">
        <tr>
            <td>
                <div>Mengetahui,</div>
                <div><strong>Pengasuh Pondok Pesantren</strong></div>
                <div class="ttd-line">( ________________________ )</div>
            </td>
            <td>
                <div>Dibuat oleh,</div>
                <div><strong>Bagian Kepengasuhan</strong></div>
                <div class="ttd-line">( ________________________ )</div>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div style="margin-top: 10px; text-align: center; font-size: 7px; color: #999; border-top: 1px solid #eee; padding-top: 4px;">
        Dicetak pada: {{ now()->translatedFormat('l, d F Y — H:i') }} WIB |
        Sistem Analitik Klasifikasi Aktivitas Santri — PP Alfurqoniyah
    </div>

    <!-- Script untuk memicu dialog print secara otomatis saat halaman dimuat -->
    <script>
        window.onload = function() {
            // Tunggu sedikit agar CSS dan asset terload sempurna
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
