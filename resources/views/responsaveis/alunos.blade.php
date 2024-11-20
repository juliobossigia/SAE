@extends('layout')

@section('content')
    <h1>Meu Perfil</h1>
    <div>
        <p><strong>Nome:</strong> {{ $responsavel->nome }}</p>
        <p><strong>Email:</strong> {{ $responsavel->email }}</p>
        <p><strong>CPF:</strong> {{ $responsavel->cpf }}</p>
        <p><strong>Telefone:</strong> {{ $responsavel->telefone }}</p>
    </div>
@endsection