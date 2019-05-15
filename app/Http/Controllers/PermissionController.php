<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserType;
use App\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userType = UserType::get();
        $mainPermission = Permission::whereNull('parent_id')->get();
        $mainPermission->transform(function($mp){
            $subSection = Permission::where('parent_id','=',$mp->per_id)->get();
            $subSection->transform(function($sub){
                return [
                    'sub_sec_id'=>$sub->per_id,
                    'sub_sec_name'=>$sub->section_name
                ];
            });
            return [
                'main_per_id'=>$mp->per_id,
                'section_name'=>$mp->section_name,
                'sub_section'=>$subSection
            ];
        });
        return view('permission.index',['userType'=>$userType,'main_permission'=>$mainPermission]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
