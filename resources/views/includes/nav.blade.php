  <!-- nav start -->
  <nav class="navbar navbar-expand-lg bg-brand sticky-top top-nav">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="top-menu navbar-nav">
          <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
          <li class="nav-item dropdown position-static"">
            <a class=" nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">Car Search</a>
            <!-- Dropdown menu -->
            <div class="dropdown-menu w-75 mt-0" aria-labelledby="navbarDropdown" style="border-top-left-radius: 0;border-top-right-radius: 0;">
              <div class="container-fluid">
                <div class="row my-2">

                  <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                    <p class="text-white mb-2"><strong>Today's Deal</strong></p>
                    <div class="list-group list-group-flush">
                      <a href="" class="list-group-item list-group-item-action">ICAR JAPAN Buyer's Selection</a>
                      <a href="" class="list-group-item list-group-item-action">ICAR JAPAN Outlet Mall</a>
                    </div>
                    <p class="text-white mb-2"><strong>Search By Price</strong></p>
                    <div class="list-group list-group-flush">
                      <a href="" class="list-group-item list-group-item-action">Under USD 500</a>
                      <a href="" class="list-group-item list-group-item-action">Under USD 1000</a>
                      <a href="" class="list-group-item list-group-item-action">Under USD 2000</a>
                      <a href="" class="list-group-item list-group-item-action">Under USD 3000</a>
                      <a href="" class="list-group-item list-group-item-action">Under USD 4000</a>
                      <a href="" class="list-group-item list-group-item-action">Over USD 5000</a>
                    </div>
                    <p class="text-white mb-2"><strong>Search By Discount</strong></p>
                    <div class="list-group list-group-flush">
                      <a href="" class="list-group-item list-group-item-action">90%~ Off</a>
                      <a href="" class="list-group-item list-group-item-action">80%~89% Off</a>
                      <a href="" class="list-group-item list-group-item-action">70%~79% Off</a>
                      <a href="" class="list-group-item list-group-item-action">60%~69% Off</a>
                      <a href="" class="list-group-item list-group-item-action">50%~59% Off</a>
                      <a href="" class="list-group-item list-group-item-action">40%~49% Off</a>
                      <a href="" class="list-group-item list-group-item-action">30%~39% Off</a>
                      <a href="" class="list-group-item list-group-item-action">1%~29% Off</a>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                    <p class="text-white mb-2"><strong>Search By Make</strong></p>
                    <div class="list-group list-group-flush">
                      @forelse($brands as $b)
                      @if($b->vehicles_count > 0)
                      <a href="{{route('brand',strtolower($b->slug_name))}}" class="list-group-item list-group-item-action">{{$b->name}} ({{$b->vehicles_count}})</a>
                      @endif
                      @empty
                      @endforelse
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                    <p class="text-white mb-2"><strong>Search By Type</strong></p>
                    <div class="list-group list-group-flush">
                      @forelse($body_types as $bt)
                      @if($bt->vehicles_count > 0)
                      <a href="" class="list-group-item list-group-item-action">{{$bt->name}} ({{$bt->vehicles_count}})</a>
                      @endif
                      @empty
                      @endforelse
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                    <p class="text-white mb-2"><strong>Inventory Location</strong></p>
                    <div class="list-group list-group-flush">
                      
                    </div>
                  </div>
                </div>
              </div>

          </li>
          <li class="nav-item dropdown">
            <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown"> How to Order</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{url('how-to-order-from-auction')}}">Auction Order Process</a></li>
              <li><a class="dropdown-item" href="{{url('how-to-buy-from-stock')}}">How To Buy From Stock</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">Services</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{url('shipping')}}">Shipping</a></li>
              <li><a class="dropdown-item" href="{{url('/inspection-services')}}">Inspection Services</a></li>
              <li><a class="dropdown-item" href="{{url('/why-choose-us')}}">Why Choose Us</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown">About Us</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{url('/overview')}}">Overview</a></li>
              <li><a class="dropdown-item" href="{{url('/company-profile')}}">Company Profile</a></li>
              <li><a class="dropdown-item" href="{{url('/customer-review')}}">Customer Reviews</a></li>
              <li><a class="dropdown-item" href="{{url('/bank-information')}}">Bank Information</a></li>
              <li><a class="dropdown-item" href="{{url('/faq')}}">FAQ</a></li>
              <li><a class="dropdown-item" href="{{url('/contact-us')}}">Contact Us</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://auc.tmtcarz.com/">Auction</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- nav end -->