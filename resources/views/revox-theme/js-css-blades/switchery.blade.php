@section('styles')
@parent
<link href="{{URL::asset('css/switchery.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
@parent
<script src="{{URL::asset('js/switchery.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
	// Success color: #10CFBD
	elems.forEach(function(html) {
	  var switchery = new Switchery(html, {color: '#10CFBD'});
	});
</script>
@endsection