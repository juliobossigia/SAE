@extends('layout')

@section('content')
    <h1>Adicionar Local</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('locais.store') }}" method="POST">
        @csrf
        <label for="predio_id">Prédio:</label>
        <select name="predio_id" id="predio_id">
            @foreach ($predios as $predio)
                <option value="{{ $predio->id }}">{{ $predio->nome }}</option>
            @endforeach
        </select>

        <label for="sala">Sala:</label>
        <input type="text" name="sala" id="sala" value="{{ old('sala') }}">

        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('locais.index') }}">Voltar</a>
@endsection
