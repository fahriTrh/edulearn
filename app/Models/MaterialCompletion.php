<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCompletion extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_completed' => 'boolean',
        'first_viewed_at' => 'datetime',
        'last_viewed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
