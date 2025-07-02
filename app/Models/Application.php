<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'shalu_applications';

    protected $fillable = [
        'user_id', 'job_id', 'cover_letter', 'status',
    ];

    /**
     * Relasi ke model User
     * Satu application dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Job
     * Satu application terkait dengan satu job
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
