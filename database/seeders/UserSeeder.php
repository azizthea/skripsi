<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder khusus untuk membuat akun pengguna (Admin & Guru)
 * AMAN dijalankan berulang kali — tidak menghapus data santri/absensi
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Administrator',
                'email'    => 'admin@pesantren.com',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Bapak Budi Santoso (Guru/Wali Kelas)',
                'email'    => 'guru1@pesantren.com',
                'password' => bcrypt('password'),
                'role'     => 'guru',
            ],
            [
                'name'     => 'Bapak Hendra Gunawan (Guru BK)',
                'email'    => 'guru2@pesantren.com',
                'password' => bcrypt('password'),
                'role'     => 'bk',
            ],
            [
                'name'     => 'Bapak Arif Rahman (Pengurus/Wali Kamar)',
                'email'    => 'guru3@pesantren.com',
                'password' => bcrypt('password'),
                'role'     => 'pengurus',
            ],
        ];

        foreach ($users as $userData) {
            $existing = User::where('email', $userData['email'])->first();

            if ($existing) {
                // Update role jika sudah ada (misal sebelumnya belum ada field role)
                $existing->update(['role' => $userData['role'], 'name' => $userData['name']]);
                $this->command->info("✔ Updated : {$userData['email']} (role: {$userData['role']})");
            } else {
                User::create($userData);
                $this->command->info("✔ Created : {$userData['email']} (role: {$userData['role']})");
            }
        }

        $this->command->info('');
        $this->command->info('=== Akun siap digunakan ===');
        $this->command->info('Admin : admin@pesantren.com  | password: password');
        $this->command->info('Guru 1: guru1@pesantren.com  | password: password');
        $this->command->info('Guru 2: guru2@pesantren.com  | password: password');
        $this->command->info('Guru 3: guru3@pesantren.com  | password: password');
    }
}
