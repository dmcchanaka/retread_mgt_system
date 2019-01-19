<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Tyre;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TyreController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('tyres.tyre_register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $tyres = DB::table('tyres')
                ->join('manufacturers', 'tyres.manufacturer_id', '=', 'manufacturers.id')
                ->select('tyres.*', 'manufacturers.name AS manufac_name')
                ->where('tyres.tyre_status', '=', 0)
                ->get();
        return view('tyres.view_tyres', ['tyres' => $tyres]);
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
                    'manufacturer' => 'required|not_in:0',
                    't_size' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                            ->withInput();
        }
        DB::beginTransaction();
        try {
            DB::insert('insert into tyres (name,size,manufacturer_id) values (?, ?, ?)', [$request->get('name'), $request->get('t_size'), $request->get('manufacturer')]);
            DB::commit();
            return redirect()->back()->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (Exception $ex) {
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
