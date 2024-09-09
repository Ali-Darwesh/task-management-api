<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'task_id';
    public $incrementing = true;
    protected $table = 'user_tasks';
    public $timestamps = true;
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'assigned_to',
    ];
    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    // Accessor: Format the due_date when retrieving
    public function getDueDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    // Mutator: Ensure due_date is stored in the right format when setting
    public function setDueDateAttribute($value)
    {
        try {
            // Try to create the date with the expected format
            $this->attributes['due_date'] = Carbon::createFromFormat('d-m-Y H:i', $value);
        } catch (\Exception $e) {
            // Handle the case where the date format is incorrect
            throw new \InvalidArgumentException('Invalid date format. Expected format: d-m-Y H:i');
        }
    }
    //filter
    public function scopePriority($query, $priority)
    {
        if (!empty($priority['priority'])) {
            $query->where('priority', 'like', '%' . $priority['priority'] . '%');
        }
        return $query;
    }
    public function scopeStatus($query, $status)
    {

        if (!empty($status['status'])) {
            $query->where('status', 'like', '%' . $status['status'] . '%');
        }
        return $query;
    }
}
