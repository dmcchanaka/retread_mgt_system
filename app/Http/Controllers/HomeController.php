<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\GoodRecieved;
use App\Tyre_orders;
use App\Belt_price;
use App\CompleteOrder;
use App\Payment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = GoodRecieved::get();
        $purchases = $purchases->sum('net_amount');

        $orders = Tyre_orders::with('order_product')->get();
        $orders->transform(function($order){
            $line_amt = 0;
            $discount = 0;
            $net_amount = 0;
            foreach ($order->order_product AS $pro) {
                $price = Belt_price::where('price_id', '=', $pro->price_id)
                        ->where('tyre_id', '=', $pro->tyre_id)->first();
                $line_amt += ($pro->qty * $price->cus_price) - (($pro->qty * $price->cus_price) * $pro->discount_per) / 100;
            }
            $discount = ($line_amt * $order->discount_per) / 100;
            $net_amount = $line_amt - $discount;
            return [
                'orders'=>$net_amount
            ];
        });
        $orders = $orders->sum('orders');

        $comOrders = CompleteOrder::with('customer', 'com_order_product')->get();
        $comOrders->transform(function($comOdr){
            $line_amt = 0;
            $discount = 0;
            $net_amount = 0;
            foreach ($comOdr->com_order_product AS $pro) {
                $price = Belt_price::where('price_id', '=', $pro->price_id)
                        ->where('tyre_id', '=', $pro->tyre_id)->first();
                $line_amt += ($pro->qty * $price->cus_price) - (($pro->qty * $price->cus_price) * $pro->discount_per) / 100;
            }
            $discount = ($line_amt * $comOdr->discount_per) / 100;
            $net_amount = $line_amt - $discount;
            return [
                'com_orders'=>$net_amount
            ];
        });
        $comOrders = $comOrders->sum('com_orders');

        $payments = Payment::get();
        $payments = $payments->sum('pay_amount');

        return view('dashboard',['purchases'=>$purchases,'orders'=>$orders,'comOrders'=>$comOrders,'payments'=>$payments]);
    }
}
