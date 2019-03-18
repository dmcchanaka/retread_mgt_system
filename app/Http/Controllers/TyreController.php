<?php

namespace App\Http\Controllers;

use App\Belt_category;
use App\Belt_subcategory;
use App\Tyre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TyreController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tyres.tyre_register');
    }
    public function indexCategory()
    {
        return view('belt_category.category_register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tyres = Tyre::with('manufacture')->get();
        $beltCat = Belt_category::get();
        $beltsubcat = Belt_subcategory::with('belt_category')->get();
        return view('tyres.view_tyres', [
            'tyres' => $tyres,
            'beltCat' => $beltCat,
            'beltSubCat' => $beltsubcat,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|not_in:0',
            't_size' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            DB::insert('insert into tyres (tyre_name,tyre_size,manufac_id) values (?, ?, ?)', [$request->get('name'), $request->get('t_size'), $request->get('manufacturer')]);
            DB::commit();
            return redirect()->route('view_tyre')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('view_tyre')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
        }
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        Belt_category::create([
            'cat_name' => $request->cat_name,
        ]);
        $belt = Belt_category::get()
            ->last();
        return $belt;
//        return redirect()->route('view_tyre');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $category = Belt_category::find($request->get('id'));
        return $category;
    }

    public function updateCategory(Request $request)
    {
        $tyercat = Belt_category::find($request->get('cat_id'));
        $tyercat->cat_name = $request->get('cat_name');
        $tyercat->save();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Belt_category::find($id)->delete();
    }

    public function addSubcatogory(Request $request)
    {
        Belt_subcategory::create([
            'cat_id' => $request->catogory_id,
            'sub_cat_name'=> $request->sub_cat_name
        ]);
        $belt_subcat = Belt_subcategory::with('belt_category')->get()
            ->last();
        return $belt_subcat;


    }

    public function showSubcatogory(Request $request){
        $category = Belt_subcategory::find($request->get('id'));
        return $category;
    }

    public function updateSubCategory(Request $request)
    {
        $tyresubcat = Belt_subcategory::find($request->get('sub_cat_id'));
        $tyresubcat->sub_cat_name = $request->get('sub_cat_name');
        $tyresubcat->cat_id = $request->get('catogory_id');
        $tyresubcat->save();
    }

}
