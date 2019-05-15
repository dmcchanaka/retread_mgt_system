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
                        <li class="active">Invoice Summary</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>INVOICE SUMMARY REPORT</h2>
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
                                            <label class="col-sm-3 col-form-label">CUSTOMER</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="cus_id" name="cus_id">
                                                <option value="0">SELECT CUSTOMER</option>
                                                @foreach ($customer as $item)
                                                <option value="{{$item->cus_id}}">{{$item->customer_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">INVOICE NO</label>
                                            <div class="col-sm-9">
                                                    <select class="form-control" id="com_order_id" name="com_order_id">
                                                        <option value="0">SELECT INVOICE</option>
                                                        @foreach ($invoice as $inv)
                                                        <option value="{{$inv->com_order_id}}">{{$inv->com_order_no}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">DATE FROM</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control has-feedback-left" id="from_date">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">DATE TO</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control has-feedback-left" id="to_date">
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
                    <div id="invoice_details"></div>
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
            url: "/invoice_summary/search",
            data: {
                'cus_id': $('#cus_id').val(),
                'com_order_id': $('#com_order_id').val(),
                'from': $('#from_date').val(),
                'to': $('#to_date').val()
            },
            cache: false,
            success: function (html) {
                $("#invoice_details").html(html).show('slow');
            }
        });
    }
</script>
@endsection