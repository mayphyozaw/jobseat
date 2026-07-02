<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPostCandidate extends Model
{
    protected $table = 'job_post_candidates';

    protected $fillable = [
        'candidate_id',
        'job_post_id',
        'status',
        'rejection_reason',
        'notes',
        'applied_online',
    ];

    

    protected $casts = [
        'applied_online' => 'boolean',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    // public function deposit()
    // {
    //     return $this->hasOne(Deposit::class);
    // }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending_payment'    => '<span class="badge bg-warning text-dark">Pending Payment</span>',
            'payment_submitted'  => '<span class="badge bg-info">Payment Submitted</span>',
            'deposit_verified'   => '<span class="badge bg-primary">Deposit Verified</span>',
            'qualified'          => '<span class="badge bg-success">Qualified</span>',
            'rejected'           => '<span class="badge bg-danger">Rejected</span>',
            'waiting_list'       => '<span class="badge bg-secondary">Waiting List</span>',
            'confirmed'          => '<span class="badge bg-success">Confirmed</span>',
            default              => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>',
        };
    }

    public function getStatusMyanmarAttribute(): string
    {
        return match ($this->status) {
            'pending_payment'    => 'ငွေပေးချေမှု စောင့်ဆိုင်းဆဲ',
            'payment_submitted'  => 'ငွေပေးချေမှု တင်သွင်းပြီး',
            'deposit_verified'   => 'အပ်ငွေ အတည်ပြုပြီး',
            'qualified'          => 'အရည်အချင်းပြည့်မီ',
            'rejected'           => 'ငြင်းပယ်ခဲ့',
            'waiting_list'       => 'စောင့်ဆိုင်းစာရင်း',
            'confirmed'          => 'အတည်ပြုပြီး',
            default              => $this->status,
        };
    }
}
