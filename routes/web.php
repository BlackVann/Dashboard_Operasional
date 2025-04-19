<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Sales;
use App\Http\Controllers\Gudang;
use App\Http\Controllers\Pengirim;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/sales/home', [Sales::class,'sales']);
Route::get('/sales/history', [Sales::class,'history']);
Route::get('/sales/sell', [Sales::class,'sell']);
Route::post('/sales/sell', [Sales::class,'sells']);
Route::get('/pengirim/home',[Pengirim::class,'home']);
Route::get('/pengirim/task', [Pengirim::class,'task']);
Route::get('/admin/request', [Admin::class,'request']);
Route::get('/admin/home', [Admin::class,'home']);
Route::get('/admin/stok', [Admin::class,'stok']);
Route::get('/admin/history', [Admin::class,'history']);
Route::get('/gudang/tambah', [Gudang::class,'tambah']);
Route::get('/gudang/home', [Gudang::class,'home']);
Route::get('/gudang/deliver', [Gudang::class,'gudang']);
Route::get('/gudang/stok', [Gudang::class,'stok']);
Route::get('/gudang/sent/{time}', [Gudang::class,'pengiriman']);
Route::put('/gudang/sent/{time}', [Gudang::class,'ubah_pengiriman']);
Route::post('/admin/request', [Admin::class,'add_request']);
Route::put('/pengirim/sent/{time}', [Pengirim::class,'pengiriman']);