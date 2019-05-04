@extends('layouts.app')
@section('css') 
<link href="../css/jquery-ui.min.css" rel="stylesheet"/>
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>TYRE Complete Order Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-4">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Complete Order Management</a></li>
                        <li class="active">Registration</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>TYRE Complete Order Information</h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div class="x_content">
                    <div class="x_panel">
                        <form class="form-horizontal form-label-left" action="{{url('add_completeorder')}}" method="post" name="com_order_form" id="com_order_form" onsubmit="com_order_validation();">
                            @csrf
                            <div class="row">
                                <div class="col-md-9 col-xs-9">
                                    <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-5" for="">DATE. <span class="required"></span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" required="required" value="{{ date('Y-m-d')}}" class="form-control col-md-2 col-xs-10" readonly="true">
                                                <input type="hidden" id="date" name="date" value="{{ date('Y-m-d')}}" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-5" for="">CUSTOMER <span class="required"></span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" id="cus_name" required="required" class="form-control col-md-2 col-xs-10" value="{{$order[0]['cus_name']}}" readonly="true">
                                                <input type="hidden" id="cus_id" name="cus_id" value="{{$order[0]['cus_id']}}" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-5" for="">ORDER NO. <span class="required"></span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" id="o_no" required="required" class="form-control col-md-2 col-xs-10" value="{{$order[0]['order_no']}}" readonly="true">
                                                <input type="hidden" id="order_id" name="order_id" value="{{$order[0]['order_id']}}" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-5" for="">COMPLETE ORDER NO. <span class="required"></span>
                                            </label>
                                            <?php
                                            $com_number = 1;
                                            if ($com_order_no == 0) {
                                                $com_number = 'TYRE/COM/ORDER/1';
                                            } else {
                                                $com_number = $com_order_no + 1;
                                                $com_number = 'TYRE/COM/ORDER/' . $com_number;
                                            }
                                            ?>
                                            <div class="col-md-6">
                                                <input type="text" id="o_no" required="required" class="form-control col-md-2 col-xs-10" value="{{$com_number}}" readonly="true">
                                                <input type="hidden" id="complete_no" name="complete_no" value="{{$com_number}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action" id="price_table">
                                    <thead>
                                        <tr class="headings">
                                            <th>&nbsp;</th>
                                            <th class="column-title">Tyre Description </th>
                                            <th class="column-title">Category </th>
                                            <th class="column-title">Sub Category </th>
                                            <th class="column-title">Price. </th>
                                            <th class="column-title">Serial No. </th>
                                            <th class="column-title">Quantity </th>
                                            <th class="column-title">Discount (%)</th>
                                            <th class="column-title">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                        $count = 0;
                                        $gross_amt = 0;
                                        @endphp
                                        @foreach ($orderDetails as $data)
                                        @php
                                        $line_amount = (($data['qty'] * $data['cus_price']) - (($data['qty'] * $data['cus_price'])/100) * $data['discount_per']);
                                        $gross_amt += $line_amount;
                                        $count++;
                                        @endphp
                                        @if ($data['qty'] > $data['product_stock'])
                                        <tr style="background-color:#FEDAF4" id="tr_msg_{{$count}}">
                                            <td colspan="9" style="color:#F00;text-align:center" id="td_{{$count}}"><?php echo "Unable to issue " . ($data['qty']) . " quantity , Because avaliable quantity is " . $data['product_stock']; ?></td>
                                        </tr>
                                        <tr class="even pointer" id="tr_{{$count}}">
                                            <td class="a-center ">
                                                <span class="glyphicon glyphicon-remove" style="cursor: pointer;color: red" id="remove_btn_{{$count}}" onclick="remove_item('{{$data['op_id']}}','{{$count}}');"></span>
                                            </td>
                                            <td>
                                                <input type="text" id="tyre_names_{{$count}}" name="tyre_names_{{$count}}" class="col-md-12" value="{{$data['tyre_name']}}"/>
                                                <input type="hidden" id="tyre_id_{{$count}}" name="tyre_id_{{$count}}" value="{{$data['tyre_id']}}" />
                                                <input type="hidden" id="active_status_{{$count}}" name="active_status_{{$count}}" value="1" />
                                            </td>
                                            <td class=" ">
                                                <select id="cat_id_{{$count}}" name="cat_id_{{$count}}" onchange="load_sub_category('{{$count}}');">
                                                    <option value="">CATEGORY</option>
                                                    @foreach ($category as $cat)
                                                    <option value="{{$cat->cat_id}}" <?php
                                                    if ($cat->cat_id == $data['cat_id']) {
                                                        echo 'selected';
                                                    }
                                                    ?>>{{$cat->cat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" ">
                                                <select id="sub_cat_id_{{$count}}" name="sub_cat_id_{{$count}}" onchange="load_price_no('{{$count}}');">
                                                    <option value="">SUB CATEGORY</option>
                                                    @foreach ($subCat as $sc)
                                                    <option value="{{$sc->sub_cat_id}}" <?php
                                                    if ($sc->sub_cat_id == $data['sub_cat_id']) {
                                                        echo 'selected';
                                                    }
                                                    ?>>{{$sc->sub_cat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" " style="text-align: center">
                                                <select id="price_no_{{$count}}" name="price_no_{{$count}}" onchange="load_cus_price('{{$count}}');">
                                                    <option>CUS PRICE</option>
                                                </select>
                                                <input type="hidden" style="text-align: right;padding-right: 3px" id="cus_price_{{$count}}" name="cus_price_{{$count}}" value="" size="10" />
                                                <input type="hidden" id="price_id_{{$count}}" name="price_id_{{$count}}" value="{{$data['price_id']}}" />
                                            </td>
                                            <td class=" ">
                                                <input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="serial_{{$count}}" name="serial_{{$count}}" value="{{$data['serial_no']}}" size="10" />
                                            </td>
                                            <td class=" ">
                                                <input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="qty_{{$count}}" name="qty_{{$count}}" value="{{$data['qty']}}" onkeyup="check_qty(event, '{{$count}}');" size="5" />
                                            </td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="discount_{{$count}}" name="discount_{{$count}}" value="{{number_format($data['discount_per'])}}" onkeyup="calc_amount();" size="5" /></td>
                                            <td class="" style="text-align: center">
                                                <input type="text" style="text-align: right;padding-right: 3px" id="amount_{{$count}}" value="{{number_format($line_amount,2)}}" size="10"/>
                                                <input type="hidden" id="line_amt_{{$count}}" name="line_amt_{{$count}}" value="{{$line_amount}}" />
                                            </td>
                                        </tr>
                                        @else 
                                        <tr class="even pointer" id="tr_{{$count}}">
                                            <td>&nbsp;</td>
                                            <td>
                                                <input type="text" id="tyre_names_{{$count}}" name="tyre_names_{{$count}}" class="col-md-12" value="{{$data['tyre_name']}}" readonly="true"/>
                                                <input type="hidden" id="tyre_id_{{$count}}" name="tyre_id_{{$count}}" value="{{$data['tyre_id']}}" />
                                                <input type="hidden" id="active_status_{{$count}}" name="active_status_{{$count}}" value="0" />
                                            </td>
                                            <td>
                                                <input type="text" id="cat_name_{{$count}}" name="cat_name_{{$count}}" value="{{$data['cat_name']}}" size="8" readonly="true" />
                                                <input type="hidden" id="cat_id_{{$count}}" name="cat_id_{{$count}}" value="{{$data['cat_id']}}" />
                                            </td>
                                            <td>
                                                <input type="text" id="sub_cat_name_{{$count}}" name="sub_cat_name_{{$count}}" value="{{$data['sub_cat_name']}}" size="10" readonly="true" />
                                                <input type="hidden" id="sub_cat_id_{{$count}}" name="sub_cat_id_{{$count}}" value="{{$data['sub_cat_id']}}" />
                                            </td>
                                            <td style="text-align: right">
                                                <input type="text" style="text-align: right;padding-right: 3px" id="cus_price_{{$count}}" name="cus_price_{{$count}}" value="{{number_format($data['cus_price'],2)}}" size="10" readonly="true" />
                                                <input type="hidden" id="price_id_{{$count}}" name="price_id_{{$count}}" value="{{$data['price_id']}}" />
                                            </td>
                                            <td class=" ">
                                                <input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="serial_{{$count}}" name="serial_{{$count}}" value="{{$data['serial_no']}}" size="15" />
                                            </td>
                                            <td style="text-align: center">
                                                <input type="text" style="text-align: right;padding-right: 3px" value="{{number_format($data['qty'])}}" size="5"/>
                                                <input type="hidden" id="qty_{{$count}}" name="qty_{{$count}}" value="{{$data['qty']}}" />
                                            </td>
                                            <td style="text-align: center">
                                                <input type="text" style="text-align: right;padding-right: 3px" value="{{number_format($data['discount_per'])}}" size="7"/>
                                                <input type="hidden" id="discount_{{$count}}" name="discount_{{$count}}" value="{{$data['discount_per']}}" />
                                            </td>
                                            <td style="text-align: center">
                                                <input type="text" style="text-align: right;padding-right: 3px" id="amount_{{$count}}" value="{{number_format($line_amount,2)}}" size="10"/>
                                                <input type="hidden" id="line_amt_{{$count}}" name="line_amt_{{$count}}" value="{{$line_amount}}" />
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    <input type="hidden" id="item_count" name="item_count" value="{{$count}}" />
                                    @php 
                                    $net_amount = round((($gross_amt) - ($gross_amt / 100) * $order[0]['discount_per']), 2);
                                    @endphp
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td style="padding-top: 20px;text-align: right">Gross Amount</td>
                                            <td colspan="1" style="text-align: right;padding-right: 5px">
                                                <input type="text" style="text-align: right;padding-right: 5px" id="tot_amount" name="tot_amount" value="{{number_format($gross_amt,2)}}" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td style="padding-top: 20px;text-align: right">Discount (%)</td>
                                            <td colspan="1" style="text-align: right;padding-right: 5px">
                                                <input type="text" style="text-align: right;padding-right: 5px" id="whole_dis" name="whole_dis" onkeyup="calc_amount();" value="{{$order[0]['discount_per']}}" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td style="padding-top: 20px;text-align: right">Net Amount</td>
                                            <td colspan="1" style="text-align: right;padding-right: 5px">
                                                <input type="text" style="text-align: right;padding-right: 5px" id="net_amount" name="net_amount" value="{{number_format($net_amount,2)}}" >
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="button" id="add" class="btn btn-success" onclick="form_submit('add', 'com_order_form')">Submit</button>
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
<!-- Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1" role="dialog"
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
                    Order Cancellation
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">

                <form class="form-horizontal_two" method="post" id="reason_form" role="form">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="order_pro_id" name="order_pro_id" value="" />
                        <input type="hidden" id="row_num" name="row_num" value="" />
                        <label  class="col-sm-4 control-label"
                                for="reason_name">Reason</label>
                        <div class="col-sm-6">
                            <select id="rsn_id" name="rsn_id" class="form-control">
                                @foreach ($reason as $rsn)
                                <option value="{{$rsn->rsn_id}}">{{ $rsn->rsn_name}}</option>  
                                @endforeach
                            </select> 
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
                <input id="tag-form-submit_reason" type="submit" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </div>
</div>
<!-- /modals -->
@endsection
@section('js')
<script type="text/javascript">
                                            function com_order_validation(){
                                                valid = true;
                                                if ($('#cus_name').val() == "" || $('#cus_id').val() == "") {
                                                    valid = false;
                                                    alert("Enter Customer Name");
                                                    $('#cus_name').focus();
                                                } else {
                                                    var m = 1;
                                                    for (m = 1; m <= parseFloat($('#item_count').val()); m++) {
                                                        if (document.getElementById('tyre_names_' + m) && ($('#tyre_id_' + m).val() == "")) {
                                                            valid = false;
                                                            alert("Select Tyre");
                                                            $('#tyre_names_' + m).focus();
                                                            break;
                                                        } else if (document.getElementById('cat_id_' + m) && ($('#cat_id_' + m).val() == "")) {
                                                            valid = false;
                                                            alert("Select Category");
                                                            $('#cat_id_' + m).focus();
                                                            break;
                                                        } else if (document.getElementById('sub_cat_id_' + m) && ($('#sub_cat_id_' + m).val() == "")) {
                                                            valid = false;
                                                            alert("Select Sub Category");
                                                            $('#sub_cat_id_' + m).focus();
                                                            break;
                                                        } else if (document.getElementById('cus_price_' + m) && ($('#price_id_' + m).val() == "")) {
                                                            valid = false;
                                                            alert("Select Customer Price");
                                                            $('#price_no_' + m).focus();
                                                            break;
                                                        } else if (document.getElementById('serial_' + m) && ($('#serial_' + m).val() == "")) {
                                                            valid = false;
                                                            alert("Enter Tyre Serial Number");
                                                            $('#serial_' + m).focus();
                                                            break;
                                                        } else if (document.getElementById('tyre_id_' + m) && $('#qty_' + m).val() == "") {
                                                            valid = false;
                                                            alert("Enter Quantity");
                                                            $('#qty_' + m).focus();
                                                            break;
                                                        } else if (document.getElementById('tyre_id_' + m) && !$('#qty_' + m).val().match(/^(\d+)$/)) {
                                                            valid = false;
                                                            alert("Enter Valid Quantity");
                                                            $('#qty_' + m).focus();
                                                            break;
                                                        } else if (document.getElementById('active_status_' + m) && $('#active_status_' + m).val() == "1") {
                                                            valid = false;
                                                            alert("Unable to save order. because available stock is not enough");
                                                            break; 
                                                        }
                                                    }
                                                }
                                                return valid;
                                            }
                                            function form_submit(button_id, form_id) {
                                                if (com_order_validation()) {
                                                    document.getElementById(button_id).style.display = "none";
                                                    document.forms[form_id].submit();
                                                }
                                            }
                                            
                                            function check_qty(evt, i) {
                                                var keyCode;
                                                if ("which" in evt) {// NN4 & FF &amp; Opera
                                                    keyCode = evt.which;
                                                } else if ("keyCode" in evt) {// Safari & IE4+
                                                    keyCode = evt.keyCode;
                                                } else if ("keyCode" in window.event) {// IE4+
                                                    keyCode = window.event.keyCode;
                                                } else if ("which" in window.event) {
                                                    keyCode = evt.which;
                                                } else {
                                                    //alert("the browser don't support");  
                                                }
                                                if (keyCode == 16) {// press Enter
                                                    gen_item();
                                                }
                                                if (!$('#qty_' + i).val().match(/^(\d+)$/) && $('#qty_' + i).val() != "") {
                                                    alert("Enter valid Number");
                                                } else if ($('#qty_' + i).val() > 1) {
                                                    alert("You cannot access to enter more than one Quantity for one serial");
                                                    $('#qty_' + i).val(1);
                                                } else if ($('#cat_id_' + i).val() === "") {
                                                    alert("Select Category");
                                                    document.getElementById("cat_id_" + i).style.borderColor = "red";
                                                    $('#cat_id_' + i).focus();
                                                    $('#qty_' + i).val(0);
                                                } else if ($('#sub_cat_id_' + i).val() === "") {
                                                    alert("Select Sub Category");
                                                    document.getElementById("sub_cat_id_" + i).style.borderColor = "red";
                                                    $('#sub_cat_id_' + i).focus();
                                                    $('#qty_' + i).val(0);
                                                } else if ($('#price_no_' + i).val() === "") {
                                                    alert("Select Price No.");
                                                    document.getElementById("price_no_" + i).style.borderColor = "red";
                                                    $('#price_no_' + i).focus();
                                                    $('#qty_' + i).val(0);
                                                }
                                                calc_amount();
                                            }
                                            
                                            function calc_amount() {
                                                var i = 1;
                                                var tot_amount = 0;
                                                for (i = 1; i <= parseFloat($('#item_count').val()); i++) {
                                                    var discount = 0;
                                                    if ((!$('#discount_' + i).val().match(/^\d+(\.\d{0,1})?$/) || parseFloat($('#discount_' + i).val()) > 100) && $('#discount_' + i).val() != "") {
                                                        alert("Enter Valid Discount");
                                                        $('#discount_' + i).val(0);
                                                    } else if (parseFloat($('#discount_' + i).val()) > 0) {
                                                        discount = parseFloat($('#discount_' + i).val());
                                                    }
                                                    if (document.getElementById('tyre_id_' + i) && $('#qty_' + i).val().match(/^(\d+)$/) && $('#qty_' + i).val() != "") {
                                                        if ($('#qty_' + i).val() > 0 && parseFloat($('#cus_price_' + i).val()) != '' && $('#active_status_' + i).val() != '2') {
                                                            var line_amount = (parseFloat($('#qty_' + i).val()) * parseFloat($('#cus_price_' + i).val()) * (100 - discount)) / 100;
                                                        } else {
                                                            var line_amount = 0;
                                                        }
                                                        if(!isNaN(line_amount)){
                                                        tot_amount += line_amount;
                                                        }
//                                                             console.log('line ' + line_amount + 'gnd ' + tot_amount);
                                                        $('#amount_' + i).val(line_amount.formatMoney(2, '.', ','));
                                                        $('#line_amt_' + i).val(line_amount.formatMoney(2, '.', ','));
                                                    } else {
                                                        $('#qty_' + i).val(0);
                                                        $('#amount_' + i).val(0);
                                                    }
                                                }
                                                $('#tot_amount').val(tot_amount.formatMoney(2, '.', ','));
                                                var net_amount = tot_amount;
                                                if ($('#whole_dis').val() == "") {
                                                    $('#whole_dis').val(0);
                                                } else if (!$('#whole_dis').val().match(/^\d+(\.\d{0,1})?$/)) {
                                                    alert("Enter Valid Discount");
                                                    $('#whole_dis').val(0);
                                                } else {
                                                    net_amount = (tot_amount * (100 - parseFloat($('#whole_dis').val()))) / 100;
                                                }
                                                $('#net_amount').val(net_amount.formatMoney(2, '.', ','));
                                            }
                                            
                                            Number.prototype.formatMoney = function (c, d, t) {
                                                var n = this,
                                                        c = isNaN(c = Math.abs(c)) ? 2 : c,
                                                        d = d == undefined ? "." : d,
                                                        t = t == undefined ? "," : t,
                                                        s = n < 0 ? "-" : "",
                                                        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
                                                        j = (j = i.length) > 3 ? j % 3 : 0;
                                                return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
                                            };
                                            
                                            /*LOAD TYRE SUB CATEGORIES*/
                                            function load_sub_category(num) {
                                            $.ajaxSetup({
                                            headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                            });
                                                    var cat_id = $('#cat_id_' + num).val();
                                                    var tyre_id = $('#tyre_id_' + num).val();
                                                    $.ajax({
                                                    type: "GET",
                                                            url: '/tyres/sub_category',
                                                            data: {
                                                            cat_id: cat_id,
                                                                    tyre_id: tyre_id
                                                            },
                                                            success: function (data) {
                                                            if (data.length > 0) {
                                                            $('#sub_cat_id_' + num).empty();
                                                                    $('#sub_cat_id_' + num).append('<option value="">SUB CATEGORY</option>');
                                                                    for (var i = 0; i < data.length; i++) {
                                                            $('#sub_cat_id_' + num).append('<option value=' + data[i].sub_cat_id + '>' + data[i].sub_cat_name + '</option>');
                                                            }
                                                            } else {
                                                            $('#sub_cat_id_' + num).empty();
                                                                    $('#sub_cat_id_' + num).append('<option value="">SUB CATEGORY</option>');
                                                            }
                                                            }
                                                    });
                                            }
                                            /*LOAD BATCH NUMBER*/
                                            function load_price_no(num) {
                                            $.ajaxSetup({
                                            headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                            });
                                                    var sub_cat_id = $('#sub_cat_id_' + num).val();
                                                    var cat_id = $('#cat_id_' + num).val();
                                                    var tyre_id = $('#tyre_id_' + num).val();
                                                    $.ajax({
                                                    type: "GET",
                                                            url: '/tyres/batch_numbers',
                                                            data: {
                                                            'sub_cat_id': sub_cat_id,
                                                                    'cat_id':cat_id,
                                                                    'tyre_id':tyre_id
                                                            },
                                                            success: function (data) {
                                                            if (data.length > 0) {
                                                            $('#price_no_' + num).empty();
                                                            $('#cus_price_' + num).val('');
                                                            $('#price_id_' + num).val('');
                                                                    $('#price_no_' + num).append('<option value="">CUS PRICE</option>');
                                                                    for (var i = 0; i < data.length; i++) {
                                                            $('#price_no_' + num).append('<option value=' + data[i].price_id + '>' + data[i].cus_price + '</option>');
                                                            }
                                                            } else {
                                                            $('#price_no_' + num).empty();
                                                                    $('#price_no_' + num).append('<option value="">CUS PRICE</option>');
                                                            }
                                                            }
                                                    });
                                                    setTimeout(function(){ calc_amount(); }, 1000);
                                            }
                                            /*LOAD PRICES*/
                                            function load_cus_price(num) {
                                            $.ajaxSetup({
                                            headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                            });
                                                    var price_no = $('#price_no_' + num).val();
                                                    $.ajax({
                                                    type: "GET",
                                                            url: '/tyres/cus_prices',
                                                            data: {
                                                            batch_id: price_no
                                                            },
                                                            success: function (data) {
                                                            $('#price_id_3' + num).empty();
                                                                    if (data.length > 0) {
                                                            var price = data[0].cus_price;
                                                                    var price_id = data[0].price_id;
                                                                    $('#price_id_' + num).val(price_id);
                                                                    $('#cus_price_' + num).val(price);
                                                                    stock_avalilability(num);
                                                            } else {
                                                            $('#price_id_' + num).val(price_id);
                                                                    $('#cus_price_' + num).val(0);
                                                            }

                                                            }
                                                    });
                                                    setTimeout(function(){ calc_amount(); }, 1000);
                                            }
                                            /*CHECK STOCK AVAILABILITY*/
                                            function stock_avalilability(num){
                                            $.ajaxSetup({
                                            headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                            });
                                                    var tyre_id = $('#tyre_id_' + num).val();
                                                    var price_id = $('#price_id_' + num).val();
                                                    $.ajax({
                                                    type: "GET",
                                                            url: '/order/stock_availability',
                                                            data: {
                                                            tyre_id: tyre_id,
                                                            price_id:price_id
                                                            },
                                                            success: function (data) {
                                                                console.log('aaaaaaaaaa '+data);
                                                            console.log('stock '+data[0]);
                                                            if (data[0] >= $('#qty_' + num).val()){
                                                            $('#tr_msg_' + num).hide();
                                                            $('#active_status_' + num).val(0);
                                                            $('#remove_btn_'+ num).hide();
                                                            }else if (typeof data[0] == 'undefined') {
                                                            $('#tr_msg_' + num).show();
                                                            $('#active_status_' + num).val(1);
                                                            $('#remove_btn_'+ num).show();
                                                            }
                                                            }
                                                    });
                                            }

                                            function remove_item(item_id, num){
                                            $('#reasonModal').modal('show');
                                                    $('#order_pro_id').val(item_id);
                                                    $('#row_num').val(num);
                                            }

                                            $('#tag-form-submit_reason').on('click', function (e) {
                                            e.preventDefault();
                                            if ($('#order_pro_id').val() != ''){
                                            $.ajax({
                                            type: "POST",
                                                    url: "/update_order_reason",
                                                    data: {
                                                    "_token": "{{ csrf_token() }}",
                                                            order_pro_id : $('#order_pro_id').val(),
                                                            reason_id: $('#rsn_id').val()
                                                    },
                                                    success: function (data) {
                                                    console.log(data);
                                                            var id = $('#row_num').val();
                                                            $('#active_status_' + id).val(2);
                                                            $('#tr_msg_' + id).hide();
                                                            $('#tr_' + id).hide();
                                                    },
                                                    error: function () {
                                                    alert('Error');
                                                    }
                                            });
                                            setTimeout(function(){ calc_amount(); }, 1000);
                                            }
                                            $('#reasonModal').modal('toggle');
                                                    return false;
                                            });
</script>
@endsection