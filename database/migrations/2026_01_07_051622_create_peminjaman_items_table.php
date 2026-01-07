<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel peminjaman
            $table->foreignId('peminjaman_id')
                ->constrained('peminjaman')
                ->cascadeOnDelete();

            // Relasi ke tabel inventaris
            $table->foreignId('inventaris_id')
                ->constrained('inventaris')
                ->cascadeOnDelete();

            // jumlah barang yang dipinjam
            $table->integer('jumlah')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_items');
    }
};
