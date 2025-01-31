<?php

use App\Models\Mekanik;
use App\Models\User;
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
        Schema::create('transaction_workshops', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Mekanik::class)->nullable();
            $table->string('alamat');
            $table->string('kendala');
            $table->string('deskripsi');
            $table->string('jenis_kendaraan');
            $table->string('plat_nomor');
            $table->float('rating')->nullable();
            $table->string('status');
            $table->timestamps();
        });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_workshops');

    }
};



