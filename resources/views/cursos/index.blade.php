<!-- resources/views/docentes/index.blade.php -->
@extends('layout')


@section('content')
    <header>
    <h1>Lista de Cursos</h1>
    <a href="{{ route('cursos.create') }}">Adicionar Curso</a>
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
        @foreach ($cursos as $curso)
            <tr>
                <td>{{ $curso->nome }}</td>
                <td>
                    <a href="{{ route('cursos.show', $curso->id) }}">Ver</a>
                    <a href="{{ route('cursos.edit', $curso->id) }}">Editar</a>
                    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline">
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
