<?php

namespace App\Api\V1\Controllers\CRM;


use App\Api\V1\Requests\CRMRequests\EmployeeCreateRequest;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param  $items
     * @return \Illuminate\Http\Response
     */
    public function index($items = 10)
    {
//        $employees = Employee::with(['permanent_address', 'residential_address'])->paginate($items);
        $employees = $this->search()->paginate($items);
        return response()->json([
            'status' => true,
            'data' => $employees,
            'message' => 'Employee Retrieved Successfully'
        ]);
    }

    function search()
    {
        $employee = Employee::with(['permanent_address', 'residential_address']);
        $search = \Request::get('search');

        if ($search !== null && $search !== '') {
            foreach ($search as $param => $key) {
                if ($key !== '' && $key !== null && $key !== "undefined") {
                    $employee = $employee->Orwhere($param, 'LIKE', "%" . $key . "%");
                }
            }
        }

        return $employee;
    }

    /**
     * Show the form for creating a new resource.
     * @param \App\Api\V1\Requests\CRMRequests\EmployeeCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(EmployeeCreateRequest $request)
    {
        try {
            if ($request->id == 'new') {
                $employee = $this->store($request);
                return response()->json([
                    'status' => true,
                    'data' => $employee,
                    'message' => 'Employee Stored Successfully'
                ], 201);
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
     * @param  \Illuminate\Http\Request $request
     * @return \App\Models\Master\Employee
     *
     * @throws \Exception
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        $employee = new Employee();
        $employee = $this->populateEmployeeModel($employee, $request);

        try {
            $employee->save();
            $addresses = collect([])->push($request->residential_address)->push($request->permanent_address)->toArray();
            $employee->addresses()->createMany($addresses);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            \DB::rollBack();
            throw new Exception($e->getMessage());
        }
        \DB::commit();
        $employee->addresses;
        return $employee;
    }

    function populateEmployeeModel(Employee $employee, Request $request)
    {
        $employee->company_id = Auth::user()->company->id;
        $employee->employee_name = $request->employee_name;
        $employee->employee_username = $request->employee_username;
        $employee->employee_adhaar_number = $request->employee_adhaar_number;
        $employee->employee_pan_number = $request->employee_pan_number;
        $employee->employee_contact_numbers = $request->employee_contact_numbers;

        $employee->email = $request->email;
        $employee->bank_name = $request->bank_name;
        $employee->bank_account_number = $request->bank_account_number;
        $employee->ifsc_code = $request->ifsc_code;
        $employee->provident_fund_account_number = $request->provident_fund_account_number;

        return $employee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee = $this->populateEmployeeModel($employee, $request);
        \DB::beginTransaction();
        try {
            $employee->permanent_address()->update($request->permanent_address);
            $employee->residential_address()->update($request->residential_address);
            $employee->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            \DB::rollBack();
            throw  new Exception($e->getMessage());
        }
        \DB::commit();
        $employee->addresses;
        return $employee;

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($employee)
    {

        $employee = Employee::with(['permanent_address', 'residential_address', 'tasks'])->where('id', $employee)->first();
        return response()->json([
            'status' => true,
            'data' => $employee,
            'message' => 'Employee Retrieved Successfully'
        ]);
    }

    public function full_index()
    {
        $employees = Employee::with(['permanent_address', 'residential_address'])->get();
        return response()->json([
            'status' => true,
            'data' => $employees,
            'message' => 'Employees Full List Retrieved Successfully'
        ]);
    }

    public function columns(Request $request)
    {
        $columns = array_keys($request->all());
        $employees = Employee::select($columns)->get();
        return response()->json([
            'status' => true,
            'data' => $employees,
            'message' => 'Employees Retrieved Successfully'
        ]);
    }

}
