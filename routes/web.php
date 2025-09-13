<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Sales;
use App\Http\Controllers\Gudang;
use App\Http\Controllers\Pengirim;
use App\Http\Controllers\Login;
use Illuminate\Support\Facades\Auth;
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
Route::get('/login', [Login::class,'view'] )->middleware('guest');
Route::post('/login', [Login::class,'login'] )->middleware('guest');

Route::get('/sales/home', [Sales::class,'sales'])->middleware('sales');
Route::get('/sales/history', [Sales::class,'history'])->middleware('sales');
Route::post('/sales/history', [Sales::class,'history2'])->middleware('sales');
Route::get('/sales/sell', [Sales::class,'sell'])->middleware('sales');
Route::post('/sales/sell', [Sales::class,'sells'])->middleware('sales');
Route::get('/pengirim/home',[Pengirim::class,'home'])->middleware('pengirim');
Route::get('/pengirim/task', [Pengirim::class,'task'])->middleware('pengirim');
Route::get('/admin/request', [Admin::class,'request'])->middleware('admin');
Route::get('/admin/home', [Admin::class,'home'])->middleware('admin');
Route::get('/admin/stok', [Admin::class,'stok'])->middleware('admin');
Route::get('/admin/stok/add', [Admin::class,'add'])->middleware('admin');
Route::post('/admin/stok/add', [Admin::class,'add1'])->middleware('admin');
Route::get('/admin/stok/{produk}', [Admin::class,'stok_detail'])->middleware('admin');
Route::get('/admin/history', [Admin::class,'history'])->middleware('admin');
Route::get('/gudang/tambah', [Gudang::class,'tambah'])->middleware('gudang');
Route::get('/gudang/home', [Gudang::class,'home'])->middleware('gudang');
Route::get('/gudang/deliver', [Gudang::class,'gudang'])->middleware('gudang');
Route::get('/gudang/in', [Gudang::class,'stok_in'])->middleware('gudang');
Route::post('/gudang/in', [Gudang::class,'stok_in1'])->middleware('gudang');
Route::get('/gudang/stok', [Gudang::class,'stok'])->middleware('gudang');
Route::get('/gudang/stok/add', [Gudang::class,'add'])->middleware('gudang');
Route::post('/gudang/stok/add', [Gudang::class,'add1'])->middleware('gudang');
Route::get('/gudang/sent/{code?}', [Gudang::class,'pengiriman'])->middleware('gudang');
Route::post('/gudang/sent/{code}', [Gudang::class,'pengiriman'])->middleware('gudang');
Route::put('/gudang/sent/{code}', [Gudang::class,'ubah_pengiriman'])->middleware('gudang');
Route::post('/admin/request', [Admin::class,'add_request'])->middleware('admin');
Route::get('/admin/request-edit/{name}/{code}', [Admin::class,'edit'])->middleware('admin');
Route::get('/admin/edit/{name}', [Admin::class,'edit_harga'])->middleware('admin');
Route::put('/admin/request-edit/', [Admin::class,'edit1'])->middleware('admin');
Route::delete('/admin/request-edit/', [Admin::class,'edit2'])->middleware('admin');
Route::put('/pengirim/sent/{time}', [Pengirim::class,'pengiriman'])->middleware('pengirim');
Route::get('/admin/history_in', [Admin::class,'history_in'])->middleware('admin');
Route::get('/gudang/history_in', [Gudang::class,'history_in'])->middleware('gudang');
Route::get('/admin/history_out', [Admin::class,'history_out'])->middleware('admin');
Route::get('/gudang/history_out', [Gudang::class,'history_out'])->middleware('gudang');
Route::get('/admin/history_out/{code}', [Admin::class,'history_out_detail'])->middleware('admin');
Route::get('/gudang/history_out/{code}', [Gudang::class,'history_out_detail'])->middleware('gudang');
Route::get('/admin/history_in/{code}', [Admin::class,'history_in_detail'])->middleware('admin');
Route::get('/gudang/stok/{produk}', [Gudang::class,'stok_detail'])->middleware('gudang');
Route::get('/gudang/history_in/{code}', [Gudang::class,'history_in_detail'])->middleware('gudang');
Route::delete('/gudang/stok/', [Gudang::class,'delete'])->middleware('gudang');
Route::delete('/admin/stok/', [Gudang::class,'delete'])->middleware('admin');
Route::put('/admin/edit_harga/', [Admin::class,'edit_harga1'])->middleware('admin');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login'); // arahkan ke halaman login atau home
})->name('logout');