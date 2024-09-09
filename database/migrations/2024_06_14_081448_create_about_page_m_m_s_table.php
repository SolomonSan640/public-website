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
        Schema::create('about_page_m_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();
            $table->string('title_4')->nullable();
            $table->string('title_5')->nullable();
            $table->string('title_6')->nullable();
            $table->string('title_7')->nullable();
            $table->string('title_8')->nullable();
            $table->string('title_9')->nullable();
            $table->string('title_10')->nullable();
            $table->string('title_11')->nullable();
            $table->string('title_12')->nullable();
            $table->string('title_13')->nullable();
            $table->string('title_14')->nullable();
            $table->string('title_15')->nullable();
            $table->longText('content_1')->nullable();
            $table->longText('content_2')->nullable();
            $table->longText('content_3')->nullable();
            $table->longText('content_4')->nullable();
            $table->longText('content_5')->nullable();
            $table->longText('content_6')->nullable();
            $table->longText('content_7')->nullable();
            $table->longText('content_8')->nullable();
            $table->longText('content_9')->nullable();
            $table->longText('content_10')->nullable();
            $table->longText('content_11')->nullable();
            $table->longText('content_12')->nullable();
            $table->longText('content_13')->nullable();
            $table->longText('content_14')->nullable();
            $table->longText('content_15')->nullable();
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_4')->nullable();
            $table->string('image_5')->nullable();
            $table->string('image_6')->nullable();
            $table->string('image_7')->nullable();
            $table->string('image_8')->nullable();
            $table->string('image_9')->nullable();
            $table->string('image_10')->nullable();
            $table->string('image_11')->nullable();
            $table->string('image_12')->nullable();
            $table->string('image_13')->nullable();
            $table->string('image_14')->nullable();
            $table->string('image_15')->nullable();
            $table->string('image_m_1')->nullable();
            $table->string('image_m_2')->nullable();
            $table->string('image_m_3')->nullable();
            $table->string('image_m_4')->nullable();
            $table->string('image_m_5')->nullable();
            $table->integer('status')->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_m_m_s');
    }
};
