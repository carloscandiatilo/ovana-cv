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
                                        <input type="text" name="nome" class="form-control" id="nomeInput"
                                            placeholder="Nome"
                                            value="{{ request('nome') }}"
                                            style="border-radius: 8px; box-shadow: none; border: 1px solid #ddd;">
                                    </div>
                                </div>

                                <!-- Província -->
                                <div class="col-12 col-md-4">
                                    <div class="form-floating">
                                        <select name="provincia" class="form-select" id="provinciaSelect"
                                            style="border-radius: 8px; box-shadow: none; border: 1px solid #ddd;">
                                            <option value="">Todas</option>
                                            @foreach(['Luanda', 'Benguela', 'Huíla', 'Cabinda', 'Namibe', 'Cuanza Sul', 'Bié', 'Zaire'] as $prov)
                                                <option value="{{ $prov }}" @selected(request('provincia') == $prov)>
                                                    {{ $prov }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Nível -->
                                <div class="col-12 col-md-3">
                                    <div class="form-floating">
                                        <select name="nivel" class="form-select" id="nivelSelect"
                                            style="border-radius: 8px; box-shadow: none; border: 1px solid #ddd;">
                                            <option value="">Todos</option>
                                            @foreach(['Ensino Médio', 'Licenciatura', 'Mestrado', 'Doutoramento'] as $nivel)
                                                <option value="{{ $nivel }}" @selected(request('nivel') == $nivel)>
                                                    {{ $nivel }}
                                                </option>
                                            @endforeach
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

                <!-- Lista de Candidatos -->
                <div class="blog_left_sidebar">
                    <div class="row">
                        @forelse($curriculums as $cv)
                            @php
                                // Garantir que experiências vem como array
                                $experiencias = is_array($cv->experiencias_profissionais) 
                                    ? $cv->experiencias_profissionais 
                                    : (json_decode($cv->experiencias_profissionais, true) ?? []);
                                $anos = count($experiencias);
                            @endphp

                            <div class="col-md-6 mb-4">
                                <article class="blog_item shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                    <div class="blog_item_img" style="height: 220px; overflow: hidden;">
                                        @if($cv->avatar)
                                            <img src="{{ Storage::url($cv->avatar) }}" 
                                                 alt="{{ $cv->pessoal['nome'] ?? 'Candidato' }}" 
                                                 style="object-fit: cover; height: 100%; width: 100%;">
                                        @else
                                            <div style="background: #f3f4f6; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 1.5rem;">
                                                {{ strtoupper(substr($cv->pessoal['nome'] ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                        <a href="#" class="blog_item_date">
                                            <h3>{{ $cv->pessoal['idade'] ?? rand(22,40) }}</h3>
                                            <p>anos</p>
                                        </a>
                                    </div>

                                    <div class="blog_details p-3">
                                        <a class="d-inline-block" href="{{ route('candidatos.show', $cv->id) }}">
                                            <h4 class="mb-2">{{ $cv->pessoal['nome'] ?? 'Sem nome' }}</h4>
                                        </a>
                                        <p><i class="fa fa-user-graduate"></i> 
                                            {{ $cv->formacoes_academicas[0]['grau_academico'] ?? 'N/A' }}
                                        </p>
                                        <p><i class="fa fa-map-marker"></i> 
                                            {{ $cv->pessoal['endereco_provincia'] ?? 'N/A' }}
                                        </p>
                                        <ul class="blog-info-link d-flex justify-content-between mt-3">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-briefcase"></i> 
                                                    {{ $anos }} {{ $anos === 1 ? 'ano' : 'anos' }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('candidatos.show', $cv->id) }}">
                                                    <i class="fa fa-envelope"></i> Ver Perfil
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Nenhum candidato encontrado.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Paginação -->
                    @if($curriculums->hasPages())
                        <nav class="blog-pagination justify-content-center d-flex mt-4">
                            {{ $curriculums->withQueryString()->links() }}
                        </nav>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog_right_sidebar">

                    <!-- Níveis Acadêmicos -->
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Níveis Acadêmicos</h4>
                        <ul class="list cat-list">
                            @foreach(['Ensino Médio', 'Licenciatura', 'Mestrado', 'Doutoramento'] as $nivel)
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['nivel' => $nivel, 'page' => 1]) }}" 
                                       class="d-flex justify-content-between">
                                        <p>{{ $nivel }}</p>
                                        <p>({{ $contagensNiveis[$nivel] ?? 0 }})</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </aside>

                    <!-- Províncias -->
                    <aside class="single_sidebar_widget tag_cloud_widget">
                        <h4 class="widget_title">Províncias</h4>
                        <ul class="list">
                            @foreach(['Luanda', 'Benguela', 'Huíla', 'Cabinda', 'Namibe', 'Cuanza Sul', 'Bié', 'Zaire'] as $prov)
                                <li>
                                    <a href="{{ request()->fullUrlWithQuery(['provincia' => $prov, 'page' => 1]) }}">
                                        {{ $prov }}
                                    </a>
                                </li>
                            @endforeach
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
