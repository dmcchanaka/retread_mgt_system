<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\GoodRecieved;
use App\RecievedBelt;

class GoodRecievedController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $grn = GoodRecieved::get();
        return view('grn.view_grn', ['grn' => $grn]);
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
        DB::beginTransaction();
        try {
            $added_user = Auth::user()->id;
            if ($request->item_count > 0 && isset($request->item_count)) {
                $grn_amount = 0;
                $grn_amount = (int) str_replace(',', '', $request->tot_amount);
                $grn = GoodRecieved::create([
                            'grn_no' => $request->grn_no,
                            'invoice_no' => $request->inv_no,
                            'net_amount' => $grn_amount
                ]);

                $lastgrn = GoodRecieved::select('grn_id')
                        ->latest()
                        ->first();

                for ($i = 1; $i <= $request->item_count; $i++) {
                    if (isset($request['qty_' . $i]) && $request['qty_' . $i] > 0) {
                        $rpBelt = RecievedBelt::create([
                                    'grn_id' => $lastgrn->grn_id,
                                    'tyre_id' => $request['tyre_id_' . $i],
                                    'price_id' => $request['price_no_' . $i],
                                    'qty' => $request['qty_' . $i],
                                    'remaining_qty' => $request['qty_' . $i]
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('view_grn')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('view_grn')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
        }
    }

    public function gen_grn_no() {
        $grn_no = GoodRecieved::count();
        return $grn_no;
    }

    public function get_grn_details($id) {
        $grn = GoodRecieved::find($id);
        $grnDetails = RecievedBelt::with('tyre', 'price')->where('grn_id', '=', $id)->get();
        return view('grn.display_grn', ['grnDetails' => $grnDetails, 'grn'=>$grn]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        return view('grn.grn');
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
