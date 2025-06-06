<div id="sidebar" class="active">
    <div class="sidebar-wrapper active ps ps--active-y">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{route('dashboard', ['role' =>currentUser()])}}"><img src="{{ asset('assets/images/logo/logo.png')}}" alt="Logo" srcset=""></a>
                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
                    </svg>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item">
                    <a href="{{route('dashboard', ['role' =>currentUser()])}}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item  has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-stack"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item">
                            <a href="{{route('role.index')}}">Role</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('user.index')}}">User</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('country.index')}}">Country</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('division.index')}}"> {{__('Division')}}</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('district.index')}}">{{__('District')}}</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('upazila.index')}}">{{__('Upazila')}}</a>
                        </li>
                        {{-- <li class="submenu-item ">
                                    <a href="{{route('thana.index')}}">{{__('Thana')}}</a>
                </li> --}}
                <li class="submenu-item ">
                    <a href="{{route('union.index')}}">{{__('Unions')}}</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{route('ward.index')}}">{{__('Wards')}}</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{route('jobpost.index')}}">{{__('Job Post')}}</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{route('zone.index')}}">{{__('Zone')}}</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{route('invoicesetting.index')}}">{{__('Invoice Setting')}}</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{route('hour.index')}}">{{__('Hour')}}</a>
                </li>
            </ul>
            </li>

            <li class="sidebar-item  has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-stack"></i>
                    <span>HRM</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item">
                        <a href="{{route('employee.index', ['role' =>currentUser()])}}">Employee</a>
                    </li>
                    {{-- <li class="submenu-item">
                                    <a href="{{route('salarySheet.create', ['role' =>currentUser()])}}">Salary Sheet</a> --}}
                </ul>
            </li>
            <li class="sidebar-item  has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-people-fill"></i>
                    <span>CRM</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="{{route('customer.index', ['role' =>currentUser()])}}">Customer</a>
                    </li>
                    {{-- <li class="submenu-item">
                                    <a href="{{route('empatten.index', ['role' =>currentUser()])}}">Employee Attendance</a>
            </li> --}}
            <li class="submenu-item">
                <a href="{{route('employee_assign.index', ['role' =>currentUser()])}}">Employee's Assign</a>
            </li>
            <li class="submenu-item">
                <a href="{{route('portlinkAssaign.index', ['role' =>currentUser()])}}">Portlink Assign</a>
            </li>
            <li class="submenu-item">
                <a href="{{route('southBanglaAssaign.index', ['role' =>currentUser()])}}">South Bangla Assign</a>
            </li>
            <li class="submenu-item">
                <a href="{{route('wasaEmployeeAsign.index', ['role' =>currentUser()])}}">Wasa Employee's Assign</a>
            </li>
            <li class="submenu-item">
                <a href="{{route('islamiBankEmpAssign.index', ['role' =>currentUser()])}}">IBBL Employee's Assign</a>
            </li>
            <li class="submenu-item">
                <a href="{{route('invoiceGenerate.index', ['role' =>currentUser()])}}">Invoice Generate</a>
            </li>
            <li class="submenu-item">
                <a href="{{route('invoice-payment.index', ['role' =>currentUser()])}}">Invoice Payment</a>
            </li>

            </ul>
            </li>
            <li class="sidebar-item  has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-stack"></i>
                    <span>Pay Roll</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item">
                        <a href="{{route('employeeRate.index', ['role' =>currentUser()])}}">Employee's Salary</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('customerduty.index', ['role' =>currentUser()])}}">Customer Duty</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('deduction_asign.index')}}">Deduction & Allownce</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('long_loan.index')}}">Long Loan</a>
                    </li>
                    <li class="sidebar-item  has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-stack"></i>
                            <span>Salary Sheet</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item">
                                <a href="{{route('salarysheet.salarySheetOneIndex')}}">Salary Sheet One</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{route('salarysheet.salarySheetTwoIndex')}}">Salary Sheet Two</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{route('salarysheet.salarySheetThreeIndex')}}">Salary Sheet Three</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{route('salarysheet.salarySheetFourIndex')}}">Office Staff Salary</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{route('salarysheet.salarySheetFiveIndex')}}">Salary (General)</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item  has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-stack"></i>
                    <span>Print</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item">
                        <a href="{{route('salarysheet.printZoneWise')}}">Zone Wise Salary Sheet Print</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item  has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-stack"></i>
                    <span>Stock</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item">
                        <a href="{{route('category.index')}}">Category</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('size.index')}}">Product Size</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('product.index')}}">Product</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('product_stockin.index')}}">Product Stock In</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('product_issue.index')}}">Product Issue</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('product_issue.product_issue_create')}}">Product Issue after</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('productdamage.index')}}">Product Condem</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('stock.index')}}">Stock</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('stock.employeeList')}}">Employee | Customer Wise</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('relEmployee.index', ['role' =>currentUser()])}}">Release List</a>
                    </li>

                </ul>
            </li>
            <li class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'><i class="bi bi-calculator"></i><span>{{__('Accounts')}}</span>
                </a>
                <ul class="submenu">
                    <li class="py-1 submenu-item"><a href="{{route('master.index')}}">{{__('Master Head')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('sub_head.index')}}">{{__('Sub Head')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('child_one.index')}}">{{__('Child One')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('child_two.index')}}">{{__('Child Two')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('navigate.index')}}">{{__('Navigate View')}}</a></li>
                </ul>
            </li>
            <li class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'><i class="bi bi-receipt"></i><span>{{__('Voucher')}}</span>
                </a>
                <ul class="submenu">
                    <li class="py-1 submenu-item"><a href="{{route('credit_voucher.index')}}">{{__('Receive/Cr Voucher')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('debit_voucher.index')}}">{{__('Payment/Dr Voucher')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('journal_voucher.index')}}">{{__('Journal Voucher')}}</a></li>
                </ul>
            </li>
            <li class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'><i class="bi bi-receipt"></i><span>{{__('Report')}}</span>
                </a>
                <ul class="submenu">
                    <li class="py-1 submenu-item"><a href="{{route('report.salary_report')}}">{{__('Salary Reports')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('salarysheet.employeeWiseSalary')}}">Employee Wise Salary</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('report.employee_wise_training')}}">Employee Wise Training Cost</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('report.inv_payment')}}">{{__('Zone Wise Invoice Due Report')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('invoice-payment.client_wise_detail_invoice_report')}}">{{__('Invoice Client Wise')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('report.inv_due')}}">{{__('Invoice Due')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('report.customer_duty_filter')}}">{{__('Customer Duty Filter')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('report.payment_receive')}}">{{__('Payment Received')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('incomeStatement.list')}}">{{__('Income Statement')}}</a></li>
                    <li class="py-1 submenu-item"><a href="{{route('report.headreport')}}">{{__('Account Head Report')}}</a></li>
                </ul>
            </li>
            <!-- <li class="sidebar-title">Forms &amp; Tables</li> -->



            <!-- <li class="sidebar-item  ">
                            <a href="https://zuramai.github.io/mazer/docs" class="sidebar-link">
                                <i class="bi bi-life-preserver"></i>
                                <span>Documentation</span>
                            </a>
                        </li> -->



            </ul>
        </div>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 657px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 253px;"></div>
        </div>
    </div>
</div>