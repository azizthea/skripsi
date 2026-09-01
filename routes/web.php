<?php

use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;

// ===================================================
// REDIRECT TO LOGIN
// ===================================================
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/fix-storage', function() {
    $target = storage_path('app/public');
    $link = public_path('storage');
    
    $message = "";
    
    // Hapus file, link, atau folder lama
    if (file_exists($link) || is_link($link)) {
        if (is_link($link)) {
            unlink($link);
            $message .= "Link lama berhasil dihapus. ";
        } elseif (is_dir($link)) {
            // Hapus isi folder jika ada (rekursif)
            $it = new RecursiveDirectoryIterator($link, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()) rmdir($file->getRealPath());
                else unlink($file->getRealPath());
            }
            rmdir($link);
            $message .= "Folder lama berhasil dihapus. ";
        } else {
            unlink($link);
            $message .= "File storage dihapus. ";
        }
    }
    
    // Buat ulang link
    try {
        symlink($target, $link);
        $message .= "Link storage BARU berhasil dibuat! Silakan cek kembali halamannya.";
    } catch (\Exception $e) {
        $message .= "Gagal membuat link otomatis: " . $e->getMessage();
    }
    
    return $message;
});

// Route khusus untuk mengatasi bug 403 Symlink di Windows (php artisan serve)
Route::get('/storage/bukti_izin/{filename}', function ($filename) {
    $path = storage_path('app/public/bukti_izin/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});


// ===================================================
// AUTH ROUTES
// ===================================================
Route::get('/portal-kepengasuhan', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/portal-kepengasuhan', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===================================================
// ADMIN ROUTES (Hanya role: admin)
// ===================================================
Route::middleware(['auth', 'role:admin,bk,pengurus'])->group(function () {

    // Dashboard Analitik Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/live-feed', [DashboardController::class, 'liveFeedJson'])->name('dashboard.live-feed');

    // Data Master Santri
    Route::post('santri/naik-kelas', [SantriController::class, 'naikKelas'])->name('santri.naik-kelas');
    Route::post('santri/import', [SantriController::class, 'import'])->name('santri.import');
    Route::resource('santri', SantriController::class);

    // Pengaturan Sistem
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
    Route::post('/setting/list', [SettingController::class, 'storeList'])->name('setting.list.store');
    Route::post('/setting/list/delete', [SettingController::class, 'destroyList'])->name('setting.list.destroy');

    // Master Data: Kelas
    Route::post('/whatsapp/send', [WhatsAppController::class, 'sendNotification'])->name('whatsapp.send');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Master Data: Kamar
    Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::put('/kamar/{id}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kamar/{id}', [KamarController::class, 'destroy'])->name('kamar.destroy');

    // Data Ruang
    Route::get('/ruangan', [\App\Http\Controllers\RuangController::class, 'index'])->name('ruangan.index');
    Route::get('/ruangan/atur', [\App\Http\Controllers\RuangController::class, 'aturRuangan'])->name('ruangan.atur');
    Route::post('/ruangan/atur/simpan', [\App\Http\Controllers\RuangController::class, 'simpanPenempatan'])->name('ruangan.simpan');
    Route::post('/ruangan/assign', [\App\Http\Controllers\RuangController::class, 'assign'])->name('ruangan.assign');

    // Data Absensi (Admin: CRUD penuh)
    Route::resource('absensi', AbsensiController::class);
    Route::post('/absensi/batch-delete', [AbsensiController::class, 'batchDelete'])->name('absensi.batch-delete');
    Route::post('/absensi/import', [AbsensiController::class, 'importRekap'])->name('absensi.import');

    // Evaluasi Klasifikasi (Forward Chaining)
    Route::get('/evaluasi', [EvaluasiController::class, 'index'])->name('evaluasi.index');
    Route::post('/evaluasi/proses', [EvaluasiController::class, 'proses'])->name('evaluasi.proses');
    Route::post('/evaluasi/reset', [EvaluasiController::class, 'reset'])->name('evaluasi.reset');
    Route::get('/evaluasi/cetak-pdf', [EvaluasiController::class, 'cetakPdf'])->name('evaluasi.cetak-pdf');
    Route::get('/evaluasi/download-pdf', [EvaluasiController::class, 'downloadPdf'])->name('evaluasi.download-pdf');
    Route::get('/evaluasi/diagnosis', [EvaluasiController::class, 'diagnosis'])->name('evaluasi.diagnosis');
    Route::get('/evaluasi/simulasi', [EvaluasiController::class, 'simulasiForward'])->name('evaluasi.simulasi');
    Route::post('/evaluasi/kirim-portal', [EvaluasiController::class, 'kirimKePortal'])->name('evaluasi.kirim-portal');
    Route::post('/evaluasi/{id}/selesai', [EvaluasiController::class, 'markSelesai'])->name('evaluasi.selesai');

    // Legacy routes
    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');
    Route::get('/aktivitas/create', [AktivitasController::class, 'create'])->name('aktivitas.create');
    Route::post('/aktivitas', [AktivitasController::class, 'store'])->name('aktivitas.store');
    Route::get('/aktivitas/{id}', [AktivitasController::class, 'show'])->name('aktivitas.show');
    Route::get('/laporan', [AktivitasController::class, 'laporan'])->name('laporan.index');

    // Manajemen Pengguna (Admin & Guru)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});


// ===================================================
// GURU ROUTES (Input Absensi Batch / SIAKAD-Style)
// ===================================================
Route::middleware(['auth', 'role:guru,bk,pengurus'])->prefix('guru')->name('guru.')->group(function () {

    // Dashboard Guru
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');

    // Input Absensi Batch (SIAKAD-style)
    Route::get('/absensi', [GuruController::class, 'inputAbsensi'])->name('input-absensi');
    Route::post('/absensi', [GuruController::class, 'storeAbsensiBatch'])->name('store-absensi-batch');
});

Route::get('/debug-db', function() {
    return response()->json(Illuminate\Support\Facades\DB::select("SELECT sql FROM sqlite_master WHERE type='table' AND name='absensis'"));
});

