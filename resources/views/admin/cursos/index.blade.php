@extends('layouts.admin')

@section('content')
    <header>
    <h1>Lista de Cursos</h1>
    <a href="{{ route('admin.cursos.create') }}">Adicionar Curso</a>
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
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
        @foreach ($cursos as $curso)
            <tr>
                <td>{{ $curso->nome }}</td>
                <td>{{ $curso->descricao }}</td>
                <td>
                    <a href="{{ route('admin.cursos.show', $curso->id) }}">Ver</a>
                    <a href="{{ route('admin.cursos.edit', $curso->id) }}">Editar</a>
                    <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" style="display:inline" class="delete-form">
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
        <a href="{{ route('admin.dashboard')}}">Voltar</a>
    </div>
@endsection
