<?php

namespace App\Api\V1\Controllers\Masters;

use App\Api\V1\Controllers\Authentication\TokenController;
use App\Http\Controllers\Controller;
use App\Models\CA_Contact;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartAccountsMaster extends Controller
{
    public function form(Request $request)
    {
        $user = TokenController::getUser();
        $status = true;
        $current_company_id = TokenController::getCompanyId();
        $id = $request->get('id');
        if ($id === 'new') {
            $count = ChartOfAccount::where('ca_company_name', $request->get('ca_company_name'))
                ->where('company_id', $current_company_id)
                ->count();
            $display = ChartOfAccount::where('ca_company_display_name', $request->get('ca_company_display_name'))
                ->where('company_id', $current_company_id)
                ->count();
            if ($count > 0) {
                $status = false;
                $message = 'Kindly Fill up the form Correctly !!';
                $error['ca_company_name'] = 'Company Name already Exits';
            }
            if ($display > 0) {
                $status = false;
                $message = 'Kindly Fill up the form Correctly !!';
                $error['ca_company_display_name'] = 'Company with same display name already Exits';
            } else {
                $account = new ChartOfAccount();
                $contact = new CA_Contact();
                $account->created_by_id = $user->id;
                $message = "Chart Of account record added Successfully !!";
                $account->company_id = $current_company_id;
            }
        } else {
            $account = ChartOfAccount::findOrFail($id);
            $message = "Record updated Successfully";
        }

        if ($status) {
            $account->ca_company_name = $request->get('ca_company_name');
            $account->ca_company_display_name = $request->get('ca_company_display_name');
            $account->ca_category = $request->get('ca_category');
            $account->ca_code = $request->get('ca_code');
            $account->ca_opening_amount = $request->get('ca_opening_amount');
            $account->ca_opening_type = $request->get('ca_opening_type');
            $account->ca_pan = $request->get('ca_pan');
            $account->ca_gstn = $request->get('ca_gstn');
            $account->ca_tan = $request->get('ca_tan');
            $account->ca_date_opened = $request->get('ca_date_opened');
            $account->updated_by_id = $user->id;
            try {
                DB::beginTransaction();
                $account->save();
                $account->saveContact($request->get('contact'));
                $account->saveAddress($request->get('address'));

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $status = false;
                $message = 'Something is wrong' . $e;
            }
            return response()->json([
                'status' => $status,
                'data' => $account,
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

    public function query()
    {
        $current_company_id = TokenController::getCompanyId();
        return ChartOfAccount::with(['address', 'contact'])->where('company_id', $current_company_id);
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
            'message' => 'Chart Of Account List',
            'data' => $result
        ]);
    }

    public function search($query)
    {
        $search = \Request::get('search');
        if (!empty($search)) {
            $TableColumn = $this->TableColumn();
            foreach ($search as $key => $searchvalue) {
                $query = $query->Where($key, 'LIKE', '%' . $searchvalue . '%');
            }
        }

        return $query;
    }

    public function TableColumn()
    {
        $TableColumn = array(
            "id" => "ca.id",
            "ca_company_name" => "ca.ca_company_name",
            "ca_company_display_name" => "ca.ca_company_display_name",
            "ca_category" => "ca.ca_category",
            "ca_code" => "ca.ca_code",
            "ca_opening_amount" => "ca.ca_opening_amount",
            "ca_opening_type" => "ca.ca_opening_type",
            "ca_first_name" => "ca.ca_first_name",
            "ca_last_name" => "ca.ca_last_name",
            "ca_mobile_number" => "ca.ca_mobile_number",
            "ca_email" => "ca.ca_email",
            "ca_designation" => "ca.ca_designation",
            "ca_branch" => "ca.ca_branch",
            "ca_pan" => "ca.ca_pan",
            "ca_gstn" => "ca.ca_gstn",
            "ca_tan" => "ca.ca_tan",
            "ca_date_opened" => "ca.ca_date_opened",
            "created_by_id" => "ca.created_by_id",
            "updated_by_id" => "ca.updated_by_id",
        );
        return $TableColumn;
    }

    //use Helpers;

    public function sort($query)
    {
        $sort = \Request::get('sort');
        if (!empty($sort)) {

            $query = $query->orderBy($sort->column, $sort->order);
        } else
            $query = $query->orderBy('ca_company_name', 'ASC');
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
            'message' => 'Chart Of Account Full List',
            'data' => $result
        ]);
    }

    public function show($id)
    {
        $query = $this->query();
        $result = $query->where('id', $id)->first();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Chart Of Account',
            'data' => $result
        ]);
    }

}
