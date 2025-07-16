<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/[timestamp]_create_shalu_applications_table.php
    public function up()
    {
        Schema::create('shalu_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shalu_job_id')->constrained('shalu_jobs')->onDelete('cascade');
            $table->foreignId('shalu_user_id')->constrained('shalu_users')->onDelete('cascade');
            $table->text('cover_letter');
            $table->string('cv_path')->nullable(); 
            $table->string('education')->nullable(); 
            $table->string('experience')->nullable();
            $table->string('domicile')->nullable(); 
            $table->string('availability')->nullable(); 
            $table->string('phone')->nullable();
            $table->string('portfolio_link')->nullable(); 
            $table->string('linkedin_link')->nullable(); 
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('shalu_applications');
    }
};