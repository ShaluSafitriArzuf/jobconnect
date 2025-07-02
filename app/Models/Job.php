<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // ✅ Penting! Biar Laravel tahu pakai tabel 'shalu_jobs'
    protected $table = 'shalu_jobs';

    protected $fillable = [
        'title',
        'company_id',
        'category_id',
        'location',
        'description',
        'job_type',
        'deadline',
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }
}
