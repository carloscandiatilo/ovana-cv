<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvPublicController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\Curriculum;
use App\Models\News;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Últimos currículos
    $curriculums = Curriculum::orderBy('id', 'desc')->take(5)->get();

    // Todas as categorias
    $allCategories = Category::orderBy('name')->get();

    // Notícias publicadas
    $publishedNews = News::with('category', 'user')
        ->where('published', true)
        ->orderBy('created_at', 'desc')
        ->get();

    // Agrupando notícias por categoria (para Whats New)
    $groupedNews = [];
    foreach ($allCategories as $category) {
        $newsOfCategory = $publishedNews->filter(function ($news) use ($category) {
            return $news->category_id === $category->id;
        })->values();

        // Paginador manual: 5 notícias por aba
        $currentPage = request()->get("page_{$category->id}", 1);
        $perPage = 5;
        $paginatedNews = new LengthAwarePaginator(
            $newsOfCategory->forPage($currentPage, $perPage),
            $newsOfCategory->count(),
            $perPage,
            $currentPage,
            ['path' => url('/'), 'pageName' => "page_{$category->id}"]
        );

        $groupedNews[$category->id] = $paginatedNews;
    }

    // Notícias de destaque (para Trending Area) -> apenas publicadas e marcadas como destaque
    $destaqueNews = News::with('category', 'user')
        ->where('published', true)
        ->where('isdestaque', true)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('home', compact('curriculums', 'allCategories', 'groupedNews', 'destaqueNews'));
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Download de currículos
Route::get('/curriculums/{id}/download', [CvPublicController::class, 'download'])->name('curriculums.download');


// Página de perfil público
Route::get('/procurar-pefil', function () {
    return view('procurar-pefil');
});

Route::get('/sobre', function () {
    return view('partials.sobre');
})->name('sobre');

Route::get('/contacto', function () {
    return view('partials.contacto');
})->name('contacto');


// Página de teste
Route::get('/curriculum', [CvPublicController::class, 'index']);
Route::get('/candidatos/{id}', [CvPublicController::class, 'show'])->name('candidatos.show');


// Página de notícia individual
Route::get('/noticia/{id}', function ($id) {
    $news = News::with('user', 'category')->findOrFail($id);
    return view('partials.show', compact('news')); // corrigido para partials.show
})->name('news.show');

// API de clima
Route::get('/weather', function () {
    $response = Http::get('https://api.open-meteo.com/v1/forecast', [
        'latitude' => -8.8383,
        'longitude' => 13.2344,
        'current_weather' => true,
    ]);

    if ($response->successful()) {
        $data = $response->json();
        return response()->json([
            'city' => 'Luanda',
            'temp' => $data['current_weather']['temperature'] ?? null,
        ]);
    }

    return response()->json(['error' => 'Não foi possível carregar o tempo'], 500);
});



require __DIR__.'/auth.php';
