    <div id="sidebar-menu">

        <ul id="side-menu">
            <li class="menu-title">Navigation</li>

            <li>
                <a href="{{url('/dashboard')}}">
                    <i class="mdi flaticon-dashboard-1"></i>
                    <span> Dashboards </span>
                </a>
            </li>

            <li class="menu-title mt-2">Apps</li>

            <li class="@if(request()->segment(1)=='members' || request()->segment(1)=='member'){{'menuitem-active'}}@endif" >
                <a href="#sidebarMembers" data-toggle="collapse">
                    <i class="mdi flaticon-crowd-of-users"></i>
                    <span> Members </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse  @if(request()->segment(1)=='members'|| request()->segment(1)=='member'){{'show'}}@endif" id="sidebarMembers">
                    <ul class="nav-second-level">
                        <li class="@if(request()->is('members/list') || request()->is('members/registration') || request()->is('member/view/details/*') || Str::contains(request()->url(), 'member/edit/details/')){{'menuitem-active'}}@endif">
                            <a href="{{url('members/list')}}">List</a>
                        </li>
                        <li> <a href="{{url('members/possible/duplicates')}}">Duplicates</a> </li>
                    </ul>
                </div>
            </li>

            <li class="@if(request()->segment(1)=='contributions'){{'menuitem-active'}}@endif">
                <a href="#sidebarContributions" data-toggle="collapse">
                    <i class="mdi flaticon-calculator-1"></i>
                    <span> Contributions </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse @if(request()->segment(1)=='contributions'){{'show'}}@endif" id="sidebarContributions">
                    <ul class="nav-second-level">
                        <li  class="@if(request()->segment(2)=='add'){{'menuitem-active'}}@endif"> <a href="{{url('contributions/add')}}">Add Contribution</a> </li>
                        <li  class="@if(request()->segment(2)=='transactions' || request()->segment(2)=='processing' || request()->segment(2)=='details'){{'menuitem-active'}}@endif"> <a href="{{url('contributions/processing/'.Crypt::encryptString('PENDING'))}}">Process Contribution</a> </li>
                        <li  class="@if(request()->segment(2)=='search'){{'menuitem-active'}}@endif"> <a href="{{url('contributions/search')}}">Search Contribution</a> </li>
                    </ul>
                </div>
            </li>

            <li class="@if(request()->segment(1)=='arrears'){{'menuitem-active'}}@endif">
                <a href="#arrears" data-toggle="collapse">
                    <i class="mdi flaticon-calculator-1"></i>
                    <span> Arrears </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse @if(request()->segment(1)=='arrears'){{'show'}}@endif" id="arrears">
                    <ul class="nav-second-level">
                        <li  class="@if(request()->segment(2)=='processingarrears'|| request()->segment(2)=='sectionarrears'|| request()->segment(2)=='viewarrears'){{'menuitem-active'}}@endif"> <a href="{{url('arrears/sectionarrears/'.Crypt::encryptString('ACTIVE'))}}">Section Arrears</a> </li>
                        <li  class="@if(request()->segment(2)=='sectionpayments'){{'menuitem-active'}}@endif"> <a href="{{url('arrears/sectionpayments/'.Crypt::encryptString('ACTIVE'))}}">Section Penalty Pay</a> </li>
                        <li  class="@if(request()->segment(2)=='sectionpenalty'){{'menuitem-active'}}@endif"> <a href="{{url('arrears/sectionpenalty/waived/'.Crypt::encryptString('PENDING'))}}">Section Penalty Waived</a> </li>
                        <li  class="@if(request()->segment(2)=='membersarrears' || request()->segment(2)=='memberarrearsprocessing'){{'menuitem-active'}}@endif"> <a href="{{url('arrears/membersarrears/'.Crypt::encryptString('ACTIVE'))}}">Member Arrears</a> </li>
                        <li  class="@if(request()->segment(2)=='memberpayments'){{'menuitem-active'}}@endif"> <a href="{{url('arrears/memberpayments/'.Crypt::encryptString('ACTIVE'))}}">Member Penalty Pay</a> </li>
                        <li  class="@if(request()->segment(2)=='memberpenalty'){{'menuitem-active'}}@endif"> <a href="{{url('arrears/memberpenalty/waived/'.Crypt::encryptString('ACTIVE'))}}">Member Penalty Waived</a> </li>
                        <li  class="@if(request()->segment(2)=='memberpayments'){{'menuitem-active'}}@endif"> <a href="{{url('arrears/memberpayments/'.Crypt::encryptString('ACTIVE'))}}">Penalty Payments</a> </li>
                    </ul>
                </div>
            </li>

            <li class="@if(request()->segment(1)=='contributors'){{'menuitem-active'}}@endif">
                <a href="#sidebarContributors" data-toggle="collapse">
                    <i class="mdi flaticon-infaq" style="transform: rotateY(180deg);"></i>
                    <span > Contributors</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse  @if(request()->segment(1)=='contributors'){{'show'}}@endif" id="sidebarContributors">
                    <ul class="nav-second-level">
                        <li class="@if(request()->is('contributors/list/*')||request()->is('contributors/edit/*')){{'menuitem-active'}}@endif"><a href="{{url('contributors/list/'.Crypt::encryptString('ACTIVE'))}}">Contributors</a></li>
                        <li class="@if(request()->is('contributors/categories/*')){{'menuitem-active'}}@endif"><a href="{{url('contributors/categories/'.Crypt::encryptString('ACTIVE'))}}">Categories</a></li>
                        <li class="@if(request()->is('contributors/structure/*')){{'menuitem-active'}}@endif"><a href="{{url('contributors/structure/'.Crypt::encryptString('ACTIVE'))}}">Contribution Structure</a></li>
                    </ul>
                </div>
            </li>
            <li class="@if(request()->segment(1)=='zones'){{'menuitem-active'}} @endif">
                <a href="#sidebarZones" data-toggle="collapse">
                    <i class="mdi mdi-map-marker-radius-outline"></i>
                    <span> Zones </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse @if(request()->segment(1)=='zones'){{'show'}}@endif" id="sidebarZones">
                    <ul class="nav-second-level">
                        <li class="@if(request()->is('zones/list') || request()->is('zones/dormant/list') ){{'menuitem-active'}} @endif"><a href="{{url('/zones/list')}}">Zones</a></li>
                        <li class="@if(request()->is('zones/districts/*')){{'menuitem-active'}} @endif"><a href="{{url('/zones/districts/'.Crypt::encryptString('ACTIVE'))}}">Districts </a></li>
                        <li class="@if(request()->is('zones/sections/*')){{'menuitem-active'}} @endif"><a href="{{url('/zones/sections/'.Crypt::encryptString('ACTIVE'))}}">Section </a></li>
                    </ul>
                </div>
            </li>


            <li class="menu-title mt-2">System Settings</li>

            <li class="@if(request()->segment(1)=='users'){{'menuitem-active'}} @endif">
                <a href="#sidebarUsers" data-toggle="collapse">
                    <i class="mdi mdi-account-group-outline"></i>
                    <span> Manage Users </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse @if(request()->segment(1)=='users'){{'show'}}@endif" id="sidebarUsers">
                    <ul class="nav-second-level">
                        <li class="@if(request()->is('users/list/*')||request()->is('users/add')){{'menuitem-active'}} @endif"> <a href="{{url('users/list/'.Crypt::encryptString('ACTIVE'))}}">Users</a> </li>
                        <li class="@if(request()->is('users/departments/*')){{'menuitem-active'}} @endif"> <a href="{{url('users/departments/'.Crypt::encryptString('ACTIVE'))}}">Departments</a> </li>
                        <li class="@if(request()->is('users/designations/*')){{'menuitem-active'}} @endif"> <a href="{{url('users/designations/'.Crypt::encryptString('ACTIVE'))}}">Designations</a> </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="#sidebarSettings" data-toggle="collapse">
                    <i data-feather="pocket"></i>
                    <span> Configurations </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSettings">
                    <ul class="nav-second-level">
                        <li> <a href="{{url('configs/constantvalues')}}">Default Value</a> </li>
                        <li> <a href="{{url('configs/schemes')}}">Schemes</a> </li>
                        <li> <a href="{{url('configs/payment/modes')}}">Payment Modes</a> </li>
                        <li> <a href="{{url('configs/arrears/recognition')}}">Arrears Control</a> </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{url('defaultpage')}}">
                    <i data-feather="calendar"></i>
                    <span> Default Page </span>
                </a>
            </li>
        </ul>
    </div>
    </li>
    </ul>

    </div>
