<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\CompleteOrder;
use App\CompleteOrderProduct;
use App\Tyre_orders;
use App\RecievedBelt;
use App\Customer;
use App\Belt_price;
use App\Mail\CompleteOrderMail;
use PDF;

class CompleteOrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $completeOrders = CompleteOrder::with('customer', 'com_order_product', 'tyre_order')->get();
        return view('complete_orders.view_complete_orders', ['complete_orders' => $completeOrders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
//        dd($request);
        DB::beginTransaction();
        try {
            $added_user = Auth::user()->id;
            if ($request->item_count > 0 && isset($request->item_count)) {
                $discount_amt = round((str_replace(',', '', $request->tot_amount) / 100) * str_replace(',', '', $request->whole_dis), 2);
                $CompleteOrder = CompleteOrder::create([
                            'order_id' => $request->order_id,
                            'com_order_no' => $request->complete_no,
                            'cus_id' => $request->cus_id,
                            'com_order_amount' => str_replace(',', '', $request->tot_amount),
                            'discount' => str_replace(',', '', $discount_amt),
                            'discount_per' => str_replace(',', '', $request->whole_dis),
                            'added_by' => $added_user
                ]);
                $lastOrder = CompleteOrder::select('com_order_id','com_order_no')
                        ->latest()
                        ->first();
                for ($i = 1; $i <= $request->item_count; $i++) {
                    $cus_price = str_replace(',', '', $request['cus_price_' . $i]);
                    $line_amt = ((int) $request['qty_' . $i] * (float) $cus_price);
                    $completeOrderProduct = CompleteOrderProduct::create([
                                'com_order_id' => $lastOrder->com_order_id,
                                'tyre_id' => $request['tyre_id_' . $i],
                                'price_id' => $request['price_id_' . $i],
                                'discount' => 0,
                                'discount_per' => $request['discount_' . $i],
                                'qty' => $request['qty_' . $i],
                                'line_amount' => str_replace(',', '', $line_amt),
                                'serial_no' => $request['serial_' . $i]
                    ]);

                    //update stock
                    $data = [
                        'tyre_id' => $request['tyre_id_' . $i],
                        'price_id' => $request['price_id_' . $i]
                    ];
                    $stock = RecievedBelt::where($data)->whereNotNull('remaining_qty')->first();

                    if ($stock->remaining_qty > 0) {
                        $newstock = $stock->remaining_qty - $request['qty_' . $i];

                        $RecievedBelt = RecievedBelt::find($stock->rec_id);
                        $RecievedBelt->remaining_qty = $newstock;
                        $RecievedBelt->save();
                    }
                }

                /* update order complete status */
                $order = Tyre_orders::find($request->order_id);
                $order->complete_status = 1;
                $order->save();
                
                /*send email notification*/
                $customer = Customer::find($request->cus_id);
                $invDetails = CompleteOrder::with('com_order_product')->where('com_order_id','=',$lastOrder->com_order_id)->get();
                $invDetails->transform(function($out) {
                    $line_amt = 0;
                    $discount = 0;
                    $gross_amt = 0;
                    $net_amount = 0;
                    foreach ($out->com_order_product AS $pro) {
                        $price = Belt_price::where('price_id', '=', $pro->price_id)
                                ->where('tyre_id', '=', $pro->tyre_id)->first();
                        $line_amt += ($pro->qty * $price->cus_price) - (($pro->qty * $price->cus_price) * $pro->discount_per) / 100;
                    }
                    $gross_amt = $line_amt;
                    $discount = ($line_amt * $out->discount_per) / 100;
                    $net_amount = $line_amt - $discount;

                    return [
                        'inv_net' => $net_amount,
                        'inv_gross' => $net_amount,
                        'inv_discount' => $discount
                    ];
                });
                $data = [
                    'name' => $customer->customer_name,
                    "inv_no" => $lastOrder->com_order_no,
                    "inv_gross" =>$invDetails[0]['inv_gross'],
                    "inv_discount" =>$invDetails[0]['inv_discount'],
                    "inv_net" =>$invDetails[0]['inv_net'],
                    "message" => "Your Tire order is now ready for collection. you may come over at the branch during standard working hours or memtion days and times for the collection of the order"
                ];
                Mail::to($customer->email)->send(new CompleteOrderMail($data));
            }
            DB::commit();
            return redirect()->route('view_orders')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('view_orders')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $order = CompleteOrder::with('customer','tyre_order')->find($id);
        $orderDetails = CompleteOrderProduct::with('tyre', 'price')->where('com_order_id', '=', $id)->get();
        return view('complete_orders.display_complete_order',['order'=>$order,'orderDetails' => $orderDetails]);
    }

    public function print_invoice($id){
        $order = CompleteOrder::with('customer','tyre_order')->find($id);
        $orderDetails = CompleteOrderProduct::with('tyre', 'price')->where('com_order_id', '=', $id)->get();
        $pdf = PDF::loadView('complete_orders.print_invoice', compact('order', 'orderDetails'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
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
