<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $casts = [
        'is_done' => 'boolean'
    ];

    public function lead()
    {
        return $this->belongsTo('App\Models\Crm\Lead','lead_id');
    }

    public function  setDueDateAttribute($value)
    {
        $due_date = $value['year'].'/'.$value['month'].'/'.$value['day'];
        $this->attributes['due_date'] = $due_date;
    }
}
