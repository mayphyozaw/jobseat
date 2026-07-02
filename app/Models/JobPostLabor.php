<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPostLabor extends Model
{
    protected $fillable = [
        'job_post_id',
        'labor_id',
        'status',
        'remark',
      
    ];


    public function candidate()
    {
        return $this->belongsTo(Labor::class);
    }
 
    public function jobOrder()
    {
        return $this->belongsTo(JobPost::class);
    }
}
