@extends('revox-theme.layout.main')
@section('content')
<div class="content">
	<div class="jumbotron" data-pages="parallax">
		<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
			<div class="inner">
				{{ Breadcrumbs::render('shopaholic') }}
			</div>
		</div>
	</div>
	
	<div class=" container-fluid   container-fixed-lg">
		<div class="card card-default m-t-20">
			<div class="card-body">
				<div class="invoice padding-50 sm-padding-10">
					<div class="col-12">
						<div class="row">
							<div class="col-lg-9 col-sm-height sm-no-padding">
								<p class="small no-margin">Shipping to</p>
								<h5 class="semi-bold m-t-0">{{$consolidation->shopaholic->user->first_name.' '.$consolidation->shopaholic->user->last_name}}</h5>
								<address>
									<strong>Address</strong>
									<br>
									{!! ($consolidation->address) ? ((@$consolidation->address->street) ? $consolidation->address->street : '').' '. ((@$consolidation->address->city) ? $consolidation->address->city : '') .' '.(($consolidation->address->state) ? $consolidation->address->state : '').', '.((@$consolidation->address->country) ? $consolidation->address->country : '').'<br> P: '.((@$consolidation->address->phone) ? $consolidation->address->phone : '') : '' !!}
								</address>
							</div>
							<div class="col-lg-3 sm-no-padding sm-p-b-20 d-flex align-items-end justify-content-between">
								<div>
									<div class="font-montserrat bold all-caps">date :</div>
									<div class="clearfix"></div>
								</div>
								<div class="text-right">
									<div class="">{{Carbon::now()->format('Y - m- d , H:i:s')}}</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<hr width="100%">
						<form action="{{route('frontend.consolidate.post_checkout')}}" class="form_checkout" method="post">
							@csrf

							<h3 class="font-montserrat all-caps hint-text">Select shipper</h3>
							<div class="row">
								@if($consolidation->shippingCharges->count() > 0)
									<input type="hidden" name="shipper_charges_id" class="shipper_id_hidn" /> 
									@foreach($consolidation->shippingCharges as $shipping) 
										<div class="col-md-2 card border-radius shipper-card  m-l-20" data-rate = "{{Helper::chargesCount($consolidation,$shipping->rate)}}">
											<input type="checkbox" name="shipper" data-id="{{$shipping->id}}" class=" display-none shipper_hid_id" />
											<div class="text-center">
												<img width="65px" height="60px"  src="http://gs.production/images/carrier/{{$shipping->courier->image_name}}" class="text-center m-t-10" />
											</div>
											<hr width="100%" class="m-b-0" />
											<h5 class="text-center no-margin">$ {{Helper::chargesCount($consolidation,$shipping->rate)}}</h5>
										</div>
									@endforeach
								@endif
							</div>
							<hr width="100%" />
							<h3 class="font-montserrat all-caps hint-text">Select Payment</h3>
							<div class="row">
								<input type="hidden" name="payment_method_id" class="pay_hidden payment_method_hidden" />
								@foreach($payment_methods as $payment_method)
									<div class="col-md-2 card border-radius  m-l-20 p-t-10 p-b-20 payment-card payemt_height" data-charges = "{{$payment_method->charges}}" data-type = "{{$payment_method->charges_type}}" >
										<input type="checkbox" data-id="{{$payment_method->id}}" name="payment_select" class="payment_select_class display-none" />

										
										<div class="text-center">
											<img src="{{URL::route("img_file", $payment_method->image_name)}}" class="text-center m-t-10 img-fluid" />
										</div>
									</div>
								@endforeach
	 							<div class="col-12">	
									<h3 class="font-montserrat all-caps hint-text m-l-20">Credit Card</h3>
									<div class="credit_card">
										<input type="hidden" name="shopaholic_id" value="{{$consolidation->id}}" />
										@if($consolidation->shopaholic->creditCardExist->count() > 0)
											<input type="hidden" name="credit_card_sel" class="credit_card_sel" value="0" /> 
											@foreach($consolidation->shopaholic->creditCardExist as $card)
												<div class="card payment-credit-card border-radius col-md-2 col-sm-2 col-xs-12 col-lg-2 m-l-20 p-t-10 p-b-20 payemt_height pull-left">
													<input type="checkbox" name="checkbox" class="credit-card-hi display-none" data-id="{{$card->id}}" />
													<div class=" ">
														<div class="border-checkbox-section f-right  btn-click-credit-card col-md-12 col-sm-12 col-xs-12 col-lg-12">
															
															<div class="border-checkbox-group border-checkbox-group-primary">
																<label class=" border-checkbox-label" for="checkbox13078"></label>
															</div> 
														</div>
														<img src="http://gs.production/images/{{$card->type}}.png" style="width: 66px;height: 63px; margin-left: 16px;" class="img-fluid" />
														<h5>**** **** {{$card->digit}} </h5>
													</div>
												</div>
											@endforeach
										@else
											<div class="col-12">
												<p class="border-all p-t-20 p-b-20 p-l-20">No Credit Card Found ... </p>
											</div>
										@endif
									</div>
								</div>
							</div>
							
							<div class="">
								<table class="table table-hover demo-table-search table-responsive-block dataTable no-footer m-t-50">
									<thead>
										<tr>
											<th>Services</th>
											<th>Rate</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										@php
											$services = 0;
										@endphp
										@if($charges_global->count() > 0)
											@foreach($charges_global as $charges)
												<tr>
													<td>{{$charges->title}}</td>
													<td>$ <span class="s_i_amount">{{$charges->amount}}</span></td>
													<td>$ <span class="s_amount">{{$charges->amount}}</span></td>
												</tr>
												@php
													$services += $charges->amount;
												@endphp
											@endforeach
										@endif
										@if($consolidation_goods->count() > 0)
											@foreach($consolidation_goods as $goods)
												<tr>
													<td>{{$goods->title}}</td>
													<td>$ <span class="s_i_amount">{{$goods->amount}}</span></td>
													<td>$ <span class="s_amount">{{$goods->amount}}</span></td>
												</tr>
												@php
													$services += $goods->amount;
												@endphp
											@endforeach
										@endif
										<tr class="shipper_add_dynamic">
										</tr>
										<tr class="payment_add_dynamic"></tr>
									</tbody>
								</table>
							</div>
							<div class="row m-t-20">
								<div class="col-md-3 offset-md-9 p-l-15 sm-p-t-15 pull-right  clearfix sm-p-b-15 d-flex flex-column justify-content-center">
									<h5 class="font-montserrat pull-right all-caps small no-margin hint-text bold">
										Sub Total
									</h5>
									<h3 class="no-margin pull-right ">
										USD $ <span class="sub_total_span"> {{$services}}</span>
									</h3>
								</div>
							</div>
							<br>
							<br>
							<br>
							<div class="">
								<input type="checkbox" onclick="walletUsed()" name="use_wallet" class="use_wallet m-r-10 m-l-5" > <spna class = "label label-primary">Use Wallet Balance</spna>
							</div>
							<div class="wallet_balance_table display-none">
								<table class="table table-hover demo-table-search table-responsive-block dataTable no-footer m-t-50">
									<thead>
										<tr>
											<th>Services</th>
											<th>Rate</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Sub Total</td>
											<td >$ <span class="sub_total_span">{{$services}}</span></td>
											<td >$ <span class="sub_total_span">{{$services}}</span></td>
										</tr>
										<tr>
											<td>Wallet Balance</td>
											<td>$ {{$balance}}</td>
											<td>- $ {{$balance}}</td>
										</tr>										
									</tbody>
								</table>
								<input type="hidden" name="wallet_balance" class="wallet_balance_hid" value="{{$balance}}" />
							</div>
							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="p-l-15 p-r-15">
								<div class="row b-a b-grey">
									<div class="col-md-5 offset-md-7 text-right bg-master-darker col-sm-height padding-15 d-flex flex-column justify-content-center align-items-end">
										<h5 class="font-montserrat all-caps small no-margin hint-text text-white bold">Total</h5>
										<h1 class="no-margin text-white grand_total">$ <span class="grand_total_span">{{$services}}</span></h1>
									</div>
								</div>
							</div>
							<div class="row ">
								@if ($errors->any())
									@foreach ($errors->all() as $error)
										<div class="col-12 p-l-5 p-r-25 pgn push-on-sidebar-open pgn-simple">
											<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">
													<span aria-hidden="true">×</span>
													<span class="sr-only">Close</span>
												</button>
												{{$error}}
											</div>
										</div>
									@endforeach
								@endif
							</div>
							<div class="col-12 p-l-0 error_msg_c_e p-r-0"> 
							</div>
							<div class="col-12 p-l-0">
								<input type="button" class="btn btn-success btn_checkout m-t-20 p-t-20 p-b-20" value="Proceed To Checkout">
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@include('revox-theme.js-css-blades.card')
@include('frontend.dashboard.storage-ship.outgoing.review-shipper-charges')
@include('frontend.dashboard.storage-ship.outgoing.credit-card-payment-model')
@endsection
@section('script')
@parent
<script type="text/javascript">
	$(document).ready(function(){
		$('.payment-card').hover(function(){
			$('.employee-task').removeClass('border-employee-task');
			$(this).addClass('border-employee-task');
		},function(){
			$(this).removeClass('border-employee-task');
		});
		$('.payment-card').click(function(){
			
			/************** *********/
			$('.payment-credit-card').removeClass('border-active');
			$('.credit-card-hi').prop('checked',false);
			/************ *********/
			$('.payment-card').removeClass('border-active');
			$('.payment_select_class').prop('checked',false);
			$(this).find('.payment_select_class').prop('checked',true);
			$(this).addClass('border-active');
			var id = $(this).find('.payment_select_class').data('id');
			$('.pay_hidden').val('');
			$('.payment_method_hidden').val(id+'_paymentMethod');
			if($(this).data('type') == 'fixed'){
				var html = `<td>Payment Method Charges</td>
						<td>$ <span class="shipper_amount_">`+$(this).data('charges')+`</span></td>
						<td>$ <span class="s_amount">`+$(this).data('charges')+`</span></td>`;
				$('.payment_add_dynamic').html(html);
			}else{
				var html = `<td>Payment Method Charges</td>
						<td>$ <span class="shipper_amount_">`+$(this).data('charges')+`</span></td>
						<td>$ <span class="s_amount">`+$(this).data('charges')+`</span></td>`;
				$('.payment_add_dynamic').html(html);
			}
			$('.credit_card_sel').val(0);
			dynamicCalculation();
			
		});
		$('.payment-credit-card').hover(function(){
			$('.employee-task').removeClass('border-employee-task');
			$(this).addClass('border-employee-task');
		},function(){
			$(this).removeClass('border-employee-task');
		});
		$('.payment-credit-card').click(function(){
			$('.payment-card').removeClass('border-active');
			$('.payment_select_class').prop('checked',false);
			$('.pay_hidden').val('');
			$('.payment-credit-card').removeClass('border-active');
			$('.credit-card-hi').prop('checked',false);
			$(this).find('.credit-card-hi').prop('checked',true);
			$(this).addClass('border-active');
			var id = $(this).find('.credit-card-hi').data('id');
			$('.pay_hidden').val('');
			$('.credit_card_sel').val(1);
			$('.payment_method_hidden').val(id+'_crditCard');
			var amount_dynamic = $('.payment_add_dynamic').find('.s_amount').text();
			if(amount_dynamic != ''){
				var grand = $('.grand_total_span').text();
				var tot = parseFloat(grand) - parseFloat(amount_dynamic);
				$('.grand_total_span').html(tot);
				$('.sub_total_span').html(tot)
			}
			$('.payment_add_dynamic').html('');

		});
		$('.shipper-card').hover(function(){
			$('.employee-task').removeClass('border-employee-task');
			$(this).addClass('border-employee-task');
		},function(){
			$(this).removeClass('border-employee-task');
		});
		$('.shipper-card').click(function(){
			$('.shipper-card').removeClass('border-active');
			$('.shipper_hid_id').prop('checked',false);
			$(this).find('.shipper_hid_id').prop('checked',true);
			$('.shipper_id_hidn').val($(this).find('.shipper_hid_id').data('id'));
			$(this).addClass('border-active');
			var rate = $(this).data('rate');
			var html = `<td><a href="javascript:;" data-toggle="modal"   data-target="#package_services_charges_modal" class="label label-success">Shipper Detail</a></td>
						<td>$ <span class="shipper_amount_">`+rate+`</span></td>
						<td>$ <span class="shipper_amount">`+rate+`</span></td>`;
			$('.shipper_add_dynamic').html(html);
			dynamicCalculation();
		});
		$('.btn_checkout').click(function(){
			//loader(this);
			// console.log($('.form_checkout').serializeArray());
			// return false;
			//$('.form_checkout').submit();
			var creditCard = $('.credit_card_sel').val();
			if(creditCard == 0){
				$.ajax({
			        type: "POST",
			        url: "{{route('frontend.consolidate.post_checkout')}}",
			        data: $('.form_checkout').serialize(),
			        dataType: "JSON",
			        success: function (response) {
			        //	console.log(response.approved_url);
			          location.replace(response.approved_url);
			      },
			      error: function (jqXHR, exception) {
			      	if (jqXHR.status == 422) {
		              var html_error = '';
		              $.each(jqXHR.responseJSON.errors, function (key, value)
		              {
		                html_error +='<div class="pgn push-on-sidebar-open pgn-simple" style="margin-left:0px; margin-right:0px;"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
		              })
		              html_error += "</ul></div>";
		              $('.error_msg_c_e').html(html_error);
		            }
			      }
			    });
			}else if(creditCard == 1){
				$('.btn_checkout').hide();
				$('#credit-card-deposit-modal').modal({
					backdrop: 'static',
    				keyboard: false
				});
			}
			

		});
	});
	function dynamicCalculation(){
		var amountt = 0;
		$('.s_amount').each(function(key,index){
			amountt = parseFloat($(this).text())+parseFloat(amountt);
		});
		var shipper_amount = $('.shipper_amount').text();
		if(shipper_amount == ''){
			//var grand = parseFloat(shipper_amount)+parseFloat(amountt);
			$('.grand_total_span').html(Math.round(amountt));
			$('.sub_total_span').html(Math.round(amountt))
		}else{
			var grand = parseFloat(shipper_amount)+parseFloat(amountt);
			$('.grand_total_span').html(Math.round(grand));
			$('.sub_total_span').html(Math.round(grand));
		}
	}
	function walletUsed(){
		if($('.use_wallet').is(':checked')){
			var walletBalance = $('.wallet_balance_hid').val();
			$('.wallet_balance_table').removeClass('display-none');
			var grandTotal = $('.grand_total_span').text();
			var total = 0;
			if(parseFloat(walletBalance) > parseFloat(grandTotal)){
				//total = parseFloat(walletBalance) - parseFloat(grandTotal);
			}else{
				total = parseFloat(grandTotal) - parseFloat(walletBalance);
			}
			$('.grand_total_span').html(Math.round(total));
		}else{
			$('.wallet_balance_table').addClass('display-none');
			$('.grand_total_span').html($('.sub_total_span').html());
		}
	}
</script>
@endsection