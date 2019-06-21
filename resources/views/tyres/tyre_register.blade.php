@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="page-title">
        <div class="title_left">
            <h3>TYRE Management</h3>
        </div>

        <div class="title_right">
            <div class="col-md-offset-5">
                <div class="input-group">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Tyre Management</a></li>
                        <li class="active">Registration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>TYRE Information<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form id="demo-form2" action="{{url('add_tyres')}}" method="post" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Tyre-size">Tyre size <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="t_size" name="t_size" type="text" placeholder="Tyre Size" required="required" value="{{ old('t_size') }}" class="form-control{{ $errors->has('t_size') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('t_size'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('t_size') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Manufacturer</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="btn-group" data-toggle="buttons">
                                    <select class="form-control" id="manufacturer" name="manufacturer" onchange="gen_tire_name()">
                                        <option value="0">SELECT MANUFACTURER</option>
                                        <option value="1">JK</option>
                                        <option value="2">MRF</option>
                                        <option value="3">CEAT</option>
                                        <option value="4">XCEED</option>
                                        <option value="5">YOKOHAMA</option>
                                    </select>
                                    @if ($errors->has('manufacturer'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('manufacturer') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tyre Name <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="name" name="name" required="required" value="{{ old('name') }}" placeholder="Tyre Name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} col-md-7 col-xs-12">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
function gen_tire_name(){
    var tire_size = $('#t_size').val();

    var manifac_name = $('#manufacturer :selected').text();
    if($('#manufacturer').val() !='0'){
        var tire_name = manifac_name +' '+ tire_size;
        $('#name').val(tire_name)
    }else{
        $('#name').val('');
    }
}
</script>
@endsection