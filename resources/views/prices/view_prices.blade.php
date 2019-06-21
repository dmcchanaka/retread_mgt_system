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
                    <h2>Price Information<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div style="padding-right:20px;text-align:right">
                    @foreach (Auth::user()->user_permission as $per)
                    @if($per->per_id == '20')
                    <button type="button" class="btn">
                    <a href="{{url('prices')}}" style="color:white"><span class="glyphicon glyphicon-plus" style="color:#5A738E"></span> Add New Price</a>
                    </button>
                    @endif
                    @endforeach
                </div>
                <div class="x_content">
                    <?php
                    if (sizeof($prices) > 0) {
                        ?>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                            <thead>
                                <tr class="headings">
                                    <th style="text-align: center">Tyre Name</th>
                                    <th style="text-align: center">Category</th>
                                    <th style="text-align: center">Sub Category</th>
                                    <th style="text-align: center">Price No</th>
                                    <th style="text-align: center">Received Price</th>
                                    <th style="text-align: center">Customer Price</th>
                                    <th style="text-align: center">Edit</th>
                                    <th style="text-align: center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($prices as $values)
                                  <tr>
                                  <td>{{$values->tyre->tyre_name}}</td>
                                  <td>{{$values->category->cat_name}}</td>
                                  <td>{{$values->subcategory->sub_cat_name}}</td>
                                  <td>{{$values->price_no}}</td>
                                  <td style="text-align:right">{{$values->rp_price}}</td>
                                  <td style="text-align:right">{{$values->cus_price}}</td>
                                  <td style="text-align: center;cursor: pointer">
                                    @foreach (Auth::user()->user_permission as $per)
                                    @if($per->per_id == '21')
                                    <span class="pull-right-container">
                                        <a href="{{url('edit_price', $values->price_id)}}"><i class="glyphicon glyphicon-pencil"></i></a> 
                                    </span>
                                    @endif
                                    @endforeach
                                </td>
                                <td style="text-align: center;cursor: pointer">
                                    @foreach (Auth::user()->user_permission as $per)
                                    @if($per->per_id == '22')
                                    <span class="pull-right-container">
                                        <a href="{{url('delete_price/'.$values->price_id)}}" data-method="delete"><i class="glyphicon glyphicon-trash"  style="color:red"></i></a>
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