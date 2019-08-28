<?php

namespace App\Api\V1\Controllers\Master;

use App\Models\Master\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param $items
     * @return \Illuminate\Http\Response
     */
    public function index($items = 10)
    {
        $products = $this->search()->paginate($items);

        return response()->json([
            'status'=>true,
            'data'=>$products,
            'message'=>"Products List paginated"
        ],200);
    }

    function search(){
        $product = Product::query();
        $search = \Request::get('search');
        
        if ($search !== null && $search !=='')
        {
            foreach ($search as $param=>$key)
            {

                if ($key !=='' && $key !==null && $key !=="undefined")
                {
                    $product = $product->Orwhere($param,'LIKE',"%".$key."%");
                }
            }
        }
        return $product;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
