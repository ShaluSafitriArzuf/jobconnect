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
        // database/migrations/2025_06_24_110228_create_shalu_applications_table.php
        Schema::create('shalu_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shalu_job_id')->constrained('shalu_jobs');
            $table->foreignId('shalu_user_id')->constrained('shalu_users');
            $table->text('cover_letter');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shalu_applications');
    }
};