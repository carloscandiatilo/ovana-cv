<!-- Whats New Start -->
<section class="whats-news-area pt-50 pb-20 gray-bg">
    <div class="container">
        <div class="row">
             <div class="col-lg-8">
                <div class="whats-news-wrapper">

                    <!-- Abas -->
                    <div class="row justify-content-between align-items-end mb-15">
                        <div class="col-xl-4">
                            <div class="section-tittle mb-30">
                                <h3>Notícias</h3>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-9">
                            <div class="properties__button">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        @foreach($allCategories as $index => $category)
                                        <a class="nav-item nav-link {{ $index == 0 ? 'active' : '' }}"
                                            id="nav-{{ $category->id }}-tab" data-toggle="tab"
                                            href="#nav-{{ $category->id }}" role="tab"
                                            aria-controls="nav-{{ $category->id }}"
                                            aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                            {{ $category->name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Tab content -->
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="nav-tabContent">
                                @foreach($allCategories as $index => $category)
                                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                    id="nav-{{ $category->id }}" role="tabpanel"
                                    aria-labelledby="nav-{{ $category->id }}-tab">

                                    @if(isset($groupedNews[$category->id]) && $groupedNews[$category->id]->count() > 0)
                                    @php
                                    $newsPaginator = $groupedNews[$category->id];
                                    $mainNews = $newsPaginator->first();
                                    @endphp

                                    <div class="row">
                                        <!-- Notícia principal -->
                                        <div class="col-xl-8 col-lg-12 mb-40">
                                            <div class="whats-news-single">
                                                <div class="whates-img">
                                                    <img src="{{ $mainNews->media ? asset('storage/'.$mainNews->media) : asset('assets/img/gallery/whats_news_details1.png') }}"
                                                        alt="">
                                                </div>
                                                <div class="whates-caption">
                                                    <h4><a href="{{ route('news.show', $mainNews->id) }}">{{
                                                            $mainNews->title }}</a></h4>
                                                    <span>Publicado: {{ $mainNews->created_at->format('d/m/Y') }} - {{
                                                        $mainNews->user->name }}</span>
                                                    <p>{{ Str::limit($mainNews->content, 200) }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notícias menores à direita -->
                                        <div class="col-xl-4 col-lg-12">
                                            @foreach($newsPaginator->skip(1)->take(4) as $news)
                                            <div class="whats-right-single d-flex mb-3">
                                                <div class="whats-right-img mr-2">
                                                    <img src="{{ $news->media ? asset('storage/'.$news->media) : asset('assets/img/gallery/whats_right_img1.png') }}"
                                                        alt="" style="width:80px; height: 60px; object-fit:cover;">
                                                </div>
                                                <div class="whats-right-cap">
                                                    <span class="colorb" style="font-size:12px;">{{
                                                        $news->category->name }}</span>
                                                    <h5><a href="{{ route('news.show', $news->id) }}"
                                                            style="font-size:14px;">{{ Str::limit($news->title, 50)
                                                            }}</a></h5>
                                                    <p style="font-size:11px;">{{ $news->created_at->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @else
                                    <p>Nenhuma notícia encontrada nesta categoria.</p>
                                    @endif

                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>


           <div class="col-lg-4">
    <!-- Estatísticas de utilizadores -->
    <div class="single-follow mb-45">
        <div class="single-box">
            <div class="follow-us d-flex align-items-center">
                <div class="follow-social text-center">
                    <i class="fa fa-user fa-2x text-primary"></i>
                </div>
                <div class="follow-count">
                    <span>00</span>
                    <p>MASCULINO</p>
                </div>
            </div>
            <div class="follow-us d-flex align-items-center">
                <div class="follow-social text-center">
                    <i class="fa fa-user fa-2x text-danger"></i>
                </div>
                <div class="follow-count">
                    <span>00</span>
                    <p>FEMININO</p>
                </div>
            </div>
            <div class="follow-us d-flex align-items-center">
                <div class="follow-social text-center">
                    <i class="fa fa-id-badge fa-2x text-success"></i>
                </div>
                <div class="follow-count">
                    <span>00</span>
                    <p>COM ORCID</p>
                </div>
            </div>
            <div class="follow-us d-flex align-items-center">
                <div class="follow-social text-center">
                    <i class="fa fa-id-badge fa-2x text-muted"></i>
                </div>
                <div class="follow-count">
                    <span>00</span>
                    <p>SEM ORCID</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Acesso rápido com formulário -->
    <div class="most-recent-area">
        <div class="small-tittle mb-20">
            <h4>Acesso Rápido</h4>
        </div>

        <div class="card p-3 shadow-sm">
            <form action="{{ url('/search-cv') }}" method="GET">
                <div class="form-group mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Ex: Digite o Nome que procura">
                </div>

           

                <div class="form-group mb-3">
                    <label for="nivel_academico">Nível Acadêmico</label>
                    <select name="nivel_academico" id="nivel_academico" class="form-select">
                        <option value="">-- Selecione --</option>
                        <option value="Licenciatura">Licenciatura</option>
                        <option value="Pos-Graduacao">Pós-Graduação</option>
                        <option value="Mestrado">Mestrado</option>
                        <option value="Doutorado">Doutorado</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="localizacao">Localização</label>
                    <input type="text" name="localizacao" id="localizacao" class="form-control" placeholder="Ex: Luanda, Benguela">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
    </div>
</section>
<!-- Whats New End -->