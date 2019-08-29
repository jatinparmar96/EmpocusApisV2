<?php

namespace App\Api\V1\Observer\CRM;

use \App\Models\Crm\Lead;
use Illuminate\Support\Facades\Auth;

class LeadObserver
{

    public function creating(Lead $lead)
    {
        $lead->created_by = Auth::user()->id;
        $lead->updated_by = Auth::user()->id;
    }
    /**
     * Handle the lead "created" event.
     *
     * @param  Lead $lead
     * @return void
     */


    public function created(Lead $lead)
    {

    }

    /**
     * Handle the lead "updated" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function updated(Lead $lead)
    {
        //
    }

    /**
     * Handle the lead "deleted" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function deleted(Lead $lead)
    {
        //
    }

    /**
     * Handle the lead "restored" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function restored(Lead $lead)
    {
        //
    }

    /**
     * Handle the lead "force deleted" event.
     *
     * @param  Lead  $lead
     * @return void
     */
    public function forceDeleted(Lead $lead)
    {
        //
    }
}
