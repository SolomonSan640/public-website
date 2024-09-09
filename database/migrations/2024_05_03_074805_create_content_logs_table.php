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
        Schema::create('content_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('service_pages');
            $table->foreignId('profile_id')->nullable()->constrained('profile_pages');
            $table->foreignId('contact_id')->nullable()->constrained('contact_pages');
            $table->foreignId('home_id')->nullable()->constrained('home_pages');
            $table->foreignId('about_id')->nullable()->constrained('about_pages');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('content_logs');
    }
};
