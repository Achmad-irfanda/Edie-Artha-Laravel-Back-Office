<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGambarToTransactionWorkshopsTable extends Migration
{
    public function up(): void
    {
        Schema::table('transaction_workshops', function (Blueprint $table) {
            $table->string('gambar')->nullable(); // Menambahkan kolom gambar
        });
    }

    public function down(): void
    {
        Schema::table('transaction_workshops', function (Blueprint $table) {
            $table->dropColumn('gambar'); // Menghapus kolom gambar jika migration dibatalkan
        });
    }
}