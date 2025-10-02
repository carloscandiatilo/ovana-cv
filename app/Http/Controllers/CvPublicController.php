<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class CvPublicController extends Controller
{
    /**
     * Exibe a lista pública de currículos com filtros.
     */
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

    /**
     * Download do PDF do currículo.
     */
    public function download($id)
    {
        $curriculum = Curriculum::aprovado()->findOrFail($id);

        $pdfPath = "curriculums/{$curriculum->id}.pdf";

        if (!Storage::disk('public')->exists($pdfPath)) {
            abort(404, 'PDF do currículo não encontrado.');
        }

        $pdfContent = Storage::disk('public')->get($pdfPath);
        $fileName = "curriculo-{$curriculum->id}.pdf";

        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }
}
