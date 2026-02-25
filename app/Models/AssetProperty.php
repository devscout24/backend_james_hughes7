<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetProperty extends Model
{
        protected $fillable = [
            'asset_id',
            'property_name',
        ];

  public function asset()
    {
        return $this->belongsTo(Asset::class,'asset_id','id');
    }
}
