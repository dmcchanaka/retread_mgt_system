@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>PAYMENT Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Payment Management</a></li>
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
                    <h2>Payment Information<small></small></h2>
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
                                        <td class="text-left">PAYMENT NO.</td>
                                        <td>:</td>
                                        <td class="text-left">{{$payment->pay_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">PAYMENT DATE</td>
                                        <td>:</td>
                                        <td class="text-left">{{$payment->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">CUSTOMER</td>
                                        <td>:</td>
                                        <td class="text-left">{{$payment->customer->customer_name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">PAYMENT TYPE</td>
                                        <td>:</td>
                                        <td class="text-left">{{($payment->pay_type==0)?'Cash':'Cheque'}}</td>
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
                                    <th class="column-title" style="text-align: center">Complete Order No </th>
                                    <th class="column-title" style="text-align: center">Paid AMount </th>
                                </tr>
                            </thead>
                            @foreach ($paymentDetails as $pay)
                                <tr>
                                <td>{{$pay->com_order_no}}</td>
                                <td style="text-align:right">{{number_format($pay->paid_amount,2)}}</td>
                                </tr>
                            @endforeach
                            <tbody>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div><br>
                    @if (sizeof($paymentCheque)>0)
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th colspan="5" class="column-title" style="text-align: center">Cheque Details </th>
                                </tr>
                                <tr class="headings">
                                    <th class="column-title" style="text-align: center">Cheque No </th>
                                    <th class="column-title" style="text-align: center">Bank </th>
                                    <th class="column-title" style="text-align: center">Branch </th>
                                    <th class="column-title" style="text-align: center">Bank Date </th>
                                </tr>
                            </thead>
                            @foreach ($paymentCheque as $chq)
                                <tr>
                                <td>{{$chq->cheque_no}}</td>
                                <td>{{$chq->bank}}</td>
                                <td>{{$chq->branch}}</td>
                                <td>{{date('Y-m-d',strtotime($chq->cheque_date))}}</td>
                                </tr>
                            @endforeach
                            <tbody>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                    @endif
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