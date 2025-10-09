<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Curriculum Completo - {{ $curriculum->pessoal['nome'] ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 9pt;
            line-height: 1.4;
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #2d3748;
            font-size: 18pt;
        }
        h2 {
            margin-top: 25px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #4299e1;
            color: #2b6cb0;
            font-size: 14pt;
        }
        h3 {
            margin-top: 18px;
            margin-bottom: 10px;
            color: #4a5568;
            font-size: 12pt;
        }
        .section, .subsection {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            page-break-inside: avoid;
        }
        th, td {
            border: 1px solid #cbd5e0;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #ebf8ff;
            font-weight: bold;
        }
        .empty {
            color: #a0aec0;
            font-style: italic;
        }
        .field-row {
            display: flex;
            margin-bottom: 4px;
        }
        .field-label {
            font-weight: bold;
            width: 200px;
            flex-shrink: 0;
        }
        .field-value {
            flex: 1;
        }
    </style>
</head>
<body>
    <h1>CURRICULUM VITAE OVANA</h1>

    <!-- =============== ETAPA 1: DADOS PESSOAIS =============== -->
    <div class="section">
        <h2>Dados Pessoais</h2>

        <div class="field-row">
            <div class="field-label">Nome Completo:</div>
            <div class="field-value">{{ $curriculum->pessoal['nome'] ?? '-' }} {{ $curriculum->pessoal['nome_do_meio'] ?? '' }} {{ $curriculum->pessoal['apelido'] ?? '' }}</div>
        </div>
        <div class="field-row">
            <div class="field-label">ORCID:</div>
            <div class="field-value">{{ $curriculum->pessoal['orcid'] ?? '-' }}</div>
        </div>
        <div class="field-row">
            <div class="field-label">Instituição:</div>
            <div class="field-value">{{ $curriculum->pessoal['instituicao_nome'] ?? '-' }}</div>
        </div>
        <div class="field-row">
            <div class="field-label">Endereço:</div>
            <div class="field-value">{{ $curriculum->pessoal['endereco_rua_bairro'] ?? '-' }}, {{ $curriculum->pessoal['endereco_municipio'] ?? '-' }}, {{ $curriculum->pessoal['endereco_pais'] ?? '-' }}</div>
        </div>
        <div class="field-row">
            <div class="field-label">Website:</div>
            <div class="field-value">{{ $curriculum->pessoal['website'] ?? '-' }}</div>
        </div>
        <div class="field-row">
            <div class="field-label">E-mail Pessoal:</div>
            <div class="field-value">{{ $curriculum->pessoal['email_pessoal'] ?? '-' }}</div>
        </div>
        <div class="field-row">
            <div class="field-label">E-mail Profissional:</div>
            <div class="field-value">{{ $curriculum->pessoal['email_profissional'] ?? '-' }}</div>
        </div>

        <!-- Idiomas -->
        <h3>Idiomas</h3>
        @if($curriculum->idiomas->isNotEmpty())
            <ul style="margin-top: 4px; margin-left: 20px;">
                @foreach($curriculum->idiomas as $idioma)
                    <li>{{ $idioma->nome }}</li>
                @endforeach
            </ul>
        @else
            <p class="empty">Nenhum idioma registrado.</p>
        @endif
    </div>

    <!-- =============== ETAPA 2: ENSINO =============== -->
    <div class="section">
        <h2>Ensino</h2>

        <!-- Formações Acadêmicas (array) -->
        <h3>Formações Acadêmicas</h3>
        @if(!empty($curriculum->formacoes_academicas))
            <table>
                <thead>
                    <tr>
                        <th>Grau</th><th>Instituição</th><th>Ano Início</th><th>Ano Conclusão</th><th>Título</th><th>Orientador</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->formacoes_academicas as $f)
                        <tr>
                            <td>{{ $f['grau_academico'] ?? '-' }}</td>
                            <td>{{ $f['instituicao_formacao'] ?? '-' }}</td>
                            <td>{{ $f['ano_inicio'] ?? '-' }}</td>
                            <td>{{ $f['ano_conclusao'] ?? '-' }}</td>
                            <td>{{ $f['titulo_monografia'] ?? '-' }}</td>
                            <td>{{ $f['nome_orientador'] ?? '-' }}</td>
                            <td>{{ $f['pais'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma formação acadêmica registrada.</p>
        @endif

        <!-- Formações Complementares -->
        <h3>Formações Complementares</h3>
        @if(!empty($curriculum->formacoes_complementares))
            <table>
                <thead>
                    <tr>
                        <th>Curso</th><th>Instituição</th><th>Ano</th><th>Carga Horária</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->formacoes_complementares as $f)
                        <tr>
                            <td>{{ $f['nome_curso'] ?? '-' }}</td>
                            <td>{{ $f['instituicao_formacao'] ?? '-' }}</td>
                            <td>{{ $f['ano_conclusao'] ?? '-' }}</td>
                            <td>{{ ($f['carga_horaria'] ?? 0) ? $f['carga_horaria'] . ' h' : '-' }}</td>
                            <td>{{ $f['pais'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma formação complementar registrada.</p>
        @endif

        <!-- Prêmios -->
        <h3>Prêmios</h3>
        @if(!empty($curriculum->premios))
            <table>
                <thead>
                    <tr>
                        <th>Premiação</th><th>Instituição</th><th>Ano</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->premios as $p)
                        <tr>
                            <td>{{ $p['nome_premiacao'] ?? '-' }}</td>
                            <td>{{ $p['instituicao'] ?? '-' }}</td>
                            <td>{{ $p['ano_atribuicao'] ?? '-' }}</td>
                            <td>{{ $p['pais'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum prêmio registrado.</p>
        @endif

        <!-- Atuação Profissional -->
        <h3>Atuação Profissional</h3>
        @if(!empty($curriculum->actuacoes_profissionais))
            <table>
                <thead>
                    <tr>
                        <th>Instituição</th><th>Vínculo</th><th>Função</th><th>Ano Início</th><th>Ano Fim</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->actuacoes_profissionais as $a)
                        <tr>
                            <td>{{ $a['instituicao'] ?? '-' }}</td>
                            <td>{{ $a['tipo_vinculo'] ?? '-' }}</td>
                            <td>{{ $a['funcao'] ?? '-' }}</td>
                            <td>{{ $a['ano_inicio'] ?? '-' }}</td>
                            <td>{{ $a['ano_fim'] ?? '-' }}</td>
                            <td>{{ $a['pais'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma atuação profissional registrada.</p>
        @endif

        <!-- Docência -->
        <h3>Docência</h3>
        @if(!empty($curriculum->actuacoes_docencias))
            <table>
                <thead>
                    <tr>
                        <th>País</th><th>Instituição</th><th>Disciplina</th><th>Carga Horária</th><th>Ano</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->actuacoes_docencias as $d)
                        <tr>
                            <td>{{ $d['pais'] ?? '-' }}</td>
                            <td>{{ $d['instituicao'] ?? '-' }}</td>
                            <td>{{ $d['disciplina'] ?? '-' }}</td>
                            <td>{{ ($d['carga_horaria'] ?? 0) ? $d['carga_horaria'] . ' h' : '-' }}</td>
                            <td>{{ $d['ano'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma docência registrada.</p>
        @endif

        <!-- Material Pedagógico (relacionamento) -->
        <h3>Material Pedagógico</h3>
        @if($curriculum->material_pedagogicos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Ano</th><th>Coautor</th><th>Registro</th><th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->material_pedagogicos as $m)
                        <tr>
                            <td>{{ $m->tipo_material }}</td>
                            <td>{{ $m->ano_publicacao }}</td>
                            <td>{{ $m->coautor }}</td>
                            <td>{{ $m->registro }}</td>
                            <td>{{ $m->link }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum material pedagógico registrado.</p>
        @endif

        <!-- Orientação de Estudantes -->
        <h3>Orientação de Estudantes</h3>
        @if($curriculum->orientacao_estudantes->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>País</th><th>Tipo</th><th>Estudante</th><th>Ano Conclusão</th><th>Instituição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->orientacao_estudantes as $o)
                        <tr>
                            <td>{{ $o->pais }}</td>
                            <td>{{ $o->tipo_orientacao }}</td>
                            <td>{{ $o->nome_estudante }}</td>
                            <td>{{ $o->ano_conclusao }}</td>
                            <td>{{ $o->instituicao }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma orientação registrada.</p>
        @endif

        <!-- Responsabilidade de Orientação -->
        <h3>Responsabilidade de Orientação</h3>
        @if($curriculum->responsabilidade_orientacoes->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>País</th><th>Tipo</th><th>Estudante</th><th>Ano Conclusão</th><th>Instituição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->responsabilidade_orientacoes as $r)
                        <tr>
                            <td>{{ $r->pais }}</td>
                            <td>{{ $r->tipo_responsabilidade }}</td>
                            <td>{{ $r->nome_estudante }}</td>
                            <td>{{ $r->ano_conclusao }}</td>
                            <td>{{ $r->instituicao }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma responsabilidade registrada.</p>
        @endif

        <!-- Leccionação -->
        <h3>Leccionação de Unidades Curriculares</h3>
        @if($curriculum->leccionacoes->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Disciplina</th><th>Ano</th><th>Instituição</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->leccionacoes as $l)
                        <tr>
                            <td>{{ $l->tipo_participacao }}</td>
                            <td>{{ $l->disciplina }}</td>
                            <td>{{ $l->ano }}</td>
                            <td>{{ $l->instituicao }}</td>
                            <td>{{ $l->pais }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma leccionação registrada.</p>
        @endif

        <!-- Infraestrutura de Ensino -->
        <h3>Infraestrutura de Apoio ao Ensino</h3>
        @if($curriculum->infraestrutura_ensinos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Laboratório/Plataforma</th><th>Registro</th><th>Ano</th><th>Instituição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->infraestrutura_ensinos as $i)
                        <tr>
                            <td>{{ $i->tipo_infraestrutura }}</td>
                            <td>{{ $i->nome_lab_plataforma }}</td>
                            <td>{{ $i->registro_responsavel }}</td>
                            <td>{{ $i->ano }}</td>
                            <td>{{ $i->instituicao }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma infraestrutura registrada.</p>
        @endif
    </div>

    <!-- =============== ETAPA 3: INVESTIGAÇÃO CIENTÍFICA =============== -->
    <div class="section">
        <h2>Investigação Científica</h2>

        <!-- Investigação Científica (array) -->
        <h3>Projetos de Investigação (Array)</h3>
        @if(!empty($curriculum->investigacoes_cientificas))
            @foreach($curriculum->investigacoes_cientificas as $inv)
                <div style="margin-bottom: 12px; padding-left: 10px; border-left: 2px solid #cbd5e0;">
                    <strong>Projeto:</strong> {{ $inv['titulo_projeto'] ?? '-' }}<br>
                    <strong>Instituição:</strong> {{ $inv['instituicao'] ?? '-' }}<br>
                    <strong>Linha:</strong> {{ $inv['linha_investigacao'] ?? '-' }}<br>
                    <strong>Período:</strong> {{ $inv['ano_inicio'] ?? '-' }} – {{ $inv['ano_fim'] ?? '-' }}<br>
                    <strong>Financiador:</strong> {{ $inv['financiador'] ?? '-' }}<br>
                    <strong>Membros:</strong>
                    @if(!empty($inv['membros_equipa']))
                        <ul style="margin-top: 4px; margin-left: 20px;">
                            @foreach($inv['membros_equipa'] as $m)
                                <li>{{ $m['nome'] ?? '-' }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span>-</span>
                    @endif
                </div>
            @endforeach
        @else
            <p class="empty">Nenhum projeto de investigação registrado.</p>
        @endif

        <!-- Produção Científica -->
        <h3>Produção Científica</h3>
        @if($curriculum->producaocientificas->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Título</th><th>Ano</th><th>Coautor</th><th>Registro</th><th>Editora</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->producaocientificas as $p)
                        <tr>
                            <td>{{ $p->tipo_producao }}</td>
                            <td>{{ $p->titulo }}</td>
                            <td>{{ $p->ano_publicacao }}</td>
                            <td>{{ $p->coautor }}</td>
                            <td>{{ $p->registro }}</td>
                            <td>{{ $p->editora }}</td>
                            <td>{{ $p->pais }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma produção científica registrada.</p>
        @endif

        <!-- Produção Tecnológica -->
        <h3>Produção Tecnológica</h3>
        @if($curriculum->producaotecnologicas->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Nome</th><th>Ano</th><th>Coautor</th><th>Registro</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->producaotecnologicas as $t)
                        <tr>
                            <td>{{ $t->tipo_producao }}</td>
                            <td>{{ $t->nome_producao }}</td>
                            <td>{{ $t->ano }}</td>
                            <td>{{ $t->coautor }}</td>
                            <td>{{ $t->registro }}</td>
                            <td>{{ $t->pais }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma produção tecnológica registrada.</p>
        @endif

        <!-- Projetos de Investigação (relacionamento) -->
        <h3>Projetos de Investigação (Relacionamento)</h3>
        @if($curriculum->projectoinvestigacaos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Projeto</th><th>Objetivo</th><th>Instituição</th><th>Ano Início</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->projectoinvestigacaos as $proj)
                        <tr>
                            <td>{{ $proj->tipo_participacao }}</td>
                            <td>{{ $proj->nome_projecto }}</td>
                            <td>{{ $proj->objectivo }}</td>
                            <td>{{ $proj->instituicao }}</td>
                            <td>{{ $proj->inicio }}</td>
                            <td>{{ $proj->pais }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum projeto de investigação (relacionamento) registrado.</p>
        @endif

        <!-- Infraestrutura de Investigação -->
        <h3>Infraestrutura de Investigação</h3>
        @if($curriculum->infraestruturasinvestigacaos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Instituição</th><th>Tipo</th><th>Laboratório</th><th>Responsável</th><th>Registro</th><th>Ano</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->infraestruturasinvestigacaos as $infra)
                        <tr>
                            <td>{{ $infra->instituicao }}</td>
                            <td>{{ $infra->tipo_infraestrutura }}</td>
                            <td>{{ $infra->laboratorio }}</td>
                            <td>{{ $infra->nome_responsavel }}</td>
                            <td>{{ $infra->registro }}</td>
                            <td>{{ $infra->ano }}</td>
                            <td>{{ $infra->pais }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma infraestrutura de investigação registrada.</p>
        @endif

        <!-- Reconhecimento Científico -->
        <h3>Reconhecimento na Comunidade Científica</h3>
        @if($curriculum->reconhecimentocomunidadecientificos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Reconhecimento</th><th>Entidade</th><th>Classificação</th><th>Prémio</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->reconhecimentocomunidadecientificos as $rec)
                        <tr>
                            <td>{{ $rec->tipo_reconhecimento }}</td>
                            <td>{{ $rec->reconhecimento }}</td>
                            <td>{{ $rec->entidade_responsavel }}</td>
                            <td>{{ $rec->classificacao }}</td>
                            <td>{{ $rec->tipo_premio }}</td>
                            <td>{{ $rec->pais }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum reconhecimento registrado.</p>
        @endif
    </div>

    <!-- =============== ETAPA 4: EXTENSÃO =============== -->
    <div class="section">
        <h2>Extensão</h2>

        <!-- Extensão Universitária (array) -->
        <h3>Extensão Universitária (Array)</h3>
        @if(!empty($curriculum->extensoes_universitarias))
            <table>
                <thead>
                    <tr>
                        <th>Projeto</th><th>Instituição</th><th>Equipa</th><th>Ano Início</th><th>Ano Fim</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->extensoes_universitarias as $e)
                        <tr>
                            <td>{{ $e['projeto_extensao'] ?? '-' }}</td>
                            <td>{{ $e['instituicao'] ?? '-' }}</td>
                            <td>{{ $e['membros_equipa'] ?? '-' }}</td>
                            <td>{{ $e['ano_inicio'] ?? '-' }}</td>
                            <td>{{ $e['ano_fim'] ?? '-' }}</td>
                            <td>{{ $e['pais'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma extensão universitária registrada.</p>
        @endif

        <!-- Captação de Financiamento -->
        <h3>Captação de Financiamento</h3>
        @if(!empty($curriculum->captacoes_financiamentos))
            <table>
                <thead>
                    <tr>
                        <th>Projeto</th><th>Instituição</th><th>Natureza</th><th>Ano Início</th><th>Ano Fim</th><th>Valor</th><th>País</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->captacoes_financiamentos as $c)
                        <tr>
                            <td>{{ $c['nome_projeto'] ?? '-' }}</td>
                            <td>{{ $c['instituicao'] ?? '-' }}</td>
                            <td>{{ $c['natureza_projeto'] ?? '-' }}</td>
                            <td>{{ $c['ano_inicio'] ?? '-' }}</td>
                            <td>{{ $c['ano_fim'] ?? '-' }}</td>
                            <td>{{ $c['valor_arrecadado'] ?? '-' }}</td>
                            <td>{{ $c['pais'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma captação registrada.</p>
        @endif

        <!-- Produção Normativa -->
        <h3>Produção Normativa</h3>
        @if($curriculum->producaonormativas->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Projeto</th><th>Curso</th><th>Natureza</th><th>Área</th><th>Instituição</th><th>Órgão Tutela</th><th>Função</th><th>Ano</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->producaonormativas as $n)
                        <tr>
                            <td>{{ $n->tipo_contribuicao }}</td>
                            <td>{{ $n->nome_projecto }}</td>
                            <td>{{ $n->curso }}</td>
                            <td>{{ $n->natureza }}</td>
                            <td>{{ $n->area }}</td>
                            <td>{{ $n->instituicao }}</td>
                            <td>{{ $n->orgao_tutela }}</td>
                            <td>{{ $n->funcao }}</td>
                            <td>{{ $n->ano }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma produção normativa registrada.</p>
        @endif

        <!-- Prestação de Serviço -->
        <h3>Prestação de Serviço</h3>
        @if($curriculum->prestacaoservicos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Projeto</th><th>Curso</th><th>Equipa</th><th>Instituição</th><th>Parceira</th><th>Coordenador</th><th>Ano Início</th><th>Ano Fim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->prestacaoservicos as $s)
                        <tr>
                            <td>{{ $s->tipo_acao }}</td>
                            <td>{{ $s->nome_projecto }}</td>
                            <td>{{ $s->curso }}</td>
                            <td>{{ $s->equipa }}</td>
                            <td>{{ $s->instituicao }}</td>
                            <td>{{ $s->instituicao_parceira }}</td>
                            <td>{{ $s->coordenador_projecto }}</td>
                            <td>{{ $s->inicio }}</td>
                            <td>{{ $s->fim }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma prestação de serviço registrada.</p>
        @endif

        <!-- Interação com Comunidade -->
        <h3>Interação com Comunidade</h3>
        @if($curriculum->interaccoescomunidade->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Projeto</th><th>Estrutura</th><th>Equipa</th><th>Função</th><th>Local</th><th>Instituição</th><th>Instituições Envolvidas</th><th>Ano Início</th><th>Ano Fim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->interaccoescomunidade as $ic)
                        <tr>
                            <td>{{ $ic->tipo_realizacao }}</td>
                            <td>{{ $ic->nome_projecto }}</td>
                            <td>{{ $ic->estrutura }}</td>
                            <td>{{ $ic->equipa }}</td>
                            <td>{{ $ic->funcao }}</td>
                            <td>{{ $ic->local_realizacao }}</td>
                            <td>{{ $ic->instituicao }}</td>
                            <td>{{ $ic->instituicoes_envolvidas }}</td>
                            <td>{{ $ic->inicio }}</td>
                            <td>{{ $ic->fim }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma interação registrada.</p>
        @endif

        <!-- Mobilização de Agente -->
        <h3>Mobilização de Agente</h3>
        @if($curriculum->mobilizacoesagente->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th><th>Parceira</th><th>Local</th><th>Mecanismo</th><th>Ano</th><th>Coordenador</th><th>Instituição</th><th>Ano Início</th><th>Ano Fim</th><th>Instituições Envolvidas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->mobilizacoesagente as $m)
                        <tr>
                            <td>{{ $m->tipo_acao }}</td>
                            <td>{{ $m->instituicao_parceira }}</td>
                            <td>{{ $m->local_actividade }}</td>
                            <td>{{ $m->nome_mecanismo }}</td>
                            <td>{{ $m->ano }}</td>
                            <td>{{ $m->coordenador_protocolo }}</td>
                            <td>{{ $m->instituicao }}</td>
                            <td>{{ $m->inicio }}</td>
                            <td>{{ $m->fim }}</td>
                            <td>{{ $m->instituicoes_envolvidas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhuma mobilização registrada.</p>
        @endif
    </div>

    <!-- =============== ETAPA 5: GESTÃO =============== -->
    <div class="section">
        <h2>Gestão</h2>

        <!-- Cargo Unidade Orgânica -->
        <h3>Cargo em Unidade Orgânica</h3>
        @if($curriculum->cargounidadeorganicas->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Cargo</th><th>Instituição</th><th>Ano Início</th><th>Ano Fim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->cargounidadeorganicas as $g)
                        <tr>
                            <td>{{ $g->cargo_tipo }}</td>
                            <td>{{ $g->instituicao }}</td>
                            <td>{{ $g->inicio }}</td>
                            <td>{{ $g->fim }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum cargo em unidade orgânica registrado.</p>
        @endif

        <!-- Cargo Nível Unidade -->
        <h3>Cargo a Nível de Unidade</h3>
        @if($curriculum->cargonivelunidades->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Cargo</th><th>Instituição</th><th>Ano Início</th><th>Ano Fim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->cargonivelunidades as $n)
                        <tr>
                            <td>{{ $n->cargo_tipo }}</td>
                            <td>{{ $n->instituicao }}</td>
                            <td>{{ $n->inicio }}</td>
                            <td>{{ $n->fim }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum cargo a nível de unidade registrado.</p>
        @endif

        <!-- Cargo Tarefas Temporárias -->
        <h3>Cargos e Tarefas Temporárias</h3>
        @if($curriculum->cargotarefastemporarias->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Cargo</th><th>Entidade</th><th>Ano Início</th><th>Ano Fim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->cargotarefastemporarias as $t)
                        <tr>
                            <td>{{ $t->cargo_tipo }}</td>
                            <td>{{ $t->entidade }}</td>
                            <td>{{ $t->inicio }}</td>
                            <td>{{ $t->fim }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum cargo temporário registrado.</p>
        @endif

        <!-- Cargo Órgão Externo -->
        <h3>Cargos em Órgãos Externos</h3>
        @if($curriculum->cargoorgaosexternos->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Cargo</th><th>Entidade</th><th>Ano Início</th><th>Ano Fim</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->cargoorgaosexternos as $e)
                        <tr>
                            <td>{{ $e->cargo_tipo }}</td>
                            <td>{{ $e->entidade }}</td>
                            <td>{{ $e->inicio }}</td>
                            <td>{{ $e->fim }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Nenhum cargo externo registrado.</p>
        @endif
    </div>

</body>
</html>