<nav class="page-sidebar" data-pages="sidebar">
  <div class="sidebar-overlay-slide from-top" id="appMenu">
    <div class="row">
      <div class="col-xs-6 no-padding">
        <a href="#" class="p-l-40"><img src="{{asset('revox/assets/img/demo/social_app.svg')}}" alt="socail">
        </a>
      </div>
      <div class="col-xs-6 no-padding">
        <a href="#" class="p-l-10"><img src="{{asset('revox/assets/img/demo/email_app.svg')}}" alt="socail">
        </a>
      </div>
    </div>
    <div class="row">

      <div class="col-xs-6 m-t-20 no-padding">
        <a href="#" class="p-l-40"><img src="{{asset('revox/assets/img/demo/calendar_app.svg')}}" alt="socail">
        </a>
      </div>

      <div class="col-xs-6 m-t-20 no-padding">
        <a href="#" class="p-l-10"><img src="{{asset('revox/assets/img/demo/add_more.svg')}}" alt="socail">
        </a>
      </div>
    </div>
  </div>
  <div class="sidebar-header">
    <img src="{{asset('revox/assets/img/logo_white.png')}}" alt="logo" class="brand" data-src="{{asset('revox/assets/img/logo_white.png')}}" data-src-retina="{{asset('revox/assets/img/logo_white_2x.png')}}" width="78" height="22">
    <div class="sidebar-header-controls">
      <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
      </button>
      <button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none btn-toggle-sidebar" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
      </button>
    </div>
  </div>
  <div class="sidebar-menu">
    <ul class="menu-items">
      @role(['owner','admin'])
      <li class="m-t-30 ">
        <a href="{{URL::route('admin_dashboard')}}" class="detailed">
          <span class="title">Dashboard</span>
        </a>
        <span class="icon-thumbnail"><i class="pg-home"></i></span>
      </li>
      <li>
        <a href="javascript:;"><span class="title">Shopaholics</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-users"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('shopaholic.index')}}">List</a>
            <span class="icon-thumbnail"><i class=" pg-unordered_list"></i></span>
          </li>
           <li class="">
            <a href="{{route('group.shopaholic.index')}}">Shopaholic Group</a>
            <span class="icon-thumbnail"><i class="fa  fa-navicon"></i></span>
          </li>
          <li class="">
            <a href="{{route('creditcard.index')}}">Credit Cards</a>
            <span class="icon-thumbnail"><i class="fa  fa-navicon"></i></span>
          </li>
          <li class="">
            <a href="{{route('shopaholic.failed_transaction')}}">Failed Transaction</a>
            <span class="icon-thumbnail"><i class="fa  fa-navicon"></i></span>
          </li>
          <li class="">
            <a href="{{route('wallet_request.deposit_request')}}">Deposit Requests</a>
            <span class="icon-thumbnail"><i class="pg-shopping_cart"></i></span>
          </li>
          <li class="">
            <a href="{{route('wallet_request.withdraw_request')}}">Withdrawal Requests</a>
            <span class="icon-thumbnail"><i class="fa fa-undo"></i></span>
          </li>
        </ul>
      </li>
       <li>
        <a href="javascript:;"><span class="title">Packages</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa  fa-suitcase"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('package.index')}}">List</a>
            <span class="icon-thumbnail"><i class="fa fa-list"></i></span>
          </li>
          <li class="">
            <a href="{{route('package.unassigned.index')}}">UNASSIGNED</a>
            <span class="icon-thumbnail"><i class="fa fa-list"></i></span>
          </li>
          {{--  <li class="">
           <a href="{{route('package.grid')}}">Grid</a>
           <span class="icon-thumbnail"><i class="fa fa-list"></i></span>
                    </li> --}}
          <li class="">
            <a href="{{route('package.services.index')}}">Services</a>
            <span class="icon-thumbnail"><i class="fa fa-truck"></i></span>
          </li>
          <li class="">
            <a href="{{route('package.categories.index')}}">Categories</a>
            <span class="icon-thumbnail"><i class="fa fa-truck"></i></span>
          </li>
        </ul>
      </li>
       <li>
        <a href="javascript:;"><span class="title">Consolidation</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-gift"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('consolidation.shipment.index')}}">Ship</a>
            <span class="icon-thumbnail"><i class="fa fa-question-circle"></i></span>
          </li>
          <li class="">
            <a href="{{route('consolidation.request_info.index')}}">Request Infos</a>
            <span class="icon-thumbnail"><i class="fa fa-info-circle"></i></span>
          </li>
          <li class="">
            <a href="{{route('consolidation.goods_description.index')}}">Goods Description</a>
            <span class="icon-thumbnail"><i class="fa fa-question-circle"></i></span>
          </li>
        </ul>
      </li>
      <li>
        <a href="javascript:;"><span class="title">ACL</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-unlock-alt"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('role.index')}}">Roles</a>
            <span class="icon-thumbnail"><i class="fa fa-legal"></i></span>
          </li>
          <li class="">
            <a href="{{route('permission.index')}}">Permissions</a>
            <span class="icon-thumbnail"><i class="fa fa-key"></i></span>
          </li>
        </ul>
      </li>

      <li>
        <a href="javascript:;"><span class="title">News & Updates</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-newspaper-o"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('blog_post.index')}}">List</a>
            <span class="icon-thumbnail"><i class="fa  fa-navicon"></i></span>
          </li>
        </ul>
      </li>
      <li>
        <a href="javascript:;"><span class="title">Employees</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-users"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('employee.index')}}">List</a>
            <span class="icon-thumbnail"><i class=" pg-unordered_list"></i></span>
          </li>
          <li class="">
            <a href="{{route('employee.grid')}}">Grid</a>
            <span class="icon-thumbnail">L</span>
          </li>
        </ul>
      </li>

      <li class="">
        <a href="{{route('country.index')}}">
          <span class="title">Countries</span>
        </a>
        <span class="icon-thumbnail"><i class="fa fa-globe"></i></span>
      </li>

      <li>
        <a href="javascript:;"><span class="title">Warehouses</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa  fa-building"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('warehouse.index')}}">List</a>
            <span class="icon-thumbnail"><i class=" pg-unordered_list"></i></span>
          </li>
          <li class="">
            <a href="{{route('warehouse.shelves.index')}}">Shelves</a>
            <span class="icon-thumbnail">L</span>
          </li>
        </ul>
      </li>
      <li>
        <a href="javascript:;"><span class="title">Courier & Zones</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa fa fa-plane"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('courier.domestic.index')}}">Domestic Courier</a>
            <span class="icon-thumbnail">D</span>
          </li>
          <li class="">
            <a href="{{route('courier.index')}}">Services</a>
            <span class="icon-thumbnail">S</span>
          </li>
          <li class="">
            <a href="{{route('courier.zone.index')}}">Zones</a>
            <span class="icon-thumbnail">Z</span>
          </li>
        </ul>
      </li>
      <li>
        <a href="javascript:;"><span class="title">Shipping</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-truck"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('admin.shipping.calculator')}}">Calculator</a>
            <span class="icon-thumbnail"><i class="fa  fa-calculator"></i></span>
          </li>
        </ul>
      </li>


      <li>
        <a href="javascript:;"><span class="title">Settings</span>
        <span class="arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-cogs"></i></span>
        <ul class="sub-menu">
          <li>
          <a href="{{route('setting.charges.index')}}">Charges</a>
          <span class="icon-thumbnail"><i class="fa fa-money"></i></span>
          </li>
          <li>
            <a href="{{route('payment.index')}}">Payment Gateway</a>
            <span class="icon-thumbnail"><i class="fa fa-money"></i></span>
          </li>
           <li>
          <a href="{{route('setting.global.index')}}">Global</a>
          <span class="icon-thumbnail"><i class="fa fa-globe"></i></span>
          </li>

          <li class="">
          <a href="javascript:;"><span class="title">Credential</span>
          <span class="arrow"></span></a>
          <span class="icon-thumbnail"><i class="fa fa-key"></i></span>
          <ul class="sub-menu">
            <li>
              <a href="{{route('setting.social-logins')}}">Social Logins</a>
              <span class="icon-thumbnail"><i class=" pg-social"></i></span>
            </li>
            <li>
              <a href="{{route('setting.payment-gateways')}}">Payment Gateways</a>
              <span class="icon-thumbnail"><i class="fa fa-paypal"></i></span>
            </li>
            <li>
              <a href="{{route('setting.recaptcha')}}">ReCaptcha</a>
              <span class="icon-thumbnail"><i class="fa  fa-refresh"></i></span>
            </li>
          </ul>
          </li>
        </ul>
      </li>

    {{-- *********************************Fakhar Code****************************** --}}
    <!--Docs > Developers -->
    <li>
      <a href="javascript:;"><span class="title">Docs</span>
      <span class="arrow"></span></a>
      <span class="icon-thumbnail"><i class="fa fa-cogs"></i></span>
      <ul class="sub-menu">

        <li class="">
        <a href="javascript:;"><span class="title">Developers</span>
        <span class="arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-key"></i></span>
        <ul class="sub-menu">
          <li>
            <a href="{{route('docs.developers.list')}}">List</a>
            <span class="icon-thumbnail"><i class=" pg-social"></i></span>
          </li>


        </ul>
        </li>
      </ul>
    </li>

    {{--************************************End Fakhar Code*****************************--}}
      @endrole
      @role(['shopaholic'])
      <li class="m-t-30 ">
        <a href="{{URL::route('client_dashboard')}}" class="detailed">
          <span class="title">Dashboard</span>
        </a>
        <span class="icon-thumbnail"><i class="pg-home"></i></span>
      </li>
      <li>
        <a href="{{route('wallet.index')}}">
          <span class="title">Wallet</span>
        </a>
        <span class="icon-thumbnail"><i class="fa fa-money"></i></span>
      </li>
      <li>
        <a href="#">
          <span class="title">Storage & Shipment</span>
          <span class=" arrow"></span>
        </a>
        <span class="icon-thumbnail"><i class="fa fa-dropbox"></i></span>

        <ul class="sub-menu">
          <li class="">
            <a href="{{route('storage.index','list')}}">List</a>
            <span class="icon-thumbnail"><i class="fa fa-list-ul"></i></span>
          </li>
          <li class="">
            <a href="{{route('storage.index','grid')}}">Grid</a>
            <span class="icon-thumbnail"><i class="fa fa-th"></i></span>
          </li>
        </ul>
      </li>
      <li>
        <a href="#"><span class="title">Shipping</span>
        <span class=" arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-truck"></i></span>
        <ul class="sub-menu">
          <li class="">
            <a href="{{route('shipping.calculator')}}">Calculator</a>
            <span class="icon-thumbnail"><i class="fa  fa-calculator"></i></span>
          </li>
        </ul>
      </li>

      @endrole
    </ul>
    <div class="clearfix"></div>
  </div>
</nav>
