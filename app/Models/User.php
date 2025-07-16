<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Application;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'shalu_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
     public function applications()
    {
        return $this->hasMany(Application::class, 'shalu_user_id'); // FOREIGN KEY disesuaikan!
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCompany(): bool
    {
        return $this->role === 'company';
    }

    public function isRegularUser(): bool
    {
        return $this->role === 'user';
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'shalu_user_id'); // foreign key di tabel perusahaan
    }
}
