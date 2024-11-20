@extends('layout')

@section('content')
    <h1>Meu Perfil</h1>
    <div>
        <p><strong>Nome:</strong> {{ $docente->nome }}</p>
        <p><strong>Email:</strong> {{ $docente->email }}</p>
        <p><strong>CPF:</strong> {{ $docente->cpf }}</p>
        <p><strong>Departamento:</strong> {{ $docente->departamento->nome }}</p>
    </div>
@endsection