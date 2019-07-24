@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('posts') }}
			</div>
		</div>
	</div>
	<div class=" container-fluid   container-fixed-lg bg-white">
		<div class="card card-transparent">
			<div class="card-header ">
				<div class="card-title">Blog Post Listing
				</div>
				<div class="pull-right">
					<div class="col-xs-12">
						<a href="{{route('blog_post.create')}}" class="btn btn-primary float-sm-right"><i class="fa fa-plus"></i> Add Post</a>
						
					</div>
				</div>
				
				<div class="clearfix"></div>
			</div>
			<div class="card-body">
				<table class="table table-hover demo-table-search table-responsive-block datatable" id="">
					<thead>
						<tr>
							<th>Title</th>
							<th>Type</th>
							<th>Status</th>
							<th>Created_by</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		
	</div>
</div>


	

@include('blog-post.assign-user-modal')
{{-- @include('blog-post.assign-country-modal') --}}
@include('revox-theme.js-css-blades.datatables')
@include('revox-theme.js-css-blades.sweetalert')
@include('revox-theme.js-css-blades.select2')


@endsection
@include('revox-theme.js-css-blades.typeahead')
@section('document_ready')
@parent
	$(".select2user").select2({
	    closeOnSelect: false,
	    ajax: {
	        url: "{{route('blog_post.searchuser')}}",
	        dataType: 'json',
	        delay: 250,
	        data: function (params) {
	            
	            return {
	                q: params.term, // search term
	                page: 10
	            };
	        },
	        processResults: function (data, page) {
	        
	            return {
	                results: data
	            };
	        },
	        cache: true
	    },
	    escapeMarkup: function (markup) {
	        return markup;
	    }, // let our custom formatter work
	    minimumInputLength: 1,
	    templateResult: formatRepo, // omitted for brevity, see the source of this page
	    templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
	});
	$('.select2country').val([]).select2(); 
	 
    $(".datatable").css('width','100%');
    var id = 0;
    var datatbl = $('.datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('blog_post.getblogpost') }}',
    columns: [
        {data: 'title',"className": "text-center"},
        {data: 'type',"className": "text-center"},
        {data: 'status',"className": "text-center"},
        {data: 'created_by',"className": "text-center"},
        {data: 'action',orderable: false, searchable: false,"className": "text-center"}
    ],


    order: [[ 1, "asc" ]]
    });
    $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
@endsection
@section('script')
@parent
<script type="text/javascript">
	function formatRepo_old(repo) {
		console.log(repo);
    if (repo.loading) return repo.text;
   if(repo.shopaholic != null){
    var markup = '<div class="clearfix">' +
        '<div class="col-sm-6">' + repo.first_name +' '+repo.last_name+ '<b> ('+ repo.shopaholic.sn +')</b></div></div>';

    return markup;
	}else{
		var markup = '<div class="clearfix">' +
        '<div class="col-sm-6">' + repo.first_name +'</div></div>';

    return markup;
	}
}

function formatRepo(repo) {
		//console.log(repo);
    if (repo.loading) return repo.text;

    /*var markup = '<div class="ms-res-group">' + repo.user.first_name +' '+ repo.user.last_name + '</div>'+
    '<div class="country">' +
                '<div class="name"></div>' +
                '<div style="clear:both;"></div>' +
                '<div class="prop">' +
                    '<div class="lbl">Serial Number : </div>' +
                    '<div class="val">(' + repo.sn + ')</div>' +
                '</div>' +
                '<div class="prop">' +
                    '<div class="lbl">Country : </div>' +
                    '<div class="val">' + repo.user.country_id + '</div>' +
                '</div>' +
                '<div style="clear:both;"></div>' +
            '</div>';*/
   
    var markup = '<div class="clearfix">' +
        '<div class="col-sm-6">' + repo.user.first_name +' '+repo.user.last_name+ '<b> ('+ repo.sn +')</b></div></div>';

    return markup;
	
}


function formatRepoSelection(repo) {
	 
	//if(repo.shopaholic != null){
		return repo.user.first_name+' ('+ repo.sn +')'; // || repo.text;
	//}
	

    
}

function statusChanges(status,id)
{
    if(status == 'active'){
     swal({
                title: "You want to DeActive the Status",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'DeActivate',
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm){
                if (isConfirm) {
                     $.ajax({
                            type: "POST",
                            url: "{{URL::route('blog_post.changestatus')}}",
                            data: {'id':id,'status':'inactive'},
                            dataType: "JSON",
                            success: function (response) {
                              if(response.status == 1)
                              {
                                swal("Success", "Status Updated :)", "success");
                                $('.datatable').DataTable().draw();
                              }
                          },
                          error: function (jqXHR, exception) {
                              
                            }
                    });
                   }else {
                    swal("Cancelled", "Your Status can't update)", "error");
                  }
        });
	}
	if(status == 'inactive'){
	     swal({
	                title: "You want to Active the Status",
	                text: '',
	                type: "warning",
	                showCancelButton: true,
	                confirmButtonColor: "#DD6B55",
	                confirmButtonText: 'Activate',
	                cancelButtonText: "No, cancel please!",
	                closeOnConfirm: false,
	                closeOnCancel: false
	              },
	              function(isConfirm){
	                if (isConfirm) {
	                    $.ajax({
	                            type: "POST",
	                            url: "{{URL::route('blog_post.changestatus')}}",
	                            data: {'id':id,'status':'active'},
	                            dataType: "JSON",
	                            success: function (response) {
	                              if(response.status == 1)
	                              {
	                                swal("Success", "Status Updated :)", "success");
	                                $('.datatable').DataTable().draw();
	                              }
	                          },
	                          error: function (jqXHR, exception) {
	                              
	                            }
	                    });
	                   }else {
	                    swal("Cancelled", "Your Status can't update)", "error");
	                  }
	        });
	}
}
</script>
@endsection