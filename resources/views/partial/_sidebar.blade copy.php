<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" height="45px" width="45px" src="{{ asset('assets/img/man_avatar.png') }}"/>
                    
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
                    E-KYC
                </div>
            </li>
            <li>
                <a href="{{ route('home') }}" >
                    <i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span>  
                </a>
            </li>





            @if(Auth::user()->role_id == 1)            
                <li>
                    <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Parameter Setup</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ route('matching.score.setup.index') }}">
                                <i class="fa fa-sitemap"></i> <span class="nav-label">Score Setup</span>  
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('parameter-setup.ocr-editable-filed-setup.index') }}">
                                <i class="fa fa-cogs"></i> <span class="nav-label">Ocr Editable Field</span>  
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('parameter.branch.index') }}">
                                <i class="fa fa-cogs"></i> <span class="nav-label">Branch Setup</span>  
                            </a>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-building-o"></i> <span class="nav-label">Agent</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{ route('parameter.agent.index') }}"> <i class="fa fa-circle-thin"></i> &nbsp; Agent Setup</a></li>
                                <li><a href="{{ route('parameter.agent.pending')  }}"> <i class="fa fa-circle-thin"></i> &nbsp;Agent Authorize</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-gear (alias)"></i> <span class="nav-label">Agent User </span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{ route('parameter.agent.user.index') }}"> <i class="fa fa-circle-thin"></i> &nbsp; Agent User List</a></li>
                                <li><a href="{{ route('parameter.agent.user.pending') }}"> <i class="fa fa-circle-thin"></i> &nbsp; Pending Agent User</a></li> 
                            </ul>
                        </li>

                    </ul>
                </li>
            @endif





            @if(Auth::user()->role_id == 1 ||  Auth::user()->role_id == 3)
            <li>
                <a href="#"><i class="fa fa-user-o"></i> <span class="nav-label">Customer</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{ route('branch.registration.show_customer_search_form') }}">Customer Registartion</a>
                    </li>
                    <li>
                        <a href="{{ route('pending.request.all_request') }}">Pending Authorization</a>
                    </li>
                    <li>
                        <a href="{{ route('verified.customer.show_list') }}">All  Customer List</a>
                    </li>
                    
                </ul>
            </li>
            @endif

            @if( Auth::user()->role_id == 3)
                <li>
                    <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Account Opening</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ route('admin.account_opening.all_request') }}">Account Opening Request</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(Auth::user()->role_id == 1)
                <li>
                    <a href="#"><i class="fa fa-group"></i> <span class="nav-label">User & Security</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ route('role.index') }}">Role</a>
                        </li>
                        <li>
                            <a href="{{ route('parameter.user.index') }}">User List</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(Auth::user()->role_id == 4)
                <li>
                    <a href="#"><i class="fa fa-book"></i> <span class="nav-label">My Request</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ route('outside.customer.request_view') }}">My Account Opening Request</a>
                        </li>
                    </ul>
                </li>
            @endif



            @if(Auth::user()->role_id == 1)
                <li>
                    <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Report</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="#">Sanction screening report</a>
                        </li>
                        <li>
                            <a href="#">Risk grading report</a>
                        </li>
                    </ul>
                </li>
            @endif


            @if(Auth::user()->role_id == 2) <!-- Head Office User (Admin) -->
            <li>
                <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Parameter Setup</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{ route('matching.score.setup.index') }}">
                            <i class="fa fa-dot-circle-o"></i> <span class="nav-label"> Score Setup</span>  
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('parameter-setup.ocr-editable-filed-setup.index') }}">
                            <i class="fa fa-dot-circle-o"></i> <span class="nav-label">Ocr Editable Field</span>  
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('parameter.branch.index') }}">
                            <i class="fa fa-dot-circle-o"></i> <span class="nav-label">Branch Setup</span>  
                        </a>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-dot-circle-o"></i> <span class="nav-label">Agent</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('parameter.agent.index') }}"> <i class="fa fa-dot-circle-o"></i> &nbsp; Agent Setup</a></li>
                            <li><a href="{{ route('parameter.agent.pending')  }}"> <i class="fa fa-dot-circle-o"></i> &nbsp;Agent Authorize</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-dot-circle-o"></i> <span class="nav-label">Agent User </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('parameter.agent.user.index') }}"> <i class="fa fa-dot-circle-o"></i> &nbsp; Agent User List</a></li>
                            <li><a href="{{ route('parameter.agent.user.pending') }}"> <i class="fa fa-dot-circle-o"></i> &nbsp; Pending Agent User</a></li> 
                        </ul>
                    </li>

                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-group"></i> <span class="nav-label">User & Security</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{ route('role.index') }}"><i class="fa fa-dot-circle-o"></i>&nbsp;Role</a>
                    </li>
                    <li>
                        <a href="{{ route('parameter.user.index') }}"> <i class="fa fa-dot-circle-o"></i>&nbsp; User List</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Report</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#"><i class="fa fa-dot-circle-o"></i>&nbsp;Sanction screening report</a>
                    </li>
                    <li>
                        <a href="#"> <i class="fa fa-dot-circle-o"></i>&nbsp;Risk grading report</a>
                    </li>
                </ul>
            </li>

            @endif







 
            @if(Auth::user()->role_id == 5) <!-- Agent Banking User Menu -->
            <li>
                <a href="#"><i class="fa fa-bank (alias)"></i> 
                    <span class="nav-label">A/C Open with EKYC</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('branch.registration.show_customer_search_form') }}"><i class="fa fa-circle-thin"></i> &nbsp;A/C Open</a></li>                   
                    <li><a href="{{ route('pending.request.all_request') }}"><i class="fa fa-circle-thin"></i> &nbsp;A/C Authorize</a></li>                   
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-credit-card"></i> 
                    <span class="nav-label">Transaction</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#"><i class="fa fa-circle-thin"></i> &nbsp;Transfer <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href=""><i class="fa fa-dot-circle-o"></i> &nbsp; Transfer Transaction </a>
                            </li>
                            <li>
                                <a href=""><i class="fa fa-dot-circle-o"></i> &nbsp; Transfer Authorization</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-circle-thin"></i> &nbsp;Cash <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href=""><i class="fa fa-dot-circle-o"></i>&nbsp; Cash Transaction </a>
                            </li>
                            <li>
                                <a href=""><i class="fa fa-dot-circle-o"></i> &nbsp; Cash Authorization</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-thin"></i> &nbsp;Clearing</a></li>  
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-file-text-o"></i> 
                    <span class="nav-label">Report</span><span class="fa arrow"></span>
                </a>
            </li>
            @endif



            @if(Auth::user()->role_id == 6) <!-- Agent Banking User Menu -->
            <li>
                <a href="{{ route('agent.my_agent.index') }}"><i class="fa fa-users"></i> 
                    <span class="nav-label">User List</span>
                </a>
            </li>

            <li>
                <a href="#"><i class="fa fa-gear (alias)"></i> <span class="nav-label">Parameter Setup</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{ route('agent.user.password_reset.index') }}"><i class="fa fa-dot-circle-o"></i>&nbsp;User Password Reset</a>
                    </li>
                    <li>
                        <a href="#"> <i class="fa fa-dot-circle-o"></i>&nbsp;User Limit Change</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Report</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#"><i class="fa fa-dot-circle-o"></i>&nbsp;Sanction screening report</a>
                    </li>
                    <li>
                        <a href="#"> <i class="fa fa-dot-circle-o"></i>&nbsp;Risk grading report</a>
                    </li>
                </ul>
            </li>

            @endif




        </ul>

    </div>
</nav>