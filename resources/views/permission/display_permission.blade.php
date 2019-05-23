@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>USER Permission</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">User Permission</a></li>
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
                    <h2>User Permission Information<small></small></h2>
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
                                        <td class="text-left">PERMISSION GROUP</td>
                                        <td>:</td>
                                        <td class="text-left">{{$permissionGroup->group_name}}</td>
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
                        <table class="table table-striped jambo_table bulk_action table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title" style="text-align: center">Main Section </th>
                                    <th class="column-title" style="text-align: center">Sub Section </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($userPermission as $item)
                                <tr>
                                    <td>{{$item['per_name']}}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @foreach ($item['subSection'] as $sub)
                                    <tr>
                                        <td>&nbsp;</td>
                                    <td>{{$sub['sub_per_name'].'-'.$sub['sub_per_id']}}</td>
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