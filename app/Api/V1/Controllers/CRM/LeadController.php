<?php

namespace App\Api\V1\Controllers\CRM;

use App\Api\V1\Requests\CRMRequests\LeadCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Crm\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leads = Lead::query()->with(['assigned'])->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $leads,
            'message' => 'Leads retrieved Successfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LeadCreateRequest $request)
    {
        try {
            if ($request->id == 'new') {
                $lead = $this->store($request);
                return response()->json([
                    'status' => true,
                    'data' => $lead,
                    'message' => 'Lead Stored Successfully'
                ], 201);
            } else {
                $lead = $this->update($request, $request->id);
                return response()->json([
                    'status' => true,
                    'data' => $lead,
                    'message' => 'Lead Updated Successfully'
                ]);
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            if (env('APP_DEBUG')) {
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage(),
                    'message' => 'Something Went Wrong',
                    'full_error'=>$e
                ], 500);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something Went Wrong'
                ], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LeadCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadCreateRequest $request)
    {

        $lead = new Lead();
        $lead = $this->populateModel($lead, $request);
        $lead->save();
        if (array_filter($request->address) != []) {
            $lead->address()->create($request->address);
        }
        $lead->contacts()->createMany($request->contact_persons);
        $lead->address;
        $lead->contacts;
        return $lead;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LeadCreateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeadCreateRequest $request, $id)
    {
        $lead = Lead::with(['contacts'])->findOrFail($id);
        $lead = $this->populateModel($lead, $request);
        $lead->save();
        if (array_filter($request->address) != []) {
            $lead->address()->updateOrCreate($request->address);
        }
        $lead->contacts()->delete();
        $lead->contacts()->createMany($request->contact_persons);
        return $lead;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function populateModel(Lead $lead, LeadCreateRequest $request)
    {
        $lead->company_id = Auth::user()->company->id;
        $lead->company_name = $request->company_name;
        $lead->source = $request->source;
        $lead->assigned_to = $request->assigned_to;
        $lead->product = $request->product;
        $lead->lead_status = $request->lead_status;
        $lead->company_info = $request->company_info;
        $lead->social = $request->social;
        $lead->source_info = $request->source_info;
        return $lead;
    }

}
