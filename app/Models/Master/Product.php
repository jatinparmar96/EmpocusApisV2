<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Master\Product
 *
 * @property int $id
 * @property int $company_id
 * @property string $product_name
 * @property string $product_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Product whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    //
    protected $fillable = ['product_name', 'product_type'];
}
