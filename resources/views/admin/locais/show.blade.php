@extends('layout')

@section('content')
    <h1>Detalhes do Local</h1>

    <p><strong>Sala:</strong> {{ $local->sala }}</p>

    @if ($local->predio)
        <p><strong>Prédio:</strong> {{ $local->predio->nome }}</p>
    @else
        <p><strong>Prédio:</strong> Não associado a nenhum prédio.</p>
    @endif

    <a href="{{ route('admin.locais.index') }}">Voltar</a>
    <a href="{{ route('admin.locais.edit', $local->id) }}">Editar</a>

    <form action="{{ route('admin.locais.destroy', $local->id) }}" method="POST" style="display:inline" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit">Deletar</button>
    </form>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!confirm('Tem certeza que deseja apagar?')) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
