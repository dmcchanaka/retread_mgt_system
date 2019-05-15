            @if(isset($results))
                    @if(isset($results) && sizeof($results) > 0)
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table table-striped jambo_table bulk_action sub_category_tbl" cellspacing="0" width="100%">
                            <thead>
                                <tr class="headings">
                                    <th style="text-align: center" class="column-title">Tyre Name</th>
                                    <th style="text-align: center" class="column-title">Tyre Size</th>
                                    <th style="text-align: center" class="column-title">Category</th>
                                    <th style="text-align: center" class="column-title">Sub Category</th>
                                    <th style="text-align: center" class="column-title">Recieved Price</th>
                                    <th style="text-align: center" class="column-title">Remaining QTY</th>
                                    <th style="text-align: center" class="column-title">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $item)
                                <tr>
                                        <td>{{$item->tyre_name}}</td>
                                        <td>{{$item->tyre_size}}</td>
                                        <td>{{$item->cat_name}}</td>
                                        <td>{{$item->sub_cat_name}}</td>
                                        <td style="text-align:right">{{number_format($item->rp_price,2)}}</td>
                                        <td style="text-align:right">{{number_format($item->stock)}}</td>
                                        <td style="text-align:right">{{number_format($item->stock * $item->rp_price,2)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    @else 
                    <div style="text-align:center;color:red"><label class="col-form-label">No Record Found</label></div>
                    @endif
            @endif