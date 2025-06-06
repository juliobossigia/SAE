@extends('layouts.admin')

@section('content')
    <h1>Editar Disciplina</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.disciplinas.update', $disciplina->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $disciplina->nome }}">


        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('admin.disciplinas.index') }}">Voltar</a>
@endsection

