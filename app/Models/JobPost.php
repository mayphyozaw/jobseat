<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class JobPost extends Model
{
    protected $fillable = [
        'job_code',
        'country_id',
        'company_name',
        'title',
        'male_count',
        'female_count',
        'total_count',
        'age_limit',
        'salary',
        'deposit_fee',
        'description',
        'deadline',
        'status',
        'job_image',
    ];


    protected function acsrImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) =>
            $attributes['job_image']
                ? asset('upload/job_images/' . $attributes['job_image'])
                : asset('upload/job_images/default.png')
        );
    }


    protected function acsrStatus(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                return match ($attributes['status']) {
                    'open' => [
                        'text'  => 'Open',
                        'badge' => 'success', // Bootstrap class
                    ],
                    'closed' => [
                        'text'  => 'Closed',
                        'badge' => 'danger',
                    ],
                    'paused' => [
                        'text'  => 'Paused',
                        'badge' => 'secondary',
                    ],
                    default => [
                        'text'  => 'unknown',
                        'badge' => 'secondary',
                    ],
                };
            }
        );
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function labor()
    {
        return $this->belongsToMany(Labor::class, 'job_post_labors', 'job_post_id', 'labor_id')->withPivot('job_post_id','labor_id','status','remark')->withTimestamps();
    }


     public function jobPostLabor()
    {
        return $this->hasMany(JobPostLabor::class);
    }


    public function jobPostCandidates()
    {
        return $this->hasMany(JobPostCandidate::class);
    }

     public function confirmedCount(): int
    {
        return $this->jobPostLabor()->whereIn('status', ['confirmed', 'qualified'])->count();
    }
 
    public function remainingQuota(): int
    {
        return max(0, $this->total_count - $this->confirmedCount());
    }
 
    public function isQuotaFilled(): bool
    {
        return $this->remainingQuota() === 0;
    }

}
