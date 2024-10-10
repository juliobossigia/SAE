@extends('layout')

@section('content')
    <h1>Editar Local</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('locais.update', $local->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="predio_id">Prédio:</label>
        <select name="predio_id" id="predio_id">
            @foreach ($predios as $predio)
                <option value="{{ $predio->id }}" {{ $local->predio_id == $predio->id ? 'selected' : '' }}>
                    {{ $predio->nome }}
                </option>
            @endforeach
        </select>

        <label for="sala">Sala:</label>
        <input type="text" name="sala" id="sala" value="{{ $local->sala }}">

        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('locais.index') }}">Voltar</a>
@endsection
