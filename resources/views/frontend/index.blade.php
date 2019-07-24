@extends('frontend.layouts.main')
@section('content')
@include('frontend.shiping_calculate')
@include('frontend.video_modal')
<!-- Main Slider-->
<section class="hero-slider hero-slider-1" style="background-image: url({{asset('frontend/img/hero-slider/main-bg.jpg')}});">
    <div class="owl-carousel large-controls dots-inside" data-owl-carousel="{ &quot;nav&quot;: true, &quot;dots&quot;: false, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 7000 }" style="margin-top:-2%">
        <div class="item">
            <div class="container padding-top-3x">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-5 col-md-6 padding-bottom-2x text-md-left text-center">
                        <div class="from-bottom">

                            <div class="h2 text-body text-normal mb-4 pb-1">Welcome to the easiest place to <span class="text-bold">Shop </span> from USA Stores and <span class="text-bold">Ship</span> Internationally</div>
                        </div>
                        <a class="btn btn-primary scale-up delay-1" href="{{url('register')}}">Sign Up Now</a>
                    </div>
                    <div class="col-md-6 padding-bottom-2x mb-3"><img class="d-block mx-auto" src="{{asset('frontend/img/hero-slider/02.png')}}" alt="Internationl Shop and Ship"></div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container padding-top-3x">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-5 col-md-6 padding-bottom-2x text-md-left text-center">
                        <div class="from-bottom">
                            <div class="h2 text-body text-normal mb-2 pt-1">Shop at US Stores and Ship to your Global Shopaholics</div>
                            <div class="h2 text-body text-normal mb-4 pb-1"><span class="text-bold">Tax Free US Address</span></div>
                        </div>
                      <a class="btn btn-primary scale-up delay-1" href="{{url('register')}}">SIGN UP NOW</a>
                    </div>
                   <div class="col-md-6 padding-bottom-2x mb-3"><img class="d-block mx-auto" src="{{asset('frontend/img/hero-slider/01.png')}}" alt="Chuck Taylor All Star II"></div>
                </div>
            </div>
        </div>

        <div class="item">
            <div class="container padding-top-3x">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-5 col-md-6 padding-bottom-2x text-md-left text-center">
                        <div class="from-bottom">
                            <div class="h2 text-body text-normal mb-4 pb-1">We offer the most <span class="text-bold">COMPETITIVE PRICING</span> in the Industry</div>
                        </div>
                        <a class="btn btn-primary scale-up delay-1" href="#" onclick="scrollDown()">View Shipping Rates</a>
                    </div>
                    <div class="col-md-6 padding-bottom-2x mb-3"><img class="d-block mx-auto" src="{{asset('frontend/img/hero-slider/03.png')}}" alt="Moto 360"></div>
                </div>
            </div>
        </div>
   </div>

</section>

<div class="text-center second-banner-heading" id="scrollBannerVideo">
   <h1 style="margin-top:50px;">How to Shop & Ship from America</h1>
   <p class="text-muted">The short video below explains how our service works.</p>
</div>

<section class="hero-slider2" style="background-image: url({{asset('frontend/img/hero-slider/test2.jpg')}});cursor: pointer;" onclick="displayVideoModal()">
</section>

