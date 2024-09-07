<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manager extends Model
{
    use HasFactory;
    protected $guarded = [
        'manager_id',
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
