<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\KelasModel;
use App\Models\Room;
use App\Models\KategoriDisiplin;
use App\Models\Setting;
use App\Services\ForwardChainingService;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================
        // 1. Admin User
        // =====================================================
        if (!User::where('email', 'admin@pesantren.com')->exists()) {
            User::create([
                'name'     => 'Administrator',
                'email'    => 'admin@pesantren.com',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ]);
        }

        // =====================================================
        // Akun Guru Demo
        // =====================================================
        $guruDemo = [
            ['name' => 'Bapak Budi Santoso (Guru/Wali Kelas)',    'email' => 'guru1@pesantren.com', 'role' => 'guru'],
            ['name' => 'Bapak Hendra Gunawan (Guru BK)', 'email' => 'guru2@pesantren.com', 'role' => 'bk'],
            ['name' => 'Bapak Arif Rahman (Pengurus/Wali Kamar)',  'email' => 'guru3@pesantren.com', 'role' => 'pengurus'],
        ];
        foreach ($guruDemo as $guru) {
            if (!User::where('email', $guru['email'])->exists()) {
                User::create([
                    'name'     => $guru['name'],
                    'email'    => $guru['email'],
                    'password' => bcrypt('password'),
                    'role'     => $guru['role'],
                ]);
            }
        }

        // =====================================================
        // 2. Kategori Disiplin
        // =====================================================
        if (KategoriDisiplin::count() == 0) {
            KategoriDisiplin::insert([
                ['nama_kategori' => 'Tinggi', 'kriteria' => 'Pengajian >= 85% AND Sekolah >= 85%'],
                ['nama_kategori' => 'Sedang', 'kriteria' => 'Pengajian 60-84% OR Sekolah 60-84%'],
                ['nama_kategori' => 'Rendah', 'kriteria' => 'Pengajian < 60% AND Sekolah < 60%'],
            ]);
        }

        // =====================================================
        // 3. Rules
        // =====================================================
        $this->call(RuleSeeder::class);

        // =====================================================
        // 4. MASTER DATA: Kelas (12 kelas)
        // =====================================================
        // KelasModel::truncate();
        $kelasMaster = [
            ['nama_kelas' => 'VII A',  'jenjang' => 'MTs'],
            ['nama_kelas' => 'VII B',  'jenjang' => 'MTs'],
            ['nama_kelas' => 'VIII A', 'jenjang' => 'MTs'],
            ['nama_kelas' => 'VIII B', 'jenjang' => 'MTs'],
            ['nama_kelas' => 'IX A',   'jenjang' => 'MTs'],
            ['nama_kelas' => 'IX B',   'jenjang' => 'MTs'],
            ['nama_kelas' => 'X A',    'jenjang' => 'MA'],
            ['nama_kelas' => 'X B',    'jenjang' => 'MA'],
            ['nama_kelas' => 'XI A',   'jenjang' => 'MA'],
            ['nama_kelas' => 'XI B',   'jenjang' => 'MA'],
            ['nama_kelas' => 'XII A',  'jenjang' => 'MA'],
            ['nama_kelas' => 'XII B',  'jenjang' => 'MA'],
        ];
        foreach ($kelasMaster as $k) {
            KelasModel::create($k);
        }

        // =====================================================
        // 5. MASTER DATA: Kamar (8 kamar)
        // =====================================================
        // Room::truncate();
        $kamarMaster = [
            ['nama_kamar' => 'An-Nur',           'kapasitas' => 20],
            ['nama_kamar' => 'Al-Fatih',          'kapasitas' => 20],
            ['nama_kamar' => 'Abu Bakar',         'kapasitas' => 20],
            ['nama_kamar' => 'Al-Falah',          'kapasitas' => 20],
            ['nama_kamar' => 'Al-Hidayah',        'kapasitas' => 20],
            ['nama_kamar' => 'Al-Ikhlas',         'kapasitas' => 20],
            ['nama_kamar' => 'Al-Barokah',        'kapasitas' => 20],
            ['nama_kamar' => 'Umar bin Khattab',  'kapasitas' => 20],
        ];
        foreach ($kamarMaster as $r) {
            Room::create($r);
        }

        // =====================================================
        // 6. SANTRI DEMO — 10 per kelas × 12 kelas = 120 santri
        // Pola kehadiran [p_hadir, p_izin, s_hadir, s_izin]
        // dari 26 hari efektif (sisanya = Alpa)
        // Distribusi per kelas: ~4 Tinggi, 4 Sedang, 2 Rendah
        // =====================================================
        // Absensi::truncate();
        // Santri::truncate();
        // Evaluasi::truncate(); // just in case

        // Helper: buat 10 santri sekaligus untuk 1 kelas
        // $pola: array 10 elemen [p_hadir, p_izin, s_hadir, s_izin]
        $dataset = [

            // ════════════════════════════════════════════════
            // VII A — MTs | Kamar: An-Nur
            // ════════════════════════════════════════════════
            [
                'kelas' => 'VII A', 'jenjang' => 'MTs', 'kamar' => 'An-Nur',
                'santri' => [
                    'Abdurrahman Wahid',  'Bayu Kurniawan',   'Candra Setiawan',
                    'Doni Pratama',       'Eko Widodo',       'Faris Rabbani',
                    'Gilang Santosa',     'Hanif Maulana',    'Ivan Permana',
                    'Jundi Al-Hakim',
                ],
                'pola' => [
                    [25, 1, 25, 0], // Tinggi
                    [23, 2, 24, 1], // Tinggi
                    [22, 2, 23, 1], // Tinggi
                    [24, 0, 22, 2], // Tinggi
                    [19, 3, 20, 2], // Sedang
                    [18, 2, 19, 3], // Sedang
                    [17, 4, 18, 2], // Sedang
                    [16, 3, 17, 3], // Sedang
                    [12, 3, 11, 4], // Rendah
                    [10, 4,  9, 3], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // VII B — MTs | Kamar: Al-Fatih
            // ════════════════════════════════════════════════
            [
                'kelas' => 'VII B', 'jenjang' => 'MTs', 'kamar' => 'Al-Fatih',
                'santri' => [
                    'Khairul Anwar',     'Latif Firmansyah',  'Miftah Huda',
                    'Nabil Zuhri',       'Omar Syaifullah',   'Putra Ramadhan',
                    'Qais Abdillah',     'Reza Maulana',      'Samsul Arifin',
                    'Tegar Santoso',
                ],
                'pola' => [
                    [26, 0, 25, 1], // Tinggi
                    [24, 1, 24, 1], // Tinggi
                    [23, 2, 22, 2], // Tinggi
                    [22, 1, 23, 1], // Tinggi
                    [20, 2, 18, 3], // Sedang
                    [19, 3, 20, 2], // Sedang
                    [17, 3, 16, 4], // Sedang
                    [16, 4, 17, 3], // Sedang
                    [11, 5, 10, 4], // Rendah
                    [ 9, 3,  8, 5], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // VIII A — MTs | Kamar: Abu Bakar
            // ════════════════════════════════════════════════
            [
                'kelas' => 'VIII A', 'jenjang' => 'MTs', 'kamar' => 'Abu Bakar',
                'santri' => [
                    'Umar Faruq',        'Vicky Hamdani',     'Wahyu Hidayat',
                    'Xander Prasetya',   'Yusuf Al-Ghifari',  'Zidan Mubarok',
                    'Arief Wicaksono',   'Bima Sakti',        'Cahyo Nugroho',
                    'Daffa Ramadhani',
                ],
                'pola' => [
                    [25, 0, 26, 0], // Tinggi
                    [23, 1, 24, 1], // Tinggi
                    [22, 2, 23, 1], // Tinggi
                    [24, 1, 21, 2], // Tinggi
                    [18, 3, 20, 2], // Sedang
                    [17, 4, 19, 3], // Sedang
                    [19, 2, 17, 4], // Sedang
                    [16, 3, 18, 3], // Sedang
                    [13, 2, 12, 3], // Rendah
                    [ 9, 5,  8, 4], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // VIII B — MTs | Kamar: Al-Falah
            // ════════════════════════════════════════════════
            [
                'kelas' => 'VIII B', 'jenjang' => 'MTs', 'kamar' => 'Al-Falah',
                'santri' => [
                    'Eka Saputra',       'Fadly Ramadhan',    'Galih Wicaksono',
                    'Harun Al-Rasyid',   'Ibnu Hajar',        'Jafar Shadiq',
                    'Karim Abdurrahman', 'Lukman Hakim',      'Musa Karim',
                    'Naufal Rasyid',
                ],
                'pola' => [
                    [26, 0, 24, 1], // Tinggi
                    [24, 2, 25, 0], // Tinggi
                    [22, 1, 23, 2], // Tinggi
                    [23, 2, 22, 1], // Tinggi
                    [20, 3, 19, 2], // Sedang
                    [18, 2, 20, 3], // Sedang
                    [17, 4, 16, 3], // Sedang
                    [15, 4, 17, 4], // Sedang
                    [12, 4, 11, 3], // Rendah
                    [ 8, 5,  7, 6], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // IX A — MTs (KELAS AKHIR) | Kamar: Al-Hidayah
            // Lulus → tidak naik ke MA, harus daftar baru
            // ════════════════════════════════════════════════
            [
                'kelas' => 'IX A', 'jenjang' => 'MTs', 'kamar' => 'Al-Hidayah',
                'santri' => [
                    'Oskar Maulana',     'Panji Wirawan',     'Qomaruddin Yusuf',
                    'Ridho Firmansyah',  'Sholeh Ahmadi',     'Taufiq Rahman',
                    'Ubaidillah Hasan',  'Vino Adiyasa',      'Wafi Dzikrullah',
                    'Yazid Al-Bustomi',
                ],
                'pola' => [
                    [24, 1, 25, 1], // Tinggi
                    [23, 2, 22, 2], // Tinggi
                    [25, 0, 23, 1], // Tinggi
                    [22, 3, 24, 0], // Tinggi
                    [18, 4, 19, 2], // Sedang
                    [17, 3, 20, 3], // Sedang
                    [19, 2, 17, 4], // Sedang
                    [16, 4, 18, 3], // Sedang
                    [13, 3, 11, 4], // Rendah
                    [ 9, 4,  8, 5], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // IX B — MTs (KELAS AKHIR) | Kamar: Al-Ikhlas
            // ════════════════════════════════════════════════
            [
                'kelas' => 'IX B', 'jenjang' => 'MTs', 'kamar' => 'Al-Ikhlas',
                'santri' => [
                    'Zaenal Abidin',     'Arman Setiadi',     'Bagus Nugroho',
                    'Cakra Wijaya',      'Dimas Aditya',      'Elfan Pratama',
                    'Fauzan Hakim',      'Giri Santoso',      'Hamzah Idris',
                    'Ilham Bachtiar',
                ],
                'pola' => [
                    [25, 1, 24, 1], // Tinggi
                    [23, 1, 25, 0], // Tinggi
                    [22, 2, 23, 2], // Tinggi
                    [24, 0, 22, 1], // Tinggi
                    [19, 3, 18, 3], // Sedang
                    [17, 4, 19, 3], // Sedang
                    [18, 3, 17, 4], // Sedang
                    [16, 3, 16, 4], // Sedang
                    [12, 4, 10, 5], // Rendah
                    [ 8, 6,  7, 5], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // X A — MA | Kamar: Al-Barokah
            // ════════════════════════════════════════════════
            [
                'kelas' => 'X A', 'jenjang' => 'MA', 'kamar' => 'Al-Barokah',
                'santri' => [
                    'Jamaluddin Akbar',  'Khalid Walid',      'Luthfi Hamdani',
                    'Malik Ibrahim',     'Nashir Umar',       'Omer Syarif',
                    'Pandu Wijaksono',   'Qudsi Rabbani',     'Rafi Maulana',
                    'Salim Barakah',
                ],
                'pola' => [
                    [26, 0, 25, 0], // Tinggi
                    [24, 1, 25, 1], // Tinggi
                    [23, 2, 24, 0], // Tinggi
                    [22, 1, 23, 2], // Tinggi
                    [20, 2, 19, 3], // Sedang
                    [18, 3, 20, 2], // Sedang
                    [17, 4, 18, 3], // Sedang
                    [19, 2, 16, 4], // Sedang
                    [12, 3, 13, 2], // Rendah
                    [ 9, 5,  8, 4], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // X B — MA | Kamar: Umar bin Khattab
            // ════════════════════════════════════════════════
            [
                'kelas' => 'X B', 'jenjang' => 'MA', 'kamar' => 'Umar bin Khattab',
                'santri' => [
                    'Thariq Aziz',       'Umam Shiddiq',      'Valdi Ramadhan',
                    'Wahab Chasbullah',  'Yahya Muhaimin',    'Zubair Alwi',
                    'Aditya Khoirul',    'Bagaskara Putra',   'Catur Wibowo',
                    'Daffa Maulana',
                ],
                'pola' => [
                    [25, 1, 26, 0], // Tinggi
                    [23, 2, 24, 1], // Tinggi
                    [24, 0, 23, 1], // Tinggi
                    [22, 2, 22, 2], // Tinggi
                    [19, 3, 20, 2], // Sedang
                    [18, 4, 17, 3], // Sedang
                    [20, 2, 18, 3], // Sedang
                    [16, 4, 19, 3], // Sedang
                    [11, 4, 10, 5], // Rendah
                    [ 8, 5,  9, 4], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // XI A — MA | Kamar: An-Nur
            // ════════════════════════════════════════════════
            [
                'kelas' => 'XI A', 'jenjang' => 'MA', 'kamar' => 'An-Nur',
                'santri' => [
                    'Egi Pramudya',      'Farhan Anshori',    'Ghazi Fatahillah',
                    'Haikal Ramadhan',   'Ivan Al-Khafid',    'Jevon Maulana',
                    'Kautsar Hamdani',   'Lizam Alfatih',     'Mufid Habibi',
                    'Nabil Arrafif',
                ],
                'pola' => [
                    [26, 0, 26, 0], // Tinggi
                    [24, 1, 24, 1], // Tinggi
                    [23, 0, 25, 1], // Tinggi
                    [22, 2, 23, 1], // Tinggi
                    [19, 2, 20, 3], // Sedang
                    [17, 4, 18, 2], // Sedang
                    [18, 3, 17, 4], // Sedang
                    [16, 4, 19, 3], // Sedang
                    [13, 3, 12, 3], // Rendah
                    [10, 4,  9, 4], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // XI B — MA | Kamar: Al-Fatih
            // ════════════════════════════════════════════════
            [
                'kelas' => 'XI B', 'jenjang' => 'MA', 'kamar' => 'Al-Fatih',
                'santri' => [
                    'Oky Pratama',       'Pria Wibawa',       'Qori Maulana',
                    'Rangga Permadi',    'Syarif Hidayat',    'Tian Kurniawan',
                    'Ulul Albab',        'Virgi Rahmat',      'Wisnu Ananda',
                    'Xavio Habibi',
                ],
                'pola' => [
                    [25, 0, 24, 1], // Tinggi
                    [23, 1, 25, 0], // Tinggi
                    [24, 1, 23, 1], // Tinggi
                    [22, 2, 22, 2], // Tinggi
                    [20, 3, 18, 2], // Sedang
                    [17, 3, 20, 3], // Sedang
                    [18, 4, 17, 3], // Sedang
                    [16, 3, 16, 4], // Sedang
                    [12, 3, 11, 4], // Rendah
                    [ 9, 5,  8, 4], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // XII A — MA (KELAS AKHIR) | Kamar: Abu Bakar
            // ════════════════════════════════════════════════
            [
                'kelas' => 'XII A', 'jenjang' => 'MA', 'kamar' => 'Abu Bakar',
                'santri' => [
                    'Yafi Maulana',      'Zain Almubarok',    'Azzam Rabbani',
                    'Basir Hamdani',     'Dzikri Mubarok',    'Fadlan Hakim',
                    'Ghifar Siddiq',     'Hasan Basri',       'Iqbal Syafii',
                    'Jibran Fattah',
                ],
                'pola' => [
                    [25, 1, 25, 1], // Tinggi
                    [24, 0, 24, 0], // Tinggi
                    [23, 2, 22, 2], // Tinggi
                    [22, 1, 23, 1], // Tinggi
                    [18, 3, 19, 3], // Sedang
                    [17, 4, 18, 2], // Sedang
                    [19, 2, 17, 4], // Sedang
                    [16, 4, 16, 3], // Sedang
                    [11, 4, 12, 3], // Rendah
                    [ 8, 5,  9, 4], // Rendah
                ],
            ],

            // ════════════════════════════════════════════════
            // XII B — MA (KELAS AKHIR) | Kamar: Al-Falah
            // ════════════════════════════════════════════════
            [
                'kelas' => 'XII B', 'jenjang' => 'MA', 'kamar' => 'Al-Falah',
                'santri' => [
                    'Kamal Mukhtar',     'Luthfan Azhari',    'Muzakki Irsyad',
                    'Naufal Dzakwan',    'Osama Habibi',      'Pauzan Zakaria',
                    'Qasim Mubarok',     'Rafiq Hamdani',     'Sulthon Aqil',
                    'Tamim Al-Anshari',
                ],
                'pola' => [
                    [24, 2, 25, 0], // Tinggi
                    [25, 1, 24, 1], // Tinggi
                    [23, 1, 23, 2], // Tinggi
                    [22, 2, 22, 1], // Tinggi
                    [19, 4, 18, 3], // Sedang
                    [18, 3, 19, 4], // Sedang
                    [17, 3, 17, 3], // Sedang
                    [16, 4, 16, 4], // Sedang
                    [12, 4, 10, 4], // Rendah
                    [ 7, 6,  8, 5], // Rendah
                ],
            ],
        ];

        // =====================================================
        // Build & Insert Santri + Absensi
        // =====================================================
        $bulan            = (int) date('m');
        $tahun            = (int) date('Y');
        $totalHariEfektif = 26;
        $startDate        = Carbon::create($tahun, $bulan, 1);

        // Update Setting for total sessions (26 days * 5 subjects = 130)
        Setting::updateOrCreate(['key' => 'hari_efektif'], ['value' => '130']);

        $totalSantriDibuat = 0;

        foreach ($dataset as $kelasData) {
            foreach ($kelasData['santri'] as $idx => $nama) {
                $waliKelas = (strpos($kelasData['kelas'], 'VII') !== false || strpos($kelasData['kelas'], 'VIII') !== false || strpos($kelasData['kelas'], 'IX') !== false) 
                    ? 'Bapak Budi Santoso' 
                    : 'Bapak Arif Rahman';

                $santri = Santri::create([
                    'nis'        => '2026' . str_pad($totalSantriDibuat + 1, 4, '0', STR_PAD_LEFT),
                    'nama'       => $nama,
                    'jenis_kelamin' => 'Putra', // Default for demo
                    'jenjang'    => $kelasData['jenjang'],
                    'kelas'      => $kelasData['kelas'],
                    'kamar'      => $kelasData['kamar'],
                    'ruang_pengajian' => 'Ruang ' . rand(1, 5), // Random assign to Ruang 1-5
                    'wali_kelas' => $waliKelas,
                    'status'     => 'aktif',
                ]);

                $pola = $kelasData['pola'][$idx];
                
                $pengajianSubjects = ['Al-Quran', 'Fiqih', 'Tafsir', 'Hadits', 'Akhlak'];
                $sekolahSubjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS'];
                
                $this->generateAbsensi($santri->id, $pengajianSubjects, $startDate, $totalHariEfektif, $pola[0], $pola[1]);
                $this->generateAbsensi($santri->id, $sekolahSubjects,   $startDate, $totalHariEfektif, $pola[2], $pola[3]);

                $totalSantriDibuat++;
            }
        }

        // =====================================================
        // Forward Chaining (Evaluasi)
        // =====================================================
        $service = new ForwardChainingService();
        $service->prosesBatch($bulan, $tahun, 'pengajian');
        $service->prosesBatch($bulan, $tahun, 'sekolah');

        $totalAbsensi = $totalSantriDibuat * 10 * $totalHariEfektif; // 5 mapel pengajian + 5 mapel sekolah
        $this->command->info("✅ Master Kelas   : 12 kelas (6 MTs + 6 MA)");
        $this->command->info("✅ Master Kamar   : 8 kamar");
        $this->command->info("✅ Santri Demo    : {$totalSantriDibuat} santri (10 per kelas × 12 kelas)");
        $this->command->info("✅ Record Absensi : {$totalAbsensi} record ({$totalHariEfektif} hari × {$totalSantriDibuat} santri × 10 mapel)");
        $this->command->info("✅ Forward Chaining selesai untuk periode {$bulan}/{$tahun}");
        $this->command->info("   Distribusi per kelas: ~4 Tinggi, 4 Sedang, 2 Rendah");
    }

    private function generateAbsensi(
        int    $santriId,
        array  $kegiatanList,
        Carbon $startDate,
        int    $totalHari,
        int    $hadirBase,
        int    $izinBase
    ): void {
        $pengali = count($kegiatanList);
        $totalSesi = $totalHari * $pengali;
        
        // Sesuaikan proporsi dari pola (pola berbasis 26 hari, kita kalikan dengan jumlah mapel)
        $hadir = $hadirBase * $pengali;
        $izin = $izinBase * $pengali;
        
        $statuses = array_merge(
            array_fill(0, $hadir, 'Hadir'),
            array_fill(0, $izin, 'Izin'),
            array_fill(0, max(0, $totalSesi - $hadir - $izin), 'Alpa')
        );
        shuffle($statuses);

        $statusIndex = 0;
        $records = [];
        for ($i = 0; $i < $totalHari; $i++) {
            foreach ($kegiatanList as $kegiatan) {
                $records[] = [
                    'santri_id'      => $santriId,
                    'jenis_kegiatan' => $kegiatan,
                    'tanggal'        => $startDate->copy()->addDays($i)->format('Y-m-d'),
                    'status'         => $statuses[$statusIndex],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
                $statusIndex++;
            }
        }
        
        // Batch insert for performance
        Absensi::insert($records);
    }
}
