<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigation-lavel"></div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ (request()->segment(2) == '') ? 'active' : '' }}">
                <a href="{{route('admin.dashboard')}}">
                    <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
            <li class="{{ (request()->segment(2) == 'user') ? 'active' : '' }}">
                <a href="{{route('admin.user.index')}}">
                    <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
                    <span class="pcoded-mtext">Users</span>
                </a>
            </li>
           
            <li class="{{ (request()->segment(2) == 'manager') ? 'active' : '' }}">
                <a href="{{route('admin.manager.index')}}">
                    <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
                    <span class="pcoded-mtext">Managers</span>
                </a>
            </li>

            <li class="{{ (request()->segment(2) == 'supplier') ? 'active' : '' }}">
                <a href="{{route('reports.supplier')}}">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Suppliers</span>
                </a>
            </li>
            <li class="pcoded-hasmenu pcoded-trigger-dropdown">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext ">Members</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="{{route('member.index')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>List of Members</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('membership.amount')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Membership Amount</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('membership.level')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Levels</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu pcoded-trigger-dropdown">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext ">Reports</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="{{route('reports.sales')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Sales</span>
                        </a>
                    </li>

                    <li class="">
                        <a href="{{route('reports.purchase')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Purchase</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('reports.stock')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Stock</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('reports.daybook')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Daybook</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('reports.top10')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Top Sales</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('reports.order')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Orders</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{route('reports.member')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Members</span>
                        </a>
                    </li>
                    <!-- <li class="">
                        <a href="{{route('reports.supplier')}}">
                            <span class="pcoded-mtext"><i class="feather icon-file-text"></i>Suppliers</span>
                        </a>
                    </li> -->
                </ul>
            </li>
            <li class="{{ (request()->segment(2) == 'slide') ? 'active' : '' }}">
                <a href="{{route('slide.index')}}">
                    <span class="pcoded-micon"><i class="feather icon-image"></i></span>
                    <span class="pcoded-mtext">Slide Image</span>
                </a>
            </li>
            <li class="">
                <a href="{{route('admin.payment.index')}}">
                    <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                    <span class="pcoded-mtext">Payment</span>
                </a>
            </li>

            <li class="pcoded-hasmenu pcoded-trigger-dropdown">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-check-square"></i></span>
                    <span class="pcoded-mtext ">Status</span>
                </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{route('payment.pending')}}">
                                <span class="pcoded-micon"><i class="feather icon-rotate-cw"></i></span>
                                <span class="pcoded-mtext text-warning">Pending </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('payment.approved')}}">
                                <span class="pcoded-micon"><i class="feather icon-check-square"></i></span>
                                <span class="pcoded-mtext text-success">Accepted </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('payment.cancelled')}}">
                                <span class="pcoded-micon"><i class="feather icon-x-square"></i></span>
                                <span class="pcoded-mtext text-danger">Cancelled </span>
                            </a>
                        </li>
                    </ul>
            </li>



        </ul>
                                
    </div>
</nav>