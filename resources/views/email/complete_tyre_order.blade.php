<p>Dear Mr./Mrs. {{ $data['name'] }} </p>
<p> {{ $data['message'] }} </p><br/>
<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-5">
        <table style="width: 100%">
            <tbody>
                <tr class="well" style="padding: 5px">
                    <th style="padding: 5px"><div> Invoice No. </div></th>
            <td style="padding: 5px" class="text-right"><strong> {{ $data['inv_no'] }} </strong></td>
            </tr>
            <tr class="well" style="padding: 5px">
                    <th style="padding: 5px"><div> Gross Amount. </div></th>
            <td style="padding: 5px" class="text-right"><strong> {{ number_format($data['inv_gross'],2) }} </strong></td>
            </tr>
            <tr class="well" style="padding: 5px">
                    <th style="padding: 5px"><div> Discount. </div></th>
            <td style="padding: 5px" class="text-right"><strong> {{ number_format($data['inv_discount'],2) }} </strong></td>
            </tr>
            <tr class="well" style="padding: 5px">
                    <th style="padding: 5px"><div> Net Amount. </div></th>
            <td style="padding: 5px" class="text-right"><strong> {{ number_format($data['inv_net'],2) }} </strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<p>Best Regards,<br/>Disanayaka Motors.<br/>Tel : 063-0000000<br/>Email : newdisanayakamotors@gmail.com</p>


