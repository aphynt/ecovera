<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="javascript:void(0);" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/dist') }}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('admin/dist') }}/assets/images/logo-light.png" alt="" height="24">
                    </span>
                </a>
                <a href="javascript:void(0);" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/dist') }}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('logo') }}/cover.png" alt="" height="40">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Home</li>
                <li>
                    <a href="{{ route('admin.dashboard.index') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>


                <li class="menu-title mt-2">Produk</li>

                <li>
                    <a href="apps-todolist.html" class="tp-link">
                        <i data-feather="tag"></i>
                        <span> Kategori </span>
                    </a>
                </li>

                <li>
                    <a href="apps-contacts.html" class="tp-link">
                        <i data-feather="box"></i>
                        <span> Produk </span>
                    </a>
                </li>

                <li class="menu-title mt-2">General</li>

                <li>
                    <a href="#sidebarBaseui" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Components </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui">
                        <ul class="nav-second-level">
                            <li>
                                <a href="ui-accordions.html" class="tp-link">Accordions</a>
                            </li>
                            <li>
                                <a href="ui-alerts.html" class="tp-link">Alerts</a>
                            </li>
                            <li>
                                <a href="ui-badges.html" class="tp-link">Badges</a>
                            </li>
                            <li>
                                <a href="ui-breadcrumb.html" class="tp-link">Breadcrumb</a>
                            </li>
                            <li>
                                <a href="ui-buttons.html" class="tp-link">Buttons</a>
                            </li>
                            <li>
                                <a href="ui-cards.html" class="tp-link">Cards</a>
                            </li>
                            <li>
                                <a href="ui-collapse.html" class="tp-link">Collapse</a>
                            </li>
                            <li>
                                <a href="ui-dropdowns.html" class="tp-link">Dropdowns</a>
                            </li>
                            <li>
                                <a href="ui-video.html" class="tp-link">Embed Video</a>
                            </li>
                            <li>
                                <a href="ui-grid.html" class="tp-link">Grid</a>
                            </li>
                            <li>
                                <a href="ui-images.html" class="tp-link">Images</a>
                            </li>
                            <li>
                                <a href="ui-list.html" class="tp-link">List Group</a>
                            </li>
                            <li>
                                <a href="ui-modals.html" class="tp-link">Modals</a>
                            </li>
                            <li>
                                <a href="ui-placeholders.html" class="tp-link">Placeholders</a>
                            </li>
                            <li>
                                <a href="ui-pagination.html" class="tp-link">Pagination</a>
                            </li>
                            <li>
                                <a href="ui-popovers.html" class="tp-link">Popovers</a>
                            </li>
                            <li>
                                <a href="ui-progress.html" class="tp-link">Progress</a>
                            </li>
                            <li>
                                <a href="ui-scrollspy.html" class="tp-link">Scrollspy</a>
                            </li>
                            <li>
                                <a href="ui-spinners.html" class="tp-link">Spinners</a>
                            </li>
                            <li>
                                <a href="ui-tabs.html" class="tp-link">Tabs</a>
                            </li>
                            <li>
                                <a href="ui-tooltips.html" class="tp-link">Tooltips</a>
                            </li>
                            <li>
                                <a href="ui-typography.html" class="tp-link">Typography</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="widgets.html" class="tp-link">
                        <i data-feather="aperture"></i>
                        <span> Widgets </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarAdvancedUI" data-bs-toggle="collapse">
                        <i data-feather="cpu"></i>
                        <span> Extended UI </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAdvancedUI">
                        <ul class="nav-second-level">
                            <li>
                                <a href="extended-carousel.html" class="tp-link">Carousel</a>
                            </li>
                            <li>
                                <a href="extended-notifications.html" class="tp-link">Notifications</a>
                            </li>
                            <li>
                                <a href="extended-offcanvas.html" class="tp-link">Offcanvas</a>
                            </li>
                            <li>
                                <a href="extended-range-slider.html" class="tp-link">Range Slider</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarIcons" data-bs-toggle="collapse">
                        <i data-feather="award"></i>
                        <span> Icons </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarIcons">
                        <ul class="nav-second-level">
                            <li>
                                <a href="icons-feather.html" class="tp-link">Feather Icons</a>
                            </li>
                            <li>
                                <a href="icons-mdi.html" class="tp-link">Material Design Icons</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarForms" data-bs-toggle="collapse">
                        <i data-feather="briefcase"></i>
                        <span> Forms </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarForms">
                        <ul class="nav-second-level">
                            <li>
                                <a href="forms-elements.html" class="tp-link">General Elements</a>
                            </li>
                            <li>
                                <a href="forms-validation.html" class="tp-link">Validation</a>
                            </li>
                            <li>
                                <a href="forms-quilljs.html" class="tp-link">Quilljs Editor</a>
                            </li>
                            <li>
                                <a href="forms-pickers.html" class="tp-link">Picker</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarTables" data-bs-toggle="collapse">
                        <i data-feather="table"></i>
                        <span> Tables </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarTables">
                        <ul class="nav-second-level">
                            <li>
                                <a href="tables-basic.html" class="tp-link">Basic Tables</a>
                            </li>
                            <li>
                                <a href="tables-datatables.html" class="tp-link">Data Tables</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarCharts" data-bs-toggle="collapse">
                        <i data-feather="pie-chart"></i>
                        <span> Apex Charts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCharts">
                        <ul class="nav-second-level">
                            <li>
                                <a href='charts-line.html' class="tp-link">Line</a>
                            </li>
                            <li>
                                <a href='charts-area.html' class="tp-link">Area</a>
                            </li>
                            <li>
                                <a href='charts-column.html' class="tp-link">Column</a>
                            </li>
                            <li>
                                <a href='charts-bar.html' class="tp-link">Bar</a>
                            </li>
                            <li>
                                <a href='charts-mixed.html' class="tp-link">Mixed</a>
                            </li>
                            <li>
                                <a href='charts-timeline.html' class="tp-link">Timeline</a>
                            </li>
                            <li>
                                <a href='charts-rangearea.html' class="tp-link">Range Area</a>
                            </li>
                            <li>
                                <a href='charts-funnel.html' class="tp-link">Funnel</a>
                            </li>
                            <li>
                                <a href='charts-candlestick.html' class="tp-link">Candlestick</a>
                            </li>
                            <li>
                                <a href='charts-boxplot.html' class="tp-link">Boxplot</a>
                            </li>
                            <li>
                                <a href='charts-bubble.html' class="tp-link">Bubble</a>
                            </li>
                            <li>
                                <a href='charts-scatter.html' class="tp-link">Scatter</a>
                            </li>
                            <li>
                                <a href='charts-heatmap.html' class="tp-link">Heatmap</a>
                            </li>
                            <li>
                                <a href='charts-treemap.html' class="tp-link">Treemap</a>
                            </li>
                            <li>
                                <a href='charts-pie.html' class="tp-link">Pie</a>
                            </li>
                            <li>
                                <a href='charts-radialbar.html' class="tp-link">Radialbar</a>
                            </li>
                            <li>
                                <a href='charts-radar.html' class="tp-link">Radar</a>
                            </li>
                            <li>
                                <a href='charts-polararea.html' class="tp-link">Polar</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarMaps" data-bs-toggle="collapse">
                        <i data-feather="map"></i>
                        <span> Maps </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMaps">
                        <ul class="nav-second-level">
                            <li>
                                <a href="maps-google.html" class="tp-link">Google Maps</a>
                            </li>
                            <li>
                                <a href="maps-vector.html" class="tp-link">Vector Maps</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
