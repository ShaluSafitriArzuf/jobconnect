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

public function user()
{
    return $this->belongsTo(User::class, 'shalu_user_id');
}
    public function jobs()
{
    return $this->hasMany(Job::class, 'shalu_company_id');
}
}
