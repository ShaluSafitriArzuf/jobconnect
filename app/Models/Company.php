<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $table = 'shalu_companies';

   protected $fillable = [
    'shalu_user_id',
    'name',
    'industry',
    'email',
    'location',
    'description',
    'logo'
];

// app/Models/Company.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function jobs()
{
    return $this->hasMany(Job::class, 'shalu_company_id');
}


public function applications()
{
    return $this->hasManyThrough(Application::class, Job::class);
}

}
