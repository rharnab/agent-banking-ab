<li>
    <a href="#">
        <i class="fa fa-gear (alias)"></i> 
        <span class="nav-label">Parameter Setup</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('product.parament_setup.index') }}"><i class="fa fa-dot-circle-o"></i>Product Setup</a></li>        
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Branch Setup</a></li>        
        <li><a href="{{ route('Sanctionscreen.sanctionscreen') }}"><i class="fa fa-dot-circle-o"></i>Sanction Screening Setup</a></li> 
        <li><a href="{{ route('Sanctionscreen.sanctionscreenlistupload') }}"><i class="fa fa-dot-circle-o"></i>Sanction screen list upload</a></li>        
        <li><a href=""><i class="fa fa-dot-circle-o"></i>Statement Shows Option</a></li>        
        <li><a href="{{ route('matching.score.setup.index') }}"><i class="fa fa-dot-circle-o"></i>eKYC Score Setup</a></li>        
        <li><a href="{{ route('parameter-setup.ocr-editable-filed-setup.index') }}"><i class="fa fa-dot-circle-o"></i>OCR Editable Field</a></li>        
        <li><a href="#"><i class="fa fa-dot-circle-o"></i>Holiday Marking</a></li>        
    </ul>
</li>

<li class="{{ request()->is('gl-setup/*') ? 'active' : '' }} {{ request()->is('gl-mapping/index') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-bank (alias)"></i> 
        <span class="nav-label">GL Create</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ request()->is('gl-setup/index') ? 'active' : '' }}" ><a href="{{ route('account_setup.index') }}"><i class="fa fa-dot-circle-o"></i>New GL creation</a></li>        
        <li class="{{ request()->is('gl-mapping/index') ? 'active' : '' }}"><a href="{{ route('gl_mapping.index') }}"><i class="fa fa-dot-circle-o"></i>GL Mapping</a></li>              
    </ul>
</li>

<li>
    <a href="#">
        <i class="fa fa-magic"></i> 
        <span class="nav-label">Commission Setup</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('commission_setup.account.index') }}"><i class="fa fa-dot-circle-o"></i>Account Open Commission</a></li>            
        <li><a href="{{ route('commission_setup.transaction.index') }}"><i class="fa fa-dot-circle-o"></i>Transaction Commission</a></li>            
        <li><a href="{{ route('commission_setup.bill.index') }}"><i class="fa fa-dot-circle-o"></i>Bill collection Commission</a></li>            
        <li><a href="{{ route('commission_setup.statement.index') }}"><i class="fa fa-dot-circle-o"></i>Statement Commission</a></li>              
    </ul>
</li>


<li>
    <a href="#">
        <i class="fa fa-group (alias)"></i> 
        <span class="nav-label">User & Security</span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('parameter.user.index') }}"><i class="fa fa-dot-circle-o"></i>Create User</a></li>        
        <li><a href="{{ route('super_admin.password_reset.index') }}"><i class="fa fa-dot-circle-o"></i>Reset User</a></li>              
        <li><a href="{{ route('role.index') }}"><i class="fa fa-dot-circle-o"></i>Role Define</a></li>                        
    </ul>
</li>

<li>
    <a href="#"><i class="fa fa-pie-chart"></i> 
        <span class="nav-label">Report </span><span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level collapse">
        <li>
            <a href="#">Parameter Report<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{ route('report.productlist') }}">Product List</a></li>
                <li><a href="{{ route('report.branchlist') }}">Branch List</a></li>
                <li><a href="">Sanction screen List</a></li>
            </ul>
        </li>


        <li>
            <a href="#">GL Report<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{route('report.listofgl')}}">List of GL</a></li>
                <li><a href="{{route('report.productMapping')}}">Product Mapping report</a></li>
            </ul>
        </li>

        <li>
            <a href="#">Commission Summary<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{route('commission.account_open')}}">Account Open Commission audit </a></li>
                <li><a href="{{route('commission.transaction_summary')}}">Transaction Commission audit </a></li>
                <li><a href="{{route('commission.bill_summary')}}">Bill collection Commission audit </a></li>
                <li><a href="{{route('commission.statement_summary')}}">Statement Showing Commission audit </a></li>
            </ul>
        </li>

        <li>
            <a href="#">Commission Details <span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{route('commission.account_open.details')}}">Account Open Commission audit </a></li>
                <li><a href="{{route('commission.transaction_details')}}"> Transaction Commission Details </a></li>
                <li><a href="{{route('commission.bill_details')}}"> Bill Commission Details </a></li>
                <li><a href="{{route('commission.statement_details')}}"> Statement Commission Details </a></li>
               
            </ul>
        </li>

        <li>
            <a href="#">User Report<span class="fa arrow"></span></a>
            <ul class="nav nav-third-level">
                <li><a href="{{route('report.user_list')}}">User List</a></li>
                <li><a href="{{route('report.user_edit_log')}}">User Modification Log Report</a></li>
            </ul>
        </li>
    </ul>
</li>