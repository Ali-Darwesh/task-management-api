<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Admin extends Model
{
    use HasFactory;
    protected $guarded = [
        'admin_id',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id', 'id'); // 'admin_id' is the foreign key in the admins table
    }
}
