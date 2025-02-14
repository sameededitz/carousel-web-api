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
        Schema::create('affiliate_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // The email must be unique in this table.
            $table->string('email')->unique();
            // Store the hashed password.
            $table->string('password');
            // Application status: pending, approved, or rejected.
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            // The referral code will be generated when the application is approved.
            $table->string('referral_code')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_applications');
    }
};
