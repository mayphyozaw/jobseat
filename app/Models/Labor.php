<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    protected $fillable = [
        'labor_no',
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'passport_number',
        'nrc_number',
        'nrc_front_path',
        'nrc_back_path',
        'passport_path',
        'photo_path',
        'status',
        'remark',
    ];

    
    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_labors', 'job_post_id', 'labor_id')->withPivot('job_post_id','labor_id','status','remark')->withTimestamps();
    }

    
}

     
