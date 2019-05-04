<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">

        <title>Invoice</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <style>
            .text-right {
                text-align: right;
            }
        </style>

    </head>
    <body class="login-page" style="background: white">

        <div>
            <div class="row">
                <div class="col-xs-7">
                    <strong>Disanayaka Motors.</strong><br>
                    No. 15 D.S Senanayaka Street <br>
                    Ampara<br>
                    P: 063-0000000 <br>
                    E: newdisanayakamotors@gmail.com <br>

                    <br>
                </div>

                <div class="col-xs-4">
                    <img src="images/logo.png">
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>
            <table style="width: 100%; margin-bottom: 20px">
                <tbody>
                    <tr class="well" style="padding: 5px">
                        <th style="padding: 5px;text-align: center"><div> Tyre Order Receipt </div></th>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-xs-6">
                    <h4>To:</h4>
                    <address>
                        <strong>{{$order->customer->customer_name}}</strong> ,<br>
                        <span>{{$order->customer->email}}</span> <br>
                        <span>{{$order->customer->address}}</span>
                    </address>
                </div>

                <div class="col-xs-5">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <th>Order No:</th>
                                <td class="text-right">{{$order->order_no}}</td>
                            </tr>
                            <tr>
                                <th> Order Date: </th>
                                <td class="text-right">{{$order->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="margin-bottom: 0px">&nbsp;</div>

                </div>
            </div>
            <table class="table">
                <thead style="background: #F5F5F5;">
                    <tr>
                        <th>Item List</th>
                        <th>Serial No.</th>
                        <th>Qty.</th>
                        <th>Dis.(%)</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $total_amt = 0;
                    @endphp
                    @foreach ($orderDetails AS $value)
                    @php
                    $line_amt = 0;
                    $line_amt = ($value->qty*$value->price->cus_price)-(($value->qty*$value->price->cus_price) * $value->discount_per)/100;
                    $total_amt += $line_amt;
                    @endphp
                    <tr>
                        <td>{{$value->tyre->tyre_name}}</td>
                        <td>{{$value->serial_no}}</td>
                        <td>{{$value->qty}}</td>
                        <td>{{$value->discount_per}}</td>
                        <td class="text-right">{{number_format($line_amt,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-xs-6"></div>
                <div class="col-xs-5">
                    <table style="width: 100%">
                        <tbody>
                            <tr class="well" style="padding: 5px">
                                <th style="padding: 5px"><div> Discount @if ($order->discount_per) ( {{$order->discount_per}} % ) @endif </div></th>
                        <td style="padding: 5px" class="text-right"><strong> {{number_format($order->discount,2)}} </strong></td>
                        </tr>
                        <tr class="well" style="padding: 5px">
                            <th style="padding: 5px"><div> Net Amount </div></th>
                        <td style="padding: 5px" class="text-right"><strong> {{number_format($total_amt,2)}} </strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-8 invbody-terms">
                    Thank you for your business. <br>
                </div>
            </div>
        </div>

    </body>
</html>