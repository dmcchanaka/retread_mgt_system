<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">

        <title>Invoice</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Bootstrap -->
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
                        <th style="padding: 5px;text-align: center"><div> Payment Receipt </div></th>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-xs-6">
                    <h4>To:</h4>
                    <address>
                        <strong>{{$payment->customer->customer_name}}</strong> ,<br>
                        <span>{{$payment->customer->email}}</span> <br>
                        <span>{{$payment->customer->address}}</span>
                    </address>
                </div>

                <div class="col-xs-5">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <th>Payment No:</th>
                                <td class="text-right">{{$payment->pay_no}}</td>
                            </tr>
                            <tr>
                                <th> Payment Date: </th>
                                <td class="text-right">{{$payment->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="margin-bottom: 0px">&nbsp;</div>

                </div>
            </div>

        </div>
    </body>
</html>