<div class=" m-t-20">
    <table class="table table-framed datatable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Ref ID</th>
                <th>Opening Blanace</th>
                <th>Amount</th> 
                <th>Closing Blanace</th>
                <th>Processed By</th>
            </tr>
        </thead>
        <tbody>

     
        </tbody>
    </table>
</div>


 
@section('document_ready')
@parent
$(".datatable").css('width','100%');

var datatbl = $('.datatable').DataTable({
               
                processing: true,
                serverSide: true,
                ajax: '{{route('shopaholic.shopaholic-profile-wallet',$shopaholic->user->id)}}',
                columns: [
                 {data: 'created_at',"className": "text-center","width": "100%"},
                {data: 'ref_code',"className": "text-center"},
                {data: 'opening_balance',"className": "text-center"},
                {data: 'amount',"className": "text-center","width": "100%"},
                {data: 'closing_balance',"className": "text-center"},
                {data: 'processed_by',"className": "text-center"}
                ],
                "order": [[ 0, "desc" ]],
});
$("div.dataTables_length").parent().css({"flex-direction": "row"});
$("div.dataTables_info").parent().css({"flex-direction": "row"});
@endsection