<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <div class="header-search">
                    <div class="input-group">
                        <span class="input-group-addon search-close">
                            <i class="ik ik-x"></i>
                        </span>
                        <input type="text" class="form-control">
                        <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                    </div>
                </div>
                <button class="nav-link" title="clear cache">
                    <a  href="{{url('clear-cache')}}">
                    <i class="ik ik-battery-charging"></i>
                </a>
                </button> &nbsp;&nbsp;
                <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
            </div>
            <div class="top-menu d-flex align-items-center">
                {{ Auth::user()->name }}

                <div class="dropdown">

                    @php
                        $auth = Auth::user();
                        $user_role = $auth->roles->first();
                    @endphp

                    @if ($user_role->name == 'Super Admin')
                        <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ asset('img/auth/logo.png')}}" alt=""></a>
                    @endif

                    @if (Auth::user()->type == 2)
                        <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ asset('img/' .  Auth::user()->owners->owner_photo) }}" alt=""></a>
                    @endif

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                        @if (Auth::user()->type == 2)
                            <a class="dropdown-item" href="{{ route('profile', Auth::user()->owners->id ) }}"><i class="ik ik-user dropdown-icon"></i> {{ __('Profile')}}</a>
                        @endif
                        <a class="dropdown-item" href="{{ url('logout') }}">
                            <i class="ik ik-power dropdown-icon"></i>
                            {{ __('Logout')}}
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</header>
