<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->hasMany(ClassModel::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasManyThrough(ClassUser::class, ClassModel::class, 'instructor_id', 'class_id');
    }
}
