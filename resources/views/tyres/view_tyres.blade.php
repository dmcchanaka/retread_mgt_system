@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>TYRE Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Tyre Management</a></li>
                        <li class="active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tyre Information<small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">


                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Tires</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Tread Categories</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Tread Sub Categories</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            @include('flash-message')
                            <div style="padding-right:20px;text-align:right">
                                @foreach (Auth::user()->user_permission as $per)
                                @if($per->per_id == '10')
                                <button type="button" class="btn">
                                    <a href="{{url('tyres')}}" style="color:white"><span class="glyphicon glyphicon-plus" style="color:#5A738E"></span> Add New Tyre</a>
                                </button>
                                @endif
                                @endforeach
                            </div>
                            @if (sizeof($tyres) > 0)
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="headings">
                                        <th style="text-align: center" class="column-title">Tyre Name</th>
                                        <th style="text-align: center" class="column-title">Size</th>
                                        <th style="text-align: center" class="column-title">Manufacturer Name</th>
                                        <th style="text-align: center" class="column-title">Edit</th>
                                        <th style="text-align: center" class="column-title">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tyres as $tt)
                                    <tr>
                                        <td>{{$tt->tyre_name}}</td>
                                        <td>{{$tt->tyre_size}}</td>
                                        <td>{{$tt->manufacture->manufacture_name}}</td>
                                        <td style="text-align: center;cursor: pointer">
                                            @foreach (Auth::user()->user_permission as $per)
                                            @if($per->per_id == '11')
                                            <span class="pull-right-container">
                                                <a href=""><i class="glyphicon glyphicon-pencil"></i></a>
                                            </span>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align: center;cursor: pointer">
                                            @foreach (Auth::user()->user_permission as $per)
                                            @if($per->per_id == '12')
                                            <span class="pull-right-container">
                                                <a href="" data-method="delete"><i class="glyphicon glyphicon-trash"  style="color:red"></i></a>
                                            </span>
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            @include('flash-message')
                            <div style="padding-right:20px;text-align:right">
                                @foreach (Auth::user()->user_permission as $per)
                                @if($per->per_id == '13')
                                <button type="button" class="btn">
                                    <a href="" data-toggle="modal" data-target="#myModalHorizontal" style="color:white"><span class="glyphicon glyphicon-plus" style="color:#5A738E"></span> Add New Tire Category</a>
                                </button>
                                @endif
                                @endforeach
                            </div>
                            <!-- Small modal -->
                            <!-- Modal -->
                            <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <button type="button" class="close"
                                                    data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel" align="center">
                                                Tread Category Registration
                                            </h4>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="modal-body">

                                            <form class="form-horizontal" action="" method="post" id="cat_form" role="form">
                                                @csrf
                                                <div class="form-group">
                                                    <label  class="col-sm-3 control-label"
                                                            for="cat_name">Category Name</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Enter Category Name"/>
                                                        <input type="hidden" id="cat_id" name="cat_id" value="" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">
                                                Close
                                            </button>
                                            <input id="tag-form-submit" type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /modals -->
                             @if (sizeof($beltCat) > 0)
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action category_tbl" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="headings">
                                        <th style="text-align: center" class="column-title">Tread Category Name</th>
                                        <th style="text-align: center" class="column-title">Edit</th>
                                        <th style="text-align: center" class="column-title">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beltCat as $cat)
                                    <tr id="{{$cat->cat_id}}">
                                        <td>{{$cat->cat_name}}</td>
                                        <td style="text-align: center;cursor: pointer">
                                            @foreach (Auth::user()->user_permission as $per)
                                            @if($per->per_id == '14')
                                            <span class="pull-right-container">
                                            <a href="#" class="popup_edit" id="{{$cat->cat_id}}" ><i class="glyphicon glyphicon-pencil"></i></a>
                                            </span>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align: center;cursor: pointer">
                                            @foreach (Auth::user()->user_permission as $per)
                                            @if($per->per_id == '15')
                                            <span class="pull-right-container">
                                            <a class="delete_record" id="{{$cat->cat_id}}" ><i class="glyphicon glyphicon-trash"  style="color:red"></i></a>
                                            </span>
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            @include('flash-message')
                            <div style="padding-right:20px;text-align:right">
                                @foreach (Auth::user()->user_permission as $per)
                                @if($per->per_id == '16')
                                <button type="button" class="btn">
                                    <a href="" data-toggle="modal" data-target="#myModalHorizontal_two" style="color:white"><span class="glyphicon glyphicon-plus" style="color:#5A738E"></span> Add New Tire Category</a>
                                </button>
                                @endif
                                @endforeach
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="myModalHorizontal_two" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <button type="button" class="close"
                                                    data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel" align="center">
                                                Tread Sub Category Registration
                                            </h4>
                                        </div>
                                        <!-- Modal Body -->
                                        <div class="modal-body">

                                            <form class="form-horizontal_two" method="post" id="subcat_form" role="form">
                                                @csrf
                                                <div class="form-group">
                                                    <label  class="col-sm-4 control-label"
                                                            for="sub_cat_name">Category Name</label>
                                                    <div class="col-sm-6">
                                                        <select id="catogory_id" name="catogory_id" class="form-control">
                                                            @foreach ($beltCat as $value)
                                                             <option value="{{$value->cat_id}}">{{ $value->cat_name}}</option>  
                                                            @endforeach
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label  class="col-sm-4 control-label"
                                                            for="cat_name">Sub Category Name</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="sub_cat_name" name="sub_cat_name" placeholder="Enter Sub Category Name"/>
                                                        <input type="hidden" id="sub_cat_id" name="sub_cat_id" value="" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">
                                                Close
                                            </button>
                                            <input id="tag-form-submit_two" type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /modals -->
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action sub_category_tbl" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="headings">
                                        <th style="text-align: center" class="column-title">Category Name</th>
                                        <th style="text-align: center" class="column-title">Tread Sub Category Name</th>
                                        <th style="text-align: center" class="column-title">Edit</th>
                                        <th style="text-align: center" class="column-title">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beltSubCat as $subcat)
                                    <tr id="{{$subcat->sub_cat_id}}">
                                        <td>{{$subcat->belt_category->cat_name}}</td>
                                        <td>{{$subcat->sub_cat_name}}</td>
                                        <td style="text-align: center;cursor: pointer">
                                            @foreach (Auth::user()->user_permission as $per)
                                            @if($per->per_id == '17')
                                            <span class="pull-right-container">
                                            <a href="#" class="sub_category_edit" id="{{$subcat->sub_cat_id}}" ><i class="glyphicon glyphicon-pencil"></i></a>
                                            </span>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align: center;cursor: pointer">
                                            @foreach (Auth::user()->user_permission as $per)
                                            @if($per->per_id == '18')
                                            <span class="pull-right-container">
                                            <a class="delete_record" id="{{$subcat->sub_cat_id}}" ><i class="glyphicon glyphicon-trash"  style="color:red"></i></a>
                                            </span>
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
<script src="../js/jquery-ui.min.js"></script>
<script type="text/javascript">
/* CATEGORY REGISTRATION & UPDATE*/
                                                $('#tag-form-submit').on('click', function (e) {
                                                    if($('#cat_id').val() == ''){
                                                    e.preventDefault();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "/add_category",
                                                        data: $('form.form-horizontal').serialize(),
                                                        success: function (data) {
                                                            console.log(data);
//                                                            $('#tab_content2').html(data);

                                                            $('.category_tbl').append('<tr id="'+data.cat_id+'">'
                                                                    +'<td>'+data.cat_name+'</td>'
                                                                    +'<td style="text-align: center;cursor: pointer">'
                                                                        +'<span class="pull-right-container">'
                                                                            +'<a href="" class="popup_edit" id="'+data.cat_id+'"><i class="glyphicon glyphicon-pencil"></i></a>'
                                                                        +'</span>'
                                                                    +'</td>'
                                                                    +'<td style="text-align: center;cursor: pointer">'
                                                                        +'<span class="pull-right-container">'
                                                                            +'<a href="" class="delete_record" id="'+data.cat_id+'"><i class="glyphicon glyphicon-trash"  style="color:red"></i></a>'
                                                                        +'</span>'
                                                                    +'</td>'
                                                                    +'</tr>'
                                                                    );
                                                        },
                                                        error: function () {
                                                            alert('Error');
                                                        }
                                                    });
                                                    $('#myModalHorizontal').modal('toggle');
                                                    return false;
                                                    }else{
                                                      
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "/update_category",
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            cat_id : $('#cat_id').val(),
                                                            cat_name: $('#cat_name').val()
                                                        },
                                                        success: function (data) {
                                                            console.log(data);
                                                        },
                                                        error: function () {
                                                            alert('Error');
                                                        }
                                                    });
                                                    $('#myModalHorizontal').modal('toggle');
                                                    return false;
                                                    }
                                                });
                                                /*END OF CATEGORY REGISTRATION & UPDATE*/
                                                /* EDIT CATEGORY*/
                                                $(".popup_edit").click(function() {
                                                    var id = $(this).attr('id');
                                                    $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        $.ajax({
                                                            type: "GET",
                                                            url: '/tyres/edit',
                                                            data: {
                                                                id: id
                                                            },
                                                            success: function (data) {
                                                                console.log(data);
                                                                $('#myModalHorizontal').modal('show');
                                                                $('#cat_name').val(data.cat_name);
                                                                $('#cat_id').val(data.cat_id);
                                                            }
                                                        });
                                                });
                                                /*END OF EDIT CATEGORY*/
                                                /*DELETE CATEGORY*/
                                                $('.delete_record').click(function() {
                                                    var id = $(this).attr('id');
                                                    $.ajax({
                                                        type: "GET",
                                                        url: 'delete_tyer/'+id,
                                                        success: function (data) {
                                                            console.log(data);
                                                            $(this).closest( "tr" ).remove();
                                                        },
                                                        error: function () {
                                                            alert('Error');
                                                        }
                                                    });
                                                });
                                                /*END OF DELETE CATEGORY*/
                                                /*SUB CATEGORY REGISTRATION AND UPDATE*/
                                        $('#tag-form-submit_two').on('click', function (e) {
                                            e.preventDefault();
                                                    if($('#sub_cat_id').val() == ''){
                                                        console.log('sssssssss');
                                                    e.preventDefault();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "/add_subcatogory",
                                                        data: $('form.form-horizontal_two').serialize(),
                                                        success: function (data) {

                                                            $('.sub_category_tbl').append('<tr id="'+data.sub_cat_id+'">'
                                                                    +'<td>'+data.belt_category.cat_name+'</td>'
                                                                    +'<td>'+data.sub_cat_name+'</td>'
                                                                    +'<td style="text-align: center;cursor: pointer">'
                                                                        +'<span class="pull-right-container">'
                                                                            +'<a href="" class="popup_edit" id="'+data.sub_cat_id+'"><i class="glyphicon glyphicon-pencil"></i></a>'
                                                                        +'</span>'
                                                                    +'</td>'
                                                                    +'<td style="text-align: center;cursor: pointer">'
                                                                        +'<span class="pull-right-container">'
                                                                            +'<a href="" class="delete_record" id="'+data.sub_cat_id+'"><i class="glyphicon glyphicon-trash"  style="color:red"></i></a>'
                                                                        +'</span>'
                                                                    +'</td>'
                                                                    +'</tr>'
                                                                    );
                                                        },
                                                        error: function () {
                                                            alert('Error');
                                                        }
                                                    });
                                                    $('#myModalHorizontal_two').modal('toggle');
                                                    return false;
                                                    }else{
                                                      console.log('false');
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "/update_sub_category",
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            sub_cat_id : $('#sub_cat_id').val(),
                                                            sub_cat_name : $('#sub_cat_name').val(),
                                                            catogory_id: $('#catogory_id').val()
                                                        },
                                                        success: function (data) {
                                                            console.log(data);
                                                        },
                                                        error: function () {
                                                            alert('Error');
                                                        }
                                                    });
                                                    $('#myModalHorizontal_two').modal('toggle');
                                                    return false;
                                                    }
                                                });

                                                /* EDIT SUB CATEGORY*/
                                                $(".sub_category_edit").click(function() {
                                                    var id = $(this).attr('id');
                                                    $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        $.ajax({
                                                            type: "GET",
                                                            url: '/tyres/sub_cat_edit',
                                                            data: {
                                                                id: id
                                                            },
                                                            success: function (data) {
                                                                console.log(data);
                                                                $('#myModalHorizontal_two').modal('show');
                                                                $('#sub_cat_name').val(data.sub_cat_name);
                                                                $('#sub_cat_id').val(data.sub_cat_id);
                                                            }
                                                        });
                                                });
                                                /*END OF EDIT SUB CATEGORY*/


</script>
@endsection
