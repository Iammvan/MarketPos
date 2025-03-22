<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_barang', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama_pengaju'); // Nama orang yang mengajukan barang
            $table->string('nama_barang'); // Nama barang yang diajukan
            $table->integer('qty'); // Jumlah barang (qty)
            $table->date('tanggal_pengajuan'); // Tanggal pengajuan barang
            $table->boolean('terpenuhi')->default(false); // Status apakah pengajuan sudah terpenuhi
            $table->text('deskripsi')->nullable(); // Deskripsi barang (opsional)
            $table->timestamps(); // Kolom untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_barang');
    }
};
