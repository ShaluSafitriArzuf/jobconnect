<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'shalu_applications';

    protected $fillable = [
        'shalu_user_id',
        'shalu_job_id',
        'cover_letter',
        'cv_path',
        'education',
        'experience',
        'domicile',
        'availability',
        'phone',
        'portfolio_link',
        'linkedin_link',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'shalu_user_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'shalu_job_id');
    }
}