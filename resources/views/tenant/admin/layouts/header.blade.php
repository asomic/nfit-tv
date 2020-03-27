<!-- START HEADER-->
<header class="header">
    <div class="page-brand">
        <a href="/">
            <img class="logo" src="{{ asset('img/logo.png') }}" alt="Ir a Dashboard">
        </a>
    </div>
    <div class="d-flex justify-content-between align-items-center flex-1">
        <!-- START TOP-LEFT TOOLBAR-->
        <ul class="nav navbar-toolbar">
            <li>
                <a class="nav-link sidebar-toggler js-sidebar-toggler" href="javascript:;">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </li>
        </ul>
        <!-- END TOP-LEFT TOOLBAR-->
        <!-- START TOP-RIGHT TOOLBAR-->
        <ul class="nav navbar-toolbar">

            <li class="dropdown dropdown-user">
                <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                    <span class="mr-1">{{ Auth::user()->full_name }}</span>

                    <div class="img-avatar img-avatar-mini"
                         style="background-image: @if (Auth::user()->avatar) url('{{ Auth::user()->avatar }}') @else url('{{ asset('/img/default_user.png') }}') @endif "></div>
                </a>
                <div class="dropdown-menu dropdown-arrow dropdown-menu-right admin-dropdown-menu">
                    <div class="dropdown-arrow"></div>
                    <div class="dropdown-header">
                        <div>
                            <div class="img-avatar img-avatar-admin"
                                 style="background-image: @if (Auth::user()->avatar) url('{{ Auth::user()->avatar }}') @else url('{{ asset('/img/default_user.png') }}') @endif"></div>
                        </div>
                        <div>
                            <h5 class="font-strong text-white">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                        </div>
                    </div>
                    <div class="admin-menu-content">
                        <div class="d-flex justify-content-end mt-2">
                            <a class="d-flex align-items-center"
                               href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            >
                               Cerrar Sesión

                               <i class="ti-shift-right ml-2 font-20"></i>
                            </a>

                            <form id="logout-form"
                                  action="{{ route('logout') }}"
                                  method="POST"
                                  style="display: none;"
                            >
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <!-- END TOP-RIGHT TOOLBAR-->
    </div>
</header>
<!-- END HEADER-->
