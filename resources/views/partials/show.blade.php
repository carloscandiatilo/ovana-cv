@extends('layouts.app')

@section('content')
<section class="news-details-area pt-50 pb-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="news-details">
                    <div class="news-details-img mb-3">
                        <img src="{{ $news->media ? asset('storage/'.$news->media) : asset('assets/img/gallery/whats_news_details1.png') }}" alt="" style="width:100%; object-fit:cover;">
                    </div>

                    <div class="news-details-caption">
                        <h2>{{ $news->title }}</h2>
                        <div class="news-meta mb-3">
                            <span>Categoria: {{ $news->category->name }}</span> |
                            <span>Publicado: {{ $news->created_at->format('d/m/Y') }}</span> |
                            <span>Por: {{ $news->user->name }}</span>
                        </div>
                        <p>{!! nl2br(e($news->content)) !!}</p>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Voltar</a>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
