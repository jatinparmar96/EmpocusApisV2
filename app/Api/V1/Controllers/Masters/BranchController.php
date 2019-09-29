<?php

namespace App\Api\V1\Controllers\Masters;

use App\Api\V1\Controllers\Authentication\TokenController;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function form(Request $request)
    {
        $status = true;
        $current_company_id = TokenController::getCompanyId();
        $id = $request->get('id');
        if ($id === 'new') {
            $count = Branch::where('branch_name', $request->get('branch_name'))
                ->where('company_id', $current_company_id)
                ->count();
            if ($count > 0) {
                $status = false;
                $message = 'Kindly Fill up the form Correctly !!';
                $error['branch_name'] = 'Branch Name already Exits';
            } else {
                $message = 'New Branch created successfully!!';
                $branch = new Branch();
                $branch->company_id = $current_company_id;
                $branch->created_by_id = TokenController::getUser()->id;
            }

        } else {
            $message = 'Branch updated successfully!!';
            $branch = Branch::findOrFail($id);
        }
        if ($status) {
            $branch->branch_name = $request->get('branch_name');
            $branch->branch_code = $request->get('branch_code');
            $branch->branch_gst_number = $request->get('branch_gst_number');
            $branch->branch_godown = $request->get('branch_godown');
            $branch->branch_bank_id = $request->get('branch_bank_id');
            $branch->updated_by_id = TokenController::getUser()->id;
            try {
                $branch->save();
                $branch->saveAddress($request->get('address'));

            } catch (\Exception $e) {
                $status = false;
                $message = 'Something is wrong' . $e;
                return response()->json([
                    'status' => $status,
                    'message' => $message
                ], 500);
            }
            return response()->json([
                'status' => $status,
                'data' => $branch,
                'message' => $message
            ], 201);

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
            'message' => 'Branch List',
            'data' => $result
        ]);
    }

    public function query()
    {
        $current_company_id = TokenController::getCompanyId();
        return Branch::with(['bank', 'address'])->where('company_id', $current_company_id);

    }

    public function search($query)
    {
        $search = \Request::get('search');
        if (!empty($search)) {
            $TableColumn = $this->TableColumn();
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
            $query = $query->orderBy('branch_name', 'ASC');

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
            'message' => 'Branch Full List',
            'data' => $result
        ]);
    }

    public function show(Request $request, $id)
    {
        $query = $this->query();
        $query = $this->search($query);
        $query = $this->sort($query);
        $result = $query->where('id', $id)->first();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Branch',
            'data' => $result
        ]);
    }
}
