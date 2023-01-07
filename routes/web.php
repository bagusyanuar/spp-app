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

Route::group(['prefix' => 'kelas'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\KelasController::class, 'index'])->name('kelas');
    Route::post( '/{id}', [\App\Http\Controllers\KelasController::class, 'patch'])->name('kelas.update');
    Route::post( '/{id}/delete', [\App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.delete');
});

