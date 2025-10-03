@extends('layouts.app')
@section('content')
<section class="candidate_area section-padding">
    <div class="container">
        <div class="row">

            <!-- Coluna principal -->
            <div class="col-lg-8 mb-5 mb-lg-0">

                <!-- Formulário de pesquisa -->
               <div class="card shadow-sm mb-4 border-0" style="border-radius: 12px; background-color: #fff;">
                <div class="card-body p-3">
                    <form method="GET" action="{{ url('/') }}">
                        <div class="row g-2 align-items-center">

                            <!-- Nome -->
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <input type="text" name="nome" class="form-control" id="nomeInput" placeholder="Nome" style="border-radius: 8px; box-shadow: none; border: 1px solid #ddd;">
                                </div>
                            </div>

                            <!-- Província -->
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <select name="provincia" class="form-select" id="provinciaSelect" style="border-radius: 8px; box-shadow: none; border: 1px solid #ddd;">
                                        <option value="">Todas</option>
                                        <option value="Luanda">Luanda</option>
                                        <option value="Benguela">Benguela</option>
                                        <option value="Huíla">Huíla</option>
                                        <option value="Cabinda">Cabinda</option>
                                        <option value="Namibe">Namibe</option>
                                        <option value="Cuanza Sul">Cuanza Sul</option>
                                        <option value="Bié">Bié</option>
                                        <option value="Zaire">Zaire</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nível -->
                            <div class="col-12 col-md-3">
                                <div class="form-floating">
                                    <select name="nivel" class="form-select" id="nivelSelect" style="border-radius: 8px; box-shadow: none; border: 1px solid #ddd;">
                                        <option value="">Todos</option>
                                        <option value="Ensino Médio">Ensino Médio</option>
                                        <option value="Licenciatura">Licenciatura</option>
                                        <option value="Mestrado">Mestrado</option>
                                        <option value="Doutoramento">Doutoramento</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Botão Limpar -->
                            <div class="col-12 col-md-1 d-flex justify-content-end align-items-center">
                                <a href="{{ url('/') }}" 
                                class="btn btn-sm shadow-sm" 
                                style="background-color: #dc3545; color: white; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.9rem;"
                                title="Limpar">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
               <!-- **************** -->

                <!-- Lista de Candidatos -->
                <div class="blog_left_sidebar">
                    <div class="row">
                        @for($i = 1; $i <= 6; $i++)
                        <div class="col-md-6 mb-4">
                            <article class="blog_item shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <div class="blog_item_img" style="height: 220px; overflow: hidden;">
                                    <img class="card-img-top" 
                                        src="https://i.pravatar.cc/500?img={{ $i }}" 
                                        alt="Candidato {{ $i }}" 
                                        style="object-fit: cover; height: 100%; width: 100%;">
                                    <a href="#" class="blog_item_date">
                                        <h3>{{ rand(22,40) }}</h3>
                                        <p>anos</p>
                                    </a>
                                </div>

                                <div class="blog_details p-3">
                                    <a class="d-inline-block" href="{{ route('candidatos.show', $i) }}">
                                        <h4 class="mb-2">Candidato {{ $i }}</h4>
                                    </a>
                                    <p><i class="fa fa-user-graduate"></i> Licenciatura</p>
                                    <p><i class="fa fa-map-marker"></i> Luanda</p>
                                    <ul class="blog-info-link d-flex justify-content-between mt-3">
                                        <li><a href="#"><i class="fa fa-briefcase"></i> Experiência 5 anos</a></li>
                                        <li><a href="{{ route('candidatos.show', $i) }}"><i class="fa fa-envelope"></i> Ver Perfil</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        @endfor
                    </div>

                    <!-- Paginação -->
                    <nav class="blog-pagination justify-content-center d-flex mt-4">
                        <ul class="pagination">
                            <li class="page-item">
                                <a href="#" class="page-link" aria-label="Previous">
                                    <i class="ti-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item"><a href="#" class="page-link">3</a></li>
                            <li class="page-item">
                                <a href="#" class="page-link" aria-label="Next">
                                    <i class="ti-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <!-- (removei o search antigo daqui) -->

                    <!-- Níveis -->
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Níveis Acadêmicos</h4>
                        <ul class="list cat-list">
                            <li><a href="#" class="d-flex justify-content-between"><p>Ensino Médio</p><p>(12)</p></a></li>
                            <li><a href="#" class="d-flex justify-content-between"><p>Licenciatura</p><p>(30)</p></a></li>
                            <li><a href="#" class="d-flex justify-content-between"><p>Mestrado</p><p>(8)</p></a></li>
                            <li><a href="#" class="d-flex justify-content-between"><p>Doutoramento</p><p>(2)</p></a></li>
                        </ul>
                    </aside>

                    <!-- Provincias -->
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">Provincias</h4>
                        <ul class="list">
                            <li><a href="#">Luanda</a></li>
                            <li><a href="#">Benguela</a></li>
                            <li><a href="#">Huíla</a></li>
                            <li><a href="#">Cabinda</a></li>
                            <li><a href="#">Namibe</a></li>
                            <li><a href="#">Cuanza Sul</a></li>
                            <li><a href="#">Bié</a></li>
                            <li><a href="#">Zaire</a></li>
                        </ul>
                    </aside>

                    <!-- Solicitar contacto -->
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">Solicitar Contacto</h4>
                        <form action="#">
                            <div class="form-group">
                                <input type="text" class="form-control mb-2" placeholder='Seu nome' required>
                                <input type="email" class="form-control mb-2" placeholder='Seu email' required>
                                <input type="text" class="form-control mb-2" placeholder='Telefone' required>
                                <textarea class="form-control mb-2" rows="3" placeholder="Mensagem"></textarea>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                type="submit">Enviar Pedido</button>
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
