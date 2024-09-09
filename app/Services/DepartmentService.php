<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{

    /**
     * Create department
     * @param array $data
     */
    public function createDepartment(array $data)
    {
        return Department::create($data);
    }
    /** Update department
     * @param Department $department, array $data
     */
    public function updateDepartment(Department $department, array $data)
    {
        //
    }

    /** delete department
     * @param Department $department
     */
    public function deleteDepartment(Department $department)
    {
        $department->delete();
        return $department;
    }
}
