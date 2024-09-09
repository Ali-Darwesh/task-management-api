<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manager extends Model
{
    use HasFactory;
    protected $fillable = [
        'manager_id',
        'department_id'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(department::class, 'manager_id', 'id');
    }
}
