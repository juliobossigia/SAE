@extends('layout')

@section('content')
    <h1>Meu Perfil</h1>
    <div>
        <p><strong>Nome:</strong> {{ $servidor->nome }}</p>
        <p><strong>Email:</strong> {{ $servidor->email }}</p>
        <p><strong>CPF:</strong> {{ $servidor->cpf }}</p>
        <p><strong>Setor:</strong> {{ $servidor->setor->nome }}</p>
    </div>
@endsection
