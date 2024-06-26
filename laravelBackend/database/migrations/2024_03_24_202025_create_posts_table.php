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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->string('title')->required();
            $table->text('jobDesc')->required();
            $table->string('profession')->required();
            $table->string('country')->required();
            $table->enum('location', ['On-site', 'Hybrid', 'Remote'])->required();
            $table->string('salaryRangeLowest')->required();
            $table->string('salaryRangeHighest')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
