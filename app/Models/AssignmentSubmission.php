<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $guarded = ['id'];
    
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
