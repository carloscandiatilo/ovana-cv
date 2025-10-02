<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvPublicController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\Curriculum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Remova a rota duplicada e mantenha apenas esta:
Route::get('/ok', [CvPublicController::class, 'index']);
Route::get('/', function () {
    return view('home');
});

Route::get('/procurar-pefil', function () {
    return view('procurar-pefil');
});

Route::get('/curriculums/{id}/download', [CvPublicController::class, 'download'])->name('curriculums.download');
Route::get('/', function () {
    $curriculums = Curriculum::orderBy('id', 'desc')
        ->take(5) // pega os 5 mais procurados
        ->get();

    return view('home', compact('curriculums'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/weather', function () {
    $response = Http::get('https://api.open-meteo.com/v1/forecast', [
        'latitude' => -8.8383,   // Luanda
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