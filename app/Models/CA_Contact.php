<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CA_Contact extends Model
{
    protected $table= 'ca_contacts';
    protected $guarded=[];
    protected $fillable = [
        'ca_contact_first_name',
        'ca_contact_last_name',
        'ca_contact_email',
        'ca_contact_mobile_number',
        'ca_contact_alternate_mobile_number',
        'ca_contact_designation',
        'ca_contact_branch',
    ];


}
