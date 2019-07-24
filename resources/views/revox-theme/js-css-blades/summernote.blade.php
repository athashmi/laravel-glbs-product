@section('styles')
@parent
<link href="{{URL::asset('revox/assets/plugins/summernote/css/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
@parent
<script src="{{URL::asset('revox/assets/plugins/summernote/js/summernote.min.js')}}" type="text/javascript"></script>
@endsection