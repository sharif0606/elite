<ul>
    <li
        class="menu-item  ">
        <a href="{{route(currentUser().'.dashboard')}}" class='menu-link'>
            <i class="bi bi-grid-fill"></i>
            <span>{{__('dashboard') }}</span>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{route(currentUser().'.profile')}}" class='menu-link'>
            <i class="bi bi-gear"></i>
            <span>{{__('My Account Info')}}</span>
        </a>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-gear"></i>
            <span>{{__('Settings')}}</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a href="{{route(currentUser().'.client.index')}}" class='submenu-link'>{{__('Users')}}</a></li>
                </ul>
            </div>
        </div>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-car-front-fill"></i>
            <span>{{__('Vehicles')}}</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a href="{{route(currentUser().'.vehicle.index')}}" class='submenu-link'>{{__('Vehicle')}}</a></li>
                </ul>  
            </div>
        </div>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-car-front-fill"></i>
            <span>{{__('Reserve')}}</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a href="{{route(currentUser().'.reservevehicle.index')}}" class='submenu-link'>{{__('Reserve List')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.reservevehicle.create')}}" class='submenu-link'>{{__('Reserve Vehicle')}}</a></li>
                </ul>  
            </div>
        </div>
    </li>
    <li class="menu-item">
        <a href="{{route(currentUser().'.invoice.index')}}" class='menu-link'>
            <i class="bi bi-shop"></i>
            <span>{{__('Invoice List')}}</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{route(currentUser().'.inquiry.index')}}" class='menu-link'>
            <i class="bi bi-shop"></i>
            <span>{{__('Inquiry List')}}</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{route(currentUser().'.payment.create')}}" class='menu-link'>
            <i class="bi bi-shop"></i>
            <span>{{__('Make Deposit')}}</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{route(currentUser().'.payment.index')}}" class='menu-link'>
            <i class="bi bi-shop"></i>
            <span>{{__('Payment List')}}</span>
        </a>
    </li>

</ul>
