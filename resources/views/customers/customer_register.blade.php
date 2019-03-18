@extends('layouts.app')
@section('css')
<!-- iCheck -->
<link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>CUSTOMER Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Customer Management</a></li>
                        <li class="active">Registration</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Customer Information</h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div class="x_content">
                    <div class="x_panel">
                        <form class="form-horizontal form-label-left" action="{{url('add_customers')}}" method="post">
                            @csrf
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    <label for="exampleInputnic">Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="customer name">
                                    <span class="glyphicon form-control-feedback"></span>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="examplegender">Customer Type</label>
                                    <select class="form-control" id="cus_type" name="cus_type">
                                        <option value="0">Select Customer Type</option>
                                        <option value="1">Individual</option>
                                        <option value="2">Company</option>
                                    </select>
                                    @if ($errors->has('cus_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cus_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="examplegender">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="0">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputAddress">Address</label>
                                    <textarea id="address" name="address" class="form-control" placeholder="Address"></textarea>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputnic">NIC</label>
                                    <input id="nic" name="nic" type="text" class="form-control" placeholder="NIC">
                                    <span class="glyphicon form-control-feedback"></span>
                                    @if ($errors->has('nic'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nic') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputmobile">Telephone</label>
                                    <input id="telephone" name="telephone" type="text" class="form-control" placeholder="Telephone">
                                    <span class="glyphicon form-control-feedback"></span>
                                    @if ($errors->has('telephone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="exampleInputmobile">Credit Limit Availability
                                        <input type="checkbox" id="myCheck" name="myCheck" onclick="myFunction()">
                                        <input type="hidden" id="chk_status" name="chk_status" value="0" />
                                    </label>
                                    <input id="credit_limit" name="credit_limit" type="text" class="form-control" placeholder="Enter Credit Limit" style="display: none">
                                    <span class="glyphicon form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="ln_solid"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('js')
<!-- iCheck -->
<script src="../vendors/iCheck/icheck.min.js"></script>
<script>
                                            function myFunction() {
                                                var checkBox = document.getElementById("myCheck");
                                                var text = document.getElementById("credit_limit");
                                                if (checkBox.checked === true) {
                                                    text.style.display = "block";
                                                    $('#chk_status').val('1');
                                                } else {
                                                    text.style.display = "none";
                                                    $('#chk_status').val('0');
                                                }
                                            }
</script>
@endsection