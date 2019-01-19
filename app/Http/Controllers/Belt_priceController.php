<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Belt_priceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('prices.price_register');
    }

    public function search_products(Request $request) {
        $term = $request->term;
        $tyres = DB::table('tyres')
                ->select('name AS label', 'id AS id')
                ->where('name', 'LIKE', '%' . $term . '%')
                ->get();
        return $tyres;
    }

    public static function get_category(Request $request) {
        $category = DB::table('belt_categories')
                ->select('id AS cat_id', 'cat_name AS cat_name')
                ->where('tyre_id', '=', $request->tyre_id)
                ->get();
        return $category;
    }

    public static function get_subcategory(Request $request) {
        $sub_category = DB::table('belt_subcategories')
                ->select('id AS sub_cat_id', 'sub_cat_name AS sub_cat_name')
                ->where('cat_id', '=', $request->cat_id)
                ->where('tyre_id', '=', $request->tyre_id)
                ->get();
        return $sub_category;
    }

    public static function gen_beltno() {
        $belt_price = DB::table('belt_prices')
                ->where('price_status', '=', 0)
                ->count();
        return $belt_price;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $belt_prices = DB::table('belt_prices AS b')
                    ->join('belt_subcategories AS bsc', 'bsc.id', '=', 'b.sub_cat_id')
                    ->join('belt_categories AS bc', 'bc.id', '=', 'bsc.cat_id')
                    ->join('tyres AS t', 't.id', '=', 'bc.tyre_id')
                    ->select('b.*', 'bsc.sub_cat_name AS sub_cat_name', 'bc.cat_name AS cat_name', 't.name AS tyre_name')
                    ->where('b.price_status', '=', 0)
                    ->get();
        return view('prices.view_prices', ['prices' => $belt_prices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Begin Transaction
        DB::beginTransaction();
        try {
            $rowData = [];
            for ($i = 1; $i <= $request->get('item_count'); $i++) {
                date_default_timezone_set('Asia/Colombo');
                $date = date('Y-m-d h:i:s', time());
                DB::insert('insert into belt_prices (tyre_id,cat_id,sub_cat_id,price_no,rp_price,cus_price,created_at,updated_at) values (?,?,?,?,?,?,?,?)', [$request->get('tyre_id_' . $i), $request->get('cat_id_' . $i), $request->get('sub_cat_id_' . $i), $request->get('pr_no_' . $i), $request->get('r_price_' . $i), $request->get('c_price_' . $i), $date, $date]);
            }
            // Commit Transaction
            DB::commit();
            return redirect()->back()->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (\Exception $e) {
            // Rollback Transaction
            dd($e);
            DB::rollback();
            return redirect()->back()->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
        }
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
