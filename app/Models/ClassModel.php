<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $guarded = ['id'];

    protected $casts = [
        'enrollment_enabled' => 'boolean',
    ];

    public function instructor()
    {
        // return $this->belongsTo(User::class, 'instructor_id');
        return $this->hasOneThrough(
            \App\Models\User::class,          // model tujuan yang ingin diambil
            \App\Models\Instructor::class,    // model perantara
            'id',                             // Foreign key di instructors (instructors.id)
            'id',                             // Foreign key di users (users.id)
            'instructor_id',                  // FK di classes (classes.instructor_id)
            'user_id'                         // FK di instructors (instructors.user_id)
        );
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }

    // kalau nanti mau tambahkan mahasiswa (students)
    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')
            ->where('role', 'student');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}
