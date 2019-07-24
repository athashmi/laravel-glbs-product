<div class="col-lg-12 m-b-10 m-t-10">
	<div class="form-group form-group-default">
	    <label>Search Package</label>
	    <input type="search" id="search-package" class="form-control" >
	</div>
</div>

<div class="packages_render">
</div>
<div class="dataTables_wrapper">
	<div class="col-ms-12 pagination-div pull-right dataTables_paginate paging_simple_numbers">
	  <ul class="pagination pagination-la"></ul>
	  <div class="clearfix"></div>
	</div>
</div>



@section('script')
@parent
<script src="{{URL::asset('js/masonry.pkgd.min.js')}}"></script>


<script id="packages-json" type="text/x-handlebars-template">
    <div class="col-lg-4 pkg">
      <div id="card-linear-color" class="card card-default card-address">
        <div class="card-header  ">
            <div class="card-title">Tracking # : @{{tracking_number}}
            </div>
           
            <hr class="m-b-0"/>
        </div>
        <div class="card-body">
            <div class="col-sm-height sm-no-padding">
                <h3>
                <span class="semi-bold">@{{name}}</span></h3>

                <address>
                <strong> @{{#if street}}
                            @{{street}}
                          @{{else}}

                        @{{/if}}</strong>
                <br>
                @{{#if city}}
                 @{{city}}
                @{{/if}},
                @{{#if state}}
                  @{{state}}
                @{{/if}}<br>

                @{{#if zip_code}}
                  @{{zip_code}}
                @{{/if}}
               ,

               @{{#if country}}
                  @{{country.name}}
                @{{/if}}
                <br/>
                <abbr title="Phone">P:</abbr>
                 @{{#if phone}}
                  @{{phone}}
                @{{/if}}
                </address>
                </div>
        </div>
      </div>
    </div>
</script>

<script>
var pkg_grid_template ='';

var ajaxPackagesGrid = function(href){
    //console.log(href);
    $.ajax({
    type: "GET",
    url: href,
    data: {'text' : $('#search-package').val()},
    dataType: "JSON",
      success: function (response) {
        if(response.status == 1){

          console.log(response);
          //contentAddress(response);    

           if(response.data.data != ""){
              packagesRender(response);
            }
            else
            {
              noAddressFound();
            }

            
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status == 422) {
          
        }
      }
    });
  }

   var check = 1; 
  var packagesRender = function(response,p){

   var html = '<div class="row package_cards">';

                $.each(response.data.data,function(index,value){
                  html += pkg_grid_template(value);
                });
              html +='</div><hr/><div class="clearfix"></div>';

              $(".packages_render").html(html);

              var grid = document.querySelector('.package_cards');

              var msnry = new Masonry(grid, {
                // options...
                itemSelector: '.pkg',
                //columnWidth: 200
              });

              if(check == 1 && response.data.data !=""){
                //console.log('ooo---'+response.data.data);
                 paginate(response.data.total,response.data.per_page);
                 check++;
               }
               if(p == 1){
                if(response.data.data != ""){
               // console.log('ooo---'+response.data.data.total);

                  $('.pagination-la').show();
                 paginate(response.data.total,response.data.per_page);
                }else{
                  $('.pagination-la').hide();
                }
               }
  }


 var paginate = function(total,per_page){
    
     $('.pagination-la').pagination({
        items: total,
        itemsOnPage: per_page,
        //cssStyle: 'light-theme',
        hrefTextPrefix:'?page=',
        listStyle: 'paginate_button',
        prevText: '<',
        nextText: '>',
        
        onPageClick: function(pageNumber, event) {
          ajaxaddress('{{route("storage.ajax-storage-packages")}}?page='+pageNumber);
          // Callback triggered when a page is clicked
          // Page number is given as an optional parameter
        },
        onInit:function(){
          $('.page-link-href').parent().addClass('paginate_button');
         
          $('a.current').parent().addClass('active');

        }
    });
}
</script>

@endsection

  @section('document_ready')
  @parent
      ajaxPackagesGrid('{{route("storage.ajax-storage-packages")}}');

      pkg_grid_template = Handlebars.compile($("#packages-json").html());
  @endsection