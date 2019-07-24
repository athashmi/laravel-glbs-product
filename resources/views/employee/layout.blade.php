<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Global Shopaholics</title>
        @include('revox-theme.layout.head')
    </head>
    <body  class="fixed-header dashboard">
        
        <div class="page-container p-0 " id="app">
            @include('employee.header')
            <div class="page-content-wrapper">
                
                @section('content')
                @show
                
                @include('revox-theme.layout.footer')
            </div>
        </div>
        
        
        @include('revox-theme.layout.search')
        @include('revox-theme.layout.script')
         <script src="{{URL::asset('js/employee-dashboard.js')}}"></script> 

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

         <script src="{{URL::asset('js/back_disable.js')}}"></script>
    </body>
</html>