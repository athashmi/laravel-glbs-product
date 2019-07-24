<div class="header ">
	<a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar">
	</a>
	<div class="">
		<div class="brand inline">
			<img src="{{asset('revox/assets/img/logo.png')}}" alt="logo" data-src="{{asset('revox/assets/img/logo.png')}}" data-src-retina="{{asset('revox/assets/img/logo_2x.png')}}" width="78" height="22">
		</div>
		<ul class="d-lg-inline-block d-none notification-list no-margin d-lg-inline-block b-grey b-l b-r no-style p-l-30 p-r-20">
			<li class="p-r-10 inline">
				<div class="dropdown">
					<a href="#" id="notification-center" class="header-icon pg pg-world" data-toggle="dropdown">
						<span class="bubble"></span>
					</a>
					<div class="dropdown-menu notification-toggle" role="menu" aria-labelledby="notification-center">
						<div class="notification-panel">
							<div class="notification-body scrollable">
								<div class="notification-item unread clearfix">
									<div class="heading open">
										<a href="#" class="text-complete pull-left">
											<i class="pg-map fs-16 m-r-10"></i>
											<span class="bold">Carrot Design</span>
											<span class="fs-12 m-l-10">David Nester</span>
										</a>
										<div class="pull-right">
											<div class="thumbnail-wrapper d16 circular inline m-t-15 m-r-10 toggle-more-details">
												<div><i class="fa fa-angle-left"></i>
												</div>
											</div>
											<span class=" time">few sec ago</span>
										</div>
										<div class="more-details">
											<div class="more-details-inner">
												<h5 class="semi-bold fs-16">“Apple’s Motivation - Innovation <br>
												distinguishes between <br>
												A leader and a follower.”</h5>
												<p class="small hint-text">
													Commented on john Smiths wall.
													<br> via pages framework.
												</p>
											</div>
										</div>
									</div>
									<div class="option" data-toggle="tooltip" data-placement="left" title="mark as read">
										<a href="#" class="mark"></a>
									</div>
								</div>
								<div class="notification-item  clearfix">
									<div class="heading">
										<a href="#" class="text-danger pull-left">
											<i class="fa fa-exclamation-triangle m-r-10"></i>
											<span class="bold">98% Server Load</span>
											<span class="fs-12 m-l-10">Take Action</span>
										</a>
										<span class="pull-right time">2 mins ago</span>
									</div>
									<div class="option">
										<a href="#" class="mark"></a>
									</div>
								</div>
								<div class="notification-item  clearfix">
									<div class="heading">
										<a href="#" class="text-warning-dark pull-left">
											<i class="fa fa-exclamation-triangle m-r-10"></i>
											<span class="bold">Warning Notification</span>
											<span class="fs-12 m-l-10">Buy Now</span>
										</a>
										<span class="pull-right time">yesterday</span>
									</div>
									<div class="option">
										<a href="#" class="mark"></a>
									</div>
								</div>
								
								<div class="notification-item unread clearfix">
									<div class="heading">
										<div class="thumbnail-wrapper d24 circular b-white m-r-5 b-a b-white m-t-10 m-r-10">
											<img width="30" height="30" data-src-retina="{{asset('revox/assets/img/profiles/1x.jpg')}}" data-src="{{asset('revox/assets/img/profiles/1.jpg')}}" alt="" src="{{asset('revox/assets/img/profiles/1.jpg')}}">
										</div>
										<a href="#" class="text-complete pull-left">
											<span class="bold">Revox Design Labs</span>
											<span class="fs-12 m-l-10">Owners</span>
										</a>
										<span class="pull-right time">11:00pm</span>
									</div>
									<div class="option" data-toggle="tooltip" data-placement="left" title="mark as read">
										<a href="#" class="mark"></a>
									</div>
								</div>
							</div>
							<div class="notification-footer text-center">
								<a href="#" class="">Read all notifications</a>
								<a data-toggle="refresh" class="portlet-refresh text-black pull-right" href="#">
									<i class="pg-refresh_new"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</li>
			
		</ul>
		<a href="#" class="search-link d-lg-inline-block d-none" data-toggle="search"><i class="pg-search"></i>Type anywhere to <span class="bold">search</span></a>
	</div>
	<div class="d-flex align-items-center">
		<div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none">
			<span class="semi-bold">Welcome {{Auth::user()->first_name}}</span> <span class="text-master">{{Auth::user()->last_name}} !</span>
		</div>
		<div class="dropdown pull-right d-lg-block d-none">
			<button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="thumbnail-wrapper d32 circular inline">
				@php
				if(Auth::user()->picture !=''):
				if(strpos(Auth::user()->picture,'https:'))
				{
				$img = Auth::user()->picture;
				}
				else
				$img = route('img_file',Auth::user()->picture);
				else:
				$img =asset('images/avatar-1.jpg');
				endif;
				@endphp
				<img src="{{$img}}" alt="" data-src="{{$img}}" data-src-retina="{{$img}}" width="32" height="32">
			</span>
			</button>
			<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
				@role('shopaholic')
				<a href="{{route('profile.index')}}" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
				@endrole
				<a href="#" class="dropdown-item"><i class="pg-outdent"></i> Feedback</a>
				<a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a>
				<a href="{{ route('logout') }}" class="clearfix bg-master-lighter dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<span class="pull-left">Logout</span>
					<span class="pull-right"><i class="pg-power"></i></span>
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			</div>
		</div>
		
	</div>
</div>