<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{

    protected $fillable = [
        'labor_no',
        'full_name',
        'phone',
        'nrc_number',
        'passport_number',
        'date_of_birth',
        'age',
        'gender',
        'address',
        'notes',
        'nrc_front_path',
        'nrc_back_path',
        'passport_path',
        'photo_path',
        'status',
    ];


    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function jobPostCandidates()
    {
        return $this->hasMany(JobPostCandidate::class);
    }

    // public function jobPosts()
    // {
    //     return $this->belongsToMany(JobPost::class, 'job_post_candidates')
    //         ->withPivot('status', 'notes', 'rejection_reason')
    //         ->withTimestamps();
    // }

    public function jobPosts()
    {
        return $this->belongsToMany(
            JobPost::class,
            'job_post_candidates',
            'candidate_id',
            'job_post_id'
        );
    }

    // public function deposits()
    // {
    //     return $this->hasMany(Deposit::class);
    // }

    public function getLatestApplicationAttribute()
    {
        return $this->jobPostCandidates()->latest()->first();
    }
}
