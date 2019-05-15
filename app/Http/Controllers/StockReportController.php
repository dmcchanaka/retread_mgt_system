<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\RecievedBelt;
use App\Tyre;
use App\Belt_category;
use App\Belt_subcategory;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index()
    {
        $tyre = Tyre::get();
        $category = Belt_category::get();
        $subCategory = Belt_subcategory::get();
        return view('report.stock_report.index', compact('tyre', 'category','subCategory'));
    }

    public function search(Request $request)
    {
        $query = DB::table('received_belts AS rb')
            ->join('tyres AS t','t.tyre_id','rb.tyre_id')
            ->join('belt_prices AS bp','bp.price_id','rb.price_id')
            ->join('belt_categories AS bc','bc.cat_id','bp.cat_id')
            ->join('belt_subcategories AS bsc','bsc.sub_cat_id','bp.sub_cat_id')
            ->select([
                't.tyre_name',
                't.tyre_size',
                'bc.cat_name',
                'bsc.sub_cat_name',
                'bp.rp_price', 
                DB::raw('SUM(rb.remaining_qty) as stock')
            ])
            ->groupBy('rb.price_id');

        
        if($request->tyre_id != '0'){
            $query->where('rb.tyre_id',$request->tyre_id);
        }
        if($request->cat_id != '0'){
            $query->where('bp.cat_id',$request->cat_id);
        }
        if($request->sub_cat_id != '0'){
            $query->where('bp.sub_cat_id',$request->sub_cat_id);
        } 
        $results = $query->get();
        return view('report.stock_report.stock_body', compact('results'));

    }

    // public function filter(Request $request)
    // {
    //     $tyre = Tyre::get();
    //     $stock = RecievedBelt::with('tyre', 'price')->where('tyre_id', $request->t_type)->get()->groupBy('price_id');
    //     // return $stock;
    //     return view('report.stock_report.index', compact('tyre', 'stock'));

    // }
}
