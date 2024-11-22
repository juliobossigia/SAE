@extends('layout')


@section('content')
    <header>
    <h1>Lista de Departamentos</h1>
    <a href="{{ route('admin.departamentos.create') }}">Adicionar Departamento</a>
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
        @foreach ($departamentos as $departamento)
            <tr>
                <td>{{ $departamento->nome }}</td>
                <td>
                    <a href="{{ route('admin.departamentos.show', $departamento->id) }}">Ver</a>
                    <a href="{{ route('admin.departamentos.edit', $departamento->id) }}">Editar</a>
                    <form action="{{ route('admin.departamentos.destroy', $departamento->id) }}" method="POST" style="display:inline" class="delete-form">
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
        <a href="{{ route('admin.dashboard')}}">Voltar</a>
    </div>
    <footer>
        <br>
    </footer>
@endsection
