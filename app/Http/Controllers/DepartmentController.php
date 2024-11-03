<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\DepartmentResource;

class DepartmentController extends Controller
{
    public function index() {
        $departments = Cache::remember('departments', now()->addMinutes(10), function () {
            return Department::all();
        });
        return response()->json([
            "departments" => $departments,
            'message' => 'success'
        ],200);
    }

    function show($id)
     {
           
        $department = Department::findOrFail($id);
        return response()->json(new DepartmentResource($department), 200);
     }

    public function countEmployeesByDepartment() {
        $count = Cache::remember('employee_count_by_department', now()->addMinutes(5), function () {
            return DB::table('departments')
                ->leftJoin('employees', 'departments.id', '=', 'employees.department_id')
                ->select('departments.name', DB::raw('COUNT(employees.id) as employee_count'))
                ->groupBy('departments.id', 'departments.name')
                ->orderBy('departments.name')
                ->get();
        });
    
        return response()->json([
            "Employee Counts" => $count,
            'message' => 'success'
        ], 200);
    }


        public function averageSalaryByDepartment()
        {
            $averageSalary = DB::table('employees')
                ->select('department_id', DB::raw('AVG(salary) as average_salary'))
                ->groupBy('department_id')
                ->get();
    
            return response()->json($averageSalary, 200);
        }

    // public function averageSalaryByDepartment() {
    //     $average = Department::with('employees')
    //         ->selectRaw('departments.*, AVG(employees.salary) as avg_salary')
    //         ->join('employees', 'departments.id', '=', 'employees.department_id')
    //         ->groupBy('departments.id')
    //         ->get();
    //     return response()->json([
    //         "The Average" => $average,
    //         'message' => 'success'
    //     ],200);
    // }
}
