<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitleSituation extends Model
{
    protected $fillable = [
        'titleSituation',
         'description',
    ];
    public function leads()
        {
            return $this->hasMany(Lead::class);
        }
}
