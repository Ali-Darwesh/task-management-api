<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    protected $primaryKey = 'task_id';
    public $incrementing = true;
    protected $fillable = [
        'task_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'assigned_to',
        'department_id',
    ];
    protected $table = 'user_tasks';
    public $timestamps = true;

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    public function department(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'department');
    }
}
