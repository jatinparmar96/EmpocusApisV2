<?php

namespace App\Api\V1\Controllers\Masters;

use App\Api\V1\Controllers\Authentication\TokenController;
use App\Http\Controllers\Controller;
use App\Models\Master\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyController extends Controller
{

    //Create Company From Wizard
    public function createCompanyWizard(Request $request)
    {
        $user = TokenController::getUser();
        $company = $this->store($request);


        $company_array['id'] = $company->id;
        $company_array['display_name'] = $company->display_name;
        $user_payload = [
            'id' => (int)$user['id'],
            'name' => $user['display_name'],
            'company_info' => $company_array
        ];
        try {
            $token = TokenController::createTokenFromPayload($user_payload);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return response()->json([
            'status' => true,
            'token' => $token
        ]);
    }


    public function store(Request $request)
    {
        $user = TokenController::getUser();
        $id = $request->get('id');

        if ($id == 'new' || $id == null) {
            $company = new Company();
            $company->created_by_id = $user->id;
        } else {
            $company = Company::findOrFail($id);
        }
        $company->user_id = $user->id;
        $company->name = $request->get('name');
        $company->display_name = $request->get('display_name');
        $company->email = $request->get('email');
        $company->website = $request->get('website');
        $company->gst_number = $request->get('gst_number');
        $company->pan_number = $request->get('pan_number');
        $company->tan_number = $request->get('tan_number');
        $company->iec_number = $request->get('iec_number');
        $company->epc_number = $request->get('epc_number');
        $company->ssi_number = $request->get('ssi_number');
        $company->nsic_number = $request->get('nsic_number');
        $company->udyog_aadhaar = $request->get('udyog_aadhaar');
        $company->tds_number = $request->get('tds_number');
        $company->cin_number = $request->get('cin_number');
        $company->updated_by_id = $user->id;
        try {
            $company->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $company;
    }


    public function setCompany(Request $request)
    {
        $user = TokenController::getUser();
        $company = $user->getCompanies()->where('id', $request['company_id'])->first(['id', 'display_name']);
        $user_payload = [
            'id' => (int)$user['id'],
            'name' => $user['display_name'],
            'company_info' => $company
        ];
        if ($user_payload['company_info'] === null) {
            dd($company);
        }
        try {
            $token = JWTAuth::fromUser($user, $user_payload);
            if (!$token) {
                return response()->json([
                    'status' => false,
                    'status_code' => 200,
                    'message' => "Company Set Failed"
                ]);
            }

        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => "Something is Wrong !!"
            ]);
        }
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => "Company Set Successfully",
            'data' => $user_payload,
            'token' => $token
        ]);
    }

    public function companies_list()
    {
        $user = TokenController::getUser();
        return $user->getCompanies()->get(['id', 'display_name']);
    }

    public function show($id)
    {
        try {
            $company = Company::findOrFail($id);
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Opps! Company not found');
        }
        return $company;
    }

    public function update(Request $request, $id)
    {
        $user = TokenController::getUser();
        $company = Company::findOrFail($id);
        $data = $request->all();
        $data['updated_by_id'] = $user->id;
        $company->update($data);
        return $company;
    }

    public function destroy($id)
    {
        if (Company::destroy($id)) {
            return response()->json([
                'status' => 'ok'
            ]);
        } else {
            throw new NotFoundHttpException('Oops! Company not found.');
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
            'message' => 'Companies List',
            'data' => $result
        ]);
    }

    public function query()
    {
        $current_company_id = TokenController::getCompanyId();
        $query = DB::table('users as u')
            ->Join('companies as co', 'u.id', 'co.user_id')
            ->select(
                'u.name', 'u.display_name', 'u.email', 'u.mobile'
            )
            ->addSelect(
                'co.name as company_name', 'co.display_name as company_display_name', 'co.company_email', 'co.pan_number', 'co.website', 'co.tan_number', 'co.iec_number', 'co.cin_number', 'co.logo', 'co.smtp_setting', 'co.created_by_id', 'co.updated_by_id'
            );
        return $query;
    }

    public function search($query)
    {
        $search = \Request::get('search');
        if (!empty($search)) {
            $TableColumn = $this->TableColumn();
            foreach ($search as $key => $searchvalue) {
                $query = $query->Where($TableColumn[$key], 'LIKE', '%' . $searchvalue . '%');
            }
        }

        return $query;
    }

    public function TableColumn()
    {
        $TableColumn = array(
            "id" => "ca.id",
            "name" => "u.name",
            "display_name" => "u.display_name",
            "email" => "u.email",
            "mobile" => "u.mobile",
        );
        return $TableColumn;
    }

    //use Helpers;

    public function sort($query)
    {
        $sort = \Request::get('sort');
        if (!empty($sort)) {
            $TableColumn = $this->TableColumn();
            $query = $query->orderBy($TableColumn[key($sort)], $sort[key($sort)]);
        } else
            $query = $query->orderBy('company_name', 'ASC');
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
            'message' => 'Companies Full List',
            'data' => $result
        ]);
    }

    public function getUserCompany(Request $request)
    {
        $company = \Auth::user()->company;
        if ($company) {
            return response()->json([
                'status' => true,
                'data' => $company,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }

    }
}


//Unused Functions 
/*
	public function storeOtherDetails(Request $request)
	{
		$company_id = TokenController::getCompanyId();
		$company = Company::find($company_id);
		$company->pan_number = $request->get('company_pan_number');
		$company->logo = $request->get('company_logo');
		$company->tan_number = $request->get('company_tan_number');
		$company->ecc_number = $request->get('company_ecc_number');
		$company->division_code = $request->get('company_division_code');
		$company->cin_number = $request->get('company_cin_number');
	
		try{
			$company->save();
			$branch = new Branch();
			$branch->name = "Head Office";
			$branch->company_id = $company->id;
			$branch->gst_number = $request->get('company_gst_number');
			$branch->save();
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	
		return $company->id;
	} */