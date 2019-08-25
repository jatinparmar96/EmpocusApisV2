<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    public function addressable()
    {
        return $this->morphTo();
    }
}
