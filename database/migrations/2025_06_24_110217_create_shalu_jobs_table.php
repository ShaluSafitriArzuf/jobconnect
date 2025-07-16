<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shalu_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shalu_company_id')->constrained('shalu_companies');
            $table->foreignId('shalu_category_id')->constrained('shalu_categories');
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable(); 
            $table->string('salary')->nullable();  
            $table->string('location');
            $table->string('job_type');
            $table->date('deadline');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shalu_jobs');
    }
};
