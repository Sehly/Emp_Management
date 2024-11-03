<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Department;

class EmployeeTest extends TestCase
{
/**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /**
     * Test for creating an employee with valid data.
     */
    public function setUp(): void
    {
        parent::setUp();
        // $this->withoutMiddleware();
    }
    public function test_create_employee_with_valid_data()
    {
        $data = [
            'firstName' => 'omar',
            'lastName' => 'mostafa',
            'email' => 'Omarr@example.com',
            'phone' => '01003743103',
            'hire_date' => now(),
            'salary' => 60000,
            'department_id' => 6
        ];
    
        $response = $this->postJson('/api/employees', $data);
        
        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'firstName' => 'omar',
                         'lastName' => 'mostafa',
                         'email' => 'Omarr@example.com',
                         'phone' => '01003743103',
                         'hire_date' => $data['hire_date'],
                         'salary' => 60000,
                         'department_id' => 6,
                     ],
                 ]);
    }
    

    /**
     * Test for creating an employee with invalid data.
     */
    public function test_create_employee_with_invalid_data()
    {
        $this->withoutMiddleware();
        $response = $this->postJson('/api/employees', [
            'firstName' => '', 
            'email' => 'not-an-email', 
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test to fetch an employee from a non-existent department.
     */
    public function test_fetch_employees_from_non_existent_department()
    {
        $this->withoutMiddleware();
        $response = $this->getJson('/api/departments/999/employees'); // 999 is non-existent
        $response->assertStatus(404);
    }
    

    /**
     * Test rate limiting for requests to create an employee.
     */
    public function test_rate_limiting()
    {
        // Assuming you have set up rate limiting
        for ($i = 0; $i < 100; $i++) {
            $this->getJson('/api/employees');
        }
    
        // You may need to use a throttle middleware and adjust the limit in your routes
        $response = $this->getJson('/api/employees');
        $response->assertStatus(429); // Too Many Requests
    }
    

    /**
     * Test access from unauthorized IP.
     */
    public function test_access_from_unauthorized_ip()
    {
        $this->withHeaders(['REMOTE_ADDR' => '10.0.0.1']) // Unauthorized IP
             ->getJson('/api/employees')
             ->assertStatus(403)
             ->assertJson(['error' => 'Access denied.']);
    }
    
}
