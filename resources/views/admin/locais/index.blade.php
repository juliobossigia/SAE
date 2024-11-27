@extends('layouts.admin')

@section('content')
    <h1>Lista de Locais</h1>

    <a href="{{ route('admin.locais.create') }}">Adicionar Local</a>

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
                    <th>Prédio</th>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locais as $local)
                <tr>
                    <td>{{ $local->id }}</td>
                    <td>{{ $local->predio->nome }}</td>  <!-- Assumindo que existe a relação 'predio' -->
                    <td>{{ $local->numero }}</td>  <!-- Mostra o número da sala/laboratório -->
                    <td>{{ ucfirst($local->tipo_local) }}</td>  <!-- Capitaliza a primeira letra do tipo -->
                    <td>
                        <a href="{{ route('admin.locais.show', $local->id) }}">Ver</a>
                        <a href="{{ route('admin.locais.edit', $local->id) }}">Editar</a>
                        <form action="{{ route('admin.locais.destroy', $local->id) }}" method="POST" style="display:inline">
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

    <a href="{{ route('admin.dashboard') }}">Voltar</a>
@endsection
