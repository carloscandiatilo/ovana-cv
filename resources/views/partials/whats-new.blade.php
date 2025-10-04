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
                <div class="single-follow mb-45">
                    <div class="single-box">
                        <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{ asset('assets/img/news/icon-fb.png') }}" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>MASCULINO</p>
                            </div>
                        </div>
                        <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{ asset('assets/img/news/icon-tw.png') }}" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>FEMININO</p>
                            </div>
                        </div>
                        <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{ asset('assets/img/news/icon-ins.png') }}" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>COM ORCID</p>
                            </div>
                        </div>
                        <div class="follow-us d-flex align-items-center">
                            <div class="follow-social">
                                <a href="#"><img src="{{ asset('assets/img/news/icon-yo.png') }}" alt=""></a>
                            </div>
                            <div class="follow-count">
                                <span>8,045</span>
                                <p>SEM ORCID</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="most-recent-area">
                    <div class="small-tittle mb-20">
                        <h4>Acesso Rápido</h4>
                    </div>
                    <div class="most-recent mb-40">
                        <div class="most-recent-img">
                            <img src="{{ asset('assets/img/gallery/most_recent.png') }}" alt="">
                            <div class="most-recent-cap">
                                <span class="bgbeg">Vogue</span>
                                <h4><a href="{{ url('/latest-news') }}">What to Wear: 9+ Cute Work <br> Outfits to Wear This.</a></h4>
                                <p>Jhon  |  2 hours ago</p>
                            </div>
                        </div>
                    </div>
                    <div class="most-recent-single">
                        <div class="most-recent-images">
                            <img src="{{ asset('assets/img/gallery/most_recent1.png') }}" alt="">
                        </div>
                        <div class="most-recent-capt">
                            <h4><a href="{{ url('/latest-news') }}">Scarlett’s disappointment at latest accolade</a></h4>
                            <p>Jhon  |  2 hours ago</p>
                        </div>
                    </div>
                    <div class="most-recent-single">
                        <div class="most-recent-images">
                            <img src="{{ asset('assets/img/gallery/most_recent2.png') }}" alt="">
                        </div>
                        <div class="most-recent-capt">
                            <h4><a href="{{ url('/latest-news') }}">Most Beautiful Things to Do in Sidney with Your BF</a></h4>
                            <p>Jhon  |  3 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Whats New End -->