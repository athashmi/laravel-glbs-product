@section('styles')
@parent
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/sweetalert.css')}}" />
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/component.css')}}" />
@endsection
@section('script')
@parent
<script type="text/javascript" src="{{URL::asset('js/sweetalert.min.js')}}"></script>
{{-- <script type="text/javascript" src="{{URL::asset('js/modal.js')}}"></script> --}}
<script type="text/javascript" src="{{URL::asset('js/modalEffects.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/classie.js')}}"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
@endsection