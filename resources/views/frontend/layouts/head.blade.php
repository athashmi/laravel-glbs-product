    @include('frontend.layouts.head_tags')
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name = "csrf-token" content="{{ csrf_token() }}" />
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon and Apple Icons-->
    <link rel="icon" type="image/x-icon" href="{{asset('frontend/favicon.ico')}}">
    <link rel="icon" type="image/png" href="{{asset('frontend/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('frontend/touch-icon-iphone.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('frontend/touch-icon-ipad.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('frontend/touch-icon-iphone-retina.png')}}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{asset('frontend/touch-icon-ipad-retina.png')}}">
    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{asset('frontend/css/vendor.min.css')}}">
    <!-- Main Template Styles-->
    <link id="mainStyles" rel="stylesheet" media="screen" href="{{asset('frontend/css/styles.min.css')}}">
    <!-- Modernizr-->
    <link href="{{asset('frontend/css/countrySelect.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('frontend/js/modernizr.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" media="screen" href="{{asset('frontend/css/updated_custom.css')}}">
   
    