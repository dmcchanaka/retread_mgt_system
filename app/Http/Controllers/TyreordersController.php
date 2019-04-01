<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Belt_price;
use App\Customer;
use App\Tyre_orders;
use App\TyreOrderProduct;
use App\Belt_category;
use App\Belt_subcategory;
use PDF;

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

                $lastOrder = Tyre_orders::select('order_id')
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
                                'line_amount' => str_replace(',', '', $line_amt)
                    ]);
                }
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
        $pdf = PDF::loadView('tyre_orders.print_order', compact('order'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
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
        $customers = Customer::select('customer_name AS label', 'cus_id AS id')
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
        $price_no = Belt_price::select('price_id AS price_id', 'price_no AS price_no')
                ->where($data)
                ->get();
        return $price_no;
    }

    public static function get_cus_prices(Request $request) {
        $price = Belt_price::select('cus_price AS cus_price')
                ->where('price_id', '=', $request->batch_id)
                ->get();
        return $price;
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
            $distroyOrderProduct = TyreOrderProduct::where('order_id',$request->so_id)->delete();
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
                            'line_amount' => str_replace(',', '', $line_amt)
                ]);
            }
            $discount_amt = round((str_replace(',', '', $request->tot_amount) / 100) * str_replace(',', '', $request->whole_dis), 2);
            $Order = Tyre_orders::where('order_id',$request->so_id)->latest()->first();
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

}
