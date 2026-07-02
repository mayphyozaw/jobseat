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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('labor_no')->nullable();
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('nrc_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('notes')->nullable();
            $table->string('nrc_front_path')->nullable();
            $table->string('nrc_back_path')->nullable();
            $table->string('passport_path')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
