<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [
        'id'
    ];
    protected $casts = [
        'more_info' => 'array'
    ];

    public function contactable()
    {
        return $this->morphTo();
    }
}
