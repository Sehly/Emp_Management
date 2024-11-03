<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;


    Route::middleware(['ip.whitelist'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index']);  
    
    Route::get('/employees/{id}', [EmployeeController::class, 'highestSalary']); 
    Route::post('/employees', [EmployeeController::class, 'store']);  
    Route::put('/employees/{id}', [EmployeeController::class, 'update']); 
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']); 
    Route::get('/employees/highest-salary', [EmployeeController::class, 'highestSalary']); 


    Route::get('/departments/employees/count', [DepartmentController::class, 'countEmployeesByDepartment']); 
    Route::get('/departments/average-salary', [DepartmentController::class, 'averageSalaryByDepartment']); 
    Route::get('/departments', [DepartmentController::class, 'index']); 
    Route::get('/departments/{id}', [DepartmentController::class, 'show']); 



    Route::get('/departments/{id}/employees', [EmployeeController::class, 'employeesByDepartment']); 
 });



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });