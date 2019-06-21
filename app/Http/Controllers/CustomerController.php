<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('customers.customer_register');
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
        $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'cus_type'=> 'required|not_in:0',
                    'email' => 'required|string|email|max:255|unique:customers',
                    // 'gender' => 'required|not_in:0',
                    'nic' => 'required|unique:customers',
                    'telephone' => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                            ->withInput();
        }
        $customer = new Customer();
        $customer->customer_name = $request->get('name');
        $customer->customer_type = $request->get('cus_type');
        $customer->email = $request->get('email');
        $customer->nic = $request->get('nic');
        $customer->mobile_no = $request->get('telephone');
        // $customer->gender = $request->get('gender');
        $customer->address = $request->get('address');
        $customer->credit_limit_availability = $request->get('chk_status');
        $customer->credit_amount = $request->get('credit_limit');
        $customer->save();
        return redirect('view_customers')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customer_view() {
//        $customers = DB::table('customers')
//                ->where('con_status', '=', 0)
//                ->get();
        $customers = Customer::get();
        return view('customers.view_customers', ['customers' => $customers]);
    }

    public function show($id) {
        $customer = Customer::find($id);
        return view('customers.edit_customer', ['cust' => $customer]);
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
        $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',
                    // 'gender' => 'required|not_in:0',
                    'nic' => 'required',
                    'telephone' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                            ->withInput();
        }
        
        $customer = Customer::find($id);
        $customer->customer_name = $request->get('name');
        // $customer->gender = $request->get('gender');
        $customer->nic = $request->get('nic');
        $customer->mobile_no = $request->get('telephone');
        $customer->email = $request->get('email');
        $customer->address = $request->get('address');
        $customer->save();
        return redirect()->route('view_customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
//        $customer = Customer::find($id);
//        $customer->con_status = 1;
//        $customer->save();
        Customer::find($id)->delete();
        return redirect()->route('view_customer')->with('success', 'RECORD HAS BEEN SUCCESSFULLY DELETED!');
    }

}
