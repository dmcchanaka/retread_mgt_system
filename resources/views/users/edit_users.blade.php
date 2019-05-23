@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>USER Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">User Management</a></li>
                        <li class="active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>EDIT User <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form id="demo-form2" action="{{url('update_users/'.$user->id)}}" method="post" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="name" name="name" required="required" value="{{$user->name}}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">User Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="u_type" name="u_type">>
                                        <option value="0">Select User Type</option>
                                        @foreach ($userType as $ut)
                                    <option value="{{$ut->u_tp_id}}" {{ $user->u_tp_id==$ut->u_tp_id ? 'selected="selected"' : '' }}>{{$ut->user_type}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('u_tp_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('u_tp_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Permission Group</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="permission" name="permission">>
                                        <option value="0">Select Permission Group</option>
                                        @foreach ($permissionGroup as $pg)
                                    <option value="{{$pg->pg_id}}" {{ $user->pg_id==$pg->pg_id ? 'selected="selected"' : '' }}>{{$pg->group_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="email" name="email" type="email" placeholder="Email" required="required" value="{{$user->email}}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nic">NIC <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="nic" name="nic" type="text" placeholder="NIC" required="required" value="{{$user->nic}}" class="form-control{{ $errors->has('nic') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('nic'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nic') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile-no">Mobile No <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="telephone" name="telephone" type="text" placeholder="Mobile No" required="required" value="{{$user->mobile_no}}" class="form-control{{ $errors->has('mobile_no') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('mobile_no'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('mobile_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea id="address" name="address" class="form-control" placeholder="Address">{{$user->address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="telephone" name="password" type="password" placeholder="password" value="" class="form-control col-md-7 col-xs-12">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Confirm Password <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="password_confirmation" type="password" id="password-confirm" placeholder="Password" class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection