<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Masters\Employee
 *
 * @property int $id
 * @property int $company_id
 * @property string $employee_name
 * @property string $employee_adhaar_number
 * @property string $employee_pan_number
 * @property array $employee_contact_numbers
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Master\Address[] $addresses
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereEmployeeAdhaarNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereEmployeeContactNumbers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereEmployeeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereEmployeePanNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereUpdatedBy($value)
 * @mixin \Eloquent
 * @property string $employee_username
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereEmployeeUsername($value)
 * @property string|null $bank_name
 * @property string|null $bank_account_number
 * @property string|null $ifsc_code
 * @property string|null $provident_fund_account_number
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereIfscCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\Employee whereProvidentFundAccountNumber($value)
 */
class Employee extends Model
{
    //
    protected  $guarded = [
        'id',
    ];
    protected $casts = [
        'employee_contact_numbers' => 'array',
    ];
    public function permanent_address()
    {
        return $this->addresses()->where('meta', 'PermanentAddress');
    }
    public function residential_address()
    {
        return $this->addresses()->where('meta', 'ResidentialAddress');
    }
    public function addresses()
    {
        return $this->morphMany('App\Models\Master\Address', 'addressable');
    }

    public  function tasks()
    {
        return $this->hasManyThrough('App\Models\Crm\Task','App\Models\Crm\Lead','assigned_to','lead_id','id','id');
    }

}
