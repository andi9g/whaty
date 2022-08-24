<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class Mobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->bigIncrements('idmobil');
            $table->String('namamobil');
            $table->bigInteger('hargamobil');
            $table->bigInteger('hargamobilbeli')->nullable()->default(0);
            $table->enum('typemobil', ['manual', 'matic']);
            $table->char('tahun', 4);
            $table->String('kodeplat')->unique();
            $table->String('warna');
            $table->Integer('idsupplier')->default(0);
            $table->String('gambar');
            $table->Integer('idketerangan');
            $table->timestamps();
        });
        
        Schema::create('keterangan', function (Blueprint $table) {
            $table->bigIncrements('idketerangan');
            $table->enum('ket', ['sah', 'dijual', 'proses', 'kredit', 'terjual'])->unique();
            $table->timestamps();
        });

        
        $ket = ['sah', 'dijual', 'proses', 'kredit', 'terjual'];

        foreach ($ket as $item) {
            DB::table('keterangan')->insert([
                'ket' => $item,
            ]);
        }

        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('idadmin');
            $table->String('username');
            $table->String('nama');
            $table->String('password');
            $table->timestamps();
        });

        DB::table('admin')->insert([
            'username' => 'admin',
            'nama' => 'admin',
            'password' => Hash::make('admin')
        ]);

        Schema::create('durasi', function (Blueprint $table) {
            $table->bigIncrements('iddurasi');
            $table->Integer('nilai');
            $table->String('durasi');
            $table->timestamps();
        });

        Schema::create('supplier', function (Blueprint $table) {
            $table->bigIncrements('idsupplier');
            $table->String('email')->unique();
            $table->String('nama');
            $table->String('password');
            $table->timestamps();
        });

        Schema::create('detailsupplier', function (Blueprint $table) {
            $table->Integer('idsupplier')->primary();
            $table->char('nik', 16)->unique();
            $table->enum('jeniskelamin', ['l', 'p']);            
            $table->String('hp');
            $table->String('alamat');
            $table->String('tempatlahir');
            $table->date('tanggallahir');
            $table->timestamps();
        });


        Schema::create('detailpembeli', function (Blueprint $table) {
            $table->bigIncrements('iddetailpembeli');
            $table->bigInteger('nik');
            $table->Integer('idmobil')->unique();
            $table->date('tanggal');
            $table->String('ket');
            $table->Integer('iddurasi')->nullable();
            $table->timestamps();
        });

        Schema::create('pembeli', function (Blueprint $table) {
            $table->bigInteger('nik')->primary();
            $table->String('nama');
            $table->String('alamat');
            $table->String('tempatlahir');
            $table->date('tanggallahir');
            $table->char('hp', 15);
            $table->enum('jeniskelamin', ['l','p']);
            $table->timestamps();
        });

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('iddetailpembeli');
            $table->date('bayar');
            $table->date('tanggalbayar');
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
