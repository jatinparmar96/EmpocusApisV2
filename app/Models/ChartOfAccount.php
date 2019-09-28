<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    public function address()
    {
        return $this->morphOne('App\Models\Master\Address', 'addressable');
    }
    public function contacts()
    {
        return $this->hasOne('App\Models\CA_Contact','ca_company_id');
    }
}
