<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Belt_price;
use App\Customer;
use App\Tyre_orders;
use App\TyreOrderProduct;
use App\Belt_category;
use App\Belt_subcategory;
use App\RecievedBelt;
use App\Reason;
use App\CompleteOrder;
use PDF;
use App\Mail\TyreOrder;

class TyreordersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('tyre_orders.orders_add');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $orders = Tyre_orders::with('customer', 'order_product')->get();
        return view('tyre_orders.view_orders', ['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        DB::beginTransaction();
        try {
            $added_user = Auth::user()->id;
            if ($request->item_count > 0 && isset($request->item_count)) {
                $discount_amt = round((str_replace(',', '', $request->tot_amount) / 100) * str_replace(',', '', $request->whole_dis), 2);
                $salesOrder = Tyre_orders::create([
                            'order_no' => $request->order_no,
                            'cus_id' => $request->cus_id,
                            'order_amount' => str_replace(',', '', $request->tot_amount),
                            'discount' => str_replace(',', '', $discount_amt),
                            'discount_per' => str_replace(',', '', $request->whole_dis),
                            'complete_status' => '0',
                            'added_by' => $added_user
                ]);

                $lastOrder = Tyre_orders::select('order_id', 'order_no')
                        ->latest()
                        ->first();
                for ($i = 1; $i <= $request->item_count; $i++) {
                    $line_amt = ($request['qty_' . $i] * $request['price_' . $i]);
                    $orderProduct = TyreOrderProduct::create([
                                'order_id' => $lastOrder->order_id,
                                'tyre_id' => $request['tyre_id_' . $i],
                                'price_id' => $request['price_no_' . $i],
                                'discount' => 0,
                                'discount_per' => $request['discount_' . $i],
                                'qty' => $request['qty_' . $i],
                                'line_amount' => str_replace(',', '', $line_amt),
                                'serial_no' => $request['serial_' . $i]
                    ]);
                }

                $customer = Customer::find($request->cus_id);
                $data = [
                    'name' => $customer->customer_name,
                    "message" => "Your tyre order has been collected successfully. it will be processing withing next few days. your order no is " . $lastOrder->order_no
                ];
                Mail::to($customer->email)->send(new TyreOrder($data));
            }

            DB::commit();
            return redirect()->route('view_orders')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('view_orders')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
        }
    }

    public function get_order_details($id) {
        $order = Tyre_orders::with('customer')->find($id);
        $orderDetails = TyreOrderProduct::with('tyre', 'price')->where('order_id', '=', $id)->get();
        return view('tyre_orders.display_order', ['orderDetails' => $orderDetails, 'order' => $order]);
    }

    public function print_order($id) {
        $order = Tyre_orders::with('customer')->find($id);
        $orderDetails = TyreOrderProduct::with('tyre', 'price')->where('order_id', '=', $id)->get();
        $pdf = PDF::loadView('tyre_orders.print_order', compact('order', 'orderDetails'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
    }

    public function search_customer_credit_amount(Request $request){
        $outstandingInv = CompleteOrder::with('com_order_product','payment_details')->where('cus_id','=',$request->cus_id)->get();
        $outstandingInv->transform(function($out) {
            $line_amt = 0;
            $discount = 0;
            $net_amount = 0;
            $grand_total = 0;
            foreach ($out->com_order_product AS $pro) {
                $price = Belt_price::where('price_id', '=', $pro->price_id)
                        ->where('tyre_id', '=', $pro->tyre_id)->first();
                $line_amt += ($pro->qty * $price->cus_price) - (($pro->qty * $price->cus_price) * $pro->discount_per) / 100;
            }
            $discount = ($line_amt * $out->discount_per) / 100;
            $net_amount = $line_amt - $discount;
            $grand_total += $net_amount;

            //calc payment
            $paid_amt = 0;
            foreach ($out->payment_details AS $pay) {
                $paid_amt += $pay->paid_amount;
            }
            $grand_total = $grand_total - $paid_amt;
            return [
                'net_amount' => $grand_total
            ];
        });
        return $outstandingInv->sum('net_amount');
    }

    public function search_customer_credit_limit(Request $request){
        $customer = Customer::find($request->cus_id);
        return $customer;
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
        Tyre_orders::find($id)->delete();
        return redirect()->route('view_orders')->with('success', 'RECORD HAS BEEN SUCCESSFULLY DELETED!');
    }

    public function gen_order_no() {
        $order_no = Tyre_orders::count();
        return $order_no;
    }

    public static function search_customers(Request $request) {
        $term = $request->term;
        $customers = Customer::select('customer_name AS label', 'cus_id AS id','credit_amount AS credit_amount')
                ->where('customer_name', 'LIKE', '%' . $term . '%')
                ->get();
        return $customers;
    }

    public static function get_batchno(Request $request) {
        $data = [
            'sub_cat_id' => $request->sub_cat_id,
            'cat_id' => $request->cat_id,
            'tyre_id' => $request->tyre_id,
        ];
        $price_no = Belt_price::select('price_id AS price_id', 'price_no AS price_no', 'cus_price AS cus_price')
                ->where($data)
                ->get();
        return $price_no;
    }

    public static function get_cus_prices(Request $request) {
        $price = Belt_price::select('cus_price AS cus_price', 'price_id AS price_id')
                ->where('price_id', '=', $request->batch_id)
                ->get();
        return $price;
    }

    public function get_stocks(Request $request) {

//        $RecievedBelt = RecievedBelt::where('price_id','=',$request->price_id)
//                ->where('tyre_id','=',$request->tyre_id)
//                ->groupBy('price_id')
//                ->get();
        $RecievedBelt = RecievedBelt::groupBy('price_id')
                ->selectRaw('sum(remaining_qty) as sum, price_id')
                ->where('price_id', '=', $request->price_id)
                ->where('tyre_id', '=', $request->tyre_id)
                ->pluck('sum');
        return $RecievedBelt;
    }

    public static function edit_order($id) {
        $customer = Tyre_orders::with('customer')->find($id);
        $orderDetails = TyreOrderProduct::with('tyre', 'price')->where('order_id', '=', $id)->get();
        $category = Belt_category::all();
        $subCat = Belt_subcategory::all();
        $price = Belt_price::all();
        return view('tyre_orders.edit_order', ['customer' => $customer, 'orderDetails' => $orderDetails, 'category' => $category, 'subCat' => $subCat, 'price' => $price]);
    }

    public static function update_order(Request $request) {
        DB::beginTransaction();
        try {

            //Remove old Items
            $distroyOrderProduct = TyreOrderProduct::where('order_id', $request->so_id)->delete();
            //Add New Items
            for ($i = 1; $i <= $request->item_count; $i++) {
                $line_amt = ($request['qty_' . $i] * $request['price_' . $i]);
                $orderProduct = TyreOrderProduct::create([
                            'order_id' => $request->so_id,
                            'tyre_id' => $request['tyre_id_' . $i],
                            'price_id' => $request['price_no_' . $i],
                            'discount' => 0,
                            'discount_per' => $request['discount_' . $i],
                            'qty' => $request['qty_' . $i],
                            'line_amount' => str_replace(',', '', $line_amt),
                            'serial_no' => $request['serial_' . $i]
                ]);
            }
            $discount_amt = round((str_replace(',', '', $request->tot_amount) / 100) * str_replace(',', '', $request->whole_dis), 2);
            $Order = Tyre_orders::where('order_id', $request->so_id)->latest()->first();
            $Order->order_amount = str_replace(',', '', $request->tot_amount);
            $Order->discount = str_replace(',', '', $discount_amt);
            $Order->discount_per = str_replace(',', '', $request->whole_dis);
            $Order->save();

            DB::commit();
            return redirect()->route('view_orders')->with('success', 'RECORD HAS BEEN SUCCESSFULLY UPDATED!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('view_orders')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY UPDATED!');
        }
    }

    public static function complete_order($id) {
//        $stock = DB::table('received_belts')
//                ->select('tyre_id',DB::raw('SUM(remaining_qty) as stock'))
//                ->whereNull('received_belts.deleted_at')
//                ->groupBy('tyre_id');
//
//        $orderDetails = DB::table('tyre_order_product')
//                ->join('belt_prices', 'tyre_order_product.price_id', '=', 'belt_prices.price_id')
//                ->join('belt_categories', 'belt_categories.cat_id', '=', 'belt_prices.cat_id')
//                ->join('belt_subcategories','belt_subcategories.sub_cat_id','belt_prices.sub_cat_id')
//                ->join('tyres','tyres.tyre_id','belt_prices.tyre_id')
//                ->joinSub($stock, 'stk', function ($join) {
//                    $join->on('tyre_order_product.tyre_id', '=', 'stk.tyre_id');
//                })->where('tyre_order_product.order_id', '=', $id)
//                ->whereNull('tyre_order_product.deleted_at')
//                ->whereNull('belt_prices.deleted_at')
//                ->whereNull('belt_categories.deleted_at')
//                ->whereNull('belt_subcategories.deleted_at')
//                ->whereNull('tyres.deleted_at')
//                ->get();
        $orderDetails = DB::table("tyre_order_product")
                ->join('belt_prices', 'tyre_order_product.price_id', '=', 'belt_prices.price_id')
                ->join('belt_categories', 'belt_categories.cat_id', '=', 'belt_prices.cat_id')
                ->join('belt_subcategories', 'belt_subcategories.sub_cat_id', 'belt_prices.sub_cat_id')
                ->join('tyres', 'tyres.tyre_id', 'belt_prices.tyre_id')
                ->select("tyre_order_product.*", "belt_categories.*", "belt_subcategories.*", "belt_prices.*", "tyres.*", DB::raw("(SELECT IFNULL(SUM(received_belts.remaining_qty),0) FROM received_belts
                                WHERE received_belts.tyre_id = tyre_order_product.tyre_id
                                AND received_belts.price_id = tyre_order_product.price_id
                                AND received_belts.deleted_at IS NULL
                                GROUP BY received_belts.tyre_id) as product_stock"))
                ->where('tyre_order_product.order_id', '=', $id)
                ->whereNull('tyre_order_product.rsn_id')
                ->whereNull('tyre_order_product.deleted_at')
                ->get();
        $orderDetails->transform(function($orderDetails) {
            return [
                'op_id' => $orderDetails->op_id,
                'order_id' => $orderDetails->order_id,
                'tyre_id' => $orderDetails->tyre_id,
                'tyre_name' => $orderDetails->tyre_name,
                'price_id' => $orderDetails->price_id,
                'cus_price' => $orderDetails->cus_price,
                'cat_id' => $orderDetails->cat_id,
                'cat_name' => $orderDetails->cat_name,
                'sub_cat_id' => $orderDetails->sub_cat_id,
                'sub_cat_name' => $orderDetails->sub_cat_name,
                'discount_per' => $orderDetails->discount_per,
                'discount' => $orderDetails->discount,
                'qty' => $orderDetails->qty,
                'product_stock' => ($orderDetails->product_stock == null) ? 0 : $orderDetails->product_stock,
                'serial_no' => $orderDetails->serial_no
            ];
        });
        $category = Belt_category::all();
        $subCat = Belt_subcategory::all();
        $price = Belt_price::all();
        $order = Tyre_orders::with('customer')->where('order_id', '=', $id)->get();
        $order->transform(function($order) {
            return [
                'order_id' => $order->order_id,
                'order_no' => $order->order_no,
                'cus_id' => $order->cus_id,
                'cus_name' => $order->customer->customer_name,
                'discount_per' => $order->discount_per
            ];
        });
        $reason = Reason::get();
        $com_order_no = CompleteOrder::count(); //CompleteOrder

        return view('complete_orders.complete_orders_add', ['orderDetails' => $orderDetails, 'category' => $category, 'subCat' => $subCat, 'price' => $price, 'order' => $order, 'reason' => $reason, 'com_order_no' => $com_order_no]);
    }

    public function update_order_reason(Request $request) {
        $orderPro = TyreOrderProduct::find($request->order_pro_id);
        $orderPro->rsn_id = $request->reason_id;
        $orderPro->save();
    }

    public function storeorder(Request $request) {
        print_r($request);
    }

}
