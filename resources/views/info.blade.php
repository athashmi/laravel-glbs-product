@extends('revox-theme.layout.main')
@section('content')
<div v-pre>
<div class="col-md-12">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-4">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Coding Standard Info</h4>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Revox Theme Folders Renamed.</h5>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="order-table" class="table table-striped  no-footer">
                    <thead>
                        <tr>
                            <th>Revox Theme Folder</th>
                            <th>Laravel theme</th>
                            <th>Laravel URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                               revox-theme/assets
                            </td>
                            <td>
                                gs-production/public/revox/assets
                            </td>
                            <td>
                            <pre> @{{URL::asset('revox/assets')}} </pre>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           revox-theme/pages
                        </td>
                        <td>
                            gs-production/public/revox/pages
                        </td>
                        <td>
                        <pre> @{{URL::asset('revox/pages')}} </pre>
                    </td>
                    </tr>

                    
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Custom Javascript and Stylesheet Files.</h5>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
              
        <table id="order-table" class="table table-striped  no-footer">
            <thead>
                <tr>
                    <th>Laravel Theme</th>
                    <th>Laravel URL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>gs-production/public/css/cutom.css</td>
                    <td>@{{URL::asset('css/custom.css')}}</td>
                </tr>
                <tr>
                    <td>gs-production/public/js/cutom.js</td>
                    <td>@{{URL::asset('js/custom.js')}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<div class="col-sm-12">
<div class="card">
<div class="card-header">
    <h5>Js Libraries Used In Project</h5>
</div>
<div class="card-body panels-wells">
    
    <div class="dt-responsive table-responsive">
        <table id="order-table" class="table table-striped  no-footer">
            <thead>
                <th>Library Name</th>
                <th>Laravel URL</th>
            </thead>
            <tbody>
                <tr>
                    <td><b>Datatables</b></td>
                    <td> @verbatim @include('revox-theme.js-css-blades.datatables') @endverbatim</td>
                </tr>
                <tr>
                    <td><b>Datepicker</b></td>
                    <td> @verbatim @include('revox-theme.js-css-blades.datepicker') @endverbatim</td>
                </tr>
                <tr>
                    <td><b>Select2</b></td>
                    <td> @verbatim @include('revox-theme.js-css-blades.select2') @endverbatim</td>
                </tr>
                <tr>
                    <td><b>Image-Upload</b></td>
                    <td> @verbatim @include('revox-theme.js-css-blades.image-upload') @endverbatim</td>
                </tr>
                <tr>
                    <td><b>Sweetalert</b></td>
                    <td> @verbatim @include('revox-theme.js-css-blades.sweetalert') @endverbatim</td>
                </tr>
                <tr>
                    <td><b>SummerNote</b></td>
                    <td> @verbatim@include('revox-theme.js-css-blades.summernote') @endverbatim</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="row">
    </div>
    </div>
</div>
</div>


<div class="col-sm-12">
<div class="card">
<div class="card-header">
    <h5>Js Libraries Usage</h5>
</div>
<div class="card-body panels-wells">
    
    
    
    <div class="row">
        <!-----------------panel 1------------------->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="card card-default">
                <div class="card-header  separator bg-complete">
                    <div class="card-title "><b>Select2 single select</b>
                    </div>
                </div>
                <div class="card-body"> 
                    Steps are as Below....
                    <ol>
                        <li> include Blade <br/>
                            @verbatim @include('revox-theme.js-css-blades.select2')  @endverbatim
                        </li>
                        <li>
                            Add select class like..
                            {{{'<select class="select"></select>'}}}  </li>
                            <li>initialize the select2 in document .ready section.<br/>
                                
                                $(".select").select2();
                            </li>
                        </ol> 
                </div>
            </div> 
        </div>
        <!-----------------panel 2------------------->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="card card-default">
                <div class="card-header  separator bg-complete">
                    <div class="card-title "><b>Select2 Multiple select</b>
                    </div>
                </div>
                <div class="card-body"> 
                    Steps are as Below....
                    <ol>
                        <li> include Blade <br/>
                            @verbatim @include('revox-theme.js-css-blades.select2')  @endverbatim
                        </li>
                        <li>
                            Add select class like..
                            {{{'<select class="select" multiple></select>'}}}
                        </li>
                            <li>initialize the select2 in document .ready section.<br/>
                                
                                $(".select").select2();
                            </li>
                        </ol> 
                </div>
            </div> 
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="card card-default">
                <div class="card-header  separator bg-complete">
                    <div class="card-title "><b>Datatables</b>
                    </div>
                </div>
                <div class="card-body"> 
                    Steps are as Below....
                    <ol>
                        <li> include Blade <br/>
                            @verbatim @include('revox-theme.js-css-blades.datatables')   @endverbatim
                        </li>
                        <li>
                            Add Table class like..
                             
<pre>
{{{'<table class="table datatable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Title</th>
        </tr> 
    </thead>
    <tbody>

    </tbody>
</table>'}}}
</pre>
                        </li>
                            <li>initialize the datatable in document .ready section.<br/>
<pre>
var datatbl = $('.datatable').DataTable({
  processing: true,
  serverSide: true,
  ajax: 'http://example.com',
  columns: [
    {data: 'name'},
    {data: 'title'}
  ]
  });
</pre>
                            </li>
                        </ol> 
                </div>
            </div> 
        </div>


     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="card card-default">
                <div class="card-header  separator">
                    <div class="card-title "><b>Datepicker</b>
                    </div>
                </div>
                <div class="card-body"> 
                    Steps are as Below....
                    <ol>
                        <li> include Blade <br/>
                            @verbatim @include('revox-theme.js-css-blades.datepicker')  @endverbatim
                        </li>
                        <li>
                            Add datepicker class like..
                            {{{'<input type="text" id="dob" name="dob_date">'}}}
                        </li>
                            <li>initialize the datepicker in document .ready section.<br/>
                                
                                $('#dob').datepicker();
                            </li>
                        </ol> 
                </div>
            </div> 
     </div>

     


    </div>
    </div>
</div>
</div>





<div class="col-sm-12">
<!-- Zero config.table end -->
<!-- Default ordering table start -->
<div class="card card-default">
    <div class="card-header">
        <h5>Ajax GET/POST request formates</h5>
    </div>
    <div class="card-body panels-wells">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        <div class="card-title "><b> GET Request</b></div>
                    </div>
                    <div class="card-body">
                        <p>
@verbatim
 <pre>
    $.get('{{URL::route("permission.edit")}}',
            {'id':id},function(response) {
    //action on response, i.e populate
    the form fields.
    }
    },"json");
</pre>
@endverbatim
                        </p>
                    </div>
                    <div class="bg-primary-dark text-white">
                       <p class="m-l-15 p-t-15 p-b-10 font-montserrat  semi-bold small"> Return result from controller json_encode($response);</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        <div class="card-title "><b> POST Request</b></div>
                    </div>
                    <div class="card-body">
                        <p>
@verbatim
 <pre>
    $.ajax({
            type: "post",
            url: '{{URL::route("permission.edit")}}',
            data: {'id' : id},
            dataType: "JSON",
              success: function (response) {
                //action on data returned i.e response
              },
              error: function (jqXHR, exception) {
              }
            });
</pre>
@endverbatim
                        </p>
                    </div>
                    <div class="bg-primary-dark text-white">
                       <p class="m-l-15 p-t-15 p-b-10 font-montserrat  semi-bold small">Return result from controller json_encode($response);</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Default ordering table end -->
</div>
<div class="col-sm-12">
<!-- Zero config.table end -->
<!-- Default ordering table start -->
<div class="card">
    <div class="card-header">
        <h5>Database Info</h5>
    </div>
    <div class="card-body">
        
        <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-bordered ">
                <thead class="thead-light">
                    <tr>
                        <th>Module</th>
                        
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <th class="align-middle">
                        Users/Shopaholics/Admin/Employees
                    </th>
                

                
                    <td>
                        <table class="table table-bordered ">
                            <thead class="thead-light">
                                <tr>
                                    <th>Table Name</th>
                                    
                                    <th>Details</th>
                                    <th>Relationships</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        users
                                    </td>
                                    <td>
                                        Holds all users(admins/owners/employees/shopaholics etc.) info
                                    </td>
                                    <td>
                                        <b>users</b> has <b> 1:1 </b> relationship to <b>shopaholics</b><br/>
                                        <b>users</b> has <b> 1:M </b> relationship to <b>wallet_requests</b><br/>
                                        <b>users</b> has <b> M:M </b> relationship to <b>roles</b>(pivot table : <b>role_user</b>)<br/>
                                    </td>

                                </tr>

                                 <tr>
                                    <td class="align-middle">
                                        shopaholics
                                    </td>
                                    <td>
                                        Holds all info about shopaholics (front-end users).
                                        <ul>
                                            <li><b>Primary address</b> is stored in shopaholics table <b>address(json field)</b>.</li>
                                            <li><b>Secondary addresses</b> are Stored in <b>shopaholic_addresses</b>.</li>
                                            <li><b>Credit card info</b> are stored in <b>shopaholic_credit_infos</b>.</li>
                                            <li><b>Failed transactions</b> are stored in <b>shopaholic_failed_transactions</b>.</li>
                                          
                                        </ul>
                                    </td>
                                    <td>
                                        <b>shopaholics</b>  <b> Belongs </b> to <b>users</b>.<br/>
                                        <b>shopaholics</b> has <b> 1:M </b> relationship to <b>shopaholic_addresses</b>.<br/>
                                        <b>shopaholics</b> has <b> 1:1 </b> relationship to <b>shopaholics_infos</b>.<br/>
                                        <b>shopaholics</b> has <b> 1:M </b> relationship to <b>shopaholic_credit_infos</b>.<br/>
                                        <b>shopaholics</b> has <b> 1:M </b> relationship to <b>shopaholic_failed_transactions</b>.<br/>
                                    </td>
                                </tr>

                                 <tr>
                                    <td class="align-middle">
                                        employees
                                    </td>
                                    <td>
                                        Holds employees (HR/personal) info
                                    </td>
                                    <td>
                                        <b>employees</b>  <b> Belongs </b> to <b>users</b>.<br/>
                                       
                                    </td>

                                </tr>
                            </tbody>

                        </table>
                    </td>
                </tr>


                <tr>
                    <th class="align-middle">
                        ACL
                    </th>
                

                
                    <td>
                        <table class="table table-bordered ">
                            <thead class="thead-light">
                                <tr>
                                    <th>Table Name</th>
                                    
                                    <th>Details</th>
                                    <th>Relationships</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        roles
                                    </td>
                                    <td>
                                        Contains Roles names/title/description.
                                    </td>
                                    <td>
                                        <b>roles</b> has <b> M:M </b> relationship with <b>permissions</b>(pivot table : <b>permission_role</b>)<br/>
                                        <b>roles</b> has <b> M:M </b> relationship to <b>users</b>(pivot table : <b>role_user</b>)<br/>
                                        <b><i>(we are using 1:1 in project)</i></b>
                                    </td>

                                </tr>

                                 <tr>
                                    <td class="align-middle">
                                        permissions
                                    </td>
                                    <td>
                                        Contains Permissions names/title/description.
                                        
                                    </td>
                                    <td>
                                       <b>permissions</b> has <b> M:M </b> relationship with <b>roles</b>(pivot table : <b>permission_role</b>)<br/>
                                        
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </td>
                </tr>


                <tr>
                    <th class="align-middle">
                        Countries/Couriers/Zones/Rates
                    </th>
                

                
                    <td>
                        <table class="table table-bordered ">
                            <thead class="thead-light">
                                <tr>
                                    <th>Table Name</th>
                                    <th>Details</th>
                                    <th>Relationships</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        countries
                                    </td>
                                    <td>
                                        Contains countries info.
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>

                                 <tr>
                                    <td class="align-middle">
                                        couriers
                                    </td>
                                    <td>
                                        Contains courier services.
                                        <ul>
                                            <li>DHL</li>
                                            <li>Fedex Priority</li>
                                            <li>Fedex Economy</li>
                                            <li>UPS Expedited</li>
                                            <li>UPS Saver</li>
                                            <li>UPS Express</li>
                                            <li>Airbnex Direct</li>
                                            <li>Airbnex In-Direct</li>
                                            <li>Aramax First pound</li>
                                            <li>Aramax per pound</li>
                                           
                                        </ul>
                                        
                                    </td>
                                    <td>
                                       <b>couriers</b> has <b> 1:M </b> relationship with <b>courier_zones</b><br/>
                                        
                                    </td>
                                </tr>


                                <tr>
                                    <td class="align-middle">
                                        courier_zones
                                    </td>
                                    <td>
                                        Contains zones for all courier services.
                                        <ul>
                                            <li>All contries ids in that specific zone are stored as <b>country_id (json field)</b> </li>
                                            
                                        </ul>
                                    </td>
                                    <td>
                                        <b>courier_zones</b>  <b> belongs </b> to <b>couriers</b><br/>
                                    </td>

                                </tr>
                            </tbody>

                        </table>
                    </td>
                </tr>
                
                </tbody>
            </table>
            
        </div>
        <div class="clearfix"> &nbsp;</div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        All Old Tables( prefixed with old_ ) to be removed After seeding/Migration of data.
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>old_admins</li>
                            <li>old_airbn_rates</li>
                            <li>old_aramax_rate</li>
                            <li>old_dhl_zones</li>
                            <li>old_dhl_rates</li>
                            <li>old_fedex_rate</li>
                            <li>old_country_zones</li>
                            <li>rate_manipulation (model has been created that table).</li>
                            <li>old_shopaholics</li>
                            <li>old_user_address</li>
                            <li>old_warehouse_self</li>
                            <li>old_credit_card_info</li>
                            ....
                            
                        </ul>
                    </div>
                   
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        
                    </div>
                    <div class="card-body">
                        <p>
                        </p>
                    </div>
                    <div class="panel-footer text-primary">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Default ordering table end -->
</div>


<div class="col-sm-12">
<!-- Zero config.table end -->
<!-- Default ordering table start -->
<div class="card">
    <div class="card-header">
        <h5>Social Login</h5>
    </div>
    <div class="card-body panels-wells">
        <div class="row">
            
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        FaceBook
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Credential saved in options table Like</li>
                            <li>title :          facebook</li>
                            <li>key :            api_key = 'test'</li>
                            <li>value :          api_secret = 'test</li>
                            <li>Callback :       api_callback_url = 'http://test/callback'</li>
                            
                        </ul>
                    </div>
                    <div class="panel-footer text-primary">
                        
                    </div>
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        Twitter
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Credential saved in options table Like</li>
                            <li>title :          twitter</li>
                            <li>key :            api_key = 'test'</li>
                            <li>value :          api_secret = 'test</li>
                            <li>Callback :       api_callback_url = 'http://test/callback'</li>
                            
                        </ul>
                    </div>
                    <div class="panel-footer text-primary">
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        Google Plus
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Credential saved in options table Like</li>
                            <li>title :          gooleplus</li>
                            <li>key :            api_key = 'test'</li>
                            <li>value :          api_secret = 'test</li>
                            <li>Callback :       api_callback_url = 'http://test/callback'</li>
                            
                        </ul>
                    </div>
                    <div class="panel-footer text-primary">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Default ordering table end -->
</div>
<!------------------------------template-------------------------------------->
<div class="col-sm-12">
<!-- Zero config.table end -->
<!-- Default ordering table start -->
<div class="card">
    <div class="card-header">
        <h5>Main Header</h5>
    </div>
    <div class="card-body panels-wells">
        <div class="row">
            <!-----------------panel 1------------------->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        Panel Header 1
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>dhl_zones</li>
                            <li>dhl_rates</li>
                            
                        </ul>
                    </div>
                    <div class="panel-footer text-primary">
                        
                    </div>
                </div>
            </div>
            <!-----------------panel 2------------------->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card card-default">
                    <div class="card-header  separator">
                        Panel Header 2
                    </div>
                    <div class="card-body">
                        <p>
                        </p>
                    </div>
                    <div class="panel-footer text-primary">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Default ordering table end -->
</div>
<!------------------------------End template-------------------------------------->
</div>
@endsection