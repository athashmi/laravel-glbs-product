<div class="offcanvas-container" id="mobile-menu"><a class="account-link" href="#"></a>
        <nav class="offcanvas-menu">
        <ul class="menu">
        <li class="has-children"><span>
        <a href="{{url('/')}}"><span><i class="fa fa-home" aria-hidden="true" style="font-size:20px;color:#52CEBE"></i>&nbsp;&nbsp; Home</span></a></span>
        </li>
        <li class="has-children"><span>
        <a href="{{url('/')}}/#shipping_calculator"><span><i class="fa fa-truck" aria-hidden="true" style="font-size:20px;color:#3DBAF2"></i>&nbsp;&nbsp; Shipping Rates</span></a></span>
        </li>
        <li class="has-children"><span>
        <a href="{{url('business/solutions')}}"><span><i class="fa fa-cube" aria-hidden="true" style="font-size:20px;color:#E1305C"></i>&nbsp;&nbsp; Business Solutions</span></a></span>
        </li>
        <li class="has-children"><span>
        <a href="{{url('faqs')}}"><span><i class="fa fa-life-ring" aria-hidden="true" style="font-size:20px;color:#FC7148"></i>&nbsp;&nbsp; FAQs</span></a></span>
        </li>
        <li class="has-children"><span><a href="#"><span><i class="fa fa-usd" aria-hidden="true"style="font-size:20px;color:#CFB874"></i>&nbsp;&nbsp; Pricing</span></a>
        <span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu pricing_icons">
        <li class="has-children"><span><a href="#"><span>Free Services Included</span></a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu ">
        <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/tax-free-usa-address.svg')}}">Tax Free USA Address</a></li>
        <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/180storage.png')}}">180 Days of Storage</a></li>
        <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/PackageArrivedPhoto.png')}}">Photo of Package upon Arrival</a></li>
        <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/contentphoto.png')}}">Photo of Package Content</a></li>
        <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/Repacking.svg')}}">Repacking</a></li>
        <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/invoiceremoval.svg')}}">Invoice and Shoe Box Removal</a></li>
        <li><a href="#"><img src="{{asset('frontend/img/pricing_icons/livechat.svg')}}">Live Chat Support</a></li>
        </ul>
        </li>
        <li class="has-children"><span><a href="#"><span>Paid and Optional Services</span></a><span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
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
        </ul>
        </li>
        <li class="has-children"><span><a href="#"><span><i class="fa fa-user" aria-hidden="true"style="font-size:20px;color:#00A3E8"></i>&nbsp;&nbsp; Account</span></a>
        <span class="sub-menu-toggle"></span></span>
        <ul class="offcanvas-submenu">
        @if(Session::get('shopaholic_id'))
        <li><a href="{{url('shopaholic/dashboard')}}"><i class="fa fa-server" aria-hidden="true" style="font-size:20px;color::#E1305C"></i>&nbsp;&nbsp; Dashboard</a></li>
        <li><a href="{{url('logout')}}"> <i class="fa fa-sign-out" aria-hidden="true" style="font-size:20px;color:#00A3E8"></i>&nbsp;&nbsp; Logout</a></li>
        @else
        <li><a href="{{url('login')}}"><i class="fa fa-sign-in" aria-hidden="true" style="font-size:20px;color:#00A3E8"></i>&nbsp;&nbsp; Login</a></li>
        <li><a href="{{url('register')}}"><i class="fa fa-sign-in" aria-hidden="true" style="font-size:20px;color:#00A3E8"></i>&nbsp;&nbsp; Register</a></li>
        <li><a href="{{url('forgot/password')}}"><i class="fa fa-unlock-alt" aria-hidden="true" style="font-size:20px;color:#00A3E8"></i>&nbsp;&nbsp; Password Recovery</a></li>
        @endif
        </ul>
        </li>
        </ul>
        </nav>
        </div>



        <div class="topbar">
        <div class="topbar-column">
        <!--a class="hidden-md-down" href="mailto:help@globalshopaholics.com"><i class="icon-mail"></i>&nbsp; help@globalshopaholics.com</a><a class="hidden-md-down" href="tel:00331697720"><i class="icon-bell"></i>&nbsp; 00 33 169 7720</a-->
        <a class="social-button sb-facebook shape-none sb-dark" href="https://www.facebook.com/GBLSHP" target="_blank">
        <i class="socicon-facebook"></i>
        </a>
        <a class="social-button sb-twitter shape-none sb-dark" href="https://twitter.com/GBLSHP" target="_blank">
        <i class="socicon-twitter"></i>
        </a>
        <a class="social-button sb-instagram shape-none sb-dark" href="https://www.instagram.com/globalshopaholics/" target="_blank">
        <i class="socicon-instagram"></i>
        </a>
        </div>
        <div class="topbar-column">
        <!-- <a class="hidden-md-down" href="{{url('report/fraudi')}}"><i class="icon-ban"></i>&nbsp; REPORT FRAUD!</a> -->
        <div class="lang-currency-switcher-wrap" style="display: none;">
        <div class="lang-currency-switcher dropdown-toggle"><span class="language"><img alt="English" src="{{asset('frontend/img/flags/GB.png')}}"></span><span class="currency">$ USD</span></div>
        <div class="dropdown-menu">
        <div class="currency-select">
         <select class="form-control form-control-rounded form-control-sm">
            <option value="usd">$ USD</option>
            <option value="usd">€ EUR</option>
            <option value="usd">£ UKP</option>
            <option value="usd">¥ JPY</option>
         </select>
        </div>
        <a class="dropdown-item" href="#">
        <img src="{{asset('frontend/img/flags/FR.png')}}" alt="Français">Français</a>
        <a class="dropdown-item" href="#">
          <img src="{{asset('frontend/img/flags/DE.png')}}" alt="Deutsch">Deutsch</a>
          <a class="dropdown-item" href="#">
            <img src="{{asset('frontend/img/flags/IT.png')}}" alt="Italiano">Italiano</a>
        </div>
        </div>
        </div>
        </div>