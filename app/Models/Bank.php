<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public function bankable()
    {
        return $this->morphTo();
    }
}
