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
        'shalu_company_id',  // Ubah dari company_id
        'shalu_category_id', // Ubah dari category_id
        'location',
        'description',
        'job_type',
        'deadline',
    ];

    // app/Models/Job.php
    public function company()
{
    return $this->belongsTo(Company::class, 'shalu_company_id');
}

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Umum'
        ]);
    }

    // Scope untuk job aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

   public function applications()
{
    return $this->hasMany(Application::class, 'shalu_job_id');
}
    protected $casts = [
        'deadline' => 'date', // atau 'datetime'
        // ... casts lainnya
    ];

}
