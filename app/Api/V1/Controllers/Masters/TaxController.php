<?php

namespace App\Api\V1\Controllers\Masters;

use App\Api\V1\Controllers\Authentication\TokenController;
use App\Http\Controllers\Controller;
use App\Models\Tax;

class TaxController extends Controller
{
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
            'message' => 'Tax List',
            'data' => $result
        ]);
    }

    public function query()
    {
        $current_company_id = TokenController::getCompanyId();
        return Tax::query()->where('company_id',$current_company_id);
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
            $query = $query->orderBy('tax_rate', 'ASC');

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
            'message' => 'Tax Full List',
            'data' => $result
        ]);
    }
}