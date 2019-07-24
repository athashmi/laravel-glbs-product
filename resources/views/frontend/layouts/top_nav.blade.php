<header class="navbar navbar-sticky">

  @if(session()->has('work_day_completed'))
            <div class="alert alert-warning" role="alert">
              This is a warning alert—check it out!
            </div>
          @endif
   <!-- Search-->
   <form class="site-search" method="get">
      <input type="text" name="site_search" placeholder="Type to search...">
      <!--div class="search-tools"><span class="clear-search">Clear</span><span class="close-search"><i class="icon-cross"></i></span></div---->
   </form>
   <a class="site-logo" href="{{url('/')}}">
     <img src="{{asset('frontend/img/logo/logo.png')}}" alt="Globalshop">
   </a>

   <div class="site-branding">
      <div class="inner">
         <!-- Off-Canvas Toggle (#shop-categories)-->
         <!-- <a class="offcanvas-toggle cats-toggle" href="#shop-categories" data-toggle="offcanvas"></a> -->

         <!-- Off-Canvas Toggle (#mobile-menu)-->
         <a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>
         <!-- Site Logo-->
      </div>
   </div>
   <!-- Main Navigation-->
   <nav class="site-menu">
      <ul>
         <li><a href="{{url('/')}}"><span>Home</span></a>
         </li>
         <li><a href="{{url('/')}}/#shipping_calculator"><span>Shipping Rates</span></a></li>
         <li class="has-megamenu">
            <a href="#"><span>Pricing</span></a>
            <ul class="mega-menu web-pricing-icons">
               <li>
                  <span class="mega-menu-title">Free Services Included</span>
                  <ul class="sub-menu">
                       <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/tax-free-usa-address.svg')}}">Tax Free USA Address</a></li>
                       <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/180storage.png')}}">180 Days of Storage</a></li>
                       <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/PackageArrivedPhoto.png')}}">Photo of Package upon Arrival</a></li>
                       <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/contentphoto.png')}}">Photo of Package Content</a></li>
                       <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/Repacking.svg')}}">Repacking</a></li>
                       <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/invoiceremoval.svg')}}">Invoice and Shoe Box Removal</a></li>
                       <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/livechat.svg')}}">Live Chat Support</a></li>
                  </ul>
               </li>
               <li>
                  <span class="mega-menu-title">Paid and Optional Services </span>
                  <ul class="sub-menu">
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/consolidation.png')}}">$1 per package Consolidated, $5 minimum charge</a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/assistedpurchase.svg')}}">Assisted Purchase: <span>5% or $5 minimum, we buy for you</span> </a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/detailedphotos.png')}}">Detailed Item Photo: $3 each</a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/expressprocessing.svg')}}">Express Processing: $5</a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/returns.svg')}}">Returns: $5</a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/equiptesting.svg')}}">Equipment Testing: $5</a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/cancelshipment.svg')}}">Shipment Cancellation: $5</a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/extramaterial.svg')}}">Extra Packing Material: $2</a></li>
                     <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/insurance.svg')}}">Insurance: $1 per $100</a></li>
                  </ul>
               </li>
               <!--li>
                  <section class="promo-box" style="background-image: url(img/banners/02.jpg);"><span class="overlay-dark" style="opacity: .4;"></span>
                    <div class="promo-box-content text-center padding-top-2x padding-bottom-2x">
                      <h4 class="text-light text-thin text-shadow">New Collection of</h4>
                      <h3 class="text-bold text-light text-shadow">Sunglasses</h3><a class="btn btn-sm btn-primary" href="#">Shop Now</a>
                    </div>
                  </section>
                  </li-->
               <li>
                  <section class="promo-box" style="background-image: url({{asset('frontend/img/banners/103.jpg')}});">
                     <!-- Choose between .overlay-dark (#000) or .overlay-light (#fff) with default opacity of 50%. You can overrride default color and opacity values via 'style' attribute.--><span class="overlay-dark" style="opacity: .45;"></span>
                     <div class="promo-box-content text-center padding-top-2x padding-bottom-2x">
                        <h3 class="text-bold text-light text-shadow">Earn GS CASH!</h3>
                        <h4 class="text-light text-thin text-shadow">Free Shipping, Made Possible!</h4>
                        <a class="btn btn-sm btn-primary" href="#">Coming Soon!</a>
                     </div>
                  </section>
               </li>
            </ul>
         </li>
         <!-- <li><a href="{{url('assisted/purchase')}}"><span>Assisted Purchase</span></a>
         </li> -->
         <li class="has-megamenu"><a href="{{url('business/solutions')}}"><span>Business Solutions</span></a>
         </li>
         <li><a href="{{url('faqs')}}"><span>FAQs</span></a>
         </li>
         <li>
            <a href="#"><span>Account</span></a>
            <ul class="sub-menu">
              @if(Auth::guest())
              <li><a href="{{url('login')}}">Login</a></li>
              <li><a href="{{url('register')}}">Register</a></li>
              <li><a href="{{url('forgot/password')}}">Password Recovery</a></li>
              @else
              <li>
              @role(['shopaholic'])
                <a href="{{{route('wallet.index')}}}"><i class="fa fa-home"></i>Dashboard</a>
              @endrole
              @role(['admin','owner'])
                <a href="{{{route('admin_dashboard')}}}"><i class="fa fa-home"></i>Dashboard</a>
              @endrole
            </li>
              {{-- <li><a href="{{url('logout')}}">  <i class="fa fa-unlock-alt" aria-hidden="true"></i>Logout</a></li> --}}
              @endif
               <!--li><a href="account-orders.html">Orders List</a></li>
                  <li><a href="account-wishlist.html">Wishlist</a></li>
                  <li><a href="account-profile.html">Profile Page</a></li>
                  <li><a href="account-address.html">Contact / Shipping Address</a></li>
                  <li><a href="account-tickets.html">My Tickets</a></li>
                  <li><a href="account-single-ticket.html">Single Ticket</a></li--->
            </ul>
         </li>
      </ul>
   </nav>
   <!-- Toolbar-->
   <div class="toolbar">
      <div class="inner">
         <div class="tools">
            <!-- <div class="search"><i class="icon-search"></i></div> -->
            <div class="account">
               <a href="#"></a>
               @if(!empty($shopaholic->picture))
               <img src="{{asset($shopaholic->picture)}}" style="border-radius: 50%!important;" alt="Daniel Adams">
               @else
               <i class="icon-head"></i>
               @endif
               <ul class="toolbar-dropdown">
                 @if(!Auth::guest())
                   <li class="sub-menu-user">
                     <div class="user-ava">
                       <img src="{{ asset('images/user2-160x160.jpg')}}" alt="image missing">
                     </div>
                     <div class="user-info">

                       <h6 class="user-name">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h6>
                       <span class="text-xs text-muted">Member since <br>{{date('F jS Y', strtotime(Auth::user()->created_at))}}</span>
                     </div>
                   </li>
                   <li class="sub-menu-separator"></li>
                   <li>
                      @role(['client'])
                        <a href="{{{route('profile.index')}}}"><i class="fa fa-user" aria-hidden="true"></i>My Profile</a>
                      @endrole
                      @role(['admin','owner'])
                        <a href="{{{route('admin_dashboard')}}}"><i class="fa fa-home"></i>Dashboard</a>
                      @endrole
                   </li>
                   <li>
                                <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </li>
                  @else
                  <li><a href="{{url('login')}}"> <i class="icon-head"></i>Login</a></li>
                  <li><a href="{{url('register')}}"> <i class="icon-head"></i>Register</a></li>
                  <li class="sub-menu-separator"></li>
                  <li><a href="{{url('forgot/password')}}"> <i class="icon-unlock"></i>Password Recovery</a></li>
                  @endif
               </ul>
            </div>
         </div>
      </div>
   </div>


</header>

<style type="text/css">
   .modal-backdrop {
      background-color: #21b58d;
   }
</style>
