<!-- Trending Area Start -->
<div class="trending-area fix pt-25 gray-bg">
    <div class="container">
        <div class="trending-main">
            <div class="row">
                @if($destaqueNews->isNotEmpty())
                    <!-- Slider principal (col-lg-8) -->
                    <div class="col-lg-8">
                        <div class="slider-active">
                            @foreach($destaqueNews->take(3) as $news)
                                <div class="single-slider">
                                    <div class="trending-top mb-30">
                                        <div class="trend-top-img">
                                            <img 
                                                src="{{ $news->media ? asset('storage/' . $news->media) : asset('assets/img/trending/trending_default.jpg') }}" 
                                                alt="{{ $news->title }}" 
                                                style="width:100%; height:400px; object-fit:cover;"
                                            >
                                            <div class="trend-top-cap">
                                                <span class="bgr">{{ $news->category?->name ?? 'Sem categoria' }}</span>
                                                <!-- <span class="badge bg-danger ms-2">Destaque</span> -->
                                                <h2>
                                                    <a href="{{ route('news.show', $news->id) }}">
                                                        {{ Str::limit($news->title, 80) }}
                                                    </a>
                                                </h2>
                                                <p>
                                                    Por {{ $news->user?->name ?? 'Anônimo' }} 
                                                    - {{ $news->created_at->format('d M, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Destaques menores (col-lg-4) -->
                    <div class="col-lg-4">
                        <div class="row">
                            @php
                                $smallNews = $destaqueNews->skip(3)->take(2);
                            @endphp

                            @foreach($smallNews as $news)
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30">
                                        <div class="trend-top-img">
                                            <img 
                                                src="{{ $news->media ? asset('storage/' . $news->media) : asset('assets/img/trending/trending_default.jpg') }}" 
                                                alt="{{ $news->title }}"
                                                style="width:100%; height:200px; object-fit:cover;"
                                            >
                                            <div class="trend-top-cap trend-top-cap2">
                                                <span class="bgb">{{ $news->category?->name ?? 'Sem categoria' }}</span>
                                                <h2>
                                                    <a href="{{ route('news.show', $news->id) }}">
                                                        {{ Str::limit($news->title, 50) }}
                                                    </a>
                                                </h2>
                                                <p>
                                                    Por {{ $news->user?->name ?? 'Anônimo' }} 
                                                    - {{ $news->created_at->format('d M, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Preenche com placeholders SOMENTE se houver menos de 2 notícias na col-lg-4 --}}
                            @for($i = 0; $i < (2 - $smallNews->count()); $i++)
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30">
                                        <div class="trend-top-img">
                                            <img 
                                                src="{{ asset('assets/img/trending/trending_default.jpg') }}" 
                                                alt="Notícia padrão"
                                                style="width:100%; height:200px; object-fit:cover;"
                                            >
                                            <div class="trend-top-cap trend-top-cap2">
                                                <span class="bgr">Categoria</span>
                                                <h2><a href="#">Notícia de destaque</a></h2>
                                                <p>Por Admin - {{ now()->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @else
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Nenhuma notícia de destaque publicada no momento.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Trending Area End -->