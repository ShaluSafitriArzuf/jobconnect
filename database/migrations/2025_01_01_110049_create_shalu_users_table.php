<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/2025_06_23_000000_create_shalu_users_table.php
        Schema::create('shalu_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin','company', 'user'])->default('user'); // Kolom role sudah ada di sini
            $table->rememberToken();
            $table->timestamps();
        });
        DB::statement("INSERT INTO shalu_users (id, name, email, password, created_at, updated_at) 
               SELECT id, name, email, password, created_at, updated_at FROM users");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shalu_users');
    }
};
