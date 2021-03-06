@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>REPORTS</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-5">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Report</a></li>
                        <li class="active">Stock Statement</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>STOCK STATEMENT REPORT</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="x_panel">
                        <div class="well" style="overflow: auto">
                                <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                    <form class="form-horizontal form-label-left" method="post">
                                            @csrf
                                        <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">TYRE NAME</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="tyre_id" name="tyre_id">
                                                <option value="0">SELECT TYRE</option>
                                                @foreach ($tyre as $item)
                                                <option value="{{$item->tyre_id}}">{{$item->tyre_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">CATEGORY</label>
                                            <div class="col-sm-9">
                                                    <select class="form-control" id="cat_id" name="cat_id">
                                                        <option value="0">SELECT CATEGORY</option>
                                                        @foreach ($category as $cat)
                                                        <option value="{{$cat->cat_id}}">{{$cat->cat_name}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">SUB CATEGORY</label>
                                            <div class="col-sm-9">
                                                    <select class="form-control" id="sub_cat_id" name="sub_cat_id">
                                                        <option value="0">SELECT CATEGORY</option>
                                                        @foreach ($subCategory as $subcat)
                                                        <option value="{{$subcat->sub_cat_id}}">{{$subcat->sub_cat_name}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"></label>
                                                    <div class="col-sm-9">
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                    <label class="col-sm-9 col-form-label"></label>
                                                    <div class="col-sm-3">
                                                        <button class="btn btn-success" type="button" onclick="search();">Search</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>

                            
                    </div>
                    <div id="stock_details"></div>
                    <div class="ln_solid"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    function search(){
        $.ajax({
            type: "GET",
            url: "/stock_statement/search",
            data: {
                'tyre_id': $('#tyre_id').val(),
                'cat_id': $('#cat_id').val(),
                'sub_cat_id': $('#sub_cat_id').val()
            },
            cache: false,
            success: function (html) {
                $("#stock_details").html(html).show('slow');
            }
        });
    }
</script>
@endsection