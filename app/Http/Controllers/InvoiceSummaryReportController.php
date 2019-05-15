<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CompleteOrder;
use App\Belt_price;

class InvoiceSummaryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        $invoice = CompleteOrder::get();
        return view('report.invoice.index',['customer'=>$customers,'invoice'=>$invoice]);
    }


    public function search(Request $request)
    {
        $query = CompleteOrder::with('customer', 'com_order_product');

        if($request->cus_id != '0'){
            $query->where('cus_id',$request->cus_id);
        }
        if($request->com_order_id != '0'){
            $query->where('com_order_id',$request->com_order_id);
        }
        if($request->from != '' && $request->to != ''){
            $from = $request->from . ' 00:00:00';
            $to = $request->to .' 23:59:59';
            $query->whereBetween('created_at', [$from, $to]);
        }
        $result = $query->get();
        $result->transform(function($res){
            $line_amt = 0;
            $discount = 0;
            $net_amount = 0;
            foreach ($res->com_order_product AS $pro){
                $price = Belt_price::where('price_id', '=', $pro->price_id)->where('tyre_id', '=', $pro->tyre_id)->first();
                $line_amt += ($pro->qty * $price->cus_price) - (($pro->qty * $price->cus_price) * $pro->discount_per) / 100;
            }
            $discount = ($line_amt * $res->discount_per) / 100;
            $net_amount = $line_amt - $discount;
            return [
                'com_order_no'=>$res->com_order_no,
                'cus_name'=>$res->customer->customer_name,
                'address'=>$res->customer->address,
                'date'=>date('Y-m-d',strtotime($res->created_at)),
                'time'=>date('H:i:s',strtotime($res->created_at)),
                'com_orders'=>$net_amount
            ];
        });
       
        return view('report.invoice.invoice_body',['results'=>$result]);
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
