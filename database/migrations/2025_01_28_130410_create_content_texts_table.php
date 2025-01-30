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
        Schema::create('content_texts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousel_id')->constrained()->onDelete('cascade');
            $table->boolean('is_custom_fonts_enabled');
            $table->string('primary_font_name');
            $table->string('primary_font_href');
            $table->string('secondary_font_name');
            $table->string('secondary_font_href');
            $table->float('font_size');
            $table->enum('font_text_alignment', ['center', 'left', 'right']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_texts');
    }
};
