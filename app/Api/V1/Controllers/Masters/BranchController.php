<?php

namespace App\Api\V1\Controllers\Masters;

use App\Api\V1\Controllers\Authentication\TokenController;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function form(Request $request, $company_id = 0)
    {
        $status = true;
        $current_company_id = $company_id;
        if ($company_id === 0) {
            $current_company_id = TokenController::getCompanyId();
        }
        $id = $request->get('id');
        if ($id === 'new') {
            $count = Branch::where('name', $request->get('branch_name'))
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
            if ($company_id !== 0) {
                $branch->name = 'Head Office';
            } else {
                $branch->name = $request->get('branch_name');
            }
            $branch->code = $request->get('branch_code');
            $branch->gst_number = $request->get('branch_gst_number');
            $branch->is_godown = ($request->get('branch_godown') == 'Yes' ? true : false);
            $branch->updated_by_id = TokenController::getUser()->id;
            try {
                $branch->save();
            } catch (\Exception $e) {
                $status = false;
                $message = 'Something is wrong' . $e;
            }
            if ($company_id != 0) {
                return $branch;
            } else {
                try {
                    DB::beginTransaction();
                    $bank = Bank::findOrFail($request->get('branch_bank_id'));
                    $branch->bank()->save($bank);
                    if ($request->has('address')) {
                        $branch->address()->create($request->get('address'));
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $status = false;
                    $message = 'Something is wrong' . $e;
                }
                return response()->json([
                    'status' => $status,
                    'data' => $branch,
                    'message' => $message
                ]);

            }
        } else {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'error' => $error
            ]);
        }
    }


    public function query()
    {
        $current_company_id = TokenController::getCompanyId();
        return Branch::with(['bank','address'])->where('company_id',$current_company_id);

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

    public function TableColumn()
    {
        $TableColumn = array(
            "id" => "b.id",
            "name" => "b.name",
            "gst_number" => "b.gst_number",
            "code" => "b.code",
        );
        return $TableColumn;
    }

    //use Helpers;

    public function sort($query)
    {
        $sort = \Request::get('sort');
        if (!empty($sort)) {
            $TableColumn = $this->TableColumn();
            $query = $query->orderBy($sort->column, $sort->order);
        } else
            $query = $query->orderBy('name', 'ASC');

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
        $result = $query->where('b.id', $id)->first();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Branch',
            'data' => $result
        ]);
    }
}
