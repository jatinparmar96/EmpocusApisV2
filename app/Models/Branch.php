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
        return $this->hasOne('App\Models\Bank', 'id','branch_bank_id');
    }

    public function saveAddress($address){
        if ($this->address){
            $this->address()->update($address);
        }
        else{
            $this->address()->create($address);
        }
    }
}
