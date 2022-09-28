<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigation-lavel"></div>
        <ul class="pcoded-item pcoded-left-item">
            
            <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
                <a href="{{route('user.dashboard')}}">
                    <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
            
            
            <li class="{{ (request()->segment(2) == 'category') ? 'active' : '' }}">
                <a href="{{route('category.index')}}">
                    <span class="pcoded-micon"><i class="fa fa-list-alt"></i></span>
                    <span class="pcoded-mtext">Category</span>
                </a>
            </li>

            
            <li class="{{ (request()->segment(2) == 'subcategory') ? 'active' : '' }}">
                <a href="{{route('subcategory.index')}}">
                    <span class="pcoded-micon"><i class="fa fa-bars"></i></span>
                    <span class="pcoded-mtext">Sub Category</span>
                </a>
            </li>

            
            <li class="{{ (request()->segment(2) == 'unit') ? 'active' : '' }}">
                <a href="{{route('unit.index')}}">
                    <span class="pcoded-micon"><i class="fa fa-balance-scale"></i></span>
                    <span class="pcoded-mtext">Unit</span>
                </a>
            </li>

             
            <li class="{{ (request()->segment(2) == 'maincategory') ? 'active' : '' }}">
                <a href="{{route('maincategory.index')}}">
                    <span class="pcoded-micon"><i class="feather icon-plus"></i></span>
                    <span class="pcoded-mtext">Gender</span>
                </a>
            </li>

            
            <li class="{{ (request()->segment(2) == 'supplier') ? 'active' : '' }}">
                <a href="{{route('supplier.index')}}">
                    <span class="pcoded-micon"><i class="fa fa-industry"></i></span>
                    <span class="pcoded-mtext">Suppliers</span>
                </a>
            </li>
            
            <li class="{{ (request()->segment(2) == 'product') ? 'active' : '' }}">
                <a href="{{route('product.mainindex')}}">
                    <span class="pcoded-micon"><i class="feather icon-shield"></i></span>
                    <span class="pcoded-mtext">Products</span>
                </a>
            </li>

            <!-- <li>
                <a href="#">
                    <span class="pcoded-micon"><i class="fa fa-cogs"></i></span>
                    <span class="pcoded-mtext">Reports</i></span>
                </a>
            </li> -->
            
        </ul>
    </div>
</nav>