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
       $table->foreignId('shalu_user_id')->nullable()->constrained('shalu_users');
        $table->string('name');
        $table->string('industry')->nullable();
        $table->string('email')->unique();
        $table->string('location');
        $table->text('description')->nullable();
        $table->string('logo')->nullable();
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
