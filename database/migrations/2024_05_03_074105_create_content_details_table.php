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
        Schema::create('content_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->nullable()->constrained('contents');
            $table->json('title')->nullable();
            $table->string('image_serial_number')->nullable();
            $table->string('content_serial_number')->nullable();
            $table->json('description')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('content_details');
    }
};
