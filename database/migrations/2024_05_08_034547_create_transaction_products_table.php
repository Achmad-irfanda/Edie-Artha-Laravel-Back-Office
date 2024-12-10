<?php

use App\Models\User;
use App\Models\Mekanik;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Mekanik::class)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('alamat');
            $table->string('koordinat')->nullable();
            $table->string('status');
            $table->string('jasa_pasang')->nullable();
            $table->string('pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_products');
    }
};
