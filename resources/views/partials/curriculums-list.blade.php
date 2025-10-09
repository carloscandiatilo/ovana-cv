<div class="row">
  @forelse ($curriculums as $cv)
    <div class="col-md-4 mb-3">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">{{ $cv->pessoal['nome'] ?? 'Sem nome' }}</h5>
          <p class="card-text mb-2">
            <strong>Província:</strong> {{ $cv->pessoal['endereco_provincia'] ?? '-' }} <br>
            <strong>Nível:</strong> {{ collect($cv->formacoes_academicas)->pluck('grau_academico')->first() ?? '-' }}
          </p>
          <a href="{{ route('cv.show', $cv->id) }}" class="btn btn-outline-primary btn-sm">Ver Perfil</a>
        </div>
      </div>
    </div>
  @empty
    <p class="text-center text-muted mt-3">Nenhum currículo encontrado.</p>
  @endforelse
</div>

<div class="mt-3">
  {{ $curriculums->links() }}
</div>
