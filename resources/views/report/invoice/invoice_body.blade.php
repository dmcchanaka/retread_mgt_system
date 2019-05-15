@if(isset($results))
    @if(isset($results) && sizeof($results) > 0)
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action sub_category_tbl" cellspacing="0" width="100%">
        <thead>
            <tr class="headings">
                <th style="text-align: center" class="column-title">Complete Order No</th>
                <th style="text-align: center" class="column-title">Customer</th>
                <th style="text-align: center" class="column-title">Address</th>
                <th style="text-align: center" class="column-title">date</th>
                <th style="text-align: center" class="column-title">Time</th>
                <th style="text-align: center" class="column-title">Net Amount</th>
            </tr>
        </thead>
        <tbody>
            @php 
            $grand_total = 0;
            @endphp
            @foreach ($results as $item)
            @php 
            $grand_total += $item['com_orders'];
            @endphp
            <tr>
            <td>{{$item['com_order_no']}}</td>
            <td>{{$item['cus_name']}}</td>
            <td>{{$item['address']}}</td>
            <td style="text-align:center">{{$item['date']}}</td>
            <td style="text-align:center">{{$item['time']}}</td>
            <td style="text-align:right">{{number_format($item['com_orders'],2)}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"><b>Grand Total</b></td>
            <td style="text-align:right"><b>{{number_format($grand_total,2)}}</b></td>
            </tr>
        </tfoot>
    </table>
    @else 
    <div style="text-align:center;color:red"><label class="col-form-label">No Record Found</label></div>
    @endif
@endif
