<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
        'employee_name',
        'employee_adhaar_number',
        'employee_pan_number',
        'employee_contact_numbers',
        'email',
    ];
    protected $casts = [
        'employee_contact_numbers' => 'array',
    ];
}
