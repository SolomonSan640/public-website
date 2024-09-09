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
        Schema::create('priority_layers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layer_id')->nullable()->constrained('layers');
            $table->foreignId('priority_id')->nullable()->constrained('priorities');
            $table->string('name')->nullable();
            $table->bigInteger('layer_priority_id')->nullable();
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
        Schema::dropIfExists('priority_layers');
    }
};
