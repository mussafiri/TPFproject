    <div id="sidebar-menu">

        <ul id="side-menu">

            <li class="menu-title">Navigation</li>

            <li>
                <a href="#sidebarDashboards" data-toggle="collapse">
                    <i data-feather="airplay"></i>
                    <span> Dashboards </span>
                </a>
                <div class="collapse" id="sidebarDashboards">
                    <ul class="nav-second-level">
                        <li>
                            <a href="index.html">Detailed</a>
                        </li>
                        <li>
                            <a href="dashboard-2.html">Summary</a>
                        </li>
                    </ul>
                </div>
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
            <li class="@if(str_contains(url()->current(), 'contributors') || str_contains(url()->current(), 'contributor')){{'menuitem-active'}}@endif">
                <a href="#sidebarContributors" data-toggle="collapse">
                    <i class="fa fas fa-church "></i>
                    <span> Contributors </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse @if(str_contains(url()->current(), 'contributors' || str_contains(url()->current(), 'contributor'))){{'show'}}@endif" id="sidebarContributors">
                    <ul class="nav-second-level">
                        <li class="@if(str_contains(url()->current(), 'contributors')){{'menuitem-active'}}@endif"><a href="{{url('contributors')}}">Contributors</a></li>
                        <li class="@if(str_contains(url()->current(), 'contributor/categories')){{'menuitem-active'}}@endif"><a href="{{url('contributor/categories/'.Crypt::encryptString('ACTIVE'))}}">Categories</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#sidebarZones" data-toggle="collapse">
                    <i class="mdi mdi-map-marker-radius"></i>
                    <span> Zones </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarZones">
                    <ul class="nav-second-level">
                        <li><a href="{{url('/contributors/zones')}}">Zones</a></li>
                        <li><a href="{{url('/contributors/districts')}}">Districts </a></li>
                        <li><a href="{{url('/contributors/sections')}}">Section </a></li>
                    </ul>
                </div>
            </li>


            <li class="menu-title mt-2">System Settings</li>
            <li>
                <a href="{{url('defaultpage')}}">
                    <i data-feather="calendar"></i>
                    <span> Default Page </span>
                </a>
            </li>

            <li>
                <a href="#sidebarBaseui" data-toggle="collapse">
                    <i data-feather="pocket"></i>
                    <span> Base UI </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarBaseui">
                    <ul class="nav-second-level">
                        <li>
                            <a href="ui-buttons.html">Buttons</a>
                        </li>
                        <li>
                            <a href="ui-cards.html">Cards</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    </li>
    </ul>

    </div>
