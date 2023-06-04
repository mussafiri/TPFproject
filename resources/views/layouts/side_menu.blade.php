    <div id="sidebar-menu">

        <ul id="side-menu">

            <li class="menu-title">Navigation</li>

            <li>
                <a href="{{url('/dashboard')}}">
                    <i data-feather="airplay"></i>
                    <span> Dashboards </span>
                </a>
            </li>

            <li class="menu-title mt-2">Apps</li>

            <li>
                <a href="#sidebarMembers" data-toggle="collapse">
                    <i class=" mdi mdi-account-group-outline"></i>
                    <span> Members </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMembers">
                    <ul class="nav-second-level">
                        <li>
                            <a href="ecommerce-dashboard.html">Dashboard</a>
                        </li>
                        <li>
                            <a href="ecommerce-products.html">Products</a>
                        </li>
                        <li>
                            <a href="ecommerce-product-detail.html">Product Detail</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="@if(request()->segment(1)=='contributors'){{'menuitem-active'}}@endif">
                <a href="#sidebarContributors" data-toggle="collapse">
                    <i class="fa fas fa-church "></i>
                    <span> Contributors</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse  @if(request()->segment(1)=='contributors'){{'show'}}@endif" id="sidebarContributors">
                    <ul class="nav-second-level">
                        <li class="@if(request()->is('contributors/list/*')||request()->is('contributors/edit/*')){{'menuitem-active'}}@endif"><a href="{{url('contributors/list/'.Crypt::encryptString('ACTIVE'))}}">Contributors</a></li>
                        <li class="@if(request()->segment(2)=='categories'){{'menuitem-active'}}@endif"><a href="{{url('contributors/categories/'.Crypt::encryptString('ACTIVE'))}}">Categories</a></li>
                    </ul>
                </div>
            </li>
            <li class="@if(request()->segment(1)=='zones'){{'menuitem-active'}} @endif">
                <a href="#sidebarZones" data-toggle="collapse">
                    <i class="mdi mdi-map-marker-radius"></i>
                    <span> Zones </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse @if(request()->segment(1)=='zones'){{'show'}}@endif" id="sidebarZones">
                    <ul class="nav-second-level">
                        <li class="@if(request()->is('zones/list')){{'menuitem-active'}} @endif"><a href="{{url('/zones/list')}}">Zones</a></li>
                        <li class="@if(request()->is('zones/districts/*')){{'menuitem-active'}} @endif"><a href="{{url('/zones/districts/'.Crypt::encryptString('ACTIVE'))}}">Districts </a></li>
                        <li class="@if(request()->is('zones/sections/*')){{'menuitem-active'}} @endif"><a href="{{url('/zones/sections/'.Crypt::encryptString('ACTIVE'))}}">Section </a></li>
                    </ul>
                </div>
            </li>


            <li>
                <a href="#sidebarUsers" data-toggle="collapse">
                    <i data-feather="pocket"></i>
                    <span> Users </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarUsers">
                    <ul class="nav-second-level">
                        <li> <a href="ui-buttons.html">Departments</a> </li>
                        <li> <a href="ui-cards.html">Designations</a> </li>
                    </ul>
                </div>
            </li>
            <li class="menu-title mt-2">System Settings</li>

            <li>
                <a href="#sidebarSettings" data-toggle="collapse">
                    <i data-feather="pocket"></i>
                    <span> Users </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSettings">
                    <ul class="nav-second-level">
                        <li> <a href="ui-buttons.html">Configs</a> </li>
                        <li> <a href="ui-cards.html">Designations</a> </li>
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
