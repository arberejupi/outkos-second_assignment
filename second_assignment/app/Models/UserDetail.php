<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'phone',
    ];

    /**
     * Get the user that owns the user detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
