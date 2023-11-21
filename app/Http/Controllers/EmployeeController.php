<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeController extends Controller
{
    public function getByName(Request $request)
    {
        $employee = Employee::where(['name' => $request->get('name')])->first();

        if (!$employee)
            return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Employee not found']);

        $employeeResource = new EmployeeResource($employee);

        return $employeeResource->toArray($request);
    }
}
