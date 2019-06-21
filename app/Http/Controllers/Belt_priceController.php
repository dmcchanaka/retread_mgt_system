<?php

namespace App\Http\Controllers;

use App\Belt_price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Tyre;
use App\Belt_category;
use App\Belt_subcategory;

class Belt_priceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('prices.price_register');
    }

    public function search_products(Request $request)
    {
        $term = $request->term;
        // $tyres = DB::table('tyres')
        //     ->select('tyre_name AS label', 'tyre_id AS id')
        //     ->where('tyre_name', 'LIKE', '%' . $term . '%')
        //     ->get();
        //     return $tyres;

            $tyres = Tyre::select('tyre_name AS label', 'tyre_id AS id')
            ->where('tyre_name', 'LIKE', '%' . $term . '%')
            ->get();
            return $tyres;


            // $tyres->transform(function ($tyres, $key) {
            //     return [
            //         'label'=>$tyres->tyre_name,
            //         'id'=>$tyres->tyre_id
            //     ];
            // });
    }

    public static function get_category(Request $request)
    {
        // $category = DB::table('belt_categories')
        //     ->select('id AS cat_id', 'cat_name AS cat_name')
        //     ->where('tyre_id', '=', $request->tyre_id)
        //     ->get();
        $category = Belt_category::all();
        return $category;
    }

    public static function get_subcategory(Request $request)
    {
        // $sub_category = DB::table('belt_subcategories')
        //     ->select('id AS sub_cat_id', 'sub_cat_name AS sub_cat_name')
        //     ->where('cat_id', '=', $request->cat_id)
        //     ->where('tyre_id', '=', $request->tyre_id)
        //     ->get();
        $sub_category = Belt_subcategory::select('sub_cat_id AS sub_cat_id', 'sub_cat_name AS sub_cat_name')
            ->where('cat_id', '=', $request->cat_id)
            ->get();
        return $sub_category;
    }

    public static function gen_beltno()
    {
        // $belt_price = DB::table('belt_prices')
        //     ->where('price_status', '=', 0)
        //     ->count();
            $belt_price = Belt_price::get()   
            ->count();
        return $belt_price;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $belt_prices = DB::table('belt_prices AS b')
        //             ->join('belt_subcategories AS bsc', 'bsc.id', '=', 'b.sub_cat_id')
        //             ->join('belt_categories AS bc', 'bc.id', '=', 'bsc.cat_id')
        //             ->join('tyres AS t', 't.id', '=', 'bc.tyre_id')
        //             ->select('b.*', 'bsc.sub_cat_name AS sub_cat_name', 'bc.cat_name AS cat_name', 't.name AS tyre_name')
        //             ->where('b.price_status', '=', 0)
        //             ->get();
        $belt_prices = Belt_price::with('tyre','category','subcategory')->get();
        return view('prices.view_prices', ['prices' => $belt_prices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            return redirect()->route('view_prices')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (\Exception $e) {
            // Rollback Transaction
            dd($e);
            DB::rollback();
            return redirect()->route('view_prices')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $price = Belt_price::with('tyre','category','subcategory')->find($id);
        $category = Belt_category::get();
        $subCategory = Belt_subcategory::get();
        $tires = Tyre::get();
        return view('prices.edit_price', ['price' => $price,'category' => $category,'subCategory' => $subCategory,'tires' => $tires]);
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
        $validator = Validator::make($request->all(), [
            'tyre_id' => 'required|not_in:0',
            'cat_id' => 'required|not_in:0',
            'sub_cat_id' => 'required|not_in:0',
            'rp_price' => 'required',
            'cus_price' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                            ->withInput();
        }

        $price = Belt_price::find($id);
        $price->tyre_id = $request->get('tyre_id');
        $price->cat_id = $request->get('cat_id');
        $price->sub_cat_id = $request->get('sub_cat_id');
        $price->rp_price = $request->get('rp_price');
        $price->cus_price = $request->get('cus_price');
        $price->save();
        return redirect()->route('view_prices')->with('success', 'RECORD HAS BEEN SUCCESSFULLY UPDATED!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Belt_price::find($id)->delete();
        return redirect()->route('view_prices')->with('success', 'RECORD HAS BEEN SUCCESSFULLY DELETED!');
    }

}
