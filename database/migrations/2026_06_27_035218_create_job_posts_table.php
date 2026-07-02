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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->string('job_code')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->string('company_name');
            $table->string('title');
            $table->integer('male_count')->default(0);
            $table->integer('female_count')->default(0);
            $table->string('total_count')->default(0);
            $table->string('age_limit')->nullable();
            $table->integer('salary')->nullable();
            $table->string('deposit_fee')->nullable();
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
