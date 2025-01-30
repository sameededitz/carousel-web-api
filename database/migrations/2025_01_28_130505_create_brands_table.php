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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousel_id')->constrained()->onDelete('cascade');
            $table->boolean('is_show_in_intro_slide');
            $table->boolean('is_show_in_outro_slide');
            $table->boolean('is_show_in_regular_slide');
            $table->string('name_text');
            $table->boolean('name_is_enabled')->default(true);
            $table->string('handle_text');
            $table->boolean('handle_is_enabled')->default(true);
            $table->boolean('profile_image_is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
