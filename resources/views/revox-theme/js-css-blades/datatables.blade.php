@section('styles')
@parent
<link href="{{URL::asset('revox/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('revox/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('revox/assets/plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script')
@parent
<script src="{{URL::asset('revox/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('revox/assets/plugins/datatables-responsive/js/datatables.responsive.js')}}" type="text/javascript"></script>
 





<script src="{{URL::asset('revox/assets/plugins/datatables-responsive/js/lodash.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{URL::asset('js/handlebars.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
@endsection