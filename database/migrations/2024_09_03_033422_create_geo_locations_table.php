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
        Schema::create('geo_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('priority_layer_id')->nullable()->constrained('priority_layers');
            $table->string('start_latitude')->nullable();
            $table->string('end_latitude')->nullable();
            $table->string('start_longitude')->nullable();
            $table->string('end_longitude')->nullable();
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
        Schema::dropIfExists('geo_locations');
    }
};
