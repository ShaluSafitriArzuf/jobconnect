<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Tabel yang digunakan
    protected $table = 'shalu_categories';

    // Kolom yang bisa diisi secara massal
    protected $fillable = ['name'];
}
