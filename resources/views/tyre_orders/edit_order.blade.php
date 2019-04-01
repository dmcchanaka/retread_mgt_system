@extends('layouts.app')
@section('css')
<link href="../css/jquery-ui.min.css" rel="stylesheet"/>
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>TYRE Order Management</h3>
        </div>
        <div class="title_right">
            <div class="col-md-offset-6">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Order Management</a></li>
                        <li class="active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>TYRE Order Information</h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div class="x_content">
                    <form class="form-horizontal form-label-left" action="{{url('update_salesorder')}}" method="post" name="order_form" id="order_form" onsubmit="tyre_order_validation();">
                        @csrf
                        <div class="row profile_details text-center">
                            <div class="well profile_view">
                                <div class="form-group">
                                    <label class="control-label col-md-5" for="">DATE. <span class="required"></span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" required="required" value="{{ date('Y-m-d')}}" class="form-control col-md-2 col-xs-10" readonly="true">
                                        <input type="hidden" id="date" name="date" value="{{ date('Y-m-d')}}" />
                                        <input type="hidden" id="so_id" name="so_id" value="{{$customer->order_id}}"
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5" for="">ORDER NO. <span class="required"></span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" id="o_no" required="required" class="form-control col-md-2 col-xs-10" readonly="true">
                                        <input type="hidden" id="order_no" name="order_no" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5" for="">CUSTOMER <span class="required"></span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" id="cus_name" required="required" class="form-control col-md-2 col-xs-10" value="{{$customer->customer->customer_name}}" onkeyup="load_customers();" readonly="true">
                                        <input type="hidden" id="cus_id" name="cus_id" value="{{$customer->customer->cus_id}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action" id="price_table">
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            &nbsp;
                                        </th>
                                        <th class="column-title">Tyre Description </th>
                                        <th class="column-title">Category </th>
                                        <th class="column-title">Sub Category </th>
                                        <th class="column-title">Price No. </th>
                                        <th class="column-title">Price. </th>
                                        <th class="column-title">Quantity </th>
                                        <th class="column-title">Discount (%)</th>
                                        <th class="column-title">Amount</th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $gross_amount = 0;
                                    $net_amount = 0;
                                    $count = 0;
                                    foreach ($orderDetails AS $od) {
                                        $count++;
                                        $gross_amount += round((($od->qty * $od->price->cus_price) - ($od->qty * $od->price->cus_price / 100) * $od->discount_per), 2);
                                        ?>
                                        <tr class="even pointer" id="tr_{{$count}}}">
                                            <td class="a-center ">
                                                <span class="glyphicon glyphicon-plus" style="cursor: pointer" onclick="gen_item();"></span>
                                            </td>
                                            <td class=" ">
                                                <input type="text" id="tyre_names_{{$count}}" name="tyre_names_{{$count}}" class="col-md-12" onclick="load_tyres('1');" value="{{$od->tyre->tyre_name}}"/>
                                                <input type="hidden" id="tyre_id_{{$count}}" name="tyre_id_{{$count}}" value="{{$od->tyre_id}}" />
                                            </td>
                                            <td class=" ">
                                                <select id="cat_id_{{$count}}" name="cat_id_{{$count}}" onchange="load_sub_category('1');">
                                                    <option value="">CATEGORY</option>
                                                    @foreach ($category as $cat)
                                                    <option value="{{$cat->cat_id}}" <?php
                                                    if ($cat->cat_id == $od->price->cat_id) {
                                                        echo 'selected';
                                                    }
                                                    ?>>{{$cat->cat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" ">
                                                <select id="sub_cat_id_{{$count}}" name="sub_cat_id_{{$count}}" onchange="load_price_no('1');">
                                                    <option value="">SUB CATEGORY</option>
                                                    @foreach ($subCat as $sc)
                                                    <option value="{{$sc->sub_cat_id}}" <?php
                                                    if ($sc->sub_cat_id == $od->price->sub_cat_id) {
                                                        echo 'selected';
                                                    }
                                                    ?>>{{$sc->sub_cat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" ">
                                                <select id="price_no_{{$count}}" name="price_no_{{$count}}" onchange="load_cus_price('1');">
                                                    <option>PRICE NO.</option>
                                                    @foreach ($price as $pr)
                                                    <option value="{{$pr->price_id}}" <?php
                                                    if ($pr->price_id == $od->price_id) {
                                                        echo 'selected';
                                                    }
                                                    ?>>{{$pr->price_no}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="price_{{$count}}" name="price_{{$count}}" value="{{$od->price->cus_price}}" /></td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="qty_{{$count}}" name="qty_{{$count}}" onkeyup="check_qty(event, '{{$count}}');" value="{{$od->qty}}" /></td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="discount_{{$count}}" name="discount_{{$count}}" onkeyup="calc_amount();" value="{{$od->discount_per}}" /></td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="amount_{{$count}}" name="amount_{{$count}}" value="{{$od->line_amount}}" /></td>
                                            <td class="a-center ">
                                                <span class="glyphicon glyphicon-minus" style="cursor: pointer" onclick="remove_item('{{$count}}');"></span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $net_amount = round((($gross_amount) - ($gross_amount / 100) * $customer->discount_per), 2);
                                    ?>
                                <input type="hidden" id="item_count" name="item_count" value="{{$count}}" />
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
                                            <input type="text" style="text-align: right;padding-right: 5px" id="tot_amount" name="tot_amount" value="{{$gross_amount}}" >
                                        </td>
                                        <td>&nbsp;</td>
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
                                            <input type="text" style="text-align: right;padding-right: 5px" id="whole_dis" name="whole_dis" onkeyup="calc_amount();" value="{{$customer->discount_per}}" >
                                        </td>
                                        <td>&nbsp;</td>
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
                                            <input type="text" style="text-align: right;padding-right: 5px" id="net_amount" name="net_amount" value="{{$net_amount}}" >
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
                </form>
            </div>
            <div class="ln_solid"></div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script src="../js/jquery-ui.min.js"></script>
<script type="text/javascript">
                                                                $(document).ready(function () {
                                                                $.ajaxSetup({
                                                                headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                }
                                                                        });
                                                                        $.ajax({
                                                                                type: "GET",
                                                                                url: '/orders/generate_no',
                                                                                data: {
                                                                                },
                                                                                success: function (data) {
                                                                                // console.log(data);
                                                                                        var order_no = "";
                                                                                if (data.length === 0) {
                                                                                var next_no = 1;
                                                                                } else {
                                                                                var next_no = + data + + 1;
                                                                                }
                                                                                        var order_no = price_no('TYRE/ORDER', next_no);
                                                                                        $('#o_no').val(order_no);
                                                                                $('#order_no').val(order_no);
                                                                        }
                                                                        });
                                                                        function price_no(str1, str2) {
                                                                                var res = str1 + '/' + str2;
                                                                        return res;
                                                                }
                                                                        });
                                                                                /*GET TYRE NAMES*/
                                                                                function load_customers() {
                                                                                $("#cus_name").autocomplete({
                                                                                        source: '/orders/customers',
                                                                                        minLength: 1,
                                                                                        select: function (event, ui) {
                                                                                                $("#cus_name").val(ui.item.label);
                                                                                        $("#cus_id").val(ui.item.id);
                                                                                }
                                                                                });
                                                                        }
                                                                        /*GENERATE NEW ROWS*/
                                                                        function gen_item() {
                                                                                var num = parseFloat($('#item_count').val()) + 1;
                                                                                $('#item_count').val(num);
                                                                                $('#price_table').append('<tr class="even pointer" id="tr_' + num + '">'
                                                                                + '<td class="a-center "><span class="glyphicon glyphicon-plus" style="cursor: pointer" onclick="gen_item();"></span></td>'
                                                                                + '<td class=" ">'
                                                                                + '<input type="text" id="tyre_names_' + num + '" name="tyre_names_' + num + '" class="col-md-12" onclick="load_tyres(' + num + ');"/>'
                                                                                + '<input type="hidden" id="tyre_id_' + num + '" name="tyre_id_' + num + '" value="" />'
                                                                                + '</td>'
                                                                                + '<td class=" ">'
                                                                                + '<select id="cat_id_' + num + '" name="cat_id_' + num + '" onchange="load_sub_category(' + num + ');">'
                                                                                + '<option value="">CATEGORY</option>'
                                                                                + '</select>'
                                                                                + '</td>'
                                                                                + '<td class=" ">'
                                                                                + '<select id="sub_cat_id_' + num + '" name="sub_cat_id_' + num + '" onchange="load_price_no(' + num + ');">'
                                                                                + '<option value="">SUB CATEGORY</option>'
                                                                                + '</select>'
                                                                                + '</td>'
                                                                                + '<td class="">'
                                                                                + '<select id="price_no_' + num + '" name="price_no_' + num + '" onchange="load_cus_price(' + num + ');">'
                                                                                + '<option>PRICE NO.</option>'
                                                                                + '</select>'
                                                                                + '</td>'
                                                                                + '<td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="price_' + num + '" name="price_' + num + '" /></td>'
                                                                                + '<td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="qty_' + num + '" name="qty_' + num + '" onkeyup="check_qty(event, ' + num + ');" /></td>'
                                                                                + '<td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="discount_' + num + '" name="discount_' + num + '" onkeyup="calc_amount();" /></td>'
                                                                                + '<td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="amount_' + num + '" name="amount_' + num + '" /></td>'
                                                                                + '<td class="a-center "><span class="glyphicon glyphicon-minus" style="cursor: pointer" onclick="remove_item(' + num + ');"></span></td>'
                                                                        + '</tr>');
                                                                        }

                                                                        /*REMOVE GENERATED ROW*/
                                                                        function remove_item(num) {
                                                                        if (parseFloat($('#item_count').val()) != 1) {
                                                                                $('#tr_' + num).remove();
                                                                                var num = parseFloat($('#item_count').val()) - 1;
                                                                        $('#item_count').val(num);
                                                                        }
                                                                        }
                                                                        /*GET TYRE NAMES*/
                                                                        function load_tyres(num) {
                                                                        if ($('#cus_name').text() != "" || $('#cus_id').val() != '') {
                                                                        $("#tyre_names_" + num).autocomplete({
                                                                                source: '/tyres/find',
                                                                                minLength: 1,
                                                                                select: function (event, ui) {
                                                                                        $("#tyre_names_" + num).val(ui.item.label);
                                                                                        $("#tyre_id_" + num).val(ui.item.id);
                                                                                load_categories(num, ui.item.id);
                                                                        }
                                                                        });
                                                                        } else {
                                                                                alert('please select customer');
                                                                        $('#cus_name').focus();
                                                                        }
                                                                        }
                                                                        /*LOAD TYRE CATEGORIES*/
                                                                        function load_categories(num, tyre_id) {
                                                                        $.ajaxSetup({
                                                                        headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                        }
                                                                                });
                                                                                $.ajax({
                                                                                        type: "GET",
                                                                                        url: '/tyres/category',
                                                                                        data: {
                                                                                        tyre_id: tyre_id
                                                                                        },
                                                                                        success: function (data) {
                                                                                        if (data.length > 0) {
                                                                                                $('#cat_id_' + num).empty();
                                                                                                $('#cat_id_' + num).append('<option value="">CATEGORY</option>');
                                                                                        for (var i = 0; i < data.length; i++) {
                                                                                        $('#cat_id_' + num).append('<option value=' + data[i].cat_id + '>' + data[i].cat_name + '</option>');
                                                                                        }
                                                                                        } else {
                                                                                                $('#cat_id_' + num).empty();
                                                                                        $('#cat_id_' + num).append('<option value="">CATEGORY</option>');
                                                                                        }
                                                                                }
                                                                        });
                                                                        }
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
                                                                                                'cat_id': cat_id,
                                                                                        'tyre_id': tyre_id
                                                                                        },
                                                                                        success: function (data) {
                                                                                        if (data.length > 0) {
                                                                                                $('#price_no_' + num).empty();
                                                                                                $('#price_no_' + num).append('<option value="">PRICE NO.</option>');
                                                                                        for (var i = 0; i < data.length; i++) {
                                                                                        $('#price_no_' + num).append('<option value=' + data[i].price_id + '>' + data[i].price_no + '</option>');
                                                                                        }
                                                                                        } else {
                                                                                                $('#price_no_' + num).empty();
                                                                                        $('#price_no_' + num).append('<option value="">PRICE NO.</option>');
                                                                                        }
                                                                                }
                                                                        });
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
                                                                                        if (data.length > 0) {
                                                                                                var price = data[0].cus_price;
                                                                                        $('#price_' + num).val(price);
                                                                                        } else {
                                                                                        $('#price_' + num).val(0);
                                                                                        }

                                                                                }
                                                                        });
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
                                                                        Number.prototype.formatMoney = function (c, d, t) {
                                                                                var n = this,
                                                                                c = isNaN(c = Math.abs(c)) ? 2 : c,
                                                                                d = d == undefined ? "." : d,
                                                                                t = t == undefined ? "," : t,
                                                                                s = n < 0 ? "-" : "",
                                                                                i = parseInt(n = Math.abs( + n || 0).toFixed(c)) + "",
                                                                                j = (j = i.length) > 3 ? j % 3 : 0;
                                                                        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
                                                                                };
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
                                                                                if ($('#qty_' + i).val() > 0) {
                                                                                        var line_amount = (parseFloat($('#qty_' + i).val()) * parseFloat($('#price_' + i).val()) * (100 - discount)) / 100;
                                                                                        tot_amount += line_amount;
                                                                                        // console.log('line ' + line_amount + 'gnd ' + tot_amount);
                                                                                $('#amount_' + i).val(line_amount.formatMoney(2, '.', ','));
                                                                                }
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

                                                                        function tyre_order_validation() {
                                                                                valid = true;
                                                                        if ($('#cus_name').val() == "" || $('#cus_id').val() == "") {
                                                                                valid = false;
                                                                                alert("Enter Customer Name");
                                                                        $('#cus_name').focus();
                                                                        } else {
                                                                        var m = 1;
                                                                        }
                                                                        }
</script>
@endsection