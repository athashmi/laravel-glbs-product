@section('styles')
@parent
<link href="{{URL::asset('revox/assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('revox/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('revox/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
@parent
<script src="{{URL::asset('revox/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
@endsection