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
        Schema::create('rekapbulanan', function (Blueprint $table) {
            $table->id();
            $table->string('bulantahun');
            $table->bigInteger('total_masuk');
            $table->bigInteger('total_keluar');
            $table->bigInteger('saldo_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekapbulanan');
    }
};
