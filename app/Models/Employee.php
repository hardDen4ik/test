<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    const EMPLOYMENT_FULL = 0;
    const EMPLOYMENT_PART = 1;
    const PAYMENT_SALARY = 0;
    const PAYMENT_HOURLY = 1;

    protected $table = 'employee';

    protected $fillable = [
        'name',
        'job_id',
        'department_id',
        'employment',
        'payment',
        'typical_hours',
        'annual_salary',
        'hourly_rate'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
