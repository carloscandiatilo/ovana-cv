<header>
    <!-- Header Start -->
    <div class="header-area">
        <div class="main-header ">
            <div class="header-top black-bg d-none d-sm-block">
                <div class="container">
                    <div class="col-xl-12">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="header-info-left">
                                <ul>     
                                    <li class="title"><span class="flaticon-energy"></span> Mais que um portal</li>
                                    <li id="weather">Carregando...</li>
                                </ul>
                            </div>
                            <div class="header-info-right">
                                <ul class="header-date">
                                    <li><span class="ti-tablet"></span> +244 999 999 999</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="header-mid gray-bg">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-lg-3 col-md-3 d-none d-md-block">
                            <div class="logo">
                              <h2>OVANA - O SEU CV</h2>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9">
                            <div class="header-banner f-right">
                                <img src="{{ asset('assets/img/gallery/header_card.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="header-bottom header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-lg-8 col-md-12 header-flex">
                            <div class="sticky-logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
                            </div>
                            <div class="main-menu d-none d-md-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="{{ url('/') }}">Inicio</a></li>
                                        <li><a href="{{ url('/sobre') }}">Sobre</a></li>
                                        <li><a href="{{ url('/curriculums') }}">Procurar Curriculum</a></li>
                                        <li><a href="{{ url('/latest-news') }}">Estatisticas</a></li>
                                        <li><a href="{{ url('/contacto') }}">Contacto</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="header-right f-right d-none d-lg-block">
                                <ul class="header-social">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                                <div class="nav-search search-switch">
                                    <a href="{{ url('/admin/login') }}">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-md-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>