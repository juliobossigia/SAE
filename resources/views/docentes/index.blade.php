@extends('layout')


@section('content')
    <header>
    <h1>Lista de Docentes</h1>
    <a href="{{ route('docentes.create') }}">Adicionar Docente</a>
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
            <th>Email</th>
            <th>Data de Nascimento</th>
            <th>CPF</th>
            <th>Ações</th>
        </tr>
        @foreach ($docentes as $docente)
            <tr>
                <td>{{ $docente->nome }}</td>
                <td>{{ $docente->email }}</td>
                <td>{{ $docente->data_nascimento }}</td>
                <td>{{ $docente->cpf }}</td>
                <td>
                    <a href="{{ route('docentes.show', $docente->id) }}">Ver</a>
                    <a href="{{ route('docentes.edit', $docente->id) }}">Editar</a>
                    <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Deletar</button>
                    </form>
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
