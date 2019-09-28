<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawProduct extends Model
{
    public function uom()
    {
        return $this->hasOne('App\Models\UnitOfMeasurement', 'id','product_uom');
    }

    public function conv_uom()
    {
        return $this->hasOne('App\Models\UnitOfMeasurement', 'id','product_conv_uom');
    }
    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id','product_gst_rate');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'product_category','id');
    }
}
