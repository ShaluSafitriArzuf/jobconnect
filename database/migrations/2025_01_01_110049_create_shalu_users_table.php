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
    Schema::create('shalu_users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->enum('role', ['admin','company', 'user'])->default('user');
        $table->rememberToken();
        $table->timestamps();
    });
    
    // Hapus statement INSERT atau buat kondisi jika tabel users ada
    if (Schema::hasTable('users')) {
        DB::statement("INSERT INTO shalu_users (name, email, password, created_at, updated_at) 
               SELECT name, email, password, created_at, updated_at FROM users");
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shalu_users');
    }
};
