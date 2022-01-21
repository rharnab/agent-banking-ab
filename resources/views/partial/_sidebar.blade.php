<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" height="45px" width="45px" src="{{ asset('assets/img/download.jfif') }}"/>
                    
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ Auth::user()->name }}</span>
                        <span class="text-muted text-xs block">Profile Setup <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Contacts</a></li>
                        <li><a class="dropdown-item" href="{{  route('password-change.index')  }}">Password Change</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" ref="{{ route('logout') }}"  onclick="event.preventDefault();
                            document.getElementById('logout-form-1').submit();"
                            {{ __('Logout') }}>Logout</a>
                        </li>
                        <form id="logout-form-1" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
                <div class="logo-element">
                   MyBank
                </div>
            </li>
            <li class="{{ request()->is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" >
                    <i class="fa fa-tachometer"></i> 
                    <span class="nav-label">Dashboards</span>  
                </a>
            </li>



            @if(Auth::user()->role_id == 1)    <!-- Super Admin Menu -->
                @include('partial.menu.super_admin')
            @endif 

            @if(Auth::user()->role_id == 2)    <!-- Head Office User -->
                @include('partial.menu.head_office_user')
            @endif 

            @if(Auth::user()->role_id == 3)    <!-- Agent User -->
                @include('partial.menu.agent')
            @endif 

            @if(Auth::user()->role_id == 4)    <!-- Agent User ID -->
                @include('partial.menu.agent_user')
            @endif 










        </ul>

    </div>
</nav>