{{-- @section('styles')
@parent
<link href="{{URL::asset('css/timeTo.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
@parent
<script src="{{URL::asset('js/flipclock.min.js')}}" type="text/javascript"></script>
@endsection --}}

@section('styles')
@parent
<link href="{{URL::asset('css/flipclock.css')}}" rel="stylesheet" type="text/css" />
{{-- <link href="{{URL::asset('css/simplyCountdown.theme.losange.css')}}" rel="stylesheet" type="text/css" /> --}}
@endsection
@section('script')
@parent
<script src="{{URL::asset('js/countid.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/flipclock.min.js')}}" type="text/javascript"></script>
@endsection