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
        Schema::create('background_overlays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousel_id')->constrained()->onDelete('cascade');
            $table->string('background_id');
            $table->string('overlay_color');
            $table->float('overlay_opacity')->nullable();
            $table->boolean('is_overlay_fade_corner');
            $table->string('corner_element_id');
            $table->float('corner_element_opacity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('background_overlays');
    }
};
