<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Global Shopaholics</title>
        @include('revox-theme.layout.head')
    </head>
    <body  class="fixed-header dashboard">
        @include('revox-theme.layout.nav')
        <div class="page-container " id="app">
            @include('revox-theme.layout.header')
            <div class="page-content-wrapper">
                
                @section('content')
                @show
                
                @include('revox-theme.layout.footer')
            </div>
        </div>
        
        {{--@include('revox-theme.layout.right-side-chat')--}}
        @include('revox-theme.layout.search')
        
        @include('revox-theme.layout.script')
        <script>
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $('.modal-footer').addClass('loading_class');
        $('<div class="loader-gif pull-left col-sm-2 hide"><img class="image-responsive-height demo-mw-50" src="{{asset('revox/assets/img/demo/progress.svg')}}" alt="Progress"></div>').appendTo($('.loading_class'));
        $(document).bind("ajaxSend", function(){
        $(".loader-gif").removeClass('hide');
        }).bind("ajaxComplete", function(event, xhr, ajaxOptions, data) {
        $(".loader-gif").addClass('hide');
        });
 
         
        </script>
    </body>
</html>