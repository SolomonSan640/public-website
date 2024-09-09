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
        Schema::create('nrc_nos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('nrc_code_id')->nullable()->constrained('nrc_codes');
            $table->foreignId('nrc_township_id')->nullable()->constrained('nrc_townships');
            $table->foreignId('nrc_type_id')->nullable()->constrained('nrc_types');
            $table->string('name_en')->nullable();
            $table->string('name_mm')->nullable();
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
        Schema::dropIfExists('nrc_nos');
    }
};
