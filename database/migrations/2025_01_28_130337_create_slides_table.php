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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousel_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['intro', 'regular', 'outro'])->nullable();
            $table->string('selected_tab')->nullable();
            $table->enum('content_orientation', ['row', 'row-reverse', 'column', 'column-reverse'])->nullable();
            $table->string('sub_title_text');
            $table->boolean('sub_title_is_enabled')->default(true);
            $table->string('title_text');
            $table->boolean('title_is_enabled')->default(true);
            $table->integer('title_font_size')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->boolean('cta_button_is_enabled')->default(true);
            $table->string('description_text')->nullable();
            $table->boolean('description_is_enabled')->default(true);
            $table->integer('description_font_size')->nullable();
            $table->boolean('image_is_enabled')->default(true);
            $table->float('image_opacity')->nullable();
            $table->string('image_background_position')->nullable();
            $table->boolean('image_is_bg_cover')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
