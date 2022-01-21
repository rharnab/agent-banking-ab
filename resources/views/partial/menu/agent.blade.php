<li>
    <a href="#">
        <i class="fa fa-group (alias)"></i> 
        <span class="nav-label">User & Security</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('agent.limit_modify.index') }}"><i class="fa fa-dot-circle-o"></i>Limit Modify</a></li>        
        <li><a href="{{ route('agent.user.password_reset.index') }}"><i class="fa fa-dot-circle-o"></i>Reset User</a></li>            
    </ul>
</li>


<li>
    <a href="#"><i class="fa fa-pie-chart"></i> 
        <span class="nav-label">Report </span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('modify.log_report') }}"><i class="fa fa-dot-circle-o"></i>User & Security</a></li> 
        <li><a href="{{ url('report/account-list/index') }}"><i class="fa fa-dot-circle-o"></i>List of accounts</a></li> 
        <li>
            <a href="#"><i class="fa fa-dot-circle-o"></i>Commission Report<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li>
                   
                    <a href="#"><i class="fa fa-dot-circle-o"></i>Summary Report <span class="fa arrow"></span></a>
                    <ul class="nav nav-forth-level">
                        <li><a href="{{route('commission.account_open')}}">Account Open Commission audit </a></li>
                        <li><a href="{{route('commission.transaction_summary')}}">Transaction Commission audit </a></li>
                        <li><a href="{{route('commission.bill_summary')}}">Bill collection Commission audit </a></li>
                        <li><a href="{{route('commission.statement_summary')}}">Statement Showing Commission audit </a></li>
                    </ul>

                </li>
                <li>
                    
                     <a href="#"><i class="fa fa-dot-circle-o"></i>Details Report <span class="fa arrow"></span></a>
                    <ul class="nav nav-forth-level">
                        <li><a href="{{route('commission.account_open.details')}}">Account Open Commission audit </a></li>
                        <li><a href="{{route('commission.transaction_details')}}"> Transaction Commission Details </a></li>
                        <li><a href="{{route('commission.bill_details')}}"> Bill Commission Details </a></li>
                        <li><a href="{{route('commission.statement_details')}}"> Statement Commission Details </a></li>
                       
                    </ul>


                </li>
            </ul>
        </li>     
    </ul>
</li>