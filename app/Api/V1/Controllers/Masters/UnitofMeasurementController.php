<?php

namespace App\Api\V1\Controllers\Masters;

use App\Api\V1\Controllers\Authentication\TokenController;
use App\Http\Controllers\Controller;
use App\Models\UnitOfMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UnitofMeasurementController extends Controller
{
    public function form(Request $request)
    {
        $status = true;
        $id = $request->get('id');
        $user = TokenController::getUser();
        $current_company_id = TokenController::getCompanyId();
        if ($id === 'new') {
            $count = UnitOfMeasurement::Where('unit_name', Input::get('unit_name'))
                ->Where('company_id', $current_company_id)
                ->count();
            if ($count > 0) {
                $status = false;
                $message = 'Kindly fill up form Correctly !!';
                $error['unit_name'] = 'Name already exist !!';
            } else {
                $message = 'Record Added Successfully';
                $uom = new UnitOfMeasurement();
                $uom->created_by_id = $user->id;
            }
        } else {
            $message = 'Record Updated Successfully';
            $uom = UnitOfMeasurement::findOrFail($id);
        }

        if ($status) {
            $uom->company_id = $current_company_id;
            $uom->unit_name = Input::get('unit_name');
            $uom->updated_by_id = $user->id;
            try {
                $uom->save();
            } catch (\Exception $e) {
                $status = false;
                $message = 'Something is wrong. Kindly Contact Admin';
            }

            return response()->json([
                'status' => $status,
                'data' => $uom,
                'message' => $message
            ]);
        } else {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'error' => $error,
            ]);
        }

    }

    public function index()
    {
        $limit = 10;
        $query = $this->query();
        $query = $this->search($query);
        $query = $this->sort($query);
        $result = $query->paginate($limit);
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'UOM List',
            'data' => $result
        ]);
    }

    public function query()
    {
        $current_company_id = TokenController::getCompanyId();
        return UnitOfMeasurement::query()->where('company_id', $current_company_id);
    }

    public function search($query)
    {
        $search = \Request::get('search');
        if (!empty($search)) {
            foreach ($search as $key => $searchvalue) {
                if ($searchvalue !== '')
                    $query = $query->Where($key, 'LIKE', '%' . $searchvalue . '%');
            }
        }

        return $query;
    }


    //use Helpers;

    public function sort($query)
    {
        $sort = \Request::get('sort');
        if (!empty($sort)) {
            $query = $query->orderBy($sort->column, $sort->order);
        } else
            $query = $query->orderBy('unit_name', 'ASC');

        return $query;
    }

    public function full_list()
    {
        $query = $this->query();
        $query = $this->search($query);
        $query = $this->sort($query);
        $result = $query->get();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'UOM Full List',
            'data' => $result
        ]);
    }

    public function show(Request $request, $id)
    {
        $query = $this->query();
        $result = $query->Where('id', $id)->first();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'UOM',
            'data' => $result
        ]);
    }

}
