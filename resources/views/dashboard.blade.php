@extends('layout')

@section('content')
    <h1>Dashboard de Administração</h1>
    <ul>
        <li><a href="{{route('alunos.index')}}">Alunos</a></li>
    </ul>
    <br>
    @livewire('logout-button')
    <br>
@endsection