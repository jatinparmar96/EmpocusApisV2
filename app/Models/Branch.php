<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function address()
    {
        return $this->morphOne('App\Models\Master\Address', 'addressable');
    }
    public function bank()
    {
        return $this->hasOne('App\Models\Bank', 'branch_id');
    }
}
