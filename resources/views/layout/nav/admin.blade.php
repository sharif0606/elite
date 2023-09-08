<ul>
    <li
        class="menu-item  ">
        <a href="{{route(currentUser().'.dashboard')}}" class='menu-link'>
            <i class="bi bi-grid-fill"></i>
            <span>{{__('dashboard') }}</span>
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
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Users')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.designation.index')}}" class='submenu-link'>{{__('Designation')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.department.index')}}" class='submenu-link'>{{__('Department')}}</a></li>
                    <li class="submenu-item has-sub"><a href="#" class='submenu-link'>{{__('Company')}}</a>
                        <ul class="subsubmenu">
                            <li class="subsubmenu-item"><a class="subsubmenu-link" href="{{route(currentUser().'.company.index')}}">{{__('Company')}}</a></li>
                            <li class="subsubmenu-item"><a class="subsubmenu-link" href="{{route(currentUser().'.warehouse.index')}}">{{__('Warehouse')}}</a></li>
                            <li class="subsubmenu-item"><a class="subsubmenu-link" href="{{route(currentUser().'.warehouseboard.index')}}">{{__('Warehouse Board')}}</a></li>
                        </ul>
                    </li>
                    <li class="submenu-item has-sub"><a href="#" class='submenu-link'>{{__('Unit')}}</a>
                        <ul class="subsubmenu">
                            <li class="subsubmenu-item"><a class="subsubmenu-link" href="{{route(currentUser().'.unitstyle.index')}}">{{__('Unit Style')}}</a></li>
                            <li class="subsubmenu-item"><a class="subsubmenu-link" href="{{route(currentUser().'.unit.index')}}">{{__('Unit')}}</a></li>
                        </ul>
                    </li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.buyer.index')}}" class='submenu-link'>{{__('Buyers')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.supplier.index')}}" class='submenu-link'>{{__('Suppliers')}}</a></li>
                </ul>  
            </div>
        </div>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-box-seam"></i>
            <span>{{__('Products')}}</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a href="{{route(currentUser().'.category.index')}}" class='submenu-link'>{{__('Category')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.product.index')}}" class='submenu-link'>{{__('Product')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.productstyle.index')}}" class='submenu-link'>{{__('Product Style')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.indent.index')}}" class='submenu-link'>{{__('Indent')}}</a></li>
                </ul>  
            </div>
        </div>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-shop"></i>
            <span>{{__('Stock')}}</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a href="{{route(currentUser().'.stockin.index')}}" class='submenu-link'>{{__('Receive')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.c_to_c_transfer.index')}}" class='submenu-link'>{{__('C2C Transfer (Req) ')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('C2C Transfer (Receive) ')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.stocktransferind.index')}}" class='submenu-link'>{{__('Transfer Indent')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.requisition.index')}}" class='submenu-link'>{{__('Requisition')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.req.pending_requisition')}}" class='submenu-link'>{{__('Requisition Receive')}}</a></li>
                </ul>  
            </div>
        </div>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-list"></i>
            <span>{{__('Reports')}}</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Stock')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Stock (Date to Date)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Stock (Warehouse Wise)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Stock (Indent Wise)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Stock Finish Date')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Product Stock Hisory')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Stock (Remain)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Stock (Remain)')}}</a></li>
                </ul>  
                <ul class="submenu-group">
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Buyer PO')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Supplier PO')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Buyer PO (Running)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Supplier PO (Running)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Buyer PO (Close)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Supplier PO (Close)')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Warehouse Status')}}</a></li>
                    <li class="submenu-item"><a href="{{route(currentUser().'.admin.index')}}" class='submenu-link'>{{__('Warehouse Board Status')}}</a></li>
                </ul>  
            </div>
        </div>
    </li>

</ul>