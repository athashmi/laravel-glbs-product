{{--<script src="{{URL::asset('revox/assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/popper/umd/popper.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{URL::asset('revox/pages/js/pages.js')}}"></script>--}}

<script src="{{URL::asset('js/app.js')}}"></script>
<script src="{{URL::asset('js/all.js')}}"></script>


<script>
  "use strict";

 
    $(document).ready(function(){

   $('a[href="' + this.location + '"]').parent().addClass('active');
   $('a[href="' + this.location + '"]').next().addClass('bg-success');
        if($('a[href="' + this.location + '"]').parent().parent().hasClass('sub-menu'))
          {
            $('a[href="' + this.location + '"]').parent().parent().parent().addClass('open active');
            $('a[href="' + this.location + '"]').parent().parent().prev().prev().find('span.arrow').addClass('open active');
          }

$('.modal-header').append('<hr style="width:100%;"/>');

$('.btn-toggle-sidebar').trigger('click');

//$('.modal-footer').append('<div class="clearfix"></div>');
    
    
    @section('document_ready')
    
    @show

    $(document).on('show.bs.modal', function(e) 
      {
        //alert('ll');
        
        //$(this).find(':input').val('');
       // console.log('llll');
       
     });
   
  });

    function loader(e){
      var html = '<div class="loader-gif pull-left"><img class="image-responsive-height demo-mw-50" src="{{asset('revox/assets/img/demo/progress.svg')}}" alt="Progress"></div>';
      $(e).addClass('display-none');
      $(html).insertAfter(e);
    }

    function hide_loader(e){
     
      $(e).removeClass('display-none');
      $('.loader-gif').remove();
    }

</script>   


<script src="{{URL::asset('js/custom.js')}}"></script>
@section('script')
@show
