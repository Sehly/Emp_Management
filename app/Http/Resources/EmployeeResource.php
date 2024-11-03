<?php

namespace App\Http\Resources;

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
            'ID' => $this->id,
            'FirstName' => $this->firstName,
            'LastName' => $this->lastName,
            'Email' => $this->email,
            'Phone' => $this->phone,
            'Hire_Date' => $this->hire_date,
            'Salary' => $this->salary,
            'Department id' => $this->department_id, 
        ];
    }
}