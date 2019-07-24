@extends('revox-theme.layout.main')
@section('content')
<div class="content">
<div class="jumbotron" data-pages="parallax">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
<div class="inner">
{{ Breadcrumbs::render('social_login') }}
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
<div class="card-title">Social Logins Credentials
</div>
 
 
<div class="clearfix"></div>
</div>
<div class="card-body">
 <div class="row">
    
<div class="col-lg-4">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">Facebook
            </div>  
        </div>
        <div class="card-body">
            <form id="facebook_form"> 
                @csrf
                <input type="hidden" name="type" value="facebook_api" >
                @foreach($options['facebook_api'] as $fb)
                    <div class="form-group">
                        <label>
                            {{$fb->title}}
                        </label>
                        <input type="text" class="form-control" value="{{$fb->value}}" name="facebook_api[{{$fb->key}}]" id="facebook_{{$fb->key}}" placeholder="{{$fb->title}}">
                    </div>

                @endforeach
                
                <div class="row">
                    <div class="col-sm-12">
                        <input type="button" onclick="updateInfo('facebook_form')" value="update" class="btn btn-primary">
                    </div>
                </div>
           </form>
        </div>
    </div>
</div>


<div class="col-lg-4">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">Twitter
            </div>  
        </div>
        <div class="card-body">
            <form id="twitter_form">
                 @csrf
                     <input type="hidden" name="type" value="twitter_api" >

                @foreach($options['twitter_api'] as $twt)
                    <div class="form-group">
                        <label>
                            {{$twt->title}}
                        </label>
                        <input type="text" class="form-control" value="{{$twt->value}}" name="twitter_api[{{$twt->key}}]" id="twitter_{{$twt->key}}" placeholder="{{$twt->title}}">
                    </div>

                @endforeach
                
                <div class="row">
                    <div class="col-sm-12">
                        <input type="button" onclick="updateInfo('twitter_form')" value="update" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="card card-default">
        <div class="card-header ">
            <div class="card-title">Google Plus
            </div>  
        </div>
        <div class="card-body">
            <form id="googleplus_form">
                @csrf
                <input type="hidden" name="type" value="googleplus_api" >

                 @foreach($options['googleplus_api'] as $gplus)
                    <div class="form-group">
                        <label>
                            {{$gplus->title}}
                        </label>
                        <input type="text" class="form-control" value="{{$gplus->value}}" name="googleplus_api[{{$gplus->key}}]" id="googleplus_{{$gplus->key}}" placeholder="{{$gplus->title}}">
                    </div>

                @endforeach

                               
                <div class="row">
                    <div class="col-sm-12">
                        <input type="button" onclick="updateInfo('googleplus_form')" value="update" class="btn btn-primary">
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
            url: "{{route('setting.social-logins.update')}}",
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