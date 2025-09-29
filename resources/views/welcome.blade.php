<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Curriculum-Ovana') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css">
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col items-center py-10">

        <!-- Título -->
        <h1 class="text-3xl font-bold mb-2">Currículos Publicados</h1>

        <!-- Link para registro -->
        <p class="mb-6 text-gray-600">
            Ainda não tem uma conta?
            <a href="{{ route('register') }}" 
               class="text-indigo-600 font-semibold hover:underline">
               Registre-se aqui
            </a>
        </p>

        <!-- Filtros -->
        <form method="GET" action="{{ url('/') }}" class="w-full max-w-4xl bg-white p-6 rounded-lg shadow mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" name="nome" id="nome" value="{{ request('nome') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                <select name="pais" id="pais"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Todos</option>
                    @foreach ($paises as $pais)
                        <option value="{{ $pais }}" @selected(request('pais') === $pais)>
                            {{ $pais }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="grau" class="block text-sm font-medium text-gray-700">Grau Acadêmico</label>
                <select name="grau" id="grau"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Todos</option>
                    <option value="Licenciatura" @selected(request('grau') === 'Licenciatura')>Licenciatura</option>
                    <option value="Mestrado" @selected(request('grau') === 'Mestrado')>Mestrado</option>
                    <option value="Doutorado" @selected(request('grau') === 'Doutorado')>Doutorado</option>
                    <option value="Pos-Doutorado" @selected(request('grau') === 'Pos-Doutorado')>Pós-Doutorado</option>
                </select>
            </div>

            <!-- Botões -->
            <div class="md:col-span-3 flex justify-end space-x-2 mt-4">
                <a href="{{ url('/') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md shadow hover:bg-gray-400">
                    Limpar
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">
                    Filtrar
                </button>
            </div>
        </form>

        <!-- Lista de Currículos -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-6xl">
            @forelse ($curriculums as $cv)
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-2">
                        {{ $cv->pessoal['nome'] ?? 'Sem nome' }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        País: {{ $cv->pessoal['endereco_pais'] ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Grau:
                        @if(!empty($cv->formacoes_academicas))
                            {{ $cv->formacoes_academicas[0]['grau_academico'] ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Nenhum currículo encontrado.</p>
            @endforelse
        </div>

        <!-- Paginação -->
        <div class="mt-6">
            {{ $curriculums->withQueryString()->links() }}
        </div>
    </div>
</body>
</html>
