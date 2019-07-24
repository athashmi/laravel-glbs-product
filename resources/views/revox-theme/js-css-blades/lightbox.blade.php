@section('styles')
@parent
<link href="{{URL::asset('css/simplelightbox.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('script')
@parent

<script type="text/javascript" src="{{asset('js/simple-lightbox.js')}}"></script>
@endsection