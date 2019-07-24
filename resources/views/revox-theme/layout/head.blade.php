<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
<link rel="apple-touch-icon" href="{{asset('revox/pages/ico/60.png')}}">
<link rel="apple-touch-icon" sizes="76x76" href="{{asset('revox/pages/ico/76.png')}}">
<link rel="apple-touch-icon" sizes="120x120" href="{{asset('revox/pages/ico/120.png')}}">
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('revox/pages/ico/152.png')}}">
<link rel="icon" type="image/x-icon" href="{{asset('revox/favicon.ico')}}" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name = "csrf-token" content="{{ csrf_token() }}" />
{{--<link href="{{URL::asset('revox/assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('revox/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />--}}

{{--<link href="{{URL::asset('revox/assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />

<link href="{{URL::asset('revox/assets/plugins/nvd3/nv.d3.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{URL::asset('revox/assets/plugins/mapplic/css/mapplic.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('revox/assets/plugins/rickshaw/rickshaw.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('revox/assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{URL::asset('revox/assets/plugins/jquery-metrojs/MetroJs.css')}}" rel="stylesheet" type="text/css" media="screen" />--}}
<link href="{{URL::asset('revox/pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
<link class="main-stylesheet" href="{{URL::asset('css/all.css')}}" rel="stylesheet" type="text/css" />

<link href="{{URL::asset('revox/assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
@section('styles')
@show
<link class="main-stylesheet" href="{{URL::asset('revox/pages/css/pages.css')}}" rel="stylesheet" type="text/css" />
<link class="main-stylesheet" href="{{URL::asset('css/custom.css')}}" rel="stylesheet" type="text/css" />

<style type="text/css">
	@section('style')
	@show
</style>
