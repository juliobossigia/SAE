@extends('layout')

@section('content')
    <h1>Lista de Locais</h1>

    <a href="{{ route('locais.create') }}">Adicionar Local</a>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if($locais->isEmpty())
        <p>Nenhum local cadastrado.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sala</th>
                    <th>Prédio</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locais as $local)
                <tr>
                    <td>{{ $local->id }}</td>
                    <td>{{ $local->sala }}</td>
                    <td>{{ $local->predio->nome }}</td>
                    <td>
                        <a href="{{ route('locais.edit', $local->id) }}">Editar</a>
                        <form action="{{ route('locais.destroy', $local->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('dashboard') }}">Voltar</a>
@endsection
