<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Crm\Lead
 *
 * @property int $id
 * @property int $company_id
 * @property string $company_name
 * @property int $assigned_to
 * @property string $lead_status
 * @property string $source
 * @property int $product_id
 * @property string $contacts
 * @property string|null $company_info
 * @property string|null $social
 * @property string|null $source_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereCompanyInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereLeadStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereSourceInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crm\Lead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lead extends Model
{
    protected $guarded = [
        'id'
    ];
    protected $casts = [
        'company_info' => 'array',
        'social' => 'array',
        'deal' => 'array',
        'source_info' => 'array',
    ];

    public function contacts()
    {
        return $this->morphMany('App\Models\Master\Contact', 'contactable');
    }

    public function address()
    {
        return $this->morphOne('App\Models\Master\Address', 'addressable');
    }

    public function  setAssignedToAttribute($value){
        $this->attributes['assigned_to']= $value['id'];
    }

    public function  setProductAttribute($value){
        $this->attributes['product']= $value['id'];
    }
}
