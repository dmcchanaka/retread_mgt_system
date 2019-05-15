@extends('layouts.app')
@section('css')
<link href="../css/jquery-ui.min.css" rel="stylesheet"/>
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>PAYMENT Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-5">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Payment Management</a></li>
                        <li class="active">Registration</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>PAYMENT Information</h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div class="x_content">
                    <div class="x_panel">
                        <form class="form-horizontal form-label-left" action="{{url('add_payment')}}" method="post" name="payment_form" id="payment_form"">
                            @csrf
                            <div class="row profile_details text-center">
                                <div class="well profile_view">
                                    <div class="form-group">
                                        <label class="control-label col-md-5" for="">DATE. <span class="required"></span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" required="required" value="{{ date('Y-m-d')}}" class="form-control col-md-2 col-xs-10" readonly="true">
                                            <input type="hidden" id="date" name="date" value="{{ date('Y-m-d')}}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5" for="">PAYMENT NO. <span class="required"></span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" id="pay_no" required="required" class="form-control col-md-2 col-xs-10" value="{{$payment_no}}" readonly="true">
                                        <input type="hidden" id="payment_no" name="payment_no" value="{{$payment_no}}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5" for="">CUSTOMER <span class="required"></span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" id="cus_name" required="required" class="form-control col-md-2 col-xs-10" onkeyup="load_customers();">
                                            <input type="hidden" id="cus_id" name="cus_id" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5" for="">PAYMENT TYPE <span class="required"></span>
                                        </label>
                                        <div class="col-md-6">
                                            <select onchange="set_payment();" id="p_type" name="p_type" class="form-control">
                                                <option value="-1">Select Payment Type</option>
                                                <option value="0">Cash</option>
                                                <option value="1">Cheque</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5" for="">TOTAL OUTSTANDING <span class="required"></span>
                                        </label>
                                        <div class="col-md-6">
                                            <input name="textb1" type="text" id="textb1" style="text-align: center;color: blue" class="form-control" value="" readonly/>
                                            <input style="text-align: center;color: blue;" type="hidden" id="textb" name="textb" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="well" style="overflow: auto;display: none" id="cash_div">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="" style="text-align: center">
                                        <h2 class="box-title">Cash Details</h2>
                                    </div>
                                    <div class="box-body" style="text-align: center">
                                        <input class="form-control" type="text" id="cash_amt" name="cash_amt" value="" style="text-align: right;padding-right: 3px" onkeyup="get_invoice();" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>

                            <div class="well" style="overflow: auto;display: none" id="cheque_div">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8">
                                    <div class="header" style="text-align: center">
                                        <h2 class="box-title">Cheque Details</h2>
                                    </div>
                                    <div class="box-body" style="text-align: center">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th style="text-align: center;background-color:#2A3F54;color: white">Cheque No.</th>
                                                <th style="text-align: center;background-color:#2A3F54;color: white">Bank</th>
                                                <th style="text-align: center;background-color:#2A3F54;color: white">Branch</th>
                                                <th style="text-align: center;background-color:#2A3F54;color: white">Amount</th>
                                                <th style="text-align: center;background-color:#2A3F54;color: white">Date</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center">
                                                    <input type="text" id="chq_no" name="chq_no" value="" size="10" maxlength="6" />
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="text" id="bank" name="bank" value="" size="8" />
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="text" id="branch" name="branch" value="" size="8" />
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="text" id="chq_amt" name="chq_amt" value="" style="text-align: right;padding-right: 3px" onkeyup="get_invoice();" size="8" />
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="date" id="chq_date" name="chq_date" value="" size="8" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>

                            <div id="inv_dev">
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <input type="text" style="text-align: right" placeholder="0.00" class="form-control" id="bAmount" name="bAmount" value="0.00" readonly="true">
                                    <input type="hidden" name="bAmounthHid" id="bAmounthHid"/>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                </div>
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
                                                        function load_customers() {
                                                            $("#cus_name").autocomplete({
                                                                source: '/orders/customers',
                                                                minLength: 1,
                                                                select: function (event, ui) {
                                                                    $("#cus_name").val(ui.item.label);
                                                                    $("#cus_id").val(ui.item.id);
                                                                    search_invoices();
                                                                   cal_outstanding();
                                                                }
                                                            });
                                                        }

                                                        function cal_outstanding() {
                                                            $.ajaxSetup({
                                                                headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                }
                                                            });
                                                            $.ajax({
                                                                type: "GET",
                                                                url: '/payment/outstanding',
                                                                data: {
                                                                    cus_id:$("#cus_id").val()
                                                                },
                                                                success: function (data) {
                                                                    console.log(data);
                                                                    $('#textb1').val(data);
                                                                    $('#textb').val(data);
                                                                }
                                                            });
                                                        }

                                                        function search_invoices() {
                                                            $.ajax({
                                                                type: "GET",
                                                                url: "/payment/load_invoice",
                                                                data: {
                                                                    'cus_id': $('#cus_id').val()
                                                                },
                                                                cache: false,
                                                                success: function (html) {
                                                                    $("#inv_dev").html(html).show('slow');
                                                                }
                                                            });
                                                        }
                                                        function checkVal(cb) {
                                                            var p_type = document.getElementById('p_type').value;
                                                            var cAmnt = document.getElementById('cash_amt').value;
                                                            var chqAmnt = document.getElementById('chq_amt').value;
                                                            var chqno = document.getElementById('chq_no').value;
                                                            var bank = document.getElementById('bank').value;
                                                            var branch = document.getElementById('branch').value;
                                                            if (p_type == '-1') {
                                                                alert('Please Select Payment Type');
                                                                $('#p_type').focus();
                                                            } else if (p_type == '0' && (cAmnt == '0.00' || cAmnt == '')) {
                                                                document.getElementById("inv_ck_" + cb).checked = false;
                                                                alert('Please Enter Cash Amount');
                                                                $("#cash_amt").focus();
                                                            } else if (p_type == '1' && chqno == '') {
                                                                document.getElementById("inv_ck_" + cb).checked = false;
                                                                alert("Please Enter Cheque Number");
                                                                $("#chq_no").focus();
                                                            } else if (p_type == '1' && chqno.length != 6) {
                                                                document.getElementById("inv_ck_" + cb).checked = false;
                                                                alert('Please Enter Correct Cheque No');
                                                                $("#chq_no").focus();
                                                            } else if (p_type == '1' && (chqAmnt == '0.00' || chqAmnt == '')) {
                                                                document.getElementById("inv_ck_" + cb).checked = false;
                                                                alert('Please Enter Cheque Amount');
                                                                $("#chq_amt").focus();
                                                            } else if (p_type == '1' && bank == '') {
                                                                document.getElementById("inv_ck_" + cb).checked = false;
                                                                alert("Please Enter Bank");
                                                                $('#bank').focus();
                                                            } else if (p_type == '1' && branch == '') {
                                                                document.getElementById("inv_ck_" + cb).checked = false;
                                                                alert("Please Enter Bank Branch");
                                                                $('#branch').focus();
                                                            } else {
                                                                //set decimal places to Amount
                                                                if (p_type == '0') {
                                                                    var cash_amount = parseFloat(document.getElementById('cash_amt').value).toFixed(2);
                                                                    $('#cash_amt').val(cash_amount);
                                                                } else if (p_type == '1') {
                                                                    var c_amount = parseFloat(document.getElementById('chq_amt').value).toFixed(2);
                                                                    $('#chq_amt').val(c_amount);
                                                                }
                                                                //load payment amount
                                                                check(cb);
                                                            }
                                                        }
                                                        var x = 0;
                                                        var tr = [];
                                                        function check(cb) {
                                                            var invoice_amount_pay = $('#order_amount_pay_' + cb).val();
                                                            var paid = document.getElementById('paid_' + cb).value;
                                                            var bAmount1 = document.getElementById('bAmount').value;
                                                            var bAmount = parseFloat(bAmount1.replace(/[^0-9-.]/g, '')); //remove thousand separators

                                                            if ($("#inv_ck_" + cb).is(":checked")) {
                                                            document.getElementById('checked_satus_' + cb).value = '1';
                                                            $('#order_amount_pay_' + cb).val(bAmount);
                                                            get_balance(cb, 1);
                                                            document.getElementById("order_amount_pay_" + cb).readOnly = false;
                                                            }
                                                            if (!$("#inv_ck_" + cb).is(":checked")) {
                                                                document.getElementById('checked_satus_' + cb).value = '0';
                                                                document.getElementById("order_amount_pay_" + cb).readOnly = true;
                                                                $('#order_amount_pay_' + cb).val('0.00');
                                                                $('#balance_' + cb).val('0.00');

                                                                reduceAmnt(invoice_amount_pay);
                                                            }
                                                        }

                                                        function reduceAmnt(cb) {
                                                            var cbNew = parseFloat(cb);
                                                            var totAmnt = document.getElementById('totAmnt').value;
                                                            var bAmount = parseFloat((document.getElementById('bAmount').value));
                                                            var newbAmnt = parseFloat(bAmount + cbNew);
                                                            $('#totAmnt').val(totAmnt - cbNew);
                                                            $('#bAmount').val(newbAmnt);
                                                        }

                                                        function get_balance(cb, num) {
                                                            calc(cb, num);
                                                            var amount1 = document.getElementById('paid_' + cb).value;
                                                            var invoice_amount_pay1 = document.getElementById('order_amount_pay_' + cb).value;
                                                            var invoice_amount_pay = parseFloat(invoice_amount_pay1.replace(/[^0-9-.]/g, '')); // 12345.99
                                                            var amount = parseFloat(amount1.replace(/[^0-9-.]/g, '')); // 12345.99
                                                            var balance = parseFloat(amount - invoice_amount_pay).toFixed(2);
                                                            var b = balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                            //balance amount
                                                            var bAmount1 = document.getElementById('bAmount').value;
                                                            var bAmount = parseFloat(bAmount1.replace(/[^0-9-.]/g, '')); //remove thousand separators
                                                            var amountNew = parseFloat(amount1.replace(/[^0-9-.]/g, '')); //remove thousand separators
                                                            var bAmounthHid1 = document.getElementById('bAmounthHid').value;
                                                            var bAmounthHid = parseFloat(bAmounthHid1.replace(/[^0-9-.]/g, '')); //remove thousand separators

                                                            var totAmnt = document.getElementById('totAmnt').value;
                                                            
                                                            if (totAmnt == '') {
                                                                totAmnt = 0;
                                                            }

                                                            if (balance < 0) {
                                                                var total = 0;
                                                                if (amountNew > bAmount) {
                                                                    var bal = parseFloat(amountNew - bAmount)
                                                                    $('#order_amount_pay_' + cb).val(bal);
                                                                    var invo_count = $('#invo_count').val();
                                                                    for (var i = 1; i <= invo_count; i++) {
                                                                        var invoice_amount_pay = $('#order_amount_pay_' + i).val();

                                                                        if (invoice_amount_pay != '') {
                                                                            total += parseFloat(invoice_amount_pay);
                                                                        }
                                                                    }
                                                                    $('#totAmnt').val(total);
                                                                    calc(cb, num);
                                                                } else {
                                                                    alert('You Can not Pay More Than O/S Amount');
                                                                    $('#order_amount_pay_' + cb).val(amount1);
                                                                    $('#balance_' + cb).val('0.00');
                                                                }
                                                            } else {
                                                                $('#balance_' + cb).val(b);
                                                            }
                                                        }

                                                        function getAmount() {
                                                            var p_type = document.getElementById('p_type').value;
                                                            var totAmnt = document.getElementById('totAmnt').value;

                                                            if (p_type == '0') {
                                                                var cash_amount = parseFloat(document.getElementById('cash_amt').value).toFixed(2);
                                                                //$('#bAmount').val(cash_amount);
                                                                $('#bAmounthHid').val(cash_amount);
                                                            } else if (p_type == '1') {
                                                                var c_amount = parseFloat(document.getElementById('chq_amt').value).toFixed(2);
                                                                $('#bAmounthHid').val(c_amount);
                                                            }
                                                            var bAmounthHid = parseFloat(document.getElementById('bAmounthHid').value);
                                                            if (totAmnt != '' && bAmounthHid < totAmnt) {
                                                                search_invoices();
                                                                $('#bAmount').val(bAmounthHid);
                                                            }
                                                            calBalanceAmnt();
                                                        }

                                                        function calBalanceAmnt(sub) {
                                                            var total = 0;
                                                            var bAmounthHid1 = document.getElementById('bAmounthHid').value;
                                                            var bAmounthHid = parseFloat(bAmounthHid1.replace(/[^0-9-.]/g, '')); // 12345.99
                                                            var totAmnt = document.getElementById('totAmnt').value;
                                                            
                                                            if (totAmnt == '') {
                                                                totAmnt = 0;
                                                            }
                                                            var bal = parseFloat(bAmounthHid - totAmnt);
                                                            if (bal < 0) {
                                                                alert('Sorry You Can not Pay More');
                                                                $('#order_amount_pay_' + sub).val('0.00');
                                                                var invo_count = $('#invo_count').val();
                                                                for (var i = 1; i <= invo_count; i++) {
                                                                    var invoice_amount_pay = $('#order_amount_pay_' + i).val();
                                                                    if (invoice_amount_pay != '') {
                                                                        total += parseFloat(invoice_amount_pay);
                                                                    }
                                                                }
                                                                $('#totAmnt').val(total);

                                                                var bal = parseFloat(bAmounthHid - total);
                                                                $('#bAmount').val(bal);
                                                            } else {
                                                                $('#bAmount').val(bal);
                                                            }
                                                        }

                                                        function calc(sub, num) {
                                                            var total = 0
                                                            var totAmnt = $('#totAmnt').val();
                                                            var bAmount = $('#bAmount').val();
                                                            
                                                            var bAmounthHid = parseFloat($('#bAmounthHid').val());
                                                            var inv_amount_pay = parseFloat($('#order_amount_pay_' + sub).val());
                                                            if (totAmnt == '') {
                                                                totAmnt = 0;
                                                            }

                                                            if (num == 1 && totAmnt == bAmounthHid) {
                                                                alert('Sorry You Can Not Pay More');
                                                                document.getElementById("inv_ck_" + sub).checked = false;
                                                                $('#checked_satus_' + sub).val('0');
                                                            }
                                                            else if (num == 1 && totAmnt < bAmounthHid) {
                                                                var invo_count = $('#invo_count').val();
                                                                for (var i = 1; i <= invo_count; i++) {
                                                                    var invoice_amount_pay = $('#order_amount_pay_' + i).val();
                                                                    if (invoice_amount_pay != '') {
                                                                        total += parseFloat(invoice_amount_pay);
                                                                    }
                                                                }
                                                                $('#totAmnt').val(total);
                                                                calBalanceAmnt(sub);
                                                            } else if (num == 0) {
                                                                var invo_count = $('#invo_count').val();
                                                                for (var i = 1; i <= invo_count; i++) {
                                                                    var invoice_amount_pay = $('#order_amount_pay_' + i).val();

                                                                    if (invoice_amount_pay != '') {
                                                                        total += parseFloat(invoice_amount_pay);
                                                                    }
                                                                }
                                                                $('#totAmnt').val(total);
                                                                calBalanceAmnt(sub);
                                                            }
                                                        }



                                                        function set_payment() {
                                                            $("#bAmounthHid").val('');
                                                            var txttb = parseFloat($("#textb").val()).toFixed(2);

                                                            //thousand seperator
                                                            var b = txttb.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                            $("#textb1").val(b);
                                                            var con_name = document.getElementById('cus_name').value;
                                                            if (con_name != '') {
                                                                search_invoices();

                                                                var p_type = $("#p_type").val();
                                                                if (p_type === "0") {
                                                                    $("#cash_div").show('slow');
                                                                    $("#cheque_div").hide('slow');
                                                                    $('#chq_amt').val('');
                                                                    $('#chq_no').val('');
                                                                    $('#bank').val('');
                                                                    $('#branch').val('');
                                                                    $('#chq_date').val('');
                                                                } else if (p_type === "1") {
                                                                    $("#cheque_div").show('slow');
                                                                    $("#cash_div").hide('slow');
                                                                    $('#cash_amt').val('');
                                                                } else {
                                                                    $("#cash_div").hide('slow');
                                                                    $("#cheque_div").hide('slow');
                                                                    $('#chq_amt').val('');
                                                                    $('#chq_no').val('');
                                                                    $('#bank').val('');
                                                                    $('#branch').val('');
                                                                    $('#chq_date').val('');
                                                                }
                                                            } else {
                                                                $("#textb1").val('0.00');
                                                                alert("Please Enter Customer");

                                                                $("#p_type").val('-1');
                                                                $("#con_name").focus();
                                                            }
                                                        }

                                                        function get_invoice(id) {
                                                            getAmount();
                                                            valPaidAmnt();
                                                        }

                                                        function valPaidAmnt() {
                                                            var totAmnt = 0;
                                                            var p_type = document.getElementById('p_type').value;
                                                            var cAmnt = parseFloat(document.getElementById('cash_amt').value);
                                                            var chqAmnt = parseFloat(document.getElementById('chq_amt').value);
                                                            var totOutng = parseFloat(document.getElementById('textb').value);
                                                            var totAmnt = parseFloat(document.getElementById('totAmnt').value);
                                                            if (totAmnt == '' || isNaN(parseFloat(totAmnt))) {
                                                                totAmnt = 0;
                                                            }
                                                            if (p_type == '0' && cAmnt > totOutng) {
                                                                alert('You Cannot Pay More Than Outstanding Amount');
                                                                $('#cash_amt').val(totOutng);
                                                                $('#bAmounthHid').val(totOutng);
                                                                $('#bAmount').val(totOutng - totAmnt);
                                                            } else if (p_type == '1' && chqAmnt > totOutng) {
                                                                alert('You Cannot Pay More Than Outstanding Amount');
                                                                $('#chq_amt').val(totOutng);
                                                                $('#bAmounthHid').val(totOutng);
                                                            }
                                                        }

                                                        function form_submit (button_id, form_id){
                                                            var totAmnt = parseFloat($('#totAmnt').val());
                                                            var bAmounthHid = parseFloat($('#bAmounthHid').val());
                                                            var bAmount = $('#bAmount').val();

                                                            if (totAmnt != '' || totAmnt != 0) {
                                                                if (totAmnt == '') {
                                                                    totAmnt == 0;
                                                                }
                                                                if (totAmnt == bAmounthHid) {
                                                                    $('#add').attr('disabled','disabled');
                                                                    document.forms[form_id].submit();
                                                                }else {
                                                                    alert('You Have ' + bAmount + ' Balance Amount');
                                                                }   
                                                            }else {
                                                                alert('Please Do Payment First');
                                                            }
                                                        }
</script>
@endsection

