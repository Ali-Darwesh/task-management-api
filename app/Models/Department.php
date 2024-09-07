<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'manager_id',
        'department_name',
    ];
    public function task(): HasMany
    {
        return $this->hasMany(Department::class, 'task_id', 'department_id'); // 'employee_id' is the foreign key in the admins table
    }
    public function manager(): HasOne
    {
        return $this->hasOne(Manager::class, 'manager_id', 'manager_id'); // 'manager_id' is the foreign key in the admins table
    }
}
