@extends('layout')


@section('content')
    <header>
    <h1>Lista de Disciplinas</h1>
    <a href="{{ route('disciplinas.create') }}">Adicionar disciplina</a>
    @livewire('logout-button')
    <br>
    </header>


    @if ($message = Session::get('success'))
        <div>
            {{ $message }}
        
        </div>
    @endif
   
    <table>
        <tr>
            <th>Nome</th>
        </tr>
        @foreach ($disciplinas as $disciplina)
            <tr>
                <td>{{ $disciplina->nome }}</td>
                <td>
                    <a href="{{ route('disciplinas.show', $disciplina->id) }}">Ver</a>
                    <a href="{{ route('disciplinas.edit', $disciplina->id) }}">Editar</a>
                    <form action="{{ route('disciplinas.destroy', $disciplina->id) }}" method="POST" style="display:inline" class="delete-form">
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
                </td>
            </tr>
        @endforeach
    </table>
    <div>
        <br>
        <a href="{{ route('dashboard')}}">Voltar</a>
    </div>
    <footer>
        <br>
    </footer>
@endsection
