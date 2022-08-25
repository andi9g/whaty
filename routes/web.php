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

Route::get('/', 'authC@root');

Route::get('login', 'authC@login');
Route::post('login', 'authC@proseslogin')->name('proses.login');
Route::get('logout', 'authC@logout');

Route::get('register', 'authC@register');
Route::post('register', 'authC@prosesregister')->name('proses.register');

Route::get('lupapassword', 'authC@resetpassword');
Route::post('lupapassword', 'authC@prosesresetpassword')->name('reset.password');
Route::patch('lupapassword/{email}', 'authC@ubahpassword')->name('ubah.password');



Route::middleware(['GerbangLogin'])->group(function () {
    
    Route::get('home', 'indexC@index');
    Route::post('ubahpassword', 'indexC@ubahpassword')->name('password.ubah');
    
    //hanya supplier yang bisa mengakses
    Route::middleware(['GerbangSupplier'])->group(function () {
        
        Route::get('identitas', 'supplierC@index');
        Route::post('identitas', 'supplierC@updateidentitas')->name('ubah.identitas');
        
        //harus mengisi identitas supplier
        Route::middleware(['LengkapiIdentitas'])->group(function () {

            Route::get('jualmobil', 'supplierC@mobil');
            Route::post('jualmobil', 'supplierC@tambahmobil')->name('tambah.jualmobil');
            Route::put('jualmobil/ubah/{idmobil}', 'supplierC@ubahmobil')->name('ubah.jualmobil');
            Route::delete('jualmobil/hapus/{idmobil}', 'supplierC@hapusmobil')->name('hapus.jualmobil');
            
            Route::get('mobilterjual', 'supplierC@mobilterjual');

        });

    });


    Route::middleware(['GerbangAdmin'])->group(function () {

        Route::resource('mobil', 'mobilC');

        //mobilmasuk
        Route::get('mobilmasuk', 'mobilsupplierC@index');
        Route::post('mobilmasuk/proses/{idmobil}', 'mobilsupplierC@proses')->name('mobilmasuk.proses');
        
        //mobil yang di proses
        Route::get('proses', 'mobilsupplierC@mobilproses');
        Route::post('proses/cancel/{idmobil}', 'mobilsupplierC@prosescancel')->name('proses.cancel');
        Route::post('proses/proses/{idmobil}', 'mobilsupplierC@prosessah')->name('proses.sah');

        //mobil yang telah dibeli dan belum terjual
        Route::get('pembelianmobil', 'mobilsupplierC@terbeli');
        Route::get('cetak/pembelianmobil', 'mobilsupplierC@cetak')->name('cetak.pembelian');
        
        //pengguna sistem
        Route::resource('admin', 'penggunaC');
        Route::post('admin/{idadmin}/reset', 'penggunaC@reset')->name('reset.admin');
        Route::get('supplier', 'penggunaC@supplier');

        //data pembeli
        Route::resource('pembeli', 'pembeliC');

        //Jual Mobil
        Route::resource('penjualan', 'penjualanC');
        Route::get('cetak/penjualan', 'penjualanC@cetak')->name('cetak.penjualan');

    });

});





