@extends('layouts.admin')

@section('content')
    <h1>Detalhes do Prédio</h1>

    <p><strong>Nome:</strong> {{ $predio->nome }}</p>

    <h2>Salas no Prédio</h2>
    @if($predio->locais->isEmpty())
        <p>Não há salas cadastradas neste prédio.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Sala</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($predio->locais as $local)
                <tr>
                    <td>{{ $local->sala }}</td>
                    <td><a href="{{ route('locais.show', $local->id) }}">Ver</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.predios.index') }}">Voltar</a>
    <a href="{{ route('admin.predios.edit', $predio->id) }}">Editar</a>

    <form action="{{ route('admin.predios.destroy', $predio->id) }}" method="POST" style="display:inline" class="delete-form">
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
