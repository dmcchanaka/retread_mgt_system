@extends('layouts.app')
@section('css')
<link href="../css/jquery-ui.min.css" rel="stylesheet"/>
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>USER Permission Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-5">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Permission Management</a></li>
                        <li class="active">Assignment</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>USER Permission Information</h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div class="x_content">
                    <div class="x_panel">
                        <form class="form-horizontal form-label-left" action="{{url('add_permission')}}" method="post" name="permission_form" id="permission_form"">
                            @csrf
                            <div class="row profile_details text-center">
                                <div class="well profile_view">
                                    <div class="form-group">
                                        <label class="control-label col-md-5" for="">PERMISSION GROUP <span class="required"></span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" id="per_group" name="per_group" required="required" class="form-control col-md-2 col-xs-10">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5" for="">PAYMENT TYPE <span class="required"></span>
                                        </label>
                                        <div class="col-md-6">
                                            <select id="user_type" class="form-control" name="user_type">
                                                <option value="-1">Select User Type</option>
                                                @foreach ($userType as $ut)
                                                <option value="{{$ut->u_tp_id}}">{{$ut->user_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                      <div class="x_content">
                    
                                        <table class="table table-bordered table-striped jambo_table">
                                          <thead>
                                            <tr class="headings">
                                                <th>&nbsp;</th>
                                              <th>Permission Main Section</th>
                                              <th>Sub Section</th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                              @php
                                                $count = 0;  
                                              @endphp
                                              @foreach ($main_permission as $mp)
                                              @php
                                                $count++;  
                                              @endphp
                                              <tr>
                                              <th scope="row">{{$count}}</th>
                                                    <td style="text-align:left">{{$mp['section_name']}}
                                                    <input type="hidden" id="main_sec_id_{{$count}}" name="main_sec_id_{{$count}}" value="{{$mp['main_per_id']}}" />
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                    <input type="checkbox" id="main_ckbox_{{$count}}" name="main_ckbox_{{$count}}" onclick="handle_main_Click('<?php echo $count; ?>');"/>
                                                    <input type="hidden" id="main_status_{{$count}}" name="main_status_{{$count}}" value="0" />
                                                    </td>
                                                </tr>
                                                @php
                                                $sub_count = 0;
                                                @endphp
                                                @foreach ($mp['sub_section'] as $sub)
                                                @php
                                                $sub_count++;
                                                @endphp
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td style="text-align:left">{{$sub['sub_sec_name']}}
                                                    <input type="hidden" id="sub_sec_id_{{$count}}_{{$sub_count}}" name="sub_sec_id_{{$count}}_{{$sub_count}}" value="{{$sub['sub_sec_id']}}"/>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id="sub_ckbox_{{$count}}_{{$sub_count}}" name="sub_ckbox_{{$count}}_{{$sub_count}}"/>
                                                        <input type="hidden" id="sub_status_{{$count}}_{{$sub_count}}" name="sub_status_{{$count}}_{{$sub_count}}" value="0" />
                                                    </td>
                                                </tr>    
                                                @endforeach   
                                                <input type="hidden" id="sub_count_{{$count}}" name="sub_count_{{$count}}" value="{{$sub_count}}" />
                                              @endforeach
                                            <input type="hidden" id="main_count" name="main_count" value="{{$count}}" />
                                          </tbody>
                                        </table>
                    
                                      </div>
                                    </div>
                                </div>

                            </div>

                            

                            <div id="inv_dev">
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="button" id="add" class="btn btn-success" onclick="form_submit('add', 'payment_form')">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="ln_solid"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="../js/jquery-ui.min.js"></script>
<script type="text/javascript">
    function handle_main_Click(num){
        var check_status = document.getElementById("main_ckbox_" + num).checked;
        if ($('#per_group').val() === '' || parseFloat($('#per_group').val()) === 0) {
            alert('Please Enter Permission Group');
            document.getElementById("main_ckbox_" + num).checked = false;
            document.getElementById("main_status_" + num).value = 1;
            $('#per_group').focus();
        } else if($('#user_type').val()=== '-1'){
            alert('Please Select User Type');
            document.getElementById("main_ckbox_" + num).checked = false;
            document.getElementById("main_status_" + num).value = 0;
            $('#user_type').focus();
        } else {
            if (check_status === true) {
                for(var i = 1; i <= $('#sub_count_'+num).val(); i++){
                    document.getElementById("sub_ckbox_" + num +'_'+ i).checked = true;
                    document.getElementById("sub_status_" + num +'_'+ i).value = 1;
                }
            } else if (check_status === false){
                for(var i = 1; i <= $('#sub_count_'+num).val(); i++){
                    document.getElementById("sub_ckbox_" + num +'_'+ i).checked = false;
                    document.getElementById("sub_status_" + num +'_'+ i).value = 0;
                } 
            }
        }

    }

    function form_submit(button_id,form_id){
        document.getElementById(button_id).style.display = "none";
        document.forms[form_id].submit();
    }
</script>
@endsection

