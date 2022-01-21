<li>
    <a href="{{ route('branch.registration.show_customer_search_form') }}" >
        <i class="fa fa fa-eercast"></i> <span class="nav-label">eKYC Registration</span>  
    </a>
</li>
<li>
    <a href="{{ route('exits.user.account_open.index') }}" >
        <i class="fa fa-handshake-o"></i> <span class="nav-label">Exist Customer's A/C Open</span>  
    </a>
</li>
<li>
    <a href="{{ route('pending.request.all_request') }}" >
        <i class="fa fa-check-square"></i> <span class="nav-label">A/C Open Authorization</span>  
    </a>
</li>
<li>
    <a href="#">
        <i class="fa fa-search"></i> 
        <span class="nav-label">Searching</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('report.agent_user.searching.customer_search.index') }}"><i class="fa fa-dot-circle-o"></i>Customer search</a></li>        
        <li><a href="{{ route('ballance-enquery') }}"><i class="fa fa-dot-circle-o"></i>Balance Inquery</a></li>              
        <li><a href="{{ route('report.agent_user.searching.cheque_requisition_status.index') }}"><i class="fa fa-dot-circle-o"></i>Cheque Requisition Status</a></li>                
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-money"></i> 
        <span class="nav-label">Transaction</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('agent_user.transaction.transfer.create') }}"><i class="fa fa-dot-circle-o"></i>Transfer</a></li>    
        <li><a href="{{ route('agent_user.transaction.cash.create') }}"><i class="fa fa-dot-circle-o"></i>Cash</a></li>              
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Clearing</a></li>          
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-check-square-o"></i> 
        <span class="nav-label">Tran. Authorization</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('agent_user.transaction.transfer.pending') }}"><i class="fa fa-dot-circle-o"></i>Transfer</a></li>       
        <li><a href="{{ route('agent_user.transaction.cash.authorize_list') }}"><i class="fa fa-dot-circle-o"></i>Cash</a></li>              
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Clearing</a></li>          
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-list-alt"></i> 
        <span class="nav-label">Cheaque</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Cheque Requisition</a></li>        
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Stop Cheque</a></li>              
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Cheque Cancel</a></li>          
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Cheque Destroy</a></li>          
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Cheque Issue</a></li>          
    </ul>
</li>
<li>
    <a href="#">
        <i class="fa fa-magnet"></i> 
        <span class="nav-label">Utility Bill collection</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{route('Utilitybill.wasa') }}"><i class="fa fa-dot-circle-o"></i>WASA Bill</a></li>        
        <li><a href="{{route('Utilitybill.dpdc') }}"><i class="fa fa-dot-circle-o"></i>DPDC Bill</a></li>              
        <li><a href="{{route('Utilitybill.titas') }}"><i class="fa fa-dot-circle-o"></i>Titas Bill</a></li>          
        <li><a href="{{route('Utilitybill.desco') }}"><i class="fa fa-dot-circle-o"></i>DESCO Bill</a></li>          
        <li><a href="{{route('Utilitybill.schoolfees') }}"><i class="fa fa-dot-circle-o"></i>School Fees</a></li>          
        <li><a href="{{route('Utilitybill.creditcardbill') }}"><i class="fa fa-dot-circle-o"></i>Credit card bill</a></li>          
    </ul>
</li>


<li>
    <a href="#"><i class="fa fa-pie-chart"></i> 
        <span class="nav-label">Report </span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li>
            <a href="#"><i class="fa fa-dot-circle-o"></i>Statement<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{ route('report.agent_user.statement.mini_statement.index') }}"><i class="fa fa-dot-circle-o"></i>Mini Statement</a></li>
                <li><a href="{{ route('report.agent_user.statement.date_range_statement.index') }}"><i class="fa fa-dot-circle-o"></i>Date Range Statement</a></li>
            </ul>
        </li>
        <li><a href="{{ route('report.agent_user.account_list.index') }}"><i class="fa fa-dot-circle-o"></i>List of accounts</a></li>
        <li>
            <a href="#"><i class="fa fa-dot-circle-o"></i>Transaction Report<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{ route('report.agent_user.transasction.transfer.index') }}"><i class="fa fa-dot-circle-o"></i>Transfer</a></li>
                <li><a href="{{ route('report.agent_user.transasction.cash.index') }}"><i class="fa fa-dot-circle-o"></i>Cash</a></li>
                <li><a href=""><i class="fa fa-dot-circle-o"></i>Clearing</a></li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fa fa-dot-circle-o"></i>Utility<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{ route('report.schoolfees') }}"><i class="fa fa-dot-circle-o"></i>School Fees</a></li>
            </ul>
        </li>
    </ul>
</li>