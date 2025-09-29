<?php
namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;

class CvPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Curriculum::aprovado()->with('user');

        if ($request->nome) {
            $query->whereJsonContains('pessoal->nome', $request->nome);
        }
        if ($request->pais) {
            $query->whereJsonContains('pessoal->endereco_pais', $request->pais);
        }
        if ($request->grau) {
            $query->whereJsonContains('formacoes_academicas', ['grau_academico' => $request->grau]);
        }

        $curriculums = $query->paginate(12);

        $paises = ['Angola', 'Brazil', /* ... */];

        return view('welcome', compact('curriculums', 'paises'));
    }
}