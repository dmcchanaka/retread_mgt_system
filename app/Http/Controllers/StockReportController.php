<?php

namespace App\Http\Controllers;

use App\RecievedBelt;
use App\Tyre;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index()
    {
        $tyre = Tyre::get();
        $stock = RecievedBelt::with('tyre', 'price')->get()->groupBy('price_id');
        // return $stock;
        return view('report.stock_report.index', compact('tyre', 'stock'));
    }

    public function filter(Request $request)
    {
        $tyre = Tyre::get();
        $stock = RecievedBelt::with('tyre', 'price')->where('tyre_id', $request->t_type)->get()->groupBy('price_id');
        // return $stock;
        return view('report.stock_report.index', compact('tyre', 'stock'));

    }
}
