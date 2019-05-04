@extends('layouts.app')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Stock Report<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form id="demo-form2" action="{{route('stock_report.filter')}}" method="post" class="form-horizontal form-label-left">
                        @csrf
                        <div class="col-md-12">
                        <div class="form-group col-md-6">
                            <label for="examplegender">Tyre</label>
                            <select class="form-control" id="t_type" name="t_type">
                                    <option value="0">Select Tyre</option>
                                @foreach ($tyre as $item)
                            <option value="{{$item->tyre_id}}">{{$item->tyre_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                                <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action sub_category_tbl" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="headings">
                                        <th style="text-align: center" class="column-title">Tyre</th>
                                        <th style="text-align: center" class="column-title">Remaining QTY</th>
                                        <th style="text-align: center" class="column-title">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                   @foreach ($stock as $key=>$items)
                                   @foreach ($items as $alldta)
                                   <tr>
                                        <td>{{$alldta->tyre->tyre_name}}</td>
                                        <td>{{$alldta->sum('remaining_qty')}}</td>
                                        <td>{{$alldta->price->cus_price}}</td>
                                        </tr>
                                   @endforeach
                                   @endforeach
                                </tbody>
                            </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
