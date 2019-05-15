@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">

    <div class="row top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-bar-chart"></i></div>
        
          <h3>Purchases</h3>
          <p>Total purchases upto day.</p>
          <div class="count" style="font-size: 32px !important">{{number_format($purchases,2)}}</div>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-comments-o"></i></div>
          <h3>Orders</h3>
          <p>Total orders upto day.</p>
          <div class="count" style="font-size: 32px !important">{{number_format($orders,2)}}</div>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-check"></i></div>
          <h3>Complete Orders</h3>
          <p>Total complete orders upto day.</p>
          <div class="count" style="font-size: 32px !important">{{number_format($comOrders,2)}}</div>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-check-square-o"></i></div>
          <h3>Payments</h3>
          <p>Total payments upto day.</p>
          <div class="count" style="font-size: 32px !important">{{number_format($payments,2)}}</div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Line Graph</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <div id="echart_line" style="height:350px;"></div>

        </div>
      </div>
    </div>
    
    </div>
@endsection

@section('js')
<!-- ECharts -->
<script src="../vendors/echarts/dist/echarts.min.js"></script>
<script src="../vendors/echarts/map/js/world.js"></script>
@endsection