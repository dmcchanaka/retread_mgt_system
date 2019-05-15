<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CompleteOrder;
use App\Belt_price;
use App\Payment;
use App\PaymentDetails;
use App\PaymentCheque;

class PaymentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $payment = Payment::count();

        if($payment == 0){
            $payment_no = 'TYRE/PAY/1';
        } else {
            $num = $payment + 1;
            $payment_no = 'TYRE/PAY/'. $num;
        }
        return view('payments.index',['payment_no'=>$payment_no]);
    }

    function get_outstanding_amount(Request $request){
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
    
    function get_outstanding_invoice(Request $request){
        $outstandingInv = CompleteOrder::with('customer', 'com_order_product','payment_details')
        ->where('cus_id','=',$request->cus_id)
        ->where('paid_status','!=','1')
        ->get();
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

            //calc payment
            $paid_amt = 0;
            foreach ($out->payment_details AS $pay) {
                $paid_amt += $pay->paid_amount;
            }
            
            return [
                'com_order_no' => $out->com_order_no,
                'com_order_id' => $out->com_order_id,
                'date'=> date_format($out->created_at,'Y-m-d'),
                'net_amount' => $net_amount,
                'paid_amount'=> $paid_amt
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
        $payment = Payment::with('customer')->get();
        
        $payment->transform(function($pay){
            return [
                'pay_id'=>$pay->pay_id,
                'pay_no'=>$pay->pay_no,
                'pay_type'=>($pay->pay_type==0)?'Cash':'Cheque',
                'customer'=>$pay->customer->customer_name,
                'address'=>$pay->customer->address,
                'date'=>date('Y-m-d H:i:s',strtotime($pay->created_at)),
                'pay_amount'=>$pay->pay_amount
            ];
        });
        return view('payments.view_payments',['payment'=>$payment]);
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
            if ($request->invo_count > 0 && isset($request->invo_count)) {
                $payment = Payment::create([
                    'pay_no' => $request->payment_no,
                    'pay_amount'=> str_replace(',', '', $request->bAmounthHid),
                    'cus_id' => $request->cus_id,
                    'pay_type' => $request->p_type,
                    'added_by' => $added_user
                ]);
                $lastPayment = Payment::select('pay_id')
                ->latest()
                ->first();
        
                if($request->p_type == 1) {
                $paymentCheque = PaymentCheque::create([
                    'pay_id' => $lastPayment->pay_id,
                    'cheque_no' => $request->chq_no,
                    'bank' => $request->bank,
                    'branch' => $request->branch,
                    'cheque_date' => $request->chq_date
                ]);
                }

                for ($i = 1; $i <= $request->invo_count; $i++) {
                    if($request['order_amount_pay_' . $i] > 0){
                    $paymentDetails = PaymentDetails::create([
                        'pay_id' => $lastPayment->pay_id,
                        'com_order_id' => $request['order_id_' . $i],
                        'paid_amount' => str_replace(',', '', $request['order_amount_pay_' . $i])
                    ]);
                    }

                    //update paid status 
                    if($request['balance_' . $i] == 0) {
                    $paidStatus = CompleteOrder::find($request['order_id_' . $i]);
                    $paidStatus->paid_status = 1;
                    $paidStatus->paid_at = date('Y-m-d H:i:s');
                    $paidStatus->save();
                    }
                }
                
            }
            DB::commit();
            return redirect()->route('view_payments')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('view_payments')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $payment = Payment::find($id);
        $paymentDetails = DB::table('payment AS p')
        ->join('payment_details AS pd','p.pay_id','=','pd.pay_id')
        ->join('complete_orders AS co','co.com_order_id','=','pd.com_order_id')
        ->select([
            'co.com_order_no',
            'pd.paid_amount'
        ])
        ->where('p.pay_id','=',$id)
        ->get();
        $PaymentCheque = PaymentCheque::where('pay_id','=',$id)->get();
        return view('payments.display_payment', ['payment' => $payment,'paymentDetails'=>$paymentDetails,'paymentCheque'=>$PaymentCheque]);
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
