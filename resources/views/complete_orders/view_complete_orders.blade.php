@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3> COMPLETE Order Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-5">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Complete Order Management</a></li>
                        <li class="active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Complete Order Information<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div class="x_content">
                    <?php
                   if (sizeof($complete_orders) > 0) {
                       ?>
                       <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                        <thead>
                            <tr class="headings">
                                <th style="text-align: center">Complete Order Number</th>
                                <th style="text-align: center">Order Number</th>
                                <th style="text-align: center">Customer</th>
                                <th style="text-align: center">Address</th>
                                <th style="text-align: center">Gross Amount</th>
                                <th style="text-align: center">Discount(%)</th>
                                <th style="text-align: center">Net Amount</th>
                                <th style="text-align: center">View</th>
                                <th style="text-align: center">Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complete_orders as $values)
                            <tr>
                                <td>{{$values->com_order_no}}</td>
                                <td>{{$values->tyre_order->order_no}}</td>
                                <td>{{$values->customer->customer_name}}</td>
                                <td>{{$values->customer->address}}</td>
                                <td style="text-align:right;padding-right:5px">{{number_format($values->com_order_amount,2)}}</td>
                                <td style="text-align:right;padding-right:5px">{{number_format($values->discount_per,2)}}</td>
                                <td style="text-align:right;padding-right:5px">{{number_format($values->com_order_amount-$values->discount,2)}}</td>
                                <td style="text-align: center;cursor: pointer">
                                    @foreach (Auth::user()->user_permission as $per)
                                    @if($per->per_id == '34')
                                    <span class="pull-right-container">@if($values->complete_status != '1')
                                        <a href="{{url('display_completeorder', $values->com_order_id)}}" target="_blank"><i class="glyphicon glyphicon-modal-window"></i></a>
                                    @endif</span>
                                    @endif
                                    @endforeach
                                </td>
                                <td style="text-align: center;cursor: pointer">
                                    @foreach (Auth::user()->user_permission as $per)
                                    @if($per->per_id == '35')
                                    <span class="pull-right-container">
                                        <a href="{{url('print_invoice',$values->com_order_id )}}" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                                    </span>
                                    @endif
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                       </table>
                    <?php } ?>
                </div>
            </div>
        </div>   
    </div>

</div>
@endsection

@section('js')
<!--javascript code-->
<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
@endsection