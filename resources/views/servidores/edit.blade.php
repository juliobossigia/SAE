@extends('layout')

@section('content')
    <h1>Editar Servidor</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servidores.update', $servidor->id) }}" method="POST">
        @csrf
        @method('PATCH')
        
 
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $servidor->nome) }}" required>
 
        
     
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $servidor->email) }}" required>
       
        
     
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $servidor->cpf) }}" required>
       
        <div>
            <br> 
            <label for="setor_id">Setor:</label>
            <select name="setor_id" id="setor" required>
                @foreach($setores as $setor)
                    <option value="{{ $setor->id }}" {{ $servidor->setor_id == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <br>
            <br>
            <button type="submit">Salvar</button>
        </div>
        <br>
    </form>

    <a href="{{ route('servidores.index') }}">Voltar</a>
@endsection