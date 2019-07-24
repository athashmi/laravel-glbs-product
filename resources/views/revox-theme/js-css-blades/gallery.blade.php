@section('styles')
@parent
<link href="{{URL::asset('css/MetroJs.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('css/dialog.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('css/dialog-sandra.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('css/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('css/jquery.nouislider.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
@parent

<script type="text/javascript" src="{{asset('revox/assets/plugins/jquery-metrojs/MetroJs.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revox/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revox/assets/plugins/jquery-isotope/isotope.pkgd.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revox/assets/plugins/codrops-dialogFx/dialogFx.js')}}"></script>
<script type="text/javascript" src="{{asset('revox/assets/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revox/assets/plugins/jquery-nouislider/jquery.nouislider.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revox/assets/plugins/jquery-nouislider/jquery.liblink.js')}}"></script>
<script type="text/javascript" src="{{asset('js/gallery.js')}}"></script>
@endsection