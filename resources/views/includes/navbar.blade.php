<div class="l-header" id="header">
    <nav class="nav bd-container">
        <a href="#" class="nav_logo"><img src="{{ url('frontend/images/logopoliklinik.png') }}" alt="Logo Yakkum"
                class="nav-img" /></a>

        <div class="nav_menu" id="nav-menu">
            <ul class="nav_list">
                <li class="nav_item">
                    <a href="#home" class="nav_link active-link">Home</a>
                </li>
                <li class="nav_item">
                    <a href="#doctors" class="nav_link">Doctors</a>
                </li>
                <li class="nav_item">
                    <a href="#contact" class="nav_link">Contact</a>
                </li>
                @guest
                    <!-- Mobile button -->
                    <form class="form-inline d-sm-block d-md-none">
                        <button class="btn btn-login my-2 my-sm-0" type="button"
                            onclick="event.preventDefault(); location.href='{{ url('login') }}';">
                            Masuk
                        </button>
                    </form>
                    <!-- Desktop Button -->
                    <form class="form-inline my-2 my-lg-0 d-none d-md-block">
                        <button class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="button"
                            onclick="event.preventDefault(); location.href='{{ url('login') }}';">
                            Masuk
                        </button>
                    </form>
                @endguest

                @auth
                    <!-- Mobile button -->
                    <form class="form-inline d-sm-block d-md-none" action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-login my-2 my-sm-0" type="submit">
                            Keluar
                        </button>
                    </form>
                    <!-- Desktop Button -->
                    <form class="form-inline my-2 my-lg-0 d-none d-md-block" action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="submit">
                            Keluar
                        </button>
                    </form>
                @endauth
            </ul>
        </div>
    </nav>
</div>
