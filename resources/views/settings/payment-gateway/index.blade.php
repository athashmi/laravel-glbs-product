@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('payment_gateways') }}
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
<div class="card-title">Payment Gateways Credentials
</div>
 
 
<div class="clearfix"></div>
</div>
<div class="card-body">
 <div class="row">
    
<div class="col-lg-4">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">Authorize.Net
            </div>  
        </div>
        <div class="card-body">
            <form id="authorize_form"> 
                @csrf
                <input type="hidden" name="type" value="authorize_net" >
                @foreach($options['authorize_net'] as $auth_net)

                    <div class="form-group">
                    <label>
                        {{$auth_net->title}}
                    </label>
                    <input type="text" class="form-control" value="{{$auth_net->value}}" name="authorize_net[{{$auth_net->key}}]" id="authorize_net{{$auth_net->key}}" placeholder="{{$auth_net->title}}">
                </div>

                @endforeach
               
               
                <div class="row">
                    <div class="col-sm-12">
                        <input type="button" onclick="updateInfo('authorize_form')" value="update" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">Paypal
            </div>  
        </div>
        <div class="card-body">
            <form id="paypal"> 
                @csrf
                <input type="hidden" name="type" value="paypal" >

                @foreach($options['paypal'] as $paypal)

                    <div class="form-group">
                    <label>
                        {{$paypal->title}}
                    </label>
                    <input type="text" class="form-control" value="{{$paypal->value}}" name="paypal[{{$paypal->key}}]" id="paypal{{$paypal->key}}" placeholder="{{$paypal->title}}">
                </div>

                @endforeach
               
               
                <div class="row">
                    <div class="col-sm-12">
                        <input type="button" onclick="updateInfo('paypal')" value="update" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>

</div>



</div>


 

@endsection
@section('script')
@parent
<script type="text/javascript">
function updateInfo(formid)
{
        $.ajax({
            type: "POST",
            url: "{{route('setting.payment-gateways.update')}}",
            data: $("#"+formid).serialize(),
            dataType: "JSON",
            success: function (response) {
              if(response.status == 1)
              {
                 responseMsg("update","{{asset('images/icons8-ok-filled-480.png')}}");
              }
              if(response.status == 'error')
              {
                responseMsg("error","{{asset('images/error.png')}}",response.error);
              }
          },
          error: function (jqXHR, exception) {
              
            }
        });
   
}



</script>
@endsection