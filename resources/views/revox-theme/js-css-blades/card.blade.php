@section('styles')
@parent
@endsection
@section('script')
@parent
<script type="text/javascript" src="{{URL::asset('js/payment-card/card.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/payment-card/jquery.payform.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/payment-card/i18next.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/payment-card/i18nextXHRBackend.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/payment-card/i18nextBrowserLanguageDetector.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/payment-card/jquery-i18next.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/payment-card/e-payment.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/payment-card/jquery.mCustomScrollbar.concat.min.js')}} "></script>
@endsection