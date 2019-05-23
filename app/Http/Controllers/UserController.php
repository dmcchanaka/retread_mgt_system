<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\UserType;
use App\PermissionGroup;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $userType = UserType::all();
        $permissionGroup = PermissionGroup::all();
        return view('users.user_register',['userType'=>$userType,'permissionGroup'=>$permissionGroup]);
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
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                    'user_type' => 'required|not_in:0',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                            ->withInput();
        }
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->nic = $request->get('nic');
        $user->mobile_no = $request->get('telephone');
        $user->gender = $request->get('gender');
        $user->address = $request->get('address');
        $user->password = Hash::make($request->get('password'));
        $user->u_tp_id = $request->get('user_type');
        $user->pg_id = $request->get('permission');
        $user->save();
        return redirect('view_users')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function user_view() {
        $users = User::with('userTypes')->where('users.u_tp_id', '!=', 1)->get();
        return view('users.view_users', ['users' => $users]);
    }
    
    public function edit_user($id) {
        $users = User::find($id);
        $userType = UserType::all();
        $permissionGroup = PermissionGroup::all();
        return view('users.edit_users', ['user' => $users,'userType'=>$userType,'permissionGroup'=>$permissionGroup]);
    }
    public function update_user($id, $name){
        
    }

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
       $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',
                    'u_type' => 'required|not_in:0',
                    'nic' => 'required',
                    'telephone' => 'required',
                    'password' => 'string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                            ->withInput();
        }
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->nic = $request->get('nic');
        $user->mobile_no = $request->get('telephone');
        $user->address = $request->get('address');
        $user->password = Hash::make($request->get('password'));
        $user->u_tp_id = $request->get('u_type');
        $user->pg_id = $request->get('permission');
        $user->save();
        return redirect('view_users')->with('success', 'RECORD HAS BEEN SUCCESSFULLY INSERTED!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // $user = User::find($id);
        // $user->user_status = 1;
        // $user->save();
        User::find($id)->delete();
        return redirect()->route('view_users')->with('success', 'RECORD HAS BEEN SUCCESSFULLY DELETED!');
    }
    

}
