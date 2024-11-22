@extends('layout')

@section('content')
    <h1>Editar Departamento</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.departamentos.update', $departamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $departamento->nome }}">


        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('admin.departamentos.index') }}">Voltar</a>
@endsection

