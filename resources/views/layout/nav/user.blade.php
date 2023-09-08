@push('styles')
<style>
    #user-nav .dropdown-menu {
        background-color: var(--bs-body-color);
    }

    #user-nav .dropdown-menu .dropdown-item a {
        text-decoration: none;
    }

    .dropdown-item:focus,
    .dropdown-item:hover {
        background-color: var(--brand-color);
    }
</style>
@endpush
<div class="container my-4">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="user-nav">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    </i>Profile
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li class="dropdown-item"><a href="{{route(currentUser().'.usercontact.index')}}" class='submenu-link'>{{__('Contact Information')}}</a></li>
                                    <li class="dropdown-item"><a href="{{route(currentUser().'.userpref.index')}}" class='submenu-link'>{{__('Preference')}}</a></li>
                                </ul>
                            </li> -->
                            <li class="nav-item">
                                <a href="{{route(currentUser().'.profile')}}" class='nav-link'>
                                    <span>{{__('Account Information')}}</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Consignee
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li class="dropdown-item"><a href="{{route(currentUser().'.consigdetl.index')}}" class='submenu-link'>{{__('Consignee List')}}</a></li>
                                    <li class="dropdown-item"><a href="{{route(currentUser().'.consigdetl.create')}}" class='submenu-link'>{{__('Add Consignee')}}</a></li>
                                </ul>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="{{route(currentUser().'.favourvehicle.index')}}" class='nav-link'>
                                    <span>{{__('Favourite Vehicle')}}</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="{{route(currentUser().'.inquiry.index')}}" class='nav-link'>
                                    <span>{{__('Inquiry')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route(currentUser().'.invoice.index')}}" class='nav-link'>
                                    <span>{{__('Invoice List')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route(currentUser().'.payment.index')}}" class='nav-link'>
                                    <span>{{__('Payment List')}}</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Vehicles
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li class="nav-item"><a href="{{route(currentUser().'.reservevehicle.index')}}" class='nav-link'>{{__('Reserved Vehicle')}}</a></li>
                                    <!-- <li class="nav-item"><a href="{{route(currentUser().'.purvehicle.index')}}" class='nav-link'>{{__('Purchase Vehicle')}}</a></li>
                                    <li class="nav-item"><a href="{{route(currentUser().'.aucvehicle.index')}}" class='nav-link'>{{__('Auction Vehicle')}}</a></li> -->
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>