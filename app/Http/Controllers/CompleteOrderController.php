<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Tyre_orders;
use App\TyreOrderProduct;
use App\Belt_category;
use App\Belt_subcategory;
use App\Belt_price;
//use App\RecievedBelt;

class CompleteOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $beltCat = Belt_category::get();
        $beltsubcat = Belt_subcategory::get();
        $beltPrice = Belt_price::get();
//        $orderDetails = TyreOrderProduct::with('tyre', 'price','price.category','price.subcategory','price.received_balt')->where('order_id', '=', $id)->get();
        $orderDetails = DB::table('tyre_order_product')
                ->join('belt_prices','tyre_order_product.price_id','=','belt_prices.price_id')
                ->join('belt_categories','belt_categories.cat_id','=','belt_prices.cat_id')
                ->join('belt_subcategories','belt_subcategories.sub_cat_id','belt_prices.sub_cat_id')
                ->join(DB::row('(SELECT * FROM received_belts )'))
                ->where('tyre_order_product.order_id','=',$id)
                ->get();
        echo '<pre>';
        print_r($orderDetails);
        echo '</pre>';
//        return view('complete_orders.complete_orders_add',['orderDetails'=>$orderDetails,'beltCat'=>$beltCat, 'beltsubcat'=>$beltsubcat,'beltPrice'=>$beltPrice]);
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
