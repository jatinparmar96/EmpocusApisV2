<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Master\Address
 *
 * @property int $id
 * @property int $addressable_id
 * @property string $addressable_type
 * @property string $meta
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $state
 * @property string $pincode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address wherePincode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Address whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'meta',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'pincode',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }


}
