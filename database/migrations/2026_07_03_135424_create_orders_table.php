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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('layanan_id')->constrained('services')->cascadeOnDelete();
            $table->string('nama_pelanggan');
            $table->string('no_hp');
            $table->decimal('berat_kg', 8, 2)->nullable();
            $table->integer('jumlah')->nullable();
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->string('status')->default('diterima');
            $table->date('tanggal_masuk');
            $table->date('estimasi_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
