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
    public function getTaskTypeAttribute($task_type){
       $fullType = '';
        switch ($task_type){
            case 'calling':$fullType = "Calling";break;
            case 'meeting':$fullType = "Meeting/Appointment";break;
            case 'follow_up':$fullType = "Follow Up";break;
            case 'send_quotation':$fullType = "Send Quotation";break;
            case 'order_generated':$fullType = "Order Generated";break;
        }
        return ['task_type'=>$task_type,'full_type'=>$fullType];
    }
}
