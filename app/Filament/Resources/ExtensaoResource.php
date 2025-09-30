<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class ExtensaoResource
{
    public static function getFormSchema(): array
    {
        return [
            Section::make('Produção Normativa')
                ->description('Registos de produção normativa')
                ->collapsed()
                ->schema([
                    Repeater::make('producaonormativas')
                        ->relationship('producaonormativas')
                        ->schema([
                            Select::make('tipo_contribuicao')
                                ->label('Tipo de Contribuição')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Participação na elaboração de projecto legislativo internacional'=>'Participação na elaboração de projecto legislativo internacional',
                                    'Participação na elaboração de norma técnica internacional'=>'Participação na elaboração de norma técnica internacional',
                                    'Participação na elaboração de projecto legislativo nacional'=>'Participação na elaboração de projecto legislativo nacional',
                                    'Participação na elaboração de norma técnica nacional'=>'Participação na elaboração de norma técnica nacional',
                                    'Participação na elaboração de projecto curricular de curso de graduação ou de pós-graduação'=>'Participação na elaboração de projecto curricular de curso de graduação ou de pós-graduação',
                                    'Participação na elaboração de regulamento ao nível da IES/Unidade Orgânica'=>'Participação na elaboração de regulamento ao nível da IES/Unidade Orgânica',
                                    'Participação na elaboração de parte de um plano curricular'=>'Participação na elaboração de parte de um plano curricular',
                                    'Emissão de parecer científico sobre projectos de diplomas legais'=>'Emissão de parecer científico sobre projectos de diplomas legais',
                                    'Participação na elaboração de documento normativo orientador'=>'Participação na elaboração de documento normativo orientador',
                                    'Participação na elaboração de Estatuto ou Regulamento Interno'=>'Participação na elaboração de Estatuto ou Regulamento Interno',
                                ]),
                            TextInput::make('nome_projecto')->required(),
                            TextInput::make('curso'),
                            TextInput::make('natureza'),
                            TextInput::make('area'),
                            TextInput::make('instituicao'),
                            TextInput::make('orgao_tutela'),
                            TextInput::make('funcao'),
                            TextInput::make('ano')->type('number')->minValue(1900)->maxValue(date('Y'))->minLength(4)->maxLength(4),
                        ])
                        ->columns(2),
                ]),

            Section::make('Prestação de Serviço')
                ->description('Registos de prestação de serviço')
                ->collapsed()
                ->schema([
                    Repeater::make('prestacaoservicos')
                        ->relationship('prestacaoservicos')
                        ->schema([
                            Select::make('tipo_acao')
                                ->label('Tipo de Ação')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Incubação e formação de empresa de base tecnológica'=>'Incubação e formação de empresa de base tecnológica',
                                    'Recebimento de pagamento (Royalties) de propriedade industrial'=>'Recebimento de pagamento (Royalties) de propriedade industrial',
                                    'Direitos de Autor (ex. livros ou software)'=>'Direitos de Autor (ex. livros ou software)',
                                    'Responsável por unidade interna prestadora de serviços'=>'Responsável por unidade interna prestadora de serviços',
                                    'Responsável por consultoria técnico-científica a entidade externa'=>'Responsável por consultoria técnico-científica a entidade externa',
                                    'Responsável por projecto de curso de formação contínua'=>'Responsável por projecto de curso de formação contínua',
                                    'Responsável por formação profissional no âmbito de protocolos'=>'Responsável por formação profissional no âmbito de protocolos',
                                    'Formador, no âmbito de protocolos de cooperação'=>'Formador, no âmbito de protocolos de cooperação',
                                    'Ministração de um módulo de curso avançado de curta duração'=>'Ministração de um módulo de curso avançado de curta duração',
                                    'Participação em projecto, processo ou unidade de prestação de serviços'=>'Participação em projecto, processo ou unidade de prestação de serviços',
                                    'Participação em consultoria técnico-científica'=>'Participação em consultoria técnico-científica',
                                    'Participação em acções educativas na comunidade'=>'Participação em acções educativas na comunidade',
                                    'Ministração de módulos de cursos de capacitação docente'=>'Ministração de módulos de cursos de capacitação docente',
                                    'Membro de júri de elaboração e de correcção de exame de acesso ao ensino superior'=>'Membro de júri de elaboração e de correcção de exame de acesso ao ensino superior',
                                    'Responsável por divulgação científica nos meios de comunicação social'=>'Responsável por divulgação científica nos meios de comunicação social',
                                    'Participante em formação profissional no âmbito de protocolos'=>'Participante em formação profissional no âmbito de protocolos',
                                ]),
                            TextInput::make('nome_projecto')->required(),
                            TextInput::make('curso'),
                            TextInput::make('equipa'),
                            TextInput::make('instituicao'),
                            TextInput::make('instituicao_parceira'),
                            TextInput::make('coordenador_projecto'),
                            DatePicker::make('inicio')->required(),
                            DatePicker::make('fim')
                                ->required()
                                ->rule(fn($get) => $get('fim') >= $get('inicio')),
                        ])
                        ->columns(2),
                ]),

            Section::make('Interação com Comunidade')
                ->description('Registos de interação com a comunidade')
                ->collapsed()
                ->schema([
                    Repeater::make('interaccoescomunidade')
                        ->relationship('interaccoescomunidade')
                        ->schema([
                            Select::make('tipo_realizacao')
                                ->label('Tipo de Realização')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Realização de projectos de cariz social e de desenvolvimento comunitário'=>'Realização de projectos de cariz social e de desenvolvimento comunitário',
                                    'Responsável por estrutura de coordenação da actividade de extensão na IES'=>'Responsável por estrutura de coordenação da actividade de extensão na IES',
                                    'Responsável por estrutura de coordenação da actividade de extensão na Unidade Orgânica'=>'Responsável por estrutura de coordenação da actividade de extensão na Unidade Orgânica',
                                    'Realização de acções de animação de rua com públicos diferenciados'=>'Realização de acções de animação de rua com públicos diferenciados',
                                    'Realização de actividades de divulgação da oferta formativa em escolas secundárias'=>'Realização de actividades de divulgação da oferta formativa em escolas secundárias',
                                    'Organização de eventos culturais na instituição'=>'Organização de eventos culturais na instituição',
                                    'Realização de actividades de voluntariado na comunidade'=>'Realização de actividades de voluntariado na comunidade',
                                    'Realização de consultas gratuitas à comunidade'=>'Realização de consultas gratuitas à comunidade',
                                    'Realização de palestras educativas e ou de cursos de extensão universitária'=>'Realização de palestras educativas e ou de cursos de extensão universitária',
                                    'Organização de eventos culturais e/ou desportivos fora da instituição'=>'Organização de eventos culturais e/ou desportivos fora da instituição',
                                    'Participação em actividades de vária natureza organizadas por entidades da comunidade'=>'Participação em actividades de vária natureza organizadas por entidades da comunidade',
                                    'Integração em associações sociais de vária natureza'=>'Integração em associações sociais de vária natureza',
                                ]),
                            TextInput::make('nome_projecto')->required(),
                            TextInput::make('estrutura'),
                            TextInput::make('equipa'),
                            TextInput::make('funcao'),
                            TextInput::make('local_realizacao'),
                            TextInput::make('instituicao'),
                            TextInput::make('instituicoes_envolvidas'),
                            DatePicker::make('inicio')->required(),
                            DatePicker::make('fim')
                                ->required()
                                ->rule(fn($get) => $get('fim') >= $get('inicio')),
                        ])
                        ->columns(2),
                ]),

            Section::make('Mobilização de Agente')
                ->description('Registos de mobilização de agentes')
                ->collapsed()
                ->schema([
                    Repeater::make('mobilizacoesagente')
                        ->relationship('mobilizacoesagente')
                        ->schema([
                            Select::make('tipo_acao')
                                ->label('Tipo de Ação')
                                ->required()
                                ->searchable()
                                ->options([
                                    'Criação de condições para assinatura de protocolo de parceria'=>'Criação de condições para assinatura de protocolo de parceria',
                                    'Organização e acompanhamento de estagiários em contextos de trabalho'=>'Organização e acompanhamento de estagiários em contextos de trabalho',
                                    'Organização de acções de formação em colaboração com parceiros sociais'=>'Organização de acções de formação em colaboração com parceiros sociais',
                                    'Realização de visitas de estudo a contextos reais em colaboração com entidades externas'=>'Realização de visitas de estudo a contextos reais em colaboração com entidades externas',
                                    'Criação de mecanismos para utilização de infra-estrutura e equipamentos sociais'=>'Criação de mecanismos para utilização de infra-estrutura e equipamentos sociais',
                                    'Preparação de condições para formalização de uma parceria'=>'Preparação de condições para formalização de uma parceria',
                                    'Mobilização de entidades para a organização conjunta de certames académicos ou culturais'=>'Mobilização de entidades para a organização conjunta de certames académicos ou culturais',
                                    'Mobilização de órgãos de comunicação social para realização de programas de interesse científico'=>'Mobilização de órgãos de comunicação social para realização de programas de interesse científico',
                                ]),
                            TextInput::make('instituicao_parceira'),
                            TextInput::make('local_actividade'),
                            TextInput::make('nome_mecanismo'),
                            TextInput::make('ano')->type('number')->minValue(1900)->maxValue(date('Y'))->minLength(4)->maxLength(4),
                            TextInput::make('coordenador_protocolo'),
                            TextInput::make('instituicao'),
                            DatePicker::make('inicio')->required(),
                            DatePicker::make('fim')
                                ->required()
                                ->rule(fn($get) => $get('fim') >= $get('inicio')),
                            TextInput::make('instituicoes_envolvidas'),
                        ])
                        ->columns(2),
                ]),
        ];
    }
}
