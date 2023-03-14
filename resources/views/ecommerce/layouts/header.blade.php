<header class="header_section">
    <div class="header_top">
        <div class="container-fluid">
            <div class="top_nav_container">

                <a class="navbar-brand" href="{{ route('home')}}">
              <span>
                Emporium
              </span>
                </a>

                <div class="d-flex justify-content-end">
                    <div class="btn-group-header">
                        @if(!auth()->user())
                            <a href="{{ route('login') }}" class="btn text-white account-link">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>
        Fazer login
      </span>
                            </a>
                        @else
                            <div class="dropdown">
                                <button class="btn text-white dropdown-toggle ml-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Minha Conta
                                </button>
                                <!-- Dropdown menu -->
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('building.page')}}">Meu Perfil</a>
                                    <a class="dropdown-item" href="{{route('building.page')}}">Meus Pedidos</a>
                                    <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('cart') }}" class="btn text-white cart-link ml-2">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span>
        Carrinho
      </span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="header_bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container ">

                <from class="search_form">
                    <input type="text" class="form-control" placeholder="Search here...">
                    <button class="" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </from>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class=""> </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('home') }}"> Página inicial </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.list') }}">Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="why.html">Contato</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
