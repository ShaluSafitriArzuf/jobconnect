<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'shalu_companies';

    protected $fillable = [
        'name', 'location', 'description', // sesuaikan sama field di database-mu
    ];
}
