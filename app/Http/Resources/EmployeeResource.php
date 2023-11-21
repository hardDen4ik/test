<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'job_title' => $this->job->name,
            'department' => $this->department->name,
            'full_or_part-time' => $this->employment == 0 ? Employee::EMPLOYMENT_FULL : Employee::EMPLOYMENT_PART,
            'salary_or_hourly' => $this->payment == 0 ? Employee::PAYMENT_SALARY : Employee::PAYMENT_HOURLY,
            'typical_hours' => $this->typical_hours,
            'annual_salary' => $this->annual_salary,
            'hourly_rate' => $this->hourly_rate,
        ];
    }
}
