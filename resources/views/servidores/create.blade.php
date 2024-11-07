@extends('layout')

@section('content')
    <h1>Adicionar Servidor</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servidores.store') }}" method="POST">
        @csrf
        
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
        

       
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
       

       
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required>
            <div>

              <br> 
            <label for="setor_id">Setor:</label>
            <select name="setor_id" id="setor" required>
                @foreach($setores as $setor)
                    <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                @endforeach
            </select>
        <div>
            <br>
            <br>
            <button type="submit">Salvar</button>
        </div>
        <br>
    </form>

    <a href="{{ route('servidores.index') }}">Voltar</a>
@endsection