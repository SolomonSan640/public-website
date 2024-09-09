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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('city_id')->nullable()->constrained('cities');
            $table->foreignId('township_id')->nullable()->constrained('townships');
            $table->foreignId('postal_code_id')->nullable()->constrained('postal_codes');
            $table->foreignId('zip_code_id')->nullable()->constrained('zip_codes');
            $table->string('name_en')->nullable();
            $table->string('name_mm')->nullable();
            $table->string('name_th')->nullable();
            $table->string('name_kr')->nullable();
            $table->longText('address_en')->nullable();
            $table->longText('address_mm')->nullable();
            $table->longText('address_th')->nullable();
            $table->longText('address_kr')->nullable();
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_mm')->nullable();
            $table->longText('description_th')->nullable();
            $table->longText('description_kr')->nullable();
            $table->longText('remark_en')->nullable();
            $table->longText('remark_mm')->nullable();
            $table->longText('remark_th')->nullable();
            $table->longText('remark_kr')->nullable();
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
        Schema::dropIfExists('shops');
    }
};
