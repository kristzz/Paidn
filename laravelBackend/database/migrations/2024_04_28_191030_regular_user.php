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
        Schema::create('regularUsers', function (Blueprint $table) {
            $table->enum('gender', ['undisclosed','male', 'female', 'other'])->nullable();
            $table->string('name')->nullable();
            $table->string('secondName')->nullable();
            $table->string('surname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
