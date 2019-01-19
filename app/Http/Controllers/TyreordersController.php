<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class TyreordersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tyre_orders.orders_add');
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
    
    public function gen_order_no() {
        $order_no = DB::table('tyre_orders')
                    ->count();
        return $order_no;
    }
    
    public static function search_customers(Request $request) {
        $term = $request->term;
        $customers = DB::table('customers')
                ->select('customer_name AS label', 'id AS id')
                ->where('customer_name', 'LIKE', '%' . $term . '%')
                ->where('con_status', '=' , 0)
                ->get();
        return $customers;
    }
    
    public static function get_batchno (Request $request){
        $price_no = DB::table('belt_prices')
                ->select('id AS price_id', 'price_no AS price_no')
                ->where('sub_cat_id', '=', $request->sub_cat_id)
                ->where('price_status', '=', 0)
                ->get();
        return $price_no;
    }
    
    public static function get_cus_prices (Request $request){
        $price = DB::table('belt_prices')
                ->select('cus_price AS cus_price')
                ->where('id', '=', $request->batch_id)
                ->where('price_status', '=', 0)
                ->get();
        return $price;
    }
}
