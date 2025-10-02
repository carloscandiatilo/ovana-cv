<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Curriculum-Ovana') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5', // indigo-600
                        secondary: '#818cf8', // indigo-400
                    }
                }
            }
        }
    </script>

    <!-- Ícones (Heroicons via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.1.1/dist/outline.js"></script>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        body {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col">

        <!-- Header -->
        <header class="bg-white shadow-sm">
            
        </header>

        <!-- Hero -->
        <section class="py-12 bg-gradient-to-r from-indigo-50 to-white">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Explore Currículos Acadêmicos</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Encontre especialistas, pesquisadores e docentes com base em país, grau acadêmico ou nome.
                    Todos os currículos estão disponíveis para download em PDF.
                </p>
            </div>
        </section>

        <!-- Filtros -->
        <section class="py-8 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <form method="GET" action="{{ url('/') }}" class="bg-gray-50 p-6 rounded-xl shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                            <input
                                type="text"
                                name="nome"
                                id="nome"
                                value="{{ request('nome') }}"
                                placeholder="Ex: João Silva"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label for="pais" class="block text-sm font-medium text-gray-700 mb-1">País</label>
                            <select
                                name="pais"
                                id="pais"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                                <option value="">Todos os países</option>
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais }}" @selected(request('pais') === $pais)>
                                        {{ $pais }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="grau" class="block text-sm font-medium text-gray-700 mb-1">Grau Acadêmico</label>
                            <select
                                name="grau"
                                id="grau"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                                <option value="">Todos os graus</option>
                                <option value="Licenciatura" @selected(request('grau') === 'Licenciatura')>Licenciatura</option>
                                <option value="Mestrado" @selected(request('grau') === 'Mestrado')>Mestrado</option>
                                <option value="Doutorado" @selected(request('grau') === 'Doutorado')>Doutorado</option>
                                <option value="Pos-Doutorado" @selected(request('grau') === 'Pos-Doutorado')>Pós-Doutorado</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <div class="flex space-x-2 w-full">
                                <a href="{{ url('/') }}"
                                   class="flex-1 px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-center font-medium hover:bg-gray-300 transition">
                                    Limpar
                                </a>
                                <button type="submit"
                                        class="flex-1 px-3 py-2 bg-primary text-white rounded-lg font-medium hover:bg-indigo-700 transition shadow-sm">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Resultados -->
        <main class="flex-1 py-10">
            <div class="max-w-7xl mx-auto px-4">
                @if($curriculums->isEmpty())
                    <div class="text-center py-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">Nenhum currículo encontrado</h3>
                        <p class="mt-2 text-gray-600">Tente ajustar os filtros ou remover alguns para ampliar sua busca.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($curriculums as $cv)
                            <div class="card-hover bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                                <div class="p-5">
                                    <div class="flex items-start space-x-4">
                                        @if($cv->avatar)
                                            <img src="{{ Storage::url($cv->avatar) }}" alt="Foto" class="w-16 h-16 rounded-full object-cover border">
                                        @else
                                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 font-bold text-lg">
                                                    {{ strtoupper(substr($cv->pessoal['nome'] ?? 'U', 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg text-gray-900 truncate">
                                                {{ $cv->pessoal['nome'] ?? 'Sem nome' }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $cv->pessoal['instituicao_nome'] ?? 'Instituição não informada' }}
                                            </p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $cv->pessoal['endereco_pais'] ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                @if(!empty($cv->formacoes_academicas))
                                                    {{ $cv->formacoes_academicas[0]['grau_academico'] ?? 'N/A' }}
                                                @else
                                                    Sem formação
                                                @endif
                                            </span>
                                            <a href="{{ route('curriculums.download', $cv->id) }}"
                                               class="inline-flex items-center text-sm font-semibold text-primary hover:text-indigo-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Baixar PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginação -->
                    <div class="mt-10 flex justify-center">
                        {{ $curriculums->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} Curriculum-Ovana. Todos os direitos reservados.
            </div>
        </footer>
    </div>
</body>
</html>