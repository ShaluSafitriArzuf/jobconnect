<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('shalu_jobs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('company_id');
        $table->unsignedBigInteger('category_id')->nullable(); // ✅ ini kolom relasi
        $table->string('title');
        $table->text('description');
        $table->string('location');
        $table->enum('job_type', ['Full-Time', 'Part-Time', 'Internship']);
        $table->date('deadline');
        $table->timestamps();

        // ✅ Foreign key ke shalu_companies
        $table->foreign('company_id')->references('id')->on('shalu_companies')->onDelete('cascade');

        // ✅ Foreign key ke shalu_categories (ditempatkan di sini juga)
        $table->foreign('category_id')->references('id')->on('shalu_categories')->onDelete('set null');
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
