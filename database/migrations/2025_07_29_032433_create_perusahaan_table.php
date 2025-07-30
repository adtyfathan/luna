<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('keterangan')->nullable();
            $table->string('logo')->nullable();
            $table->string('headline')->nullable();
            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->foreign('provinsi_id')
                ->references('id')
                ->on('provinsi')
                ->onDelete('cascade');
            $table->unsignedBigInteger('kota_id')->nullable();
            $table->foreign('kota_id')
                ->references('id')
                ->on('kota')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};