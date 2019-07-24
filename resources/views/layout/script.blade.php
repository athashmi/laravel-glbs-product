   {{-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
 --}}
 {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
   <script type="text/javascript" src="{{URL::asset('adminity-components/jquery/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('adminity-components/jquery-ui/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('adminity-components/popper/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('adminity-components/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{URL::asset('adminity-components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{URL::asset('adminity-components/modernizr/js/modernizr.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('adminity-components/modernizr/js/css-scrollbars.js')}}"></script>

    
    {{-- <script type="text/javascript" src="{{URL::asset('js-components/dashboard/custom-dashboard.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/script.min.js')}}"></script> --}}




   {{--  <script type="text/javascript" src="{{URL::asset('js/validate.min.js')}}"></script> --}}

   
    <script>
      "use strict";
      var $window = $(window);
      $(document).ready(function(){

         
          //add id to main menu for mobile menu start
          var getBody = $("body");
          var bodyClass = getBody[0].className;
          $(".main-menu").attr('id', bodyClass);


          $('.date').datepicker({
              dateFormat: "mm/dd/yy",
              prevText: '<i class="fa fa-caret-left"></i>',
              nextText: '<i class="fa fa-caret-right"></i>'

          });

        @section('document_ready')
        @show

        $('.theme-loader').fadeOut('slow', function() {
          $(this).remove();
        });


      //alert(this.location.pathname);
        $('a[href="' + this.location + '"]').parent().addClass('active');
        if($('a[href="' + this.location + '"]').parent().parent().hasClass('pcoded-submenu'))
          {
            $('a[href="' + this.location + '"]').parent().parent().parent().addClass('pcoded-trigger');
          }

          $('.modal-header').addClass('bg-primary');

      });
      
    </script>
    @section('script')
    @show

    <script src="{{URL::asset('js/pcoded.min.js')}}"></script>

    <script src="{{URL::asset('js/vartical-layout.min.js')}}"></script>
     <script src="{{URL::asset('js/custom.js')}}"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script> --}}