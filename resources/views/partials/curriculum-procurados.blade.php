<!-- Weekly2-News start -->
<div class="weekly2-news-area pt-50 pb-30 gray-bg">
    <div class="container">
        <div class="weekly2-wrapper">
            <div class="row">
                <div class="col-lg-3">
                    <div class="home-banner2 d-none d-lg-block">
                        <img src="{{ asset('assets/img/gallery/studante.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="slider-wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="small-tittle mb-30">
                                    <h4>TOP 5 - Mais Procurados</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Carrossel -->
                                <div class="weekly2-news-active owl-carousel">
                                   @foreach ($curriculums as $cv)
                                        @if($cv->published)
                                            <div class="weekly2-single">
                                                <div class="weekly2-img text-center">
                                                    @if($cv->avatar)
                                                        <img src="{{ Storage::url($cv->avatar) }}" 
                                                            alt="Foto de {{ $cv->pessoal['nome'] ?? 'Sem nome' }}">
                                                    @else
                                                        <!-- Avatar default com inicial -->
                                                        <div style="width:120px;height:120px;margin:auto;border-radius:50%;
                                                                    background:#ddd;display:flex;align-items:center;
                                                                    justify-content:center;font-size:2rem;font-weight:bold;color:#555;">
                                                            {{ strtoupper(substr($cv->pessoal['nome'] ?? 'U', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="weekly2-caption text-center">
                                                    <h4 class="mt-2">
                                                        {{ $cv->pessoal['nome'] ?? 'Sem nome' }}
                                                    </h4>
                                                    <p>
                                                        {{ $cv->pessoal['instituicao_nome'] ?? 'Instituição não informada' }}
                                                        |
                                                        {{ $cv->pessoal['endereco_pais'] ?? 'N/A' }}
                                                    </p>
                                                    
                                                    <!-- Ações -->
                                                    <div class="mt-3 flex justify-center space-x-3">
                                                        <a href="#" 
                                                        class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                                                            Ver mais
                                                        </a>
                                                        <a href="#" 
                                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                                            Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Weekly-News -->
