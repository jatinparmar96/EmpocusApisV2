<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Masters\Company
 *
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string|null $company_display_name
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereCompanyDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Company whereWebsite($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    //
}
