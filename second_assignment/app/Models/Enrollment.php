<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    protected $table = 'enrollments';

    // Optionally, you can define fillable attributes if needed
    protected $fillable = [
        'user_id',
        'course_id',
    ];

    // Optionally, you can define relationships to User and Course
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
