@extends('layout')


@section('content')
    <header>
    <h1>Lista de Turmas</h1>
    <a href="{{ route('turmas.create') }}">Adicionar Turma</a>
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
            <th>Letra</th>
            <th>Ano</th>
        </tr>
        @foreach ($turmas as $turma)
            <tr>
                <td>{{ $turma->letra }}</td>
                <td>{{ $turma->ano }}</td>
                <td>
                    <a href="{{ route('turmas.show', $turma->id) }}">Ver</a>
                    <a href="{{ route('turmas.edit', $turma->id) }}">Editar</a>
                    <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" style="display:inline" class="delete-form">
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
