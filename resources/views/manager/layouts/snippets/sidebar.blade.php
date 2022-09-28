<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
     <div class="pcoded-navigation-lavel"></div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ (request()->segment(2) == '') ? 'active' : '' }}">
                <a href="{{route('manager.dashboard')}}">
                    <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>

            <li class="{{ (request()->segment(2) == 'order') ? 'active' : 'order' }}">

                <a href="{{route('manager.order.index')}}">
                    <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                    <span class="pcoded-mtext">All Orders</span>
                </a>
            </li>
            <li >

                <a href="{{route('order.pending')}}">
                    <span class="pcoded-micon"><i class="feather icon-rotate-cw"></i></span>
                    <span class="pcoded-mtext text-warning">Pending </span>
                </a>
            </li>
            <li>

                <a href="{{route('order.approved')}}">
                    <span class="pcoded-micon"><i class="feather icon-check-square"></i></span>
                    <span class="pcoded-mtext text-success">Approved </span>
                </a>
            </li>
            <li>

                <a href="{{route('order.cancelled')}}">
                    <span class="pcoded-micon"><i class="feather icon-x-square"></i></span>
                    <span class="pcoded-mtext text-danger">Cancelled </span>
                </a>
            </li>



            <li>
                <a href="{{route('product.Index')}}">
                    <span class="pcoded-micon"><i class="feather icon-shield"></i></span>
                    <span class="pcoded-mtext">Products</span>
                </a>
            </li>


        </ul>
    </div>
</nav>