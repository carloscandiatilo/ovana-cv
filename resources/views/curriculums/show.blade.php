@extends('layouts.app')

@section('content')
<section class="candidate_details section-padding">
    <div class="container">
        <div class="row">
            <!-- Perfil Completo -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm p-4">
                    <!-- Cabeçalho com foto e dados básicos -->
                    <div class="d-flex align-items-center mb-3">
                        @if(!empty($curriculum->avatar) && Storage::disk('public')->exists($curriculum->avatar))
                            <img src="{{ Storage::url($curriculum->avatar) }}" 
                                 class="rounded-circle mr-3" width="100" height="100" 
                                 alt="Foto de {{ $pessoal['nome'] ?? 'Sem nome' }}">
                        @else
                            <div style="width:100px;height:100px;border-radius:50%;
                                        background:#ddd;display:flex;align-items:center;
                                        justify-content:center;font-size:2rem;font-weight:bold;color:#555;">
                                {{ strtoupper(substr($pessoal['nome'] ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <div class="ml-3">
                            <h3>{{ $pessoal['nome'] ?? 'Nome não disponível' }} {{ $pessoal['nome_do_meio'] ?? '' }} {{ $pessoal['apelido'] ?? '' }}</h3>
                            <p><i class="fa fa-map-marker"></i> {{ $pessoal['endereco_pais'] ?? 'Local não definido' }}</p>
                            <p><i class="fa fa-envelope"></i> {{ $curriculum->user->email ?? '---' }}</p>
                            @if(!empty($pessoal['orcid']))
                                <p><i class="fa fa-id-card"></i> ORCID: {{ $pessoal['orcid'] }}</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Dados Pessoais Detalhados -->
                    <h4><i class="fa fa-user"></i> Dados Pessoais</h4>
                    <ul class="list-unstyled">
                        <li><strong>Instituição:</strong> {{ $pessoal['instituicao_nome'] ?? 'Não informado' }}</li>
                        <li><strong>Endereço:</strong> {{ $pessoal['endereco_rua_bairro'] ?? '' }}, {{ $pessoal['endereco_municipio'] ?? '' }}, {{ $pessoal['endereco_pais'] ?? '' }}</li>
                        @if(!empty($pessoal['website']))
                            <li><strong>Website:</strong> <a href="{{ $pessoal['website'] }}" target="_blank">{{ $pessoal['website'] }}</a></li>
                        @endif
                        <li><strong>E-mail Pessoal:</strong> {{ $pessoal['email_pessoal'] ?? '—' }}</li>
                        <li><strong>E-mail Profissional:</strong> {{ $pessoal['email_profissional'] ?? '—' }}</li>
                    </ul>

                    <!-- Idiomas -->
                    <h4 class="mt-3"><i class="fa fa-language"></i> Idiomas</h4>
                    <ul>
                        @forelse($curriculum->idiomas as $idioma)
                            <li>{{ $idioma->nome }}</li>
                        @empty
                            <li>Nenhum idioma cadastrado.</li>
                        @endforelse
                    </ul>

                    <!-- Formação Acadêmica -->
                    <h4 class="mt-3"><i class="fa fa-user-graduate"></i> Formação Acadêmica</h4>
                    <ul>
                        @forelse($formacoes as $f)
                            <li>
                                {{ $f['grau_academico'] ?? '—' }} em {{ $f['instituicao_formacao'] ?? '—' }}
                                ({{ $f['ano_inicio'] ?? '—' }} – {{ $f['ano_conclusao'] ?? '—' }})
                                @if(!empty($f['titulo_monografia']))
                                    <br><small>Título: {{ $f['titulo_monografia'] }}</small>
                                @endif
                            </li>
                        @empty
                            <li>Nenhuma formação acadêmica cadastrada.</li>
                        @endforelse
                    </ul>

                    <!-- Formações Complementares -->
                    <h4 class="mt-3"><i class="fa fa-graduation-cap"></i> Formações Complementares</h4>
                    <ul>
                        @forelse($formacoes_complementares as $fc)
                            <li>
                                {{ $fc['nome_curso'] ?? '—' }} – {{ $fc['instituicao_formacao'] ?? '—' }}
                                ({{ $fc['ano_conclusao'] ?? '—' }})
                                @if(!empty($fc['carga_horaria']))
                                    <br><small>{{ $fc['carga_horaria'] }} horas</small>
                                @endif
                            </li>
                        @empty
                            <li>Nenhuma formação complementar cadastrada.</li>
                        @endforelse
                    </ul>

                    <!-- Prêmios -->
                    <h4 class="mt-3"><i class="fa fa-trophy"></i> Prêmios e Reconhecimentos</h4>
                    <ul>
                        @forelse($premios as $p)
                            <li>
                                {{ $p['nome_premiacao'] ?? '—' }} – {{ $p['instituicao'] ?? '—' }} ({{ $p['ano_atribuicao'] ?? '—' }})
                            </li>
                        @empty
                            <li>Nenhum prêmio cadastrado.</li>
                        @endforelse
                    </ul>

                    <!-- Atuação Profissional -->
                    <h4 class="mt-3"><i class="fa fa-briefcase"></i> Atuação Profissional</h4>
                    <ul>
                        @forelse($actuacoes_profissionais as $ap)
                            <li>
                                <strong>{{ $ap['funcao'] ?? '—' }}</strong> na {{ $ap['instituicao'] ?? '—' }}
                                ({{ $ap['ano_inicio'] ?? '—' }} – {{ $ap['ano_fim'] ?? 'Atual' }})
                                <br><small>{{ $ap['tipo_vinculo'] ?? 'Vínculo não especificado' }}</small>
                            </li>
                        @empty
                            <li>Nenhuma atuação profissional cadastrada.</li>
                        @endforelse
                    </ul>

                    <!-- Docência -->
                    <h4 class="mt-3"><i class="fa fa-chalkboard-teacher"></i> Docência</h4>
                    <ul>
                        @forelse($actuacoes_docencias as $d)
                            <li>
                                {{ $d['disciplina'] ?? '—' }} – {{ $d['instituicao'] ?? '—' }} ({{ $d['ano'] ?? '—' }})
                                @if(!empty($d['carga_horaria']))
                                    <br><small>{{ $d['carga_horaria'] }} horas</small>
                                @endif
                            </li>
                        @empty
                            <li>Nenhuma docência registrada.</li>
                        @endforelse
                    </ul>

                    <!-- Orientação de Estudantes -->
                    <h4 class="mt-3"><i class="fa fa-user-friends"></i> Orientação de Estudantes</h4>
                    <ul>
                        @forelse($curriculum->orientacao_estudantes as $o)
                            <li>
                                {{ $o->tipo_orientacao }}: <strong>{{ $o->nome_estudante }}</strong>
                                ({{ $o->ano_conclusao }}) – {{ $o->instituicao }}
                            </li>
                        @empty
                            <li>Nenhuma orientação registrada.</li>
                        @endforelse
                    </ul>

                    <!-- Projetos de Investigação -->
                    <h4 class="mt-3"><i class="fa fa-flask"></i> Projetos de Investigação</h4>
                    <ul>
                        @forelse($investigacoes_cientificas as $inv)
                            <li>
                                <strong>{{ $inv['titulo_projeto'] ?? '—' }}</strong><br>
                                <small>
                                    {{ $inv['instituicao'] ?? '—' }} | 
                                    {{ $inv['linha_investigacao'] ?? '—' }} |
                                    {{ $inv['ano_inicio'] ?? '—' }} – {{ $inv['ano_fim'] ?? '—' }}
                                </small>
                                @if(!empty($inv['financiador']))
                                    <br><small>Financiador: {{ $inv['financiador'] }}</small>
                                @endif
                            </li>
                        @empty
                            <li>Nenhum projeto de investigação cadastrado.</li>
                        @endforelse
                    </ul>

                    <!-- Produção Científica -->
                    <h4 class="mt-3"><i class="fa fa-book"></i> Produção Científica</h4>
                    <ul>
                        @forelse($curriculum->producaocientificas as $p)
                            <li>
                                <em>{{ $p->titulo }}</em> ({{ $p->ano_publicacao }})
                                <br><small>{{ $p->tipo_producao }} – {{ $p->editora ?? '—' }}</small>
                            </li>
                        @empty
                            <li>Nenhuma produção científica registrada.</li>
                        @endforelse
                    </ul>

                    <!-- Extensão Universitária -->
                    <h4 class="mt-3"><i class="fa fa-hand-holding-heart"></i> Extensão Universitária</h4>
                    <ul>
                        @forelse($extensoes_universitarias as $e)
                            <li>
                                {{ $e['projeto_extensao'] ?? '—' }} – {{ $e['instituicao'] ?? '—' }}
                                ({{ $e['ano_inicio'] ?? '—' }} – {{ $e['ano_fim'] ?? '—' }})
                            </li>
                        @empty
                            <li>Nenhuma atividade de extensão cadastrada.</li>
                        @endforelse
                    </ul>


                    <!-- Botão de Download -->
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('curriculums.download', $curriculum->id) }}" class="btn btn-primary">
                            <i class="fa fa-download"></i> Baixar CV Completo em PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Solicitar Contacto -->
            <div class="col-lg-4">
                <div class="card shadow-sm p-4">
                    <h4>Solicitar Contacto</h4>
                    <form action="#">
                        <div class="form-group">
                            <input type="text" class="form-control mb-2" placeholder="Seu nome" required>
                            <input type="email" class="form-control mb-2" placeholder="Seu email" required>
                            <input type="text" class="form-control mb-2" placeholder="Telefone" required>
                            <textarea class="form-control mb-2" rows="3" placeholder="Mensagem"></textarea>
                        </div>
                        <button class="btn btn-primary w-100">Enviar Pedido</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection