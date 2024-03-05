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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('businessName');
            $table->string('businessType');
            $table->string('businessAddress')->nullable();
            $table->string('businessEmail');
            $table->string('businessDescription')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('businessPassword');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
