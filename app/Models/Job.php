<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'shalu_jobs';

    protected $fillable = [
        'title',
        'shalu_company_id',
        'shalu_category_id',
        'location',
        'description',
        'job_type',
        'deadline',
        'salary',
        'requirements',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'shalu_company_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'shalu_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'shalu_job_id');
    }
    protected $casts = [
        'deadline' => 'date', 
    ];

}
