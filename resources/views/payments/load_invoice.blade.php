<div class="x_content">
    <div class="table-responsive">
        @if (sizeof($outstanding) > 0)
        <table class="table table-striped jambo_table table-bordered">
            <thead>
                <tr class="headings">
                    <th>Tick To Pay</th>
                    <th style="text-align: center">Complete Order No </th>
                    <th style="text-align: center">Complete Date </th>
                    <th style="text-align: center">Net Amount </th>
                    <th style="text-align: center">Outstanding Amount </th>
                    <th style="text-align: center">Paid Amount </th>
                    <th style="text-align: center">Balance </th>
                </tr>
            </thead>

            <tbody>
                @php 
                $count = 0;
                @endphp
                @foreach ($outstanding AS $out)
                @php 
                $count++;
                @endphp
                <tr class="even pointer">
                    <td style="text-align: center">
                        <input type="checkbox" id="inv_ck_{{$count}}" name="inv_ck_{{$count}}" class="flat" name="table_records" onclick="checkVal('{{$count}}')">
                        <input type="hidden" id="checked_satus_{{$count}}" name="checked_satus_{{$count}}" value="0"/>
                    </td>
                    <td style="text-align: right">{{$out['com_order_no']}}
                        <input type="hidden" value="{{$out['com_order_id']}}"  name="order_id_{{$count}}" id="order_id_{{$count}}"/>
                    </td>
                    <td style="text-align: right">{{$out['date']}}</td>
                    <td style="text-align: right">{{$out['net_amount']}}
                        <input type="hidden" value="{{$out['net_amount']}}"  name="order_amount_{{$count}}" id="order_amount_{{$count}}"/>
                    </td>
                    <td style="text-align: center">
                        <input type="text" style="text-align:center;" value="{{$out['net_amount']-$out['paid_amount']}}"  name="paid_{{$count}}" id="paid_{{$count}}" readonly="true"/>
                    </td>
                    <td>
                        <input type="text" style="text-align:center;" name="order_amount_pay_{{$count}}" id="order_amount_pay_{{$count}}" value="0.00" readonly="true"/>
                    </td>
                    <td style="text-align: center">
                        <input type="text" id="balance_{{$count}}" name="balance_{{$count}}" value="0.00" class="form-group" style="text-align:right" size="10" />
                    </td>
                    </td>
                </tr>
                @endforeach
                <input type="hidden" id="totAmnt" name="totAmnt">
                <input type="hidden" value="{{$count}}" id="invo_count" name="invo_count">
            </tbody>
        </table>
        @else
        <div class="center" style="text-align: center;color: red">No Any Oustanding Orders</div>
        @endif
    </div>


</div>