<section class="hero-slider">
   <div class="container">
        <div class="row align-items-center padding-top-9x">
            <div class="col-md-12 image-sizing-1 banner-3-web" style="background-image:url('{{asset('frontend/img/features/01.jpg')}}');">
                <div class="hero-text-1">
                   <h1>Shop, Collect, Consolidate <br> and Ship.</h1>
                   <p>Buy what you want from your favorite US stores and receive packages at your Tax free Global Shopaholics US address. Collect as many packages as you want for up to 180 days of free storage. Combine all packages into a single parcel and pay international shipping only once.  Choose your favorite shipping carrier and ship worldwide!</p>
                   <a class="text-medium text-decoration-none" href="#" onclick="scrollBanner8()">Learn why people choose Global Shopaholics&nbsp;<i class="icon-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row align-items-center banner-3-mobile">
            <div class="col-md-5"><img class="d-block w-400 m-auto" src="{{asset('frontend/img/features/01.jpg')}}" alt="Mobile App"></div>
            <div class="col-md-7 text-md-left text-center" style="margin-top: -127px;">
                <div class="mt-30 hidden-md-up"></div>
                <h1>Shop, Collect, Consolidate <br> and Ship.</h1>
                   <p>Buy what you want from your favorite US stores and receive packages at your Tax free Global Shopaholics US address. Collect as many packages as you want for up to 180 days of free storage. Combine all packages into a single parcel and pay international shipping only once.  Choose your favorite shipping carrier and ship worldwide!</p>
            </div>
        </div>


        <div class="row align-items-center">
            <div class="col-md-5 tree-banner"><img class="d-block w-400 m-auto" src="{{asset('frontend/img/features/03.jpg')}}" alt="Mobile App"></div>
            <div class="col-md-7 text-md-left text-center">
                <div class="mt-30 hidden-md-up"></div>
                <h1>Now Offering Price Match Guarantee!</h1>
                <p class="mb-4">We want you to stop worring about paying too much for shipping so we offer the best price in the industry!  We will match the price of any major competitor, even the ones that do not charge dimensional weight like MyUS.  Use our service with confidence! (terms and conditions apply)   </p>
                <a class="market-button" style="background-image: url('{{asset('frontend/img/features/03.jpg')}}');"href="#">
                    <span class="mb-subtitle">Compare to</span>
                    <span class="mb-title">MyUS</span>
                </a>
                <a class="market-button" style="background-image: url('{{asset('frontend/img/svg-comp/WS1.png')}}');" href="#">
                    <span class="mb-subtitle">Compare to</span>
                    <span class="mb-title">WS1</span>
                </a>
                <a class="market-button" style="background-image: url('{{asset('frontend/img/svg-comp/fif-749.svg')}}');" href="#">
                    <span class="mb-subtitle">Compare to</span>
                    <span class="mb-title">FishisFast</span></a>
                <a class="market-button"style="background-image: url('{{asset('frontend/img/svg-comp/s2d.png')}}');" href="#">
                    <span class="mb-subtitle">Compare to</span>
                    <span class="mb-title">Store2Door</span></a>
            </div>
        </div>



        <div class="row align-items-center padding-top-9x padding-bottom-9x fast_delivery">
            <div class="col-md-7 order-md-2">
                <img class="d-block w-700 m-auto" src="{{asset('frontend/img/features/02.jpg')}}" alt="Delivery">
                <div id="shipping_calculator" style="position: absolute;bottom:80px"></div>
            </div>
            <div class="col-md-5 order-md-1 text-md-left text-center">
                <div class="mt-30 hidden-md-up"></div>
                <h1>Fast Delivery Worldwide.</h1>
                <p>We offer both Premium and Economical shipping services.  Our fastest shipping option can get your parcel to your doorstep in Saudi Arabia in as little as 2 days while our most economical option can save you the maximum amount of money compared to any competitor. </p>
                <a class="text-medium text-decoration-none" href="#">Compare Shipping Services from USA to Saudi Arabia&nbsp;<i class="icon-arrow-right"></i></a>
            </div>
        </div>

        <div class="text-center padding-top-3.5x mb-30" style="margin-top:5%">
             <h2>We offer more shipping options than our competitors!</h2>
        </div>


        <div class="owl-carousel logo_owl" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: false, &quot;loop&quot;: true, &quot;margin&quot;: 30, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 4000, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;630&quot;:{&quot;items&quot;:2},&quot;991&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:5}} }" style="padding-bottom:50px">
            <!-- Products in Carousel-->
            <!-- Product-->
            <div class="grid-item">
                <div class="product-card">
                   <div class="product-badge text-danger">  </div>
                   <a class="product-thumb" href=""><img src="https://s3.amazonaws.com/freebiesupply/large/2x/usps-logo-transparent.png" alt="Product" style="margin-top:20px"></a>
                </div>
            </div>

            <!-- Product-->
            <div class="grid-item">
                <div class="product-card"><a class="product-thumb" href=""><img src="https://globalshopaholics.com/assets/images/carrier/ExpressWorldwideNonDoc.png" alt="Product"></a>
                </div>
            </div>

            <!-- Product-->
            <div class="grid-item">
                <div class="product-card"><a class="product-thumb" href=""><img src="https://globalshopaholics.com/assets/images/carrier/PriorityParcelExpress.png" alt="Product"></a>
                </div>
             </div>

            <!-- Product-->
            <div class="grid-item">
                <div class="product-card"><a class="product-thumb" href=""><img src="{{asset('frontend/assets-outer/images/carrier/fedex-1.png')}}" alt="Product"></a>
                </div>
            </div>

            <!-- Product-->
            <div class="grid-item">
                <div class="product-card"><a class="product-thumb"  href=""><img src="https://globalshopaholics.com/assets/images/carrier/airbnex.png" alt="Product" style="margin-top:10px"></a>
                </div>
            </div>

            <!-- Product-->
            <div class="grid-item">
                <div class="product-card"><a class="product-thumb" style="margin-left:75px!important" href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/United_Parcel_Service_logo_2014.svg/1200px-United_Parcel_Service_logo_2014.svg.png" alt="Product" style="width:65px"></a>
                </div>
            </div>
        </div>


        <div class="row justify-content-center certified_shipper" >
            <div class="col-xl-5 col-lg-6 mb-30">
                <div class="rounded bg-faded position-relative padding-bottom-3x">
                    <span class="product-badge text-danger" style="top: 24px; left: 24px;"></span>
                    <div class="text-center">
                        <h3 class="h2 text-normal mb-1"><br>
                         Dangerous Goods
                        </h3>
                        <h2 class="display-2 text-bold mb-2">Certified Shipper</h2>
                        <a class="market-button" style="background-image: url('{{asset('frontend/img/svg-comp/makeup.svg')}}');" href="#"><span class="mb-subtitle">We Ship</span><span class="mb-title">Cosmetics</span></a>
                        <a class="market-button"style="background-image: url('{{asset('frontend/img/svg-comp/spray.svg')}}');" href="#"><span class="mb-subtitle">We Ship</span><span class="mb-title">Perfumes</span></a>
                        <a class="market-button"style="background-image: url('{{asset('frontend/img/svg-comp/battery.svg')}}');" href="#"><span class="mb-subtitle">We Ship</span><span class="mb-title">Batteries</span></a><br><a class="btn btn-primary margin-bottom-none" href="#">And Much More!</a>
                    </div>
                </div>
            </div>

             <div class="col-lg-6 col-md-6 order-md-1">
                <!-- Side Menu-->
                <div class="padding-top-3x hidden-md-up"></div>
                <div class="card rounded-bottom-0" data-filter-list="#components-list">
                    <div class="card-body pb-3">
                      <!--testing-->
                        <div class="row" style="padding:5px 15px">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                   <label class="col-form-label" for="number-input">Select Country*</label>
                                   <!--testing-->
                                   <!--demo-->
                                        <div class="form-item">
                                            <input id="country_selector" onchange="checkCountry(this)"  type="text" style="border: 1px solid #dbe2e8;height: 44px">
                                            <label for="country_selector" style="display:none;">Select a country here...</label>
                                        </div>
                                        <div class="form-item" style="display:none;">
                                            <input type="text" id="country_selector_code"  name="country_selector_code" data-countrycodeinput="1" readonly="readonly" placeholder="Selected country code will appear here" />
                                            <label for="country_selector_code">...and the selected country code will be updated here</label>
                                        </div>
                                        <button type="submit" style="display:none;">Submit</button>
                                </div>
                            </div>

                            <div class="form-group" id="take_zip" style="display:none" >
                                <label class="col-form-label" for="number-input">Zip Code</label>
                                <div class="col-10">
                                   <input class="form-control" id="zip_code" type="text" name="zip_code"  value="">
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Choose Unit of Measure:</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="unit" value="kg" id="unit"><span class="custom-control-indicator"></span><span class="custom-control-description">KG/Centimeters</span>
                                            </label>
                                        </div>
                                        <div class="col-6">
                                            <label class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" name="unit" value="lb" id="unit" checked><span class="custom-control-indicator"></span><span class="custom-control-description">Pounds/Inches</span>
                                            </label>
                                        </div>
                                   </div>
                                </div>
                            </div>

                            <div class="col-md-3 col_50_per">
                                <div class="form-group">
                                   <label class="col-form-label" for="number-input">Weight</label>
                                   <input class="form-control" type="number" id="weight"  value=""  style="border-radius: 0px;">
                                </div>
                            </div>


                            <div class="col-md-3 col_50_per">
                                <div class="form-group">
                                   <label class="col-form-label" for="number-input">Lenght</label>
                                   <input class="form-control" type="number" id="length" value=""  style="border-radius: 0px;">
                                </div>
                            </div>


                            <div class="col-md-3 col_50_per">
                                <div class="form-group">
                                   <label class="col-form-label" for="number-input">Width </label>
                                   <input class="form-control" type="number"  id="width" value=""  style="border-radius: 0px;">
                                </div>
                            </div>


                            <div class="col-md-3 col_50_per">
                                <div class="form-group">
                                   <label class="col-form-label" for="number-input">Height</label>
                                   <input class="form-control" type="number"   id="height" value="" style="border-radius: 0px;">
                                </div>
                            </div>
                        </div>

                      <button onclick="calculateTotal()" type="button" class="btn btn-primary" name="button" style="float:right">Calculate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid padding-top-3x">
    <div class="text-center">
        <h1 class="banner-8-heading">Why Choose Us?</h1>
    </div>
    <div class="row justify-content-center banner-8-section" style="margin-left: 0px;margin-right: 0px;padding-bottom:72px;padding-right:8%;padding-left:8%;margin-top: -15px">
        <div id="banner-8" style="position: absolute;bottom:1100px"></div>
        <div class="col-lg-4 mb-30">
            <div class="banner-8-height" style="background-color:#fff;padding: 45px 30px 30px 30px;">
                <div class="8-banner-title" style="padding-bottom:15px">
                   <h3 class="h2 text-normal mb-1"><br>
                      Powerful Yet <br />
                      Simple to Use!
                   </h3>
                </div>
                <div class="8-banner-image">
                   <img src="{{asset('frontend/img/banners/interfacegif_1.png')}}">
                </div>
                <div class="8-banner-description" style="padding-bottom: 10px;padding-top: 10px;">
                   We offer a powerful management tool with easy to use interface experience so you can ship the way you've always wanted to with full control.  Whether
                   you are a business catering to thousands of customers or an individual who enjoys picking  from a variety of top quality brands and products available in the US, we are the right fit for you!
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-30" >
             <div class="banner-8-height" style="background-color:#fff;padding: 45px 30px 30px 30px;">
                <div class="8-banner-title" style="padding-bottom:15px">
                   <h3 class="h2 text-normal mb-1"><br>
                      Smart Shipping, Smarter Savings!
                   </h3>
                </div>
                <div class="8-banner-image">
                   <img src="{{asset('frontend/img/banners/Carriersbox_1.png')}}">
                </div>
                <div class="8-banner-description" style="padding-bottom: 10px;padding-top: 10px;">
                   Global Shopaholics gives you access to the worlds most trusted carriers and we let them compete for your business by offering the best pricing available on the market. Simply pick your price and ship with confidence!
                </div>
             </div>
        </div>

        <div class="col-lg-4 mb-30">
            <div class="banner-8-height" style="background-color:#fff;padding: 45px 30px 30px 30px;">
                <div class="8-banner-title" style="padding-bottom:15px">
                    <h3 class="h2 text-normal mb-1"><br>
                      Your Personal Shipping Negotiator!
                    </h3>
                </div>
                <div class="8-banner-image">
                   <img src="{{asset('frontend/img/banners/negotiator_1.jpg')}}">
                </div>
                <div class="8-banner-description" style="padding-bottom: 10px;padding-top: 10px;">
                   We know our shipping rates are amazing but it doesn't end there.  We are constantly connecting with our carriers to Negotiate even better discounts.  The more our business grows, the cheaper our rates get and we don't pocket the savings, we pass them to you!
                </div>
            </div>
        </div>
   </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="{{asset('frontend/js/countrySelect.js')}}"></script>
<script>
  $("#country_selector").countrySelect({
    defaultCountry: "us",
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    preferredCountries: ['au', 'sa', 'gb']
  });

  function checkCountry(obj){
    var val=$("#country_selector_code").val();
    if(val=="ca"){
      $("#take_zip").show();
    }else{
      $("#take_zip").hide();
    }

  }
</script>
@endsection
