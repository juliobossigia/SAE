@extends('layout')

@section('content')
    <h1>Lista de Prédios</h1>

    <a href="{{ route('admin.predios.create') }}">Adicionar Prédio</a>

    <ul>
        @foreach ($predios as $predio)
            <li>
                {{ $predio->nome }}
                <a href="{{ route('admin.predios.show', $predio->id) }}">Ver</a>
                <a href="{{ route('admin.predios.edit', $predio->id) }}">Editar</a>
                <form action="{{ route('admin.predios.destroy', $predio->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
            </li>
        @endforeach
    </ul>
    <div>
        <br>
        <a href="{{ route('admin.dashboard')}}">Voltar</a>
    </div>
    <footer>
        <br>
    </footer>
@endsection
