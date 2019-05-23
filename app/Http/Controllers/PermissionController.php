<?php

namespace App\Http\Controllers;

use App\Permission;
use App\PermissionGroup;
use App\UserPermission;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $mainPermission->transform(function ($mp) {
            $subSection = Permission::where('parent_id', '=', $mp->per_id)->get();
            $subSection->transform(function ($sub) {
                return [
                    'sub_sec_id' => $sub->per_id,
                    'sub_sec_name' => $sub->section_name,
                ];
            });
            return [
                'main_per_id' => $mp->per_id,
                'section_name' => $mp->section_name,
                'sub_section' => $subSection,
            ];
        });
        return view('permission.index', ['userType' => $userType, 'main_permission' => $mainPermission]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionGroup = PermissionGroup::with('user_type')->get();
        return view('permission.view_permission', ['permissionGroup' => $permissionGroup]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if (isset($request->main_count) && $request->main_count > 0) {
                $permissionGroup = PermissionGroup::create([
                    'group_name' => $request->per_group,
                    'u_tp_id' => $request->user_type,
                ]);

                $permissionGroup = PermissionGroup::select('pg_id')
                    ->latest()
                    ->first();

                for ($i = 1; $i <= $request->main_count; $i++) {
                    if ($request['main_status_' . $i] == '1') {
                        $userPermission = UserPermission::create([
                            'pg_id' => $permissionGroup->pg_id,
                            'per_id' => $request['main_sec_id_' . $i],
                        ]);
                        for ($j = 1; $j <= $request['sub_count_' . $i]; $j++) {
                            if ($request['sub_status_' . $i . '_' . $j] == '1') {
                                $userPermission = UserPermission::create([
                                    'pg_id' => $permissionGroup->pg_id,
                                    'per_id' => $request['sub_sec_id_' . $i . '_' . $j],
                                ]);
                            }
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('view_parmission')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('view_parmission')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY INSERTED!');
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
        $permissionGroup = PermissionGroup::find($id);

        $userPermission = DB::table('user_permission AS up')
            ->join('permission AS p', 'p.per_id', '=', 'up.per_id')
            ->select('up.up_id', 'up.pg_id', 'up.per_id', 'p.section_name')
            ->where('p.parent_id', '=', NULL)
            ->where('p.deleted_at', '=', NULL)
            ->where('up.deleted_at', '=', NULL)
            ->where('up.pg_id', '=', $id)->get();
            $userPermission = collect($userPermission);
            $userPermission->transform(function($up){
                $subPermission = DB::table('user_permission AS upp')
                ->join('permission AS pp', 'pp.per_id', '=', 'upp.per_id')
                ->select('upp.per_id', 'pp.section_name')
                ->where('upp.pg_id','=',$up->pg_id)
                ->where('pp.parent_id', '!=', NULL)
                ->where('pp.deleted_at', '=', NULL)
                ->where('upp.deleted_at', '=', NULL)
                ->get();
                $subPermission = collect($subPermission);
                $subPermission->transform(function($sp){
                    return [
                        'sub_per_id'=>$sp->per_id,
                        'sub_per_name'=>$sp->section_name
                    ];
                });
                return [
                    'up_id'=>$up->up_id,
                    'pg_id'=>$up->pg_id,
                    'per_id'=>$up->per_id,
                    'per_name'=>$up->section_name,
                    'subSection'=>$subPermission
                ];
            });
            return view('permission.display_permission',['permissionGroup'=>$permissionGroup,'userPermission'=>$userPermission]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userType = UserType::get();
        $mainPermission = Permission::whereNull('parent_id')->get();
        $mainPermission->transform(function ($mp) {
            $subSection = Permission::where('parent_id', '=', $mp->per_id)->get();
            $subSection->transform(function ($sub) {
                return [
                    'sub_sec_id' => $sub->per_id,
                    'sub_sec_name' => $sub->section_name,
                ];
            });
            return [
                'main_per_id' => $mp->per_id,
                'section_name' => $mp->section_name,
                'sub_section' => $subSection,
            ];
        });
        //assigned Permission
        $permissionGroup = PermissionGroup::find($id);
        $userPermission = DB::table('user_permission AS up')
            ->join('permission AS p', 'p.per_id', '=', 'up.per_id')
            ->select('up.up_id', 'up.pg_id', 'up.per_id', 'p.section_name')
            ->where('p.parent_id', '=', NULL)
            ->where('p.deleted_at', '=', NULL)
            ->where('up.deleted_at', '=', NULL)
            ->where('up.pg_id', '=', $id)->get();
            $userPermission = collect($userPermission);
            $userPermission->transform(function($up){
                $subPermission = DB::table('user_permission AS upp')
                ->join('permission AS pp', 'pp.per_id', '=', 'upp.per_id')
                ->select('upp.per_id', 'pp.section_name')
                ->where('upp.pg_id','=',$up->pg_id)
                ->where('pp.parent_id', '!=', NULL)
                ->where('pp.deleted_at', '=', NULL)
                ->where('upp.deleted_at', '=', NULL)
                ->get();
                $subPermission = collect($subPermission);
                $subPermission->transform(function($sp){
                    return [
                        'sub_per_id'=>$sp->per_id,
                        'sub_per_name'=>$sp->section_name
                    ];
                });
                return [
                    'up_id'=>$up->up_id,
                    'pg_id'=>$up->pg_id,
                    'per_id'=>$up->per_id,
                    'per_name'=>$up->section_name,
                    'subSection'=>$subPermission
                ];
            });
            // return $userPermission;
        return view('permission.edit_permission',['userType' => $userType, 'main_permission' => $mainPermission,'permissionGroup'=>$permissionGroup,'userPermission'=>$userPermission]);
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
        DB::beginTransaction();
        try {
            if (isset($request->main_count) && $request->main_count > 0) {
                $permissionGroup=PermissionGroup::find($id);
                $permissionGroup->group_name = $request->per_group;
                $permissionGroup->u_tp_id = $request->user_type;
                $permissionGroup->save();

                UserPermission::where('pg_id',$id)->delete();

                for ($i = 1; $i <= $request->main_count; $i++) {
                    if ($request['main_status_' . $i] == '1') {

                        $userPermission = UserPermission::create([
                            'pg_id' => $permissionGroup->pg_id,
                            'per_id' => $request['main_sec_id_' . $i],
                        ]);
                        for ($j = 1; $j <= $request['sub_count_' . $i]; $j++) {
                            if ($request['sub_status_' . $i . '_' . $j] == '1') {
                                $userPermission = UserPermission::create([
                                    'pg_id' => $permissionGroup->pg_id,
                                    'per_id' => $request['sub_sec_id_' . $i . '_' . $j],
                                ]);
                            }
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('view_parmission')->with('success', 'RECORD HAS BEEN SUCCESSFULLY UPDATED!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('view_parmission')->with('error', 'RECORD HAS NOT BEEN SUCCESSFULLY UPDATED!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PermissionGroup::find($id)->delete();
        UserPermission::where('pg_id',$id)->delete();
        return redirect()->route('view_permission')->with('success', 'RECORD HAS BEEN SUCCESSFULLY DELETED!');
    }
}
