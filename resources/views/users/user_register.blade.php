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
                        <li class="active">Registration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form class="form-horizontal form-label-left" action="{{url('add_users')}}" method="post">
            @csrf
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Basic Information <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label" for="full-name">Full Name <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="first-name" required="required" name="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} col-md-7 col-xs-12" placeholder="Full name">
                                <span class="glyphicon form-control-feedback"></span>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif   
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label" for="nic">NIC <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="nic" name="nic" placeholder="NIC" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telephone" class="col-sm-3 col-form-label">Telephone</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="telephone" name="telephone" class="form-control col-md-7 col-xs-12" type="text" placeholder="Telephone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="0">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label">Address <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea id="address" name="address" class="form-control" placeholder="Address"></textarea>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                &nbsp;
                            </div>
                        </div>
                        <!--</form>-->
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Login Information <small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->

                        <div class="form-group">
                            <label class="col-sm-3 col-form-label" for="user-type">User Type <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="user_type" name="user_type">
                                        <option value="0">SELECT</option>
                                        @foreach ($userType as $ut)
                                        <option value="{{$ut->u_tp_id}}">{{$ut->user_type}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label" for="user-type">Permission Group <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="permission_id" name="permission_id">
                                        <option value="0">SELECT</option>
                                        @foreach ($permissionGroup as $pg)
                                    <option value="{{$pg->pg_id}}">{{$pg->group_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label" for="email">Email address <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="password" type="text" name="password" placeholder="Password" class="form-control col-md-7 col-xs-12" type="text">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="password_confirmation" type="text" id="password-confirm" placeholder="Password" class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                        </div>
                        <div class="" style="padding-bottom: 16px">
                            <div class="">
                                &nbsp;
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>

                        <!--</form>-->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


@section('js')
@endsection
