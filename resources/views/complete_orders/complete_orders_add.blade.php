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
                        <form class="form-horizontal form-label-left" action="{{url('add_salesorder')}}" method="post" name="order_form" id="order_form" onsubmit="tyre_order_validation();">
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
                                            <label class="control-label col-md-5" for="">COMPLETE ORDER NO. <span class="required"></span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" id="o_no" required="required" class="form-control col-md-2 col-xs-10" readonly="true">
                                                <input type="hidden" id="grn_no" name="grn_no" value="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-5" for="">INVOICE NO. <span class="required"></span>
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" id="inv_no" name="inv_no" required="required" class="form-control col-md-2 col-xs-10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action" id="price_table">
                                    <thead>
                                        <tr class="headings">
                                            <th class="column-title">Tyre Description </th>
                                            <th class="column-title">Category </th>
                                            <th class="column-title">Sub Category </th>
                                            <th class="column-title">Price No. </th>
                                            <th class="column-title">Price. </th>
                                            <th class="column-title">Quantity </th>
                                            <th class="column-title">Discount (%)</th>
                                            <th class="column-title">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php // dd($orderDetails); ?>
                                        @foreach ($orderDetails as $data) 
                                        <?php
                                        echo '<pre>';
                                        echo $data;
                                        echo '</pre>';
                                        die();
                                        ?>
                                        <tr class="even pointer" id="tr_1">
                                            <td class=" ">
                                                <input type="text" id="tyre_names_1" name="tyre_names_1" class="col-md-12" onclick="load_tyres('1');" value="{{ $data->tyre->tyre_name }}"/>
                                                <input type="hidden" id="tyre_id_1" name="tyre_id_1" value="{{ $data->tyre_id }}" />
                                            </td>
                                            <td class=" ">
                                                <select id="cat_id_1" name="cat_id_1" onchange="load_sub_category('1');">
                                                    <option value="">CATEGORY</option>
                                                    @foreach ($beltCat as $cat)
                                                    <option value="{{$cat->cat_id}}" <?php if($cat->cat_id == $data->price->cat_id){echo 'selected';} ?>>{{$cat->cat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" ">
                                                <select id="sub_cat_id_1" name="sub_cat_id_1" onchange="load_price_no('1');">
                                                    <option value="">SUB CATEGORY</option> 
                                                    @foreach ($beltsubcat as $subcat)
                                                    <option value="{{$subcat->sub_cat_id}}" <?php if($subcat->sub_cat_id == $data->price->sub_cat_id){echo 'selected';} ?>>{{$subcat->sub_cat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" ">
                                                <select id="price_no_1" name="price_no_1" onchange="load_cus_price('1');">
                                                    <option>PRICE NO.</option> 
                                                    @foreach ($beltPrice as $price)
                                                    <option value="{{$price->price_id}}" <?php if($price->price_id == $data->price_id){echo 'selected';} ?>>{{$price->price_no}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="price_1" name="price_1" value="{{ $data->price->cus_price }}" /></td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="qty_1" name="qty_1" onkeyup="check_qty(event, '1');" value="{{ $data->qty }}" /></td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="discount_1" name="discount_1" onkeyup="calc_amount();" value="{{ $data->discount }}" /></td>
                                            <td class=" "><input type="text" style="text-align: right;padding-right: 5px" class="col-md-12" id="amount_1" name="amount_1" value="{{ $data->line_amount }}" /></td>
                                        </tr>
                                        @endforeach
                                    <input type="hidden" id="item_count" name="item_count" value="1" />
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
                                                <input type="text" style="text-align: right;padding-right: 5px" id="tot_amount" name="tot_amount" value="0" >
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
                                                <input type="text" style="text-align: right;padding-right: 5px" id="whole_dis" name="whole_dis" onkeyup="calc_amount();" value="0" >
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
                                                <input type="text" style="text-align: right;padding-right: 5px" id="net_amount" name="net_amount" value="0" >
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
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