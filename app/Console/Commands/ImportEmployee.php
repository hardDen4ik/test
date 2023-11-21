<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Console\Command;

class ImportEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports employees from .csv';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = fopen(base_path('data.csv'), 'r');
        $lines = [];
        while (!feof($file)) {
            $lines[] = fgetcsv($file, 0, ',');
        }
        fclose($file);
        if (!empty($lines))
            foreach (array_slice($lines, 1) as $line){
                if (!empty($line)) {
                    $job = Job::firstOrNew(['name' => $line[1]]);
                    $job->save();
                    $department = Department::firstOrNew(['name' => $line[2]]);
                    $department->save();
                    Employee::create([
                        'name' => $line[0],
                        'job_id' => $job->id,
                        'department_id' => $department->id,
                        'employment' => $line[3] == 'F' ? Employee::EMPLOYMENT_FULL : Employee::EMPLOYMENT_PART,
                        'payment' => $line[4] == 'SALARY' ? Employee::PAYMENT_SALARY : Employee::PAYMENT_HOURLY,
                        'typical_hours' => floatval($line[5]),
                        'annual_salary' => floatval($line[6]),
                        'hourly_rate' => floatval($line[7]),
                    ]);
                }
            }
    }
}
