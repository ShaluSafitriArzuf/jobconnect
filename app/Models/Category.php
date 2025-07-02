<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Category extends Model
{
     use HasFactory;
    // Tabel yang digunakan
    protected $table = 'shalu_categories';

    // Kolom yang bisa diisi secara massal
    protected $fillable = ['name'];
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
