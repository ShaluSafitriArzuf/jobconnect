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
        Schema::create('shalu_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('industry')->nullable(); // opsional
            $table->string('email')->unique();
            $table->string('location'); // ✅ lokasi perusahaan
            $table->text('description')->nullable(); // ✅ penjelasan tentang perusahaan
            $table->string('logo')->nullable(); // logo opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shalu_companies');
    }
};
