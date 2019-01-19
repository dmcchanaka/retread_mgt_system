@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
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
                        <li class="active">Registration</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>PRICE Information</h2>
                    <div class="clearfix"></div>
                </div>
                @include('flash-message')
                <div class="x_content">
                    <div class="x_panel">
                        <form class="form-horizontal form-label-left" action="{{url('add_prices')}}" method="post">
                            @csrf
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
                                            <th class="column-title">Received Price</th>
                                            <th class="column-title">Customer Price</th>
                                            <th>
                                                &nbsp;
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="even pointer" id="tr_1">
                                            <td class="a-center ">
                                                <span class="glyphicon glyphicon-plus" style="cursor: pointer" onclick="gen_item();"></span>
                                            </td>
                                            <td class=" ">
                                                <input type="text" id="tyre_names_1" name="tyre_names_1" class="col-md-12" onclick="load_tyres('1');"/>
                                                <input type="hidden" id="tyre_id_1" name="tyre_id_1" value="" />
                                            </td>
                                            <td class=" ">
                                                <select id="cat_id_1" name="cat_id_1" onchange="load_sub_category('1');">
                                                    <option value="">SELECT CATEGORY</option>
                                                </select>
                                            </td>
                                            <td class=" ">
                                                <select id="sub_cat_id_1" name="sub_cat_id_1">
                                                    <option value="">SELECT SUB CATEGORY</option>
                                                </select>
                                            </td>
                                            <td class=" ">
                                                <input type="text" id="price_no_1" name="price_no_1" onclick="gen_price_no('1');" />
                                                <input type="hidden" id="pr_no_1" name="pr_no_1" />
                                            </td>
                                            <td class=" "><input type="text" id="r_price_1" name="r_price_1" /></td>
                                            <td class=" "><input type="text" id="c_price_1" name="c_price_1" /></td>
                                            <td class="a-center ">
                                                <span class="glyphicon glyphicon-minus" style="cursor: pointer" onclick="remove_item('1');"></span>
                                            </td>
                                        </tr>
                                    <input type="hidden" id="item_count" name="item_count" value="1" />
                                    </tbody>
                                </table>
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
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
                                                    $(document).ready(function () {

                                                    });
                                                    /*GET TYRE NAMES*/
                                                    function load_tyres(num) {
                                                        $("#tyre_names_" + num).autocomplete({
                                                            source: '/tyres/find',
                                                            minLength: 1,
                                                            select: function (event, ui) {
                                                                $("#tyre_names_" + num).val(ui.item.label);
                                                                $("#tyre_id_" + num).val(ui.item.id);
                                                                load_categories(num, ui.item.id);
                                                            }
                                                        });
                                                    }
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
                                                                    $('#cat_id_' + num).append('<option value="">SELECT CATEGORY</option>');
                                                                    for (var i = 0; i < data.length; i++) {
                                                                        $('#cat_id_' + num).append('<option value=' + data[i].cat_id + '>' + data[i].cat_name + '</option>');
                                                                    }
                                                                } else {
                                                                    $('#cat_id_' + num).empty();
                                                                    $('#cat_id_' + num).append('<option value="">SELECT CATEGORY</option>');
                                                                }
                                                            }
                                                        });
                                                    }
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
                                                                    $('#sub_cat_id_' + num).append('<option value="">SELECT SUB CATEGORY</option>');
                                                                    for (var i = 0; i < data.length; i++) {
                                                                        $('#sub_cat_id_' + num).append('<option value=' + data[i].sub_cat_id + '>' + data[i].sub_cat_name + '</option>');
                                                                    }
                                                                } else {
                                                                    $('#sub_cat_id_' + num).empty();
                                                                    $('#sub_cat_id_' + num).append('<option value="">SELECT SUB CATEGORY</option>');
                                                                }
                                                            }
                                                        });
                                                    }
                                                    function gen_price_no(num) {
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        var cat_id = $('#cat_id_' + num).val();
                                                        var tyre_id = $('#tyre_id_' + num).val();
                                                        var sub_cat_id = $('#sub_cat_id_' + num).val();
                                                        $.ajax({
                                                            type: "GET",
                                                            url: '/price/beltno',
                                                            data: {
                                                                cat_id: cat_id,
                                                                sub_cat_id: sub_cat_id,
                                                                tyre_id: tyre_id
                                                            },
                                                            success: function (data) {
                                                                console.log(data);
                                                                var tyre_str = $('#tyre_names_' + num).val();
                                                                var tyre_match = tyre_str.match(/\b(\w)/g); // ['J','S','O','N']
                                                                var acronym = tyre_match.join(''); // JSON

                                                                var cat_str = $('#cat_id_' + num + ' option:selected').text();
                                                                var cat_match = cat_str.match(/\b(\w)/g); // ['J','S','O','N']
                                                                var cat_ltr = cat_match.join(''); // JSON

                                                                var sub_cat_str = $('#sub_cat_id_' + num + ' option:selected').text();
                                                                var sub_cat_match = sub_cat_str.match(/\b(\w)/g); // ['J','S','O','N']
                                                                var sub_cat_ltr = sub_cat_match.join(''); // JSON
                                                                var res = acronym.concat(cat_ltr);
                                                                var res_cat = res.concat(sub_cat_ltr);
                                                                if (data == 0) {
                                                                    var next_no = 1;
                                                                } else {
                                                                    var next_no = +data + +1;
                                                                }
                                                                var next_price_no = price_no(res_cat, next_no);
                                                                $('#price_no_' + num).val(next_price_no);
                                                                $('#pr_no_'+ num).val(next_price_no);
                                                                $('#price_no_' + num).attr("disabled", "disabled");
                                                            }
                                                        });
                                                    }
                                                    function price_no(str1, str2) {
                                                        var res = str1 + '-' + str2;
                                                        return res;
                                                    }
                                                    /*GENERATE NEW ROW*/
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
                                                                + '<option value="">SELECT CATEGORY</option>'
                                                                + '</select>'
                                                                + '</td>'
                                                                + '<td class=" ">'
                                                                + '<select id="sub_cat_id_' + num + '" name="sub_cat_id_' + num + '">'
                                                                + '<option value="">SELECT SUB CATEGORY</option>'
                                                                + '</select>'
                                                                + '</td>'
                                                                + '<td class=" "><input type="text" id="price_no_' + num + '" name="price_no_' + num + '" onclick="gen_price_no(' + num + ');" /><input type="hidden" id="pr_no_' + num + '" name="pr_no_' + num + '" /></td>'
                                                                + '<td class=" "><input type="text" id="r_price_' + num + '" name="r_price_' + num + '" /></td>'
                                                                + '<td class=" "><input type="text" id="c_price_' + num + '" name="c_price_' + num + '" /></td>'
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
</script>
@endsection

