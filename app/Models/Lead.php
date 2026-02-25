<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{

 public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function title()
    {
        return $this->belongsTo(TitleSituation::class);
    }

     public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
