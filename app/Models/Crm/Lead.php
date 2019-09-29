<?php

namespace App\Models\Crm;

use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function contact_persons()
    {
        return $this->morphMany('App\Models\Master\Contact', 'contactable');
    }

    public function address()
    {
        return $this->morphOne('App\Models\Master\Address', 'addressable');
    }

    public function assigned_to()
    {
        return $this->hasOne('\App\Models\Master\Employee', 'id', 'assigned_to');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Master\Contact', 'id','product');
    }


    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Task Related Functions of Lead
     * -----------------------------------------------------------------------------------------------------------------
     **/

    /**
     * ------------------------------
     * @return HasMany
     * Return all pending tasks related to Lead
     * ------------------------------
     **/

    public function pending_tasks()
    {
        return $this->hasMany('App\Models\Crm\Task', 'lead_id')->where('is_done', false);
    }

    /**
     * ------------------------------
     * @return HasMany
     * Return Tasks not completed tasks and missed deadlines
     * ------------------------------
     **/
    public function dueTasks()
    {
        return $this->pending_tasks()->where('due_date', '<', Carbon::today());
    }


    /**
     * ------------------------------
     * @return HasMany
     * Return Tasks not completed tasks and deadline is within 2 days Not Including Today's Tasks
     * ------------------------------
     **/
    public function pendingTaskClose()
    {
        $from = Carbon::today()->addDay();
        $to = $from->copy()->addDays(2);
       
        return $this->pending_tasks()->whereBetween('due_date',[$from,$to]);
    }

    /**
     * ------------------------------
     * @return HasMany
     * Return Tasks not completed tasks and deadline is today
     * ------------------------------
     **/
    public function pendingTaskToday(){
        return $this->pending_tasks()->where('due_date', '=', Carbon::today());
    }

    /**
     * ------------------------------
     * @return HasMany
     * Return Tasks not completed tasks and deadline is today
     * ------------------------------
     **/
    public function completedTasks(){
        return $this->hasMany('App\Models\Crm\Task', 'lead_id')->where('is_done', true);
    }


    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Task Related Accessors and Mutators
     * -----------------------------------------------------------------------------------------------------------------
     **/
    public function setAssignedToAttribute($value)
    {
        $this->attributes['assigned_to'] = $value['id'];
    }

    public function setProductAttribute($value)
    {
        $this->attributes['product'] = $value['id'];
    }
}
