<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Evaluasi;
use App\Services\ForwardChainingService;

class DemoSantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bersihkan data lama agar tidak menumpuk (Disable FK checks first)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('evaluasis')->truncate();
        DB::table('absensis')->truncate();
        DB::table('santris')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ---------------------------------------------------------
        // 1. DATA DEMO SANTRI
        // ---------------------------------------------------------
        $santris = [
            [
                'id' => 1,
                'nis' => '2026001',
                'nama' => 'Muhammad Fatih',
                'jenis_kelamin' => 'Putra',
                'kelas' => 'X-A',
                'ruang_pengajian' => 'Ruang 1',
                'wali_kelas' => 'Bapak Budi Santoso',
                'status' => 'aktif',
            ],
            [
                'id' => 2,
                'nis' => '2026002',
                'nama' => 'Naufal Hakim',
                'jenis_kelamin' => 'Putra',
                'kelas' => 'X-A',
                'ruang_pengajian' => 'Ruang 1',
                'wali_kelas' => 'Bapak Budi Santoso',
                'status' => 'aktif',
            ],
            [
                'id' => 3,
                'nis' => '2026003',
                'nama' => 'Aisyah Putri',
                'jenis_kelamin' => 'Putri',
                'kelas' => 'X-B',
                'ruang_pengajian' => 'Ruang 2',
                'wali_kelas' => 'Bapak Budi Santoso',
                'status' => 'aktif',
            ],
            [
                'id' => 4,
                'nis' => '2026004',
                'nama' => 'Khadijah Zahra',
                'jenis_kelamin' => 'Putri',
                'kelas' => 'X-B',
                'ruang_pengajian' => 'Ruang 2',
                'wali_kelas' => 'Bapak Budi Santoso',
                'status' => 'aktif',
            ],
            [
                'id' => 5,
                'nis' => '2026005',
                'nama' => 'Rayhan Putra',
                'jenis_kelamin' => 'Putra',
                'kelas' => 'XI-A',
                'ruang_pengajian' => 'Ruang 3',
                'wali_kelas' => 'Bapak Arif Rahman',
                'status' => 'aktif',
            ],
            [
                'id' => 6,
                'nis' => '2026006',
                'nama' => 'Nisa Ramadhani',
                'jenis_kelamin' => 'Putri',
                'kelas' => 'XI-B',
                'ruang_pengajian' => 'Ruang 4',
                'wali_kelas' => 'Bapak Arif Rahman',
                'status' => 'aktif',
            ]
        ];

        foreach ($santris as $s) {
            Santri::create($s);
        }

        // ---------------------------------------------------------
        // 2. DATA ABSENSI BIKINAN (Skenario)
        // ---------------------------------------------------------
        $bulan = date('m');
        $tahun = date('Y');
        
        // Kita butuh 30 hari efektif (dari Setting)
        // Kita simulasikan 30 record per santri untuk Pengajian dan 30 untuk Sekolah
        
        foreach (Santri::all() as $santri) {
            for ($i = 1; $i <= 30; $i++) {
                $tanggal = Carbon::createFromDate($tahun, $bulan, $i)->format('Y-m-d');
                
                // --- Default Status ---
                $statusPengajian = 'Hadir';
                $statusSekolah = 'Hadir';

                // --- Skenario Berdasarkan ID ---
                
                if ($santri->id == 2) { // Naufal (Sering Sakit)
                    if ($i <= 10) { 
                        $statusPengajian = 'Sakit'; 
                        $statusSekolah = 'Sakit'; 
                    }
                } 
                elseif ($santri->id == 3) { // Aisyah Putri (Bolos Sekolah)
                    if ($i <= 15) { 
                        $statusSekolah = 'Alpa'; // Sering bolos sekolah formal
                    }
                }
                elseif ($santri->id == 4) { // Khadijah Zahra (Bolos Pengajian)
                    if ($i <= 15) { 
                        $statusPengajian = 'Alpa'; // Sering bolos ngaji, kecapean asrama
                    }
                }
                elseif ($santri->id == 5) { // Rayhan Putra (Pelanggaran Berat)
                    if ($i % 3 == 0) { // Bolos teratur tiap 3 hari sekali di keduanya
                        $statusPengajian = 'Alpa';
                        $statusSekolah = 'Alpa';
                    }
                }
                elseif ($santri->id == 6) { // Nisa Ramadhani (Sering Izin Kel)
                    if ($i <= 10) { 
                        $statusPengajian = 'Izin';
                        $statusSekolah = 'Izin';
                    }
                }

                // Insert Data Pengajian
                Absensi::create([
                    'santri_id' => $santri->id,
                    'tanggal' => $tanggal,
                    'jenis_kegiatan' => 'Pengajian',
                    'status' => $statusPengajian,
                    'keterangan' => 'Skenario Demo'
                ]);

                // Insert Data Sekolah
                Absensi::create([
                    'santri_id' => $santri->id,
                    'tanggal' => $tanggal,
                    'jenis_kegiatan' => 'Sekolah',
                    'status' => $statusSekolah,
                    'keterangan' => 'Skenario Demo'
                ]);
            }
        }

        // ---------------------------------------------------------
        // 3. JALANKAN FORWARD CHAINING AGAR DATA MASUK KE EVALUASI
        // ---------------------------------------------------------
        $fcService = new ForwardChainingService();
        $fcService->prosesBatch($bulan, $tahun, 'pengajian');
        $fcService->prosesBatch($bulan, $tahun, 'sekolah');

        $this->command->info('Data Demo Santri, Absensi, dan Evaluasi Forward Chaining berhasil di-generate!');
    }
}
