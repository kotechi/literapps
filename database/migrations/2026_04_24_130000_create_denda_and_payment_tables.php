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
        if (! Schema::hasTable('denda')) {
            Schema::create('denda', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_pengembalian')->constrained('pengembalian')->onDelete('cascade');
                $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
                $table->string('nama_kategori')->default('Keterlambatan Pengembalian');
                $table->enum('status', ['menunggu', 'selesai'])->default('menunggu');
                $table->unsignedBigInteger('total_denda')->default(0);
                $table->timestamps();

                $table->unique('id_pengembalian');
            });
        }

        if (! Schema::hasTable('payment')) {
            Schema::create('payment', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_denda')->constrained('denda')->onDelete('cascade');
                $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
                $table->unsignedBigInteger('nominal')->default(0);
                $table->string('proof_img');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
        Schema::dropIfExists('denda');
    }
};
