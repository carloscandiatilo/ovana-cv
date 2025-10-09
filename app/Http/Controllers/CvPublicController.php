<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Curriculum::aprovado()->with('user');

        if ($request->filled('nome')) {
            $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(pessoal, '$.nome'))) LIKE ?", [
                '%' . strtolower($request->nome) . '%'
            ]);
        }

        if ($request->filled('pais')) {
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(pessoal, '$.endereco_pais')) = ?", [
                $request->pais
            ]);
        }

        if ($request->filled('grau')) {
            $query->whereRaw("JSON_CONTAINS(formacoes_academicas, ?)", [
                json_encode(['grau_academico' => $request->grau])
            ]);
        }

        $curriculums = $query->paginate(12)->withQueryString();

        $paises = Curriculum::aprovado()
            ->selectRaw("DISTINCT JSON_UNQUOTE(JSON_EXTRACT(pessoal, '$.endereco_pais')) as pais")
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(pessoal, '$.endereco_pais')) IS NOT NULL")
            ->pluck('pais')
            ->filter()
            ->sort()
            ->values()
            ->toArray();

        return view('welcome', compact('curriculums', 'paises'));
    }

    public function show($id)
{
    // Carrega o currículo com todos os relacionamentos usados no PDF
    $curriculum = Curriculum::aprovado()
        ->with([
            'user',
            'idiomas',
            'material_pedagogicos',
            'orientacao_estudantes',
            'responsabilidade_orientacoes',
            'leccionacoes',
            'infraestrutura_ensinos',
            'producaocientificas',
            'producaotecnologicas',
            'projectoinvestigacaos',
            'infraestruturasinvestigacaos',
            'reconhecimentocomunidadecientificos',
            'producaonormativas',
            'prestacaoservicos',
            'interaccoescomunidade',
            'mobilizacoesagente',
            'cargounidadeorganicas',
            'cargonivelunidades',
            'cargotarefastemporarias',
            'cargoorgaosexternos',
        ])
        ->findOrFail($id);

    // Função auxiliar para decodificar JSON com segurança
    $decodeJson = function ($value) {
        if (is_null($value)) return [];
        if (is_array($value)) return $value;
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    };

    // Decodifica todos os campos JSON usados no PDF
    $pessoal = $decodeJson($curriculum->pessoal);
    $formacoes = $decodeJson($curriculum->formacoes_academicas);
    $formacoes_complementares = $decodeJson($curriculum->formacoes_complementares);
    $premios = $decodeJson($curriculum->premios);
    $actuacoes_profissionais = $decodeJson($curriculum->actuacoes_profissionais);
    $actuacoes_docencias = $decodeJson($curriculum->actuacoes_docencias);
    $investigacoes_cientificas = $decodeJson($curriculum->investigacoes_cientificas);
    $extensoes_universitarias = $decodeJson($curriculum->extensoes_universitarias);
    $captacoes_financiamentos = $decodeJson($curriculum->captacoes_financiamentos);
    $competencias = $decodeJson($curriculum->competencias);
    $experiencias = $decodeJson($curriculum->experiencias_profissionais); // já usado

    return view('curriculums.show', compact(
        'curriculum',
        'pessoal',
        'formacoes',
        'formacoes_complementares',
        'premios',
        'actuacoes_profissionais',
        'actuacoes_docencias',
        'investigacoes_cientificas',
        'extensoes_universitarias',
        'captacoes_financiamentos',
        'competencias',
        'experiencias'
    ));
}

    public function download($id)
    {
        $curriculum = Curriculum::aprovado()->findOrFail($id);

        $pdfPath = "curriculums/{$curriculum->id}.pdf";

        if (!Storage::disk('public')->exists($pdfPath)) {
            abort(404, 'PDF do currículo não encontrado.');
        }

        return response()->download(storage_path("app/public/{$pdfPath}"), "curriculo-{$curriculum->id}.pdf");
    }
}
