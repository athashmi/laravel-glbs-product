@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('calculator') }}
{{-- <ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Data Tables</li>
</ol> --}}

 
</div>
</div>
</div>



<div class=" container-fluid   container-fixed-lg bg-white">
<div class="card card-transparent">
<div class="card-header ">
<div class="card-title">Shipping Cost Calculator
</div>
 
 
<div class="clearfix"></div>
</div>
<div class="card-body">
 
<div class="box-body calculator-color">
<div class="row m-t-20 p-t-20">
    <div class="col-md-5 col-xs-12 input-section padding-0 calculator">
        <form id="shippingCalculatorForm" onsubmit="return getShippingRates(this)">
          
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="form-group">
                        <label>  Country</label>
                        <select  name="to_country" class="form-control select2 full-width">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{$country->iso}}">{{$country->name}}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                        <label> City</label>
                        <input type="text" name="to_city" class="form-control" placeholder="City" required>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                        <label> Zip</label>
                        <input type="text" name="to_zip" class="form-control"  placeholder="Zip Code" >
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="form-group">
                        <label> Measurement Units</label>
                        <select name="measurement_unit" class="select2 form-control" required>
                            <option value="">Select Unit Measure</option>
                            <option value="1">Pound/inch</option>
                            <option value="2">Kg/CM</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                  <h5>Box # 1</h5>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                        <label> Weight</label>
                        <input  type="text" class="form-control" name="parcel_weight[]"  placeholder="Weight" required>
                    </div>
                </div>

                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                        <label> Length</label>
                        <input type="text" class="form-control" name="parcel_length[]" placeholder="Length" required>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                        <label> Width</label>
                        <input type="text" class="form-control" name="parcel_width[]" placeholder="Width" required>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                        <label> Height</label>
                        <input type="text" class="form-control" name="parcel_height[]" placeholder="Height" required>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12" id="add_box_button">
                    <div class="form-group">
                        <button type="button" onclick="addNewBox()" class="btn btn-primary btn-sm" name="button">Add Box <i class="fa fa-plus"></i> </button>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="form-group loading_class">
                        <button type="submit"  class="pull-left col-sm-8 btn-block custom-button btn btn-primary">GET SHIPPING RATES</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-7 col-xs-12 output-section">
    </div>
</div>
</div>
<div class="shipper-full-data display-none">
    <div class="row">
        <div class="col-md-12"><i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp;Delivery to your door handled by the carrier selected. </div>
    </div>
    <div class="row">
        <div class="col-md-6"><i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp;Estimated Delivery time</div>
        <div class="col-md-6 est_delivery"></div>
    </div>
    <div class="row">
        <div class="col-md-6"><i class="fa fa-suitcase" aria-hidden="true"></i> &nbsp;Maximum Weight</div>
        <div class="col-md-6 max_weight"></div>
    </div>
    <div class="row">
        <div class="col-md-6"><i class="fa fa-circle-thin" aria-hidden="true"></i> &nbsp;Dimensional Weight</div>
        <div class="col-md-6 dim_weight"></div>
    </div>
    <div class="row">
        <div class="col-md-6"><i class="fa fa-crosshairs" aria-hidden="true"></i> &nbsp;Maximum Size</div>
        <div class="col-md-6 max_size"></div>
    </div>
    <div class="row">
        <div class="col-md-6"><i class="fa fa-truck" aria-hidden="true"></i> &nbsp;Tracking</div>
        <div class="col-md-6 tracking"></div>
    </div>
    <div class="row">
        <div class="col-md-6"><i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;Frequency of departure</div>
        <div class="col-md-6 fod"></div>
    </div>
    <div class="row row-last">
        <div class="col-md-6"><i class="fa fa-medkit" aria-hidden="true"></i> &nbsp;Insurance</div>
        <div class="col-md-6 insurance"></div>
    </div>
</div>


</div>
</div>

</div>



</div>



 @include('revox-theme.js-css-blades.select2')
@endsection
@section('script')
@parent
<script>
var box_no = 1;

function getShippingRates(e) {
    $(e).append('<div class="loading"></div>');
    $('.custom-white-button').prop('disabled', true);
    var parcel_length= new Array();
    $('input[name^="parcel_length"]').each(function()
    {
      parcel_length.push($(this).val());
    });
    var parcel_width= new Array();
    $('input[name^="parcel_width"]').each(function()
    {
      parcel_width.push($(this).val());
    });
    var parcel_height= new Array();
    $('input[name^="parcel_height"]').each(function()
    {
      parcel_height.push($(this).val());
    });
    var parcel_weight= new Array();
    $('input[name^="parcel_weight"]').each(function()
    {
      parcel_weight.push($(this).val());
    });

    $.ajax({
        url: "{{route('admin.shipping.getshippingrate')}}",
        type:'post',
        data: {
            "to_country"    : $("[name=to_country]").val(),
            "to_city"       : $("[name=to_city]").val(),
            "to_zip"        : $("[name=to_zip]").val(),

            "parcel_length" : parcel_length,
            "parcel_width"  : parcel_width,
            "parcel_height" : parcel_height,
            "parcel_weight" : parcel_weight,

            "measurement_unit" : $("[name=measurement_unit]").val(),
            "call_from"        : 'admin'
        },
        success: function(response) {
            var rates = JSON.parse(response);
            var rates_tile = "";
           for(var i=0; i<rates.length; i++){
                rates_tile    +=  '<div class="sub-sec row">';
                rates_tile    +=  '<div class="col-sm-7 col-xs-7 img"><img src="/images/carrier/'+rates[i].service+'.png" height="25px;"> '+rates[i].service+'</div>';
                rates_tile    +=  '<div class="col-sm-2 col-xs-2  rate"><span>$'+rates[i].rate.toFixed(2)+'</span></div>';
                rates_tile    +=  '<div class="col-sm-2 col-xs-3">'+rates[i].actaul_rate.toFixed(2)+'</div>';
                rates_tile    +=  '<div class="clear"></div>';
                rates_tile    +=  '</div>';
            }
            $(".output-section").html(rates_tile);
            $(".loading").remove();
        },
        error: function(xhr) {
            console.log(xhr);
        }
    }); // ajax end
    return false;
}


$( "#splc_calculator" ).addClass( "active" );


function addNewBox(){
  box_no ++;
  var html="";
  html+='<div id="box_'+box_no+'"><div class ="row">'
  +'<div class="col-md-12 col-xs-12">'
    +'<h5>Box # '+box_no+' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-danger btn-sm" onclick="removeBox('+box_no+')" type="button"><i class="fa fa-trash"></i></button></h5>'
    +'</div>';
    html+='<div class="col-md-6 col-xs-6">'
      +'<div class="form-group">'
          +'<label> Weight</label>'
          +'<input  type="text" class="form-control" name="parcel_weight[]"  placeholder="Weight" required>'
      +'</div>'
  +'</div>'
  +'<div class="col-md-6 col-xs-6">'
      +'<div class="form-group">'
          +'<label> Length</label>'
          +'<input type="text" class="form-control" name="parcel_length[]" placeholder="Length" required>'
      +'</div>'
  +'</div>'
  +'<div class="col-md-6 col-xs-6">'
      +'<div class="form-group">'
          +'<label> Width</label>'
          +'<input type="text" class="form-control" name="parcel_width[]" placeholder="Width" required>'
      +'</div>'
  +'</div>'
  +'<div class="col-md-6 col-xs-6">'
      +'<div class="form-group">'
          +'<label> Height</label>'
          +'<input type="text" class="form-control" name="parcel_height[]" placeholder="Height" required>'
      +'</div>'
  +'</div>'
  +'</div></div>';
  $("#add_box_button").before(html);
}

function removeBox(id){
  $("#box_"+id).remove();
  box_no--;
}
</script>
@endsection

@section('document_ready')
@parent
$(".select2").select2();
@endsection