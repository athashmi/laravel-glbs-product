<template>
	<div :class="'modal fade slide-right '+showClass" id="package_split_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				
				<div class="container-xs-height full-height ">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height">
							<div class="modal-header">
								<button type="button" class="backgroud-clr split_back_btn btn btn-default pull-left" data-dismiss="modal" aria-hidden="true">
								<i class="fa fa-long-arrow-left  fs-14"></i>
								</button>
								<h4 class="modal-title pull-left" id="myModalLabel"><b>Split Package</b></h4>
								<input type="hidden" name="split_id" id="split_id">
								<input type="hidden" name="package_id" id="package_id">
							</div>



								<div class="col-lg-12 clearfix">
									<button type="button" class="btn btn-primary add-package-btn float-sm-right"><i class="fa fa-plus"></i> Add Package</button>
								</div>
								<div class="col-lg-6 m-t-10 pull-left">
									<div data-pages="card" class="card card-default" id="card-basic">
										<div class="card-header  ">
											<div class="card-title">Package
											</div>
											<div class="card-controls">
												<!-- <ul>
														<li>
															<a href="#" class="package-card-close">
																<i class="card-icon card-icon-close"></i>
															</a>
														</li>
												</ul> -->
											</div>
										</div>
										<div class="card-body package_split_show">
											<ul class="list-group list-group-flush">
			                                    <li class="list-group-item li-item">
			                                        <span class="bold">Items :</span>
			                                        <ul class="list-group item_inner list-group-flush">
					                                    <li class="list-group-item row">
					                                    	<div class="col-lg-6 pull-left">
						                                        <span class="bold">Name :</span>
						                                        <span> <input type="text" class="pull-right item_name form-control" name="item[]"></span>
					                                    	</div>
					                                    	<div class="col-lg-6 pull-left">
					                                    		<span class="bold">Qty :</span>
					                                        	<span> <input type="number" class="pull-right quantity_no form-control" name="quantity[]"></span>
					                                    	</div>
					                                    </li> 
					                                    <hr>
		                                			</ul>
		                                			 
													<li class="list-group-item">
				                                        <span class="bold"></span>
				                                        <button class="pull-right btn-plus-add btn btn-default"> <i class="fa fa-plus"></i></button>
			                                    	</li>
			                                    </li>
		                                	</ul>
										</div>
									</div>
								</div>
						<div class="pa"></div>
						<div class="clearfix"></div> 
						<div class="col-lg-12">
							<div class="error_msg_p_split"></div>
							<button type="button" class="btn btn-primary btn-send-split-package float-sm-right">Send</button>
						</div>		 
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</template>


<script>
export default {
     data(){
            return{
            	split_packages:[],
            	showClass:'',
               
            }
        },
        methods:{
        	showModaleve(){
        		alert('llll');
        		console.log('kkkk');
        		this.showClass = 'show';
        	}
        },
       
        mounted() {
           /*Event.$on('showSplitModal',function(){
           		console.log('kkkk333');
           });*/
           
           
        },
        created: function() {
		    this.$root.$on('showSplitModal',()=>{
		    	console.log('kkkkiiii');
		    	this.showClass = 'show';
		    });
		  }
    }
</script>