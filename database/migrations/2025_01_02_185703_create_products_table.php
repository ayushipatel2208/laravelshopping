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
        Schema::create('products', function (Blueprint $table) {
            $table->id('pro_id');
            $table->string('title');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->double('price',10,2);
            $table->double('compare_price',10,2)->nullable();
            $table->bigInteger('cat_id');
            $table->bigInteger('sub_id')->nullable();
            $table->bigInteger('id')->nullable();
            $table->enum('is_featured',['Yes', 'No'])->default('No');
            $table->string('sku');
            $table->string('barcode')->nullable();
            $table->enum('track_qty',['Yes', 'No'])->default('Yes');
            $table->integer('qty')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
