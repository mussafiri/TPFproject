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
                        <a href="{{url('defaultpage')}}">
                            <i data-feather="calendar"></i>
                            <span> Default Page </span>
                        </a>
                    </li>
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
                    <li>
                        <a href="#sidebarContributors" data-toggle="collapse">
                            <i data-feather="shopping-cart"></i>
                            <span> Contributors </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarContributors">
                            <ul class="nav-second-level">
                                <li><a href="{{url('/contributors')}}">List</a></li>
                                <li><a href="{{url('/contributors/zones')}}">Zones</a></li>
                                <li><a href="{{url('/contributors/districts')}}">Districts </a></li>
                                <li><a href="{{url('/contributors/sections')}}">Section </a></li>

                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#sidebarZones" data-toggle="collapse">
                            <i data-feather="shopping-cart"></i>
                            <span> Zones </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarZones">
                            <ul class="nav-second-level">
                                <li><a href="{{url('/contributors')}}">List</a></li>
                                <li><a href="{{url('/contributors/zones')}}">Zones</a></li>
                                <li><a href="{{url('/contributors/districts')}}">Districts </a></li>
                                <li><a href="{{url('/contributors/sections')}}">Section </a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#sidebarCrm" data-toggle="collapse">
                            <i data-feather="users"></i>
                            <span> CRM </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="crm-dashboard.html">Dashboard</a>
                                </li>
                                <li>
                                    <a href="crm-contacts.html">Contacts</a>
                                </li>
                                <li>
                                    <a href="crm-opportunities.html">Opportunities</a>
                                </li>
                                <li>
                                    <a href="crm-leads.html">Leads</a>
                                </li>
                                <li>
                                    <a href="crm-customers.html">Customers</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#sidebarEmail" data-toggle="collapse">
                            <i data-feather="mail"></i>
                            <span> Email </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="email-inbox.html">Inbox</a>
                                </li>
                                <li>
                                    <a href="email-read.html">Read Email</a>
                                </li>
                                <li>
                                    <a href="email-compose.html">Compose Email</a>
                                </li>
                                <li>
                                    <a href="email-templates.html">Email Templates</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="apps-social-feed.html">
                            <span class="badge badge-pink float-right">Hot</span>
                            <i data-feather="rss"></i>
                            <span> Social Feed </span>
                        </a>
                    </li>

                    <li>
                        <a href="apps-companies.html">
                            <i data-feather="activity"></i>
                            <span> Companies </span>
                        </a>
                    </li>

                    <li>
                        <a href="#sidebarProjects" data-toggle="collapse">
                            <i data-feather="briefcase"></i>
                            <span> Projects </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarProjects">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="project-list.html">List</a>
                                </li>
                                <li>
                                    <a href="project-detail.html">Detail</a>
                                </li>
                                <li>
                                    <a href="project-create.html">Create Project</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#sidebarTasks" data-toggle="collapse">
                            <i data-feather="clipboard"></i>
                            <span> Tasks </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarTasks">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="task-list.html">List</a>
                                </li>
                                <li>
                                    <a href="task-details.html">Details</a>
                                </li>
                                <li>
                                    <a href="task-kanban-board.html">Kanban Board</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#sidebarContacts" data-toggle="collapse">
                            <i data-feather="book"></i>
                            <span> Contacts </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarContacts">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="contacts-list.html">Members List</a>
                                </li>
                                <li>
                                    <a href="contacts-profile.html">Profile</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#sidebarTickets" data-toggle="collapse">
                            <i data-feather="aperture"></i>
                            <span> Tickets </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarTickets">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="tickets-list.html">List</a>
                                </li>
                                <li>
                                    <a href="tickets-detail.html">Detail</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="apps-file-manager.html">
                            <i data-feather="folder-plus"></i>
                            <span> File Manager </span>
                        </a>
                    </li>

                    <li class="menu-title mt-2">Custom</li>

                    <li>
                        <a href="#sidebarAuth" data-toggle="collapse">
                            <i data-feather="file-text"></i>
                            <span> Auth Pages </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarAuth">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="auth-login.html">Log In</a>
                                </li>
                                <li>
                                    <a href="auth-login-2.html">Log In 2</a>
                                </li>
                                <li>
                                    <a href="auth-register.html">Register</a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#sidebarExpages" data-toggle="collapse">
                            <i data-feather="package"></i>
                            <span> Extra Pages </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarExpages">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="pages-starter.html">Starter</a>
                                </li>
                                <li>
                                    <a href="pages-timeline.html">Timeline</a>
                                </li>

                                <li>
                                    <a href="pages-500-two.html">Error 500 Two</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#sidebarLayouts" data-toggle="collapse">
                            <i data-feather="layout"></i>
                            <span class="badge badge-blue float-right">New</span>
                            <span> Layouts </span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="layouts-horizontal.html">Horizontal</a>
                                </li>
                                <li>
                                    <a href="layouts-detached.html">Detached</a>
                                </li>
                                <li>
                                    <a href="layouts-two-column.html">Two Column Menu</a>
                                </li>
                                <li>
                                    <a href="layouts-two-tone-icons.html">Two Tones Icons</a>
                                </li>
                                <li>
                                    <a href="layouts-preloader.html">Preloader</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-title mt-2">System Settings</li>

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