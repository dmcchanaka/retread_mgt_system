<div class="x_panel">
    <div class="x_content">
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 form-group text-center">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-left">TYRE ORDER NO.</td>
                        <td>:</td>
                        <td class="text-left">{{$order->order_no}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">TYRE DATE</td>
                        <td>:</td>
                        <td class="text-left">{{$order->created_at}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">CUSTOMER</td>
                        <td>:</td>
                        <td class="text-left">{{$order->customer->customer_name}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            </div>
        </div>
    </div>
</div>