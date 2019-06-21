<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">

        <title>Payment Receipt</title>

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

                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <td> Payment Date </td> 
                                <td>:</td>
                                <td class="text-left">{{$payment->created_at}}</td>
                            </tr>
                            <tr>
                                <td> Customer </td> 
                                <td>:</td>
                                <td class="text-left">{{$payment->customer->customer_name}}</td>
                            </tr>
                            <tr>
                                <td> Payment Type </td> 
                                <td>:</td>
                                <td class="text-left">
                                    @php 
                                    $pay_type = "";
                                    if($payment->pay_type == 0){
                                        $pay_type = "Cash";
                                    }else {
                                        $pay_type = "Cheque";
                                    }
                                    @endphp
                                    {{$pay_type}}
                                </td>
                            </tr>
                            <tr>
                                <td> Amount </td> 
                                <td>:</td>
                                <td class="text-left">{{$payment->pay_amount}}</td>
                            </tr>
                            <tr>
                                <td> Amount In Words </td> 
                                <td>:</td>
                                <td class="text-left">{{money_in_word($payment->pay_amount)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-5">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <th class="text-right">Payment No:</th>
                                <td class="text-right">{{$payment->pay_no}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="margin-bottom: 0px">&nbsp;</div>

                </div>
                
            </div><br/>
            <div class="row">
                <div class="col-xs-8 invbody-terms">
                     <br>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table style="width: 100%" align="center">
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;width: 60%;padding-left:15px">This Receipt is Valid Subject to Realization of {{$pay_type}}</td>
                                <td style="text-align:center;width: 40%">.......................................................</td>
                            </tr>
                            <tr>
                                <th style="text-align:center"></th>
                                <th style="text-align:center">Customer signature</th>
                            </tr>
                        </tbody>
                    </table>

                    <div style="margin-bottom: 0px">&nbsp;</div>

                </div>
            </div>
        </div>
    </body>
</html>
@php 
function money_in_word($number){
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  $price_value= $result . "Rupees  " . $points . " Only";
  return $price_value;
}
@endphp