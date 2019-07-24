
<table class="table table-hover demo-table-search table-responsive-block datatable img_cell my_storage" id="">
	<thead>
	    <tr>
	        <th><i class="fa fa-tablet fa-lg"></i></th>
	        <th>Package Image</th>
	        <th>Package ID</th>
	        <th>Date Received</th>
	        <th>Tracking Number</th>
	        <th>Action</th>
	    </tr>
	</thead>
	<tbody>
	</tbody>
</table>

@section('styles')
@parent
<style type="text/css">
	th.sorting{
		width:auto !important;
	}
	th.sorting_asc{
		width:auto !important;
	}
	th.sorting_desc{
		width:auto !important;
	}
	th.sorting_disabled{
		width:auto !important;
	}
</style>
@endsection
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function() {
	
    package_outgoing_tbl = $('.my_storage').DataTable({
    processing: true,
    serverSide: true,
    retrieve: true,
    responsive:true,
    ajax: '{{route("storage.getmystoragepackage")}}',
    columns: [
        {data: 'checkBox',"orderable": false,"searchable": false,"className": "text-center chkbx"},
        {data: 'image',"orderable": false,"className": "text-center img_cell"},
        {data: 'package_id',"className": "text-center",'width':'20%'},
        {data: 'created_at',"className": "text-center"},
        {data: 'tracking_number',"className": "text-center",'width':'20%'},
        {data: 'action',"className": "text-center","orderable": false}
    ],
     order: [[ 2, "desc" ]],
         "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            //console.log(rows);
           $(rows).each(function(i,row){
   		//var row_data = ;
   		var childs = api.row(row).data().child_packages;
   		var split_rows = '';
   		
   		if(childs.length !== 0)
   		{
           			
       		$(childs).each(function(i,pkg){
       			var j=i;
       			var b_b_2 = (((childs.length)-1) == i)?"b-b-2":"";
       			var cls_bbnone = ((childs.length-1) > i)?"b-b-none":"";
       			var diabled_ = (pkg.consolidation_request_id != null)?"disabled":"";
       			var consolidated = (pkg.consolidation_request_id != null)?"Consolidated":"";
       			++j;
 				
	           	split_rows += '<tr class="b-l-r-2 '+b_b_2+' m-b-0-imp">\
				           		<td class="text-right '+cls_bbnone+' text-white" >\<label class="label label-warning">Child-pkg-'+(j)+'</label>\
				           		</td>\
				           		<td> <input type="checkbox" data-id="'+pkg.id+'" name="checkBox" class="checkbox_package" '+diabled_+'>&nbsp;&nbsp;<label class="font-weight-bold font-italic">'+consolidated+'</label>\ </td>\
				     					<td class="text-center">'+pkg.package_id+'</td>\
				     					<td class="text-center">'+pkg.created_at+'</td>\
				     					<td class="text-center">'+pkg.tracking_number+'</td>\
				     					<td class="text-center"><button data-toggle="modal" data-id="'+pkg.id+'" data-target="#package_details_modal" class="btn btn-primary" >Details</button></td>\
				     				</tr>';

 				var b_l_r_2 = (((childs.length)-1) == i)?"b-l-r-2 b-t-2 m-b-0-imp":"";

 				$(row).addClass(b_l_r_2);

 				if((childs.length-1) == i)
 					split_rows += '<tr><td colspan="6" class="b-b-none"></td></tr>';
			 	});

	       		$(row).after(split_rows);

	       		api.cell(api.row(row),'.chkbx').data('Parent');
	       		
	       		//$(row).children(':nth-child(1)').addClass('bg-master-dark text-white');
	       		$(row).children(':nth-child(1)').html('<label class="label label-info">Parent</label>');

	       		//api.cell(api.row(row),'.img_cell').data('');
	       		$(row).children(':nth-child(1),:nth-child(2)').addClass('b-b-none');
			}
		           	
	            	//console.log(row.attr('track_no'));
	    });
           
 
            /*api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
            		//console.log(group.indexOf(group));
                if ( last !== group ) {
                	
	                	console.log(group+'----'+last);
	                    $(rows).eq( i ).before(
	                        '<tr class="group"><td colspan="5">'+group+'</td></tr>'
	                    );
	               
                    last = group;
                }
            } );*/
        }
    });


    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"}); 
});


</script>
@endsection