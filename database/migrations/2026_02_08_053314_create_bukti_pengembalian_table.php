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
        Schema::create('bukti_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengembalian')->constrained('pengembalian')->onDelete('cascade');
            $table->string('tipe_media')->default('foto'); // foto, video, dokumen, dll
            $table->string('path_file');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pengembalian');
    }
};
