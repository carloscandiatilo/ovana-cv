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

        // 🔍 Filtro por nome
        if ($request->filled('nome')) {
            $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(pessoal, '$.nome'))) LIKE ?", [
                '%' . strtolower($request->nome) . '%'
            ]);
        }

        // 📍 Filtro por província
        if ($request->filled('provincia')) {
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(pessoal, '$.endereco_provincia')) = ?", [
                $request->provincia
            ]);
        }

        // 🎓 Filtro por nível (grau acadêmico)
        if ($request->filled('nivel')) {
            $query->whereRaw("JSON_CONTAINS(formacoes_academicas, ?)", [
                json_encode(['grau_academico' => $request->nivel])
            ]);
        }

        // Paginação com query string mantida
        $curriculums = $query->paginate(12)->withQueryString();

        // (opcional) Estatísticas de níveis para a sidebar
        $contagensNiveis = [
            'Licenciatura' => Curriculum::aprovado()->whereRaw("JSON_CONTAINS(formacoes_academicas, ?)", [json_encode(['grau_academico' => 'Licenciatura'])])->count(),
            'Mestrado'     => Curriculum::aprovado()->whereRaw("JSON_CONTAINS(formacoes_academicas, ?)", [json_encode(['grau_academico' => 'Mestrado'])])->count(),
            'Doutoramento' => Curriculum::aprovado()->whereRaw("JSON_CONTAINS(formacoes_academicas, ?)", [json_encode(['grau_academico' => 'Doutoramento'])])->count(),
        ];

        return view('welcome', compact('curriculums', 'contagensNiveis'));
    }

    public function show($id)
    {
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

        $decodeJson = fn($v) => is_array($v) ? $v : (json_decode($v, true) ?: []);

        return view('curriculums.show', [
            'curriculum' => $curriculum,
            'pessoal' => $decodeJson($curriculum->pessoal),
            'formacoes' => $decodeJson($curriculum->formacoes_academicas),
            'formacoes_complementares' => $decodeJson($curriculum->formacoes_complementares),
            'premios' => $decodeJson($curriculum->premios),
            'actuacoes_profissionais' => $decodeJson($curriculum->actuacoes_profissionais),
            'actuacoes_docencias' => $decodeJson($curriculum->actuacoes_docencias),
            'investigacoes_cientificas' => $decodeJson($curriculum->investigacoes_cientificas),
            'extensoes_universitarias' => $decodeJson($curriculum->extensoes_universitarias),
            'captacoes_financiamentos' => $decodeJson($curriculum->captacoes_financiamentos),
            'competencias' => $decodeJson($curriculum->competencias),
            'experiencias' => $decodeJson($curriculum->experiencias_profissionais),
        ]);
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
