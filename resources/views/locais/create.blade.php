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

    <div class="form-group">
        <label for="tipo_local">Tipo de Local</label>
        <select name="tipo_local" id="tipo_local" class="form-control">
            <option value="sala" {{ old('tipo_local', $local->tipo_local ?? '') == 'sala' ? 'selected' : '' }}>Sala</option>
            <option value="laboratório" {{ old('tipo_local', $local->tipo_local ?? '') == 'laboratório' ? 'selected' : '' }}>Laboratório</option>
        </select>
    </div>

    <div class="form-group">
        <label for="numero">Número</label>
        <input type="text" name="numero" class="form-control" value="{{ old('numero', $local->numero ?? '') }}">
    </div>


    <button type="submit">Salvar</button>
</form>

<a href="{{ route('locais.index') }}">Voltar</a>
@endsection