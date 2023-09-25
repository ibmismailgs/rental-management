<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
                <?php
                    $generalSettings = App\Models\RentInfo\GeneralSetting::first();
                ?>
                  @if (empty($generalSettings))
                  @else
                    <img height="30" src="@isset($generalSettings) {{ asset('img/' . $generalSettings->logo) }} @endisset" class="header-brand-img" title="Wardan Tech">
                @endif
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $prefix = Request::route()->getPrefix();
        $route  = Route::current()->getName();
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">

                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                         @endcan
                         <!-- only those have manage_role permission will get access -->
                        @can('manage_role')
                        <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                        <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                        @endcan
                    </div>
                </div>

                <div class="nav-item {{ ($route == 'general-settings') ? 'active open' : '' }} has-sub">
                    <a href="javascript:void(0)" class="menu-item {{ ( $route == 'general-settings' ) ? 'active' : '' }}"><i class="fa fa-cog"></i>{{ __('General Settings')}}</a>
                        <div class="submenu-content">
                            @can('manage_owner')
                                <a href="{{route('general-settings')}}" class="menu-item {{ ( $route == 'general-settings') ? 'active' : '' }}">{{ __('Settings')}}</a>
                            @endcan
                        </div>
                </div>

                <div class="nav-item {{ ($route == 'owner-info.index' || $route == 'owner-info.create' || $route == 'owner-info.edit' ||$route == 'owner-info.show' || $route == 'flat-info.index' || $route == 'flat-info.create' || $route == 'flat-info.edit' || $route == 'flat-info.show' || $route == 'rent-info.index' || $route == 'rent-info.create' || $route == 'rent-info.edit' || $route == 'rent-info.show' || $route == 'tenant-info.index' || $route == 'tenant-info.create' || $route == 'tenant-info.edit' || $route == 'tenant-info.show' || $route == 'rent-collection' || $route == 'rent-collect.index' || $route == 'rent-collect.edit' || $route == 'rent-collect.show' ||  $route == 'owner-report' || $route == 'flat-report' || $route == 'tenant-report' || $route == 'rent-report' || $route == 'due-collect' || $route == 'profile' || $route == 'rent-collect-transaction') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Rent Info')}}</span></a>
                    <div class="submenu-content">
                        <div class="nav-item has-sub {{ ( $route == 'owner-info.index' || $route == 'owner-info.create' || $route == 'owner-info.edit' ||$route == 'owner-info.show' ||  $route == 'owner-report' || $route == 'profile') ? 'open ' : '' }}">

                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'owner-info.index' || $route == 'owner-info.create' || $route == 'owner-info.edit' || $route == 'owner-info.show' ||  $route == 'owner-report' || $route == 'profile') ? 'active' : '' }}">{{ __('Owner Info')}}</a>

                            <div class="submenu-content">
                                @can('manage_owner')
                                    <a href="{{route('owner-info.index')}}" class="menu-item {{ ( $route == 'owner-info.index' || $route == 'profile' || $route == 'owner-report' || $route == 'owner-info.show') ? 'active' : '' }}">{{ __('Owner List')}}</a>
                                @endcan

                                @can('manage_user')
                                    <a href="{{ route('owner-info.create') }}" class="menu-item {{ ( $route == 'owner-info.create' ) ? 'active' : '' }} ">{{ __('Owner Create')}}</a>
                                @endcan
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ ( $route == 'flat-info.index' || $route == 'flat-info.create' || $route == 'flat-info.edit' || $route == 'flat-info.show' || $route == 'flat-report') ? 'open ' : '' }}">

                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'flat-info.index' || $route == 'flat-info.create' || $route == 'flat-info.edit' || $route == 'flat-info.show' || $route == 'flat-report') ? 'active' : '' }}">{{ __('Flat Info')}}</a>

                            <div class="submenu-content">
                                @can('manage_flat')
                                    <a href="{{route('flat-info.index')}}" class="menu-item {{ ( $route == 'flat-info.index' || $route == 'flat-report' || $route == 'flat-info.show') ? 'active' : '' }}">{{ __('Flat List')}}</a>
                                @endcan

                                @can('manage_flat')
                                    <a href="{{ route('flat-info.create') }}" class="menu-item {{ ( $route == 'flat-info.create' ) ? 'active' : '' }} ">{{ __('Flat Create')}}</a>
                                @endcan
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ ( $route == 'tenant-info.index' || $route == 'tenant-info.create' || $route == 'tenant-info.edit' ||$route == 'tenant-info.show' || $route == 'tenant-report') ? 'open ' : '' }}">

                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'tenant-info.index' || $route == 'tenant-info.create' || $route == 'tenant-info.edit' || $route == 'tenant-info.show' || $route == 'tenant-report') ? 'active' : '' }}">{{ __('Tenant Info')}}</a>

                            <div class="submenu-content">
                                @can('manage_tenant')
                                    <a href="{{route('tenant-info.index')}}" class="menu-item {{ ( $route == 'tenant-info.index' || $route == 'tenant-report') ? 'active' : '' }}">{{ __('Tenant List')}}</a>
                                @endcan

                                @can('manage_tenant')
                                    <a href="{{ route('tenant-info.create') }}" class="menu-item {{ ( $route == 'tenant-info.create' ) ? 'active' : '' }} ">{{ __('Tenant Create')}}</a>
                                @endcan
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ ( $route == 'rent-info.index' || $route == 'rent-info.create' || $route == 'rent-info.edit' || $route == 'rent-info.show' || $route == 'rent-collection' || $route == 'rent-report') ? 'open ' : '' }}">
                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'rent-info.index' || $route == 'rent-info.create' || $route == 'rent-info.edit' || $route == 'rent-info.show' || $route == 'rent-collection' || $route == 'rent-report') ? 'active' : '' }}">{{ __('Rent Info')}}</a>

                            <div class="submenu-content">
                                @can('manage_rent')
                                    <a href="{{route('rent-info.index')}}" class="menu-item {{ ( $route == 'rent-info.index' || $route =='rent-collection' || $route == 'rent-report') ? 'active' : '' }}">{{ __('Rent List')}}</a>
                                @endcan

                                @can('manage_rent')
                                    <a href="{{ route('rent-info.create') }}" class="menu-item {{ ( $route == 'rent-info.create' ) ? 'active' : '' }} ">{{ __('Rent Create')}}</a>
                                @endcan
                            </div>
                        </div>

                        <div class="nav-item has-sub {{ ( $route == 'rent-collect.index' ||  $route == 'rent-collect.edit' || $route == 'rent-collect.show' || $route == 'due-collect' || $route == 'rent-collect-transaction') ? 'open ' : '' }}">

                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'rent-collect.index' || $route == 'rent-collect.edit' || $route == 'rent-collect.show' || $route == 'due-collect' || $route == 'rent-collect-transaction') ? 'active' : '' }}">{{ __('Rent Collect')}}</a>

                            <div class="submenu-content">
                                @can('manage_rent_collect')
                                    <a href="{{route('rent-collect.index')}}" class="menu-item {{ ( $route == 'rent-collect.index' || $route == 'due-collect' || $route == 'rent-collect-transaction') ? 'active' : '' }}">{{ __('Rent Collect List')}}</a>
                                @endcan
                            </div>
                        </div>

                    </div>
                </div>

                <div class="nav-item {{ ($route == 'mobile-banking.index' || $route == 'mobile-banking.edit' || $route == 'mobile-banking.create' || $route == 'mobile-banking-account.index' || $route == 'mobile-banking-account.edit' || $route == 'mobile-banking-account.create' ||$route == 'bank.index' || $route == 'bank.edit' || $route == 'bank.create' || $route == 'bank-account.index' || $route == 'bank-account.edit' || $route == 'bank-account.create' || $route == 'bank-account.show' || $route == 'expense-category.index' || $route == 'expense-category.create' || $route == 'expense-category.edit' || $route == 'expense.index' || $route == 'expense.create' || $route == 'expense.edit' || $route == 'expense.show' || $route == 'mobile-account.report' || $route == 'bank-account.report' || $route == 'revenue') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="fas fa-users"></i><span>{{ __('Accounts')}}</span></a>

                    <div class="submenu-content">
                        <div class="nav-item has-sub {{ ( $route == 'mobile-banking.index' || $route == 'mobile-banking.edit' || $route == 'mobile-banking.create' || $route == 'mobile-banking-account.index' || $route == 'mobile-banking-account.edit' || $route == 'mobile-banking-account.create' || $route == 'mobile-account.report' || $route == 'bank-account.report') ? 'open ' : '' }}">

                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'mobile-banking.index' || $route == 'mobile-banking.edit' || $route == 'mobile-banking.create' || $route == 'mobile-banking-account.index' || $route == 'mobile-banking-account.edit' || $route == 'mobile-banking-account.create' || $route == 'mobile-account.report') ? 'active' : '' }}">{{ __('Mobile Banking')}}</a>

                            <div class="submenu-content">
                                @can('manage_mobile_banking')
                                    <a href="{{route('mobile-banking.index')}}" class="menu-item {{ ( $route == 'mobile-banking.index' || $route == 'mobile-banking.edit' || $route == 'mobile-banking.create' ) ? 'active' : '' }}">{{ __('Mobile Banking')}}</a>
                                @endcan

                                @can('manage_mobile_banking_account')
                                    <a href="{{route('mobile-banking-account.index')}}" class="menu-item {{ ( $route == 'mobile-banking-account.index' || $route == 'mobile-banking-account.edit' || $route == 'mobile-banking-account.create' || $route == 'mobile-account.report') ? 'active' : '' }}">{{ __('Mobile Banking Accounts')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="submenu-content">
                        <div class="nav-item has-sub {{ ( $route == 'bank.index' || $route == 'bank.edit' || $route == 'bank.create' || $route == 'bank-account.index' || $route == 'bank-account.edit' || $route == 'bank-account.create' || $route == 'bank-account.show' || $route == 'bank-account.report') ? 'open ' : '' }}">

                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'bank.index' || $route == 'bank.edit' || $route == 'bank.create' || $route == 'bank-account.index' || $route == 'bank-account.edit' || $route == 'bank-account.create' || $route == 'bank-account.report') ? 'active' : '' }}">{{ __('Bank Account')}}</a>

                            <div class="submenu-content">
                                @can('manage_bank')
                                    <a href="{{route('bank.index')}}" class="menu-item {{ ( $route == 'bank.index' || $route == 'bank.edit' || $route == 'bank.create') ? 'active' : '' }}">{{ __('Banks')}}</a>
                                @endcan

                                @can('manage_bank_account')
                                    <a href="{{route('bank-account.index')}}" class="menu-item {{ ( $route == 'bank-account.index' || $route == 'bank-account.edit' || $route == 'bank-account.create' || $route == 'bank-account.show' || $route == 'bank-account.report') ? 'active' : '' }}">{{ __('Bank Accounts')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="submenu-content">
                        <div class="nav-item has-sub {{ ( $route == 'expense-category.index' || $route == 'expense-category.create' || $route == 'expense-category.edit' || $route == 'expense.index' || $route == 'expense.create' || $route == 'expense.edit' || $route == 'expense.show') ? 'open ' : '' }}">
                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'expense-category.index' || $route == 'expense-category.create' || $route == 'expense-category.edit' || $route == 'expense.index' || $route == 'expense.create' || $route == 'expense.edit' || $route == 'expense.show') ? 'active' : '' }}">{{ __('Expenses')}}</a>

                            <div class="submenu-content">
                                @can('manage_expense_category')
                                    <a href="{{route('expense-category.index')}}" class="menu-item {{ ( $route == 'expense-category.index' || $route == 'expense-category.edit') ? 'active' : '' }}">{{ __('Expense Category')}}</a>
                                @endcan

                                @can('manage_user')
                                     <a href="{{ route('expense-category.create') }}" class="menu-item {{ ( $route == 'expense-category.create' ) ? 'active' : '' }} ">{{ __('Expense Category Create')}}</a>
                                @endcan

                                @can('manage_expense')
                                    <a href="{{route('expense.index')}}" class="menu-item {{ ( $route == 'expense.index' || $route == 'expense.edit' || $route == 'expense.show') ? 'active' : '' }}">{{ __('Expense List')}}</a>
                                @endcan

                                @can('manage_expense')
                                     <a href="{{ route('expense.create') }}" class="menu-item {{ ( $route == 'expense.create' ) ? 'active' : '' }} ">{{ __('Expense Create')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="submenu-content">
                    <div class="nav-item has-sub {{ ( $route == 'revenue') ? 'open ' : '' }}">
                            <a href="javascript:void(0)" class="menu-item {{ ( $route == 'revenue') ? 'active' : '' }}">{{ __('Revenue')}}</a>

                            <div class="submenu-content">
                                @can('manage_revenue')
                                    <a href="{{route('revenue')}}" class="menu-item {{ ( $route == 'revenue') ? 'active' : '' }}">{{ __('Revenue List')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
