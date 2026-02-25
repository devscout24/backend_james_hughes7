<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = [
        'condition',
        'describtion',
    ];
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
