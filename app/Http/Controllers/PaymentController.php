<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CompleteOrder;
use App\Belt_price;

class PaymentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('payments.index');
    }
    
    function get_outstanding_invoice(Request $request){
        $outstandingInv = CompleteOrder::with('customer', 'com_order_product')->where('cus_id','=',$request->cus_id)->get();
        $outstandingInv->transform(function($out) {
            $line_amt = 0;
            $discount = 0;
            $net_amount = 0;
            foreach ($out->com_order_product AS $pro) {
                $price = Belt_price::where('price_id', '=', $pro->price_id)
                        ->where('tyre_id', '=', $pro->tyre_id)->first();
                $line_amt += ($pro->qty * $price->cus_price) - (($pro->qty * $price->cus_price) * $pro->discount_per) / 100;
            }
            $discount = ($line_amt * $out->discount_per) / 100;
            $net_amount = $line_amt - $discount;
            return [
                'com_order_no' => $out->com_order_no,
                'com_order_id' => $out->com_order_id,
                'date'=> date_format($out->created_at,'Y-m-d'),
                'net_amount' => $net_amount
            ];
        });
        return view('payments.load_invoice',['outstanding'=>$outstandingInv]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
