@component('mail::message')
# Hello {{ $name }}
We have recived your package split request, details are as following.

<div style="background-color:#F8F8F8;">
	<div class="block-grid two-up" style="Margin: 0 auto; min-width: 320px; max-width: 650px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;;">
		<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
			@php
				$i = 1;
			@endphp
			@foreach($package_service_request->details->split as $key => $service_request)
				<div class="col num6" style="min-width: 320px; max-width: 325px; display: table-cell; vertical-align: top;;">
					<div style="width:100% !important;">
						<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 15px; padding-left: 15px;">
							 
							<div style="color:#EE2337;font-family:'Droid Serif', Georgia, Times, 'Times New Roman', serif;line-height:120%;padding-top:20px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
								<div style="font-size: 12px; line-height: 14px; color: #EE2337; font-family: 'Droid Serif', Georgia, Times, 'Times New Roman', serif;">
									<p style="font-size: 14px; line-height: 21px; margin: 0;"><span style="font-size: 18px;"><strong>Package {{$i}}</strong></span></p>
								</div>
							</div>
							<div style="color:#555555;font-family:'Droid Serif', Georgia, Times, 'Times New Roman', serif;line-height:150%;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;">
								@foreach($service_request->items as $key_i => $item)
									<div style="font-size: 12px; line-height: 18px; color: #555555; font-family: 'Droid Serif', Georgia, Times, 'Times New Roman', serif;">
										<ul class="b">
										  <li>Item Name : <span>{{$item->name}}</span></li>
										  <li>Quantity :  <span>{{$item->qty}} </span></li> 
										</ul>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				@php
					$i++;
				@endphp
			@endforeach
		</div>
	</div>
</div>
{{-- 
<br>
{{ config('app.name') }} --}}
 
@endcomponent
