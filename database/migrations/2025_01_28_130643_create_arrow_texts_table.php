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
        Schema::create('arrow_texts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carousel_id')->constrained()->onDelete('cascade');
            $table->string('arrow_id');
            $table->boolean('is_only_arrow');
            $table->string('intro_slide_arrow_text');
            $table->boolean('intro_slide_arrow_is_enabled');
            $table->string('regular_slide_arrow_text');
            $table->boolean('regular_slide_arrow_is_enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrow_texts');
    }
};
