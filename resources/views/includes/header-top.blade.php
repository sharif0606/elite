  <!-- Header top start -->
  <div class="header-top">
    <header class="container fw-bold">
      <div class="row d-flex align-items-center justify-content-sm-center">
        <div class="col-sm-12 col-md-12 col-lg-2 logo">
          <a href="{{url('/')}}"><img class="img-fluid" src="{{asset('front/img/header-logo.png')}}" alt="" /></a>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-10 header-top-secound">
          <div class="container-fluid">
            <div class="row d-flex align-items-center">
              <div class="col-12 col-md-3">
              <p class="text-center">{{$japan_locale_data->format('M, d, H:i (T)')}} {{--Japan Time: Dec, 26, 18:42(JST)--}}</p>
              <h4 class="text-center m-0">Total Cars: {{$total_cars}}</h4>
              </div>
              @php //print_r($location);die;@endphp
              <div class="col-12 col-md-2 text-center">
                <p class="m-0">{{$current_locale_data->format('M, d, H:i (T)')}}</p>
                @php //echo '<pre>';//print_r($location); @endphp
              <p class="m-0">{{$location['geoplugin_currencyCode']}}/USD {{number_format($location['geoplugin_currencyConverter'], 2, '.', ',')}}</p>
            </div>

            <div class="col-6 col-md-3 d-grid text-center">
              <p>Home currency display</p>
              <button class="btn btn-secondary" type="button" style="color: #fff;text-align: center;text-decoration: none;font-weight: bold;font-size: 12px;border-radius: 10px;">On</button>
              <!--<select class="form-select" id="currency_opt" aria-label="Default select example">
                <option value="1">ON</option>
                <option value="0">Off</option>
              </select>-->
            </div>
            <div class="col-6 col-md-2 text-center">
              <p><span><i class="bi bi-headset"></i></span>Support</p>
              {{--<select class="form-select" id="lang_id" aria-label="Default select example">
                <option value=""></option>
                <option value="1" selected>EN</option>
                <option value="2">BN</option>
              </select>--}}
            </div>
            <!-- <div class="col-sm-1 col-lg-1 mb-3">
              <select class="form-select" id="country_id" aria-label="Default select example">
                <option value=""></option>
                <option value="1" selected>BD</option>
                <option value="2">USA</option>
                <option value="3">UK</option>
              </select>
            </div> -->
            @if(currentUser())
            <div class="col col-md-2 d-flex justify-content-end">
              <!-- Button trigger dropdown -->
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-fill"></i>
              </button>
              <!-- Dropdown menu -->
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="z-index:9999">
                <li><a class="dropdown-item" href="#"><strong>{{encryptor('decrypt', request()->session()->get('userName'))}}</strong></a></li>
                <li><a class="dropdown-item" href="{{route(currentUser().'.profile')}}">{{__('My Account') }}</a></li>
                <li><a class="dropdown-item" href="{{route(currentUser().'.change_password')}}">{{__('Change Password') }}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{route('logOut')}}">{{__('Logout') }}</a></li>
              </ul>
            </div>
            @else
              <div class="col col-md-2 d-flex justify-content-center align-items-center">
                <a class="auth-link fw-bold" href="{{route('login')}}">Login</a>
                <a class="auth-link fw-bold" href="{{route('register')}}">Register</a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </header>
  </div>
  <!-- Header top end -->