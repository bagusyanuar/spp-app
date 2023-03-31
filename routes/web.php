<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['post', 'get'], '/', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::group(['prefix' => 'jenis-pembayaran'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\JenisPembayaranController::class, 'index'])->name('jenis-pembayaran');
    Route::post('/{id}', [\App\Http\Controllers\JenisPembayaranController::class, 'patch'])->name('jenis-pembayaran.update');
    Route::post('/{id}/delete', [\App\Http\Controllers\JenisPembayaranController::class, 'destroy'])->name('jenis-pembayaran.delete');
});

Route::group(['prefix' => 'pos-pembayaran'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\PosPembayaranController::class, 'index'])->name('pos-pembayaran');
    Route::post('/{id}/delete', [\App\Http\Controllers\PosPembayaranController::class, 'destroy'])->name('pos-pembayaran.delete');
});

Route::group(['prefix' => 'pembayaran'], function () {
    Route::get('/', [\App\Http\Controllers\PembayaranController::class, 'index'])->name('pembayaran');
    Route::get('/total-pembayaran-siswa', [\App\Http\Controllers\PembayaranController::class, 'total_pembayaran_siswa'])->name('pembayaran.siswa');
    Route::match(['get', 'post'], '/tambah', [\App\Http\Controllers\PembayaranController::class, 'add'])->name('pembayaran.add');
    Route::get('/{id}/cetak', [\App\Http\Controllers\PembayaranController::class, 'cetakDetail'])->name('pembayaran.cetak');
});

Route::group(['prefix' => 'kelas'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\KelasController::class, 'index'])->name('kelas');
    Route::post('/{id}', [\App\Http\Controllers\KelasController::class, 'patch'])->name('kelas.update');
    Route::post('/{id}/delete', [\App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.delete');
});

Route::group(['prefix' => 'tahun-ajaran'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\TahunAjaranContoller::class, 'index'])->name('tahun-ajaran');
    Route::post('/{id}', [\App\Http\Controllers\TahunAjaranContoller::class, 'patch'])->name('tahun-ajaran.update');
    Route::post('/{id}/delete', [\App\Http\Controllers\TahunAjaranContoller::class, 'destroy'])->name('tahun-ajaran.delete');
    Route::post('/{id}/change', [\App\Http\Controllers\TahunAjaranContoller::class, 'change'])->name('tahun-ajaran.change');
});

Route::group(['prefix' => 'siswa'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswa');
    Route::match(['get', 'post'], '/add', [\App\Http\Controllers\SiswaController::class, 'store'])->name('siswa.store');
    Route::post('/{id}', [\App\Http\Controllers\SiswaController::class, 'patch'])->name('siswa.update');
    Route::post('/{id}/delete', [\App\Http\Controllers\SiswaController::class, 'destroy'])->name('siswa.delete');
    Route::post('/{id}/change', [\App\Http\Controllers\SiswaController::class, 'change'])->name('siswa.change');
});

Route::group(['prefix' => 'pos-kelas-siswa'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\PosKelasSiswaController::class, 'index'])->name('pos-kelas-siswa');
});

Route::group(['prefix' => 'laporan-penerimaan'], function () {
    Route::get('/', [\App\Http\Controllers\LaporanJurnalPenerimaanController::class, 'index'])->name('laporan.penerimaan.index');
    Route::get('/cetak', [\App\Http\Controllers\LaporanJurnalPenerimaanController::class, 'cetak'])->name('laporan.penerimaan.cetak.all');
    Route::get('/{id}/cetak', [\App\Http\Controllers\LaporanJurnalPenerimaanController::class, 'cetakDetail'])->name('laporan.penerimaan.cetak');
});
Route::group(['prefix' => 'laporan-pembayaran'], function () {
    Route::get('/', [\App\Http\Controllers\LaporanPembayaranController::class, 'index'])->name('laporan.pembayaran.index');
    Route::get('/data', [\App\Http\Controllers\LaporanPembayaranController::class, 'getData'])->name('laporan.pembayaran.data');
    Route::get('/cetak', [\App\Http\Controllers\LaporanPembayaranController::class, 'cetak'])->name('laporan.pembayaran.cetak');
});

