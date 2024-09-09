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
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories');
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('currency_id')->nullable()->constrained('currencies');
            $table->string('name_en')->nullable();
            $table->string('name_mm')->nullable();
            $table->string('name_th')->nullable();
            $table->string('name_kr')->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('price')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_mm')->nullable();
            $table->longText('description_th')->nullable();
            $table->longText('description_kr')->nullable();
            $table->longText('remark_en')->nullable();
            $table->longText('remark_mm')->nullable();
            $table->longText('remark_th')->nullable();
            $table->longText('remark_kr')->nullable();
            $table->boolean('is_show')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->tinyInteger('updated_by')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
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
