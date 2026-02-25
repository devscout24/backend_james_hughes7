<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    public function leads(){
        return $this->belongsTo(Lead::class,'lead_id','id');
    }
}
