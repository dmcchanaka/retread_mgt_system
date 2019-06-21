@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>PRICE Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Price Management</a></li>
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
                    <h2>EDIT Price <small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form id="demo-form2" action="{{url('update_price/'.$price->price_id)}}" method="post" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tire Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="tyre_id" name="tyre_id">>
                                        <option value="0">Select Category</option>
                                        @foreach ($tires as $tire)
                                    <option value="{{$tire->tyre_id}}" {{ $tire->tyre_id== $price->tyre_id ? 'selected="selected"' : '' }}>{{$tire->tyre_name}}</option> 
                                        @endforeach
                                    </select>
                                    @if ($errors->has('tyre_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tyre_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="cat_id" name="cat_id">>
                                        <option value="0">Select Category</option>
                                        @foreach ($category as $cat)
                                    <option value="{{$cat->cat_id}}" {{ $cat->cat_id== $price->cat_id ? 'selected="selected"' : '' }}>{{$cat->cat_name}}</option> 
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cat_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cat_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="sub_cat_id" name="sub_cat_id">>
                                        <option value="0">Select Sub Category</option>
                                        @foreach ($subCategory as $subcat)
                                    <option value="{{$subcat->sub_cat_id}}" {{ $subcat->sub_cat_id== $price->sub_cat_id ? 'selected="selected"' : '' }}>{{$subcat->sub_cat_name}}</option> 
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sub_cat_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sub_cat_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Price No. <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="price_no" name="price_no" required="required" value="{{$price->price_no}}" class="form-control{{ $errors->has('price_no') ? ' is-invalid' : '' }} col-md-7 col-xs-12" readonly>
                                @if ($errors->has('price_no'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('price_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Received Price <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="rp_price" name="rp_price" required="required" value="{{$price->rp_price}}" class="form-control{{ $errors->has('rp_price') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('rp_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('rp_price') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Price <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="cus_price" name="cus_price" required="required" value="{{$price->cus_price}}" class="form-control{{ $errors->has('cus_price') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('cus_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cus_price') }}</strong>
                                </span>
                                @endif
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