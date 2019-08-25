<?php

namespace App\Api\V1\Controllers\CRM;

use App\Api\V1\Requests\CRMRequests\EmployeeCreateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EmployeeCreateRequest $request)
    {
        $employee = '';

        try {
            if ($request->id == 'new') {
                $employee =  $this->store($request);
                return response()->json([
                    'status' => true,
                    'data' => $employee,
                    'message' => 'Employee Stored Successfully'
                ]);
            } else {
                $employee = $this->update($request, $request->id);
                return response()->json([
                    'status' => true,
                    'data' => $employee,
                    'message' => 'Employee Updated Successfully'
                ]);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            if (env('APP_DEBUG')) {
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage(),
                    'message' => 'Something Went Wrong'
                ], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $employee = new Employee();
        $employee->company_id = Auth::user()->company->id;
        $employee->employee_name = $request->employee_name;
        $employee->employee_adhaar_number = $request->adhar_number;
        $employee->employee_pan_number = $request->pan_number;
        $employee->employee_contact_numbers = $request->contact_numbers;
        $employee->email = $request->email;
        $employee->save();

        return $employee;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
