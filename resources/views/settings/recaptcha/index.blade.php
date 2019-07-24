@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('recaptcha') }}
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
<div class="card-title">Google reCaptcha Credentials
</div>
 
 
<div class="clearfix"></div>
</div>
<div class="card-body">
 <div class="row">
    
<div class="col-lg-4">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">ReCaptcha
            </div>  
        </div>
        <div class="card-body">
            <form id="recaptcha_form"> 
                @csrf
                <input type="hidden" name="type" value="recaptcha" >

                @foreach($options['recaptcha'] as $recaptcha)

                    <div class="form-group">
                    <label>
                        {{$recaptcha->title}}
                    </label>
                    <input type="text" class="form-control" value="{{$recaptcha->value}}" name="recaptcha[{{$recaptcha->key}}]" id="recaptcha{{$recaptcha->key}}" placeholder="{{$recaptcha->title}}">
                </div>

                @endforeach
                
                
               
                <div class="row">
                    <div class="col-sm-12">
                        <input type="button" onclick="updateInfo('recaptcha_form')" value="update" class="btn btn-primary">
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
            url: "{{route('setting.recaptcha.update')}}",
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