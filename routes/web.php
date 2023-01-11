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

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'jenis-pembayaran'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\JenisPembayaranController::class, 'index'])->name('jenis-pembayaran');
    Route::post( '/{id}', [\App\Http\Controllers\JenisPembayaranController::class, 'patch'])->name('jenis-pembayaran.update');
    Route::post( '/{id}/delete', [\App\Http\Controllers\JenisPembayaranController::class, 'destroy'])->name('jenis-pembayaran.delete');
});

Route::group(['prefix' => 'pos-pembayaran'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\PosPembayaranController::class, 'index'])->name('pos-pembayaran');
    Route::post( '/{id}', [\App\Http\Controllers\PosPembayaranController::class, 'patch'])->name('pos-pembayaran.update');
    Route::post( '/{id}/delete', [\App\Http\Controllers\PosPembayaranController::class, 'destroy'])->name('pos-pembayaran.delete');
});

Route::group(['prefix' => 'kelas'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\KelasController::class, 'index'])->name('kelas');
    Route::post( '/{id}', [\App\Http\Controllers\KelasController::class, 'patch'])->name('kelas.update');
    Route::post( '/{id}/delete', [\App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.delete');
});

Route::group(['prefix' => 'tahun-ajaran'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\TahunAjaranContoller::class, 'index'])->name('tahun-ajaran');
    Route::post( '/{id}', [\App\Http\Controllers\TahunAjaranContoller::class, 'patch'])->name('tahun-ajaran.update');
    Route::post( '/{id}/delete', [\App\Http\Controllers\TahunAjaranContoller::class, 'destroy'])->name('tahun-ajaran.delete');
    Route::post( '/{id}/change', [\App\Http\Controllers\TahunAjaranContoller::class, 'change'])->name('tahun-ajaran.change');
});

Route::group(['prefix' => 'siswa'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswa');
    Route::match(['get', 'post'], '/add', [\App\Http\Controllers\SiswaController::class, 'store'])->name('siswa.store');
    Route::post( '/{id}', [\App\Http\Controllers\SiswaController::class, 'patch'])->name('siswa.update');
    Route::post( '/{id}/delete', [\App\Http\Controllers\SiswaController::class, 'destroy'])->name('siswa.delete');
    Route::post( '/{id}/change', [\App\Http\Controllers\SiswaController::class, 'change'])->name('siswa.change');
});

