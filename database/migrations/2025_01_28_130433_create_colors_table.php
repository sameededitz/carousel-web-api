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
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousel_id')->constrained()->onDelete('cascade');
            $table->boolean('is_use_custom_colors');
            $table->boolean('is_alternate_slide_colors');
            $table->string('background_color');
            $table->string('text_color');
            $table->string('accent_color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
