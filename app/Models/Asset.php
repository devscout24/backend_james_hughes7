<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
        protected $fillable = [
            'assetType',
            'description',
            'image',
        ];

        public function leads()
        {
            return $this->hasMany(Lead::class);
        }

        public function property()
        {
            return $this->hasMany(AssetProperty::class,'asset_id','id');
        }
}
