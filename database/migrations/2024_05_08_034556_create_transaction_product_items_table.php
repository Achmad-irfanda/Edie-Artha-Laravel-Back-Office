<?php

use App\Models\Product;
use App\Models\TransactionProduct;
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
        Schema::create('transaction_product_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TransactionProduct::class);
            $table->foreignIdFor(Product::class);
            $table->string('varian')->nullable();
            $table->integer('kuantitas');
            $table->decimal('harga', 10, 2);
            $table->decimal('total', 10, 2);
            $table->float('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_product_items');
    }
};
