@section('styles')
@parent
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/jquery.filer.css')}}" />
@endsection
@section('script')
@parent
<script type="text/javascript" src="{{URL::asset('js/jquery.filer.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/custom-filer.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/jquery.fileuploads.init.js')}}"></script>
@endsection