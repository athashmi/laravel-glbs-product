@section('styles')
@parent
<link href="{{URL::asset('revox/assets/plugins/select2/css/select2-new.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
@parent
<script src="{{URL::asset('revox/assets/plugins/select2/js/select2-new.min.js')}}" type="text/javascript"></script>
@endsection