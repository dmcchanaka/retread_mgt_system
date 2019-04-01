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
                    <h2>User Information<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div style="padding-right:20px;text-align:right">
                    <button type="button" class="btn">
                    <a href="{{url('users')}}" style="color:white"><span class="glyphicon glyphicon-plus" style="color:#5A738E"></span> Add New User</a>
                    </button>
                </div>
                <div class="x_content">
                    <?php
                    if (sizeof($users) > 0) {
                        ?>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                            <thead>
                                <tr class="headings">
                                    <th style="text-align: center">Name</th>
                                    <th style="text-align: center">User Type</th>
                                    <th style="text-align: center">NIC</th>
                                    <th style="text-align: center">Mobile No</th>
                                    <th style="text-align: center">Address</th>
                                    <th style="text-align: center">Edit</th>
                                    <th style="text-align: center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($users as $user) {
                                    ?>
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->userTypes->user_type}}</td>
                                        <td>{{$user->nic}}</td>
                                        <td>{{$user->mobile_no}}</td>
                                        <td>{{$user->address}}</td>
                                        <td style="text-align: center;cursor: pointer">
                                            <span class="pull-right-container">
                                                <a href="{{url('get_userdetails', $user->id)}}"><i class="glyphicon glyphicon-pencil"></i></a>
                                            </span>
                                        </td>
                                        <td style="text-align: center;cursor: pointer">
                                            <span class="pull-right-container">
                                                <a href="{{url('delete_user/'.$user->id)}}" data-method="delete"><i class="glyphicon glyphicon-trash"  style="color:red"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                <?php } ?>
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