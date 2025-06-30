<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function company()
{
    return $this->belongsTo(\App\Models\Company::class);
}

public function category()
{
    return $this->belongsTo(\App\Models\Category::class);
}

}