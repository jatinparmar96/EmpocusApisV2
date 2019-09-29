<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    public function address()
    {
        return $this->morphOne('App\Models\Master\Address', 'addressable');
    }
    public function contact()
    {
        return $this->hasOne('App\Models\CA_Contact','ca_company_id');
    }
    public function saveAddress($address){
        if ($this->address){
            $this->address()->update($address);
        }
        else{
            $this->address()->create($address);
        }
    }
    public function saveContact($contact){
        if ($this->contacts){
            $this->contact()->update($contact);
        }
        else{
            $this->contact()->create($contact);
        }
    }
}
