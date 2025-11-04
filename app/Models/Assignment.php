<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'deadline' => 'datetime',
    ];
    

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }
}
