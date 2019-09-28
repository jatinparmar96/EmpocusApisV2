<?php

namespace App\Api\V1\Controllers\Masters;

use App\Api\V1\Controllers\Authentication\TokenController;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankMasterController extends Controller
{
    public function form(Request $request, $type = '', $type_id = 0, $company_id = 0)
    {
        // If type and Type_Id is non zero Function is called from wizard
        // Else the request is coming from a form in that case return a json response

        $status = true;
        $user = TokenController::getUser();

        $id = $request->get('id');
        if ($id == 'new') {
            $count = Bank::where('name', $request->get('bank_name'))
                ->where('account_name', $request->get('account_name'))
                ->count();
            if ($count > 0) {
                $status = false;
                $message = 'Kindly Fill up the form Correctly !!';
                $error['bank'] = 'Bank Name with Same account name already Exits!!!';
                return response()->json([
                    'status' => $status,
                    'message' => $message,
                    'error' => $error
                ]);
            } else {
                $bank = new Bank();
                $bank->created_by_id = $user->id;
                $message = 'Bank Created Successfully';
            }
        } else {
            $bank = Bank::findOrFail($id);
            $message = 'Bank updated Successfully';
        }
        if ($status) {
            $bank->account_name = $request->get('bank_account_name');
            $bank->name = $request->get('bank_name');
            $bank->account_no = $request->get('bank_account_number');
            $bank->ifsc_code = $request->get('bank_ifsc_code');
            $bank->branch = $request->get('bank_branch');
            $bank->updated_by_id = $user->id;
            try {
                $bank->save();
            } catch (\Exception $e) {
                dd($e);
                $status = false;
                $message = 'Something is wrong. Kindly Contact Admin' . $e;
            }
            return response()->json([
                'status' => $status,
                'data' => $bank,
                'message' => $message
            ]);
        } else {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'error' => $error
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
            'message' => 'Bank List',
            'data' => $result
        ]);
    }

    public function query()
    {
        return Bank::query();
    }

    public function search($query)
    {
        $search = \Request::get('search');
        if (!empty($search)) {
            foreach ($search as $key => $searchvalue) {
                $query = $query->Where($key, 'LIKE', '%' . $searchvalue . '%');
            }
        }

        return $query;
    }

    public function TableColumn()
    {
        $TableColumn = array(
            "id" => "ba.id",
            "type" => "ba.type ",
            "type_id" => "ba.type_id",
            "account_name" => "ba.account_name",
            "bank_name" => "ba.bank_name",
            "account_no" => "ba.account_no",
            "ifsc_code" => "ba.ifsc_code",
            "branch" => "ba.branch",
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
            $query = $query->orderBy('account_name', 'ASC');
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
            'message' => 'Bank Full List',
            'data' => $result
        ]);
    }

    public function show($id)
    {
        $query = $this->query();
        $query = $this->search($query);
        $query = $this->sort($query);
        $result = $query->where('ba.id', $id)->first();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Bank',
            'data' => $result
        ]);
    }
}
