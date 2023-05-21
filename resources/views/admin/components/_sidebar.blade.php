<div id="app">
    <div id="sidebar" class='active'>
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <img class="img-fluid" src="/img/commons/emporium-logo.png" alt="">
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class='sidebar-title'>Menu</li>
                    <li class="sidebar-item @yield('orders') ">
                        <a href="{{route('admin.orders')}}" class='sidebar-link'>
                            <i class="bi bi-bar-chart-line"></i>
                            <span>Pedidos</span>
                        </a>
                    </li>
                    <li class="sidebar-item @yield('products') ">
                        <a href="{{route('admin.products')}}" class='sidebar-link'>
                            <i class="bi bi-egg-fried"></i>
                            <span>Produtos</span>
                        </a>
                    </li>
                    <li class="sidebar-item @yield('userManager') ">
                        <a href="{{route('building.page')}}" class='sidebar-link'>
                            <i class="bi bi-journal"></i>
                            <span>Relatórios</span>
                        </a>
                    </li>
                    <li class="sidebar-item @yield('userManager')">
                        <a href="{{route('building.page')}}" class='sidebar-link'>
                            <i class="bi bi-people"></i>
                            <i data-feather="home" width="20"></i>
                            <span>Gerenciar Usuarios</span>
                        </a>
                    </li>

                    <li class="sidebar-item  has-sub">
                        <a href="#" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>Minha Conta</span>
                        </a>
                        <ul class="submenu ">
                            <li>
                                <a href="{{route('building.page')}}">Perfil</a>
                            </li>
                            <li>
                                <a href="{{route('logout')}}">Logout</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item @yield('userManager')">
                        <a href="{{route('home')}}" class='sidebar-link'>
                            <i class="bi bi-house"></i>
                            <i data-feather="home" width="20"></i>
                            <span>Acesso ao ecommerce</span>
                        </a>
                    </li>
                </ul>



            </div>

            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>

    </div>


</div>
