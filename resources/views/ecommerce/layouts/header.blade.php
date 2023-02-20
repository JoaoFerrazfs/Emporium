    <header class="header_section">
        <div class="header_top">
            <div class="container-fluid">
                <div class="top_nav_container">

                    <a class="navbar-brand" href="{{ route('home')}}">
              <span>
                Emporium
              </span>
                    </a>

                    <div class="user_option_box">
                        <a href="{{ route('register') }}" class="account-link">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>
                  Login
                </span>
                        </a>
                        <a href="{{ route('myCart') }}" class="cart-link">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <span>
                  Carrinho
                </span>
                        </a>
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
