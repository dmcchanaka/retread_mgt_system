@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>ORDER Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">ORDER Management</a></li>
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
                    <h2>ORDER Information<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group text-center">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="text-left">TYRE ORDER NO.</td>
                                        <td>:</td>
                                        <td class="text-left">{{$order->order_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">TYRE DATE</td>
                                        <td>:</td>
                                        <td class="text-left">{{$order->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">CUSTOMER</td>
                                        <td>:</td>
                                        <td class="text-left">{{$order->customer->customer_name}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="text-align: center">Tire Name </th>
                                    <th class="column-title" style="text-align: center">Price No. </th>
                                    <th class="column-title" style="text-align: center">Price </th>
                                    <th class="column-title" style="text-align: center">Qty. </th>
                                    <th class="column-title" style="text-align: center">Discount. </th>
                                    <th class="column-title" style="text-align: center">Amount </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $total_amt = 0;
                                foreach ($orderDetails as $data) {
                                    $line_amt = 0;
                                    $line_amt = ($data->qty*$data->price->cus_price)-(($data->qty*$data->price->cus_price) * $data->discount_per)/100;
                                    $total_amt += $line_amt;
                                    ?>
                                    <tr>
                                        <td style="text-align: left;padding-left: 3px">{{$data->tyre->tyre_name}}</td>
                                        <td style="text-align: left;padding-left: 3px">{{$data->price->price_no}}</td>
                                        <td style="text-align: right;padding-right: 3px">{{number_format($data->price->cus_price,2)}}</td>
                                        <td style="text-align: right;padding-right: 3px">{{$data->qty}}</td>
                                        <td style="text-align: right;padding-right: 3px">@if(isset($data->discount_per)){{$data->discount_per}} % @endif</td>
                                        <td style="text-align: right;padding-right: 3px">{{number_format($line_amt,2)}}</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: right"><b>Gross Amount :</b></td>
                                    <td style="text-align: right;padding-right: 3px"><b>{{number_format($total_amt,2)}}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right"><b>Discount  {{$order->discount_per}} <?php if(isset($order->discount_per)){echo '%'; } ?> :</b></td>
                                    <td style="text-align: right;padding-right: 3px"><b>{{number_format($order->discount,2)}}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right"><b>Net Amount :</b></td>
                                    <td style="text-align: right;padding-right: 3px"><b>{{number_format($total_amt - $order->discount,2)}}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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