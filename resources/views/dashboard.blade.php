@extends('layout')

@section('content')
    <h1>Dashboard de Administração</h1>
    <ul>
        <li><a href="{{route('alunos.index')}}">Alunos</a></li>
        <li><a href="{{route('docentes.index')}}">Docentes</a></li>
        <li><a href="{{route('turmas.index')}}">Turmas</a></li>
        <li><a href="{{route('cursos.index')}}">Cursos</a></li>
        <li><a href="{{route('servidores.index')}}">Servidores</a></li>
        <li><a href="{{route('setores.index')}}">Setores</a></li>
        <li><a href="{{route('disciplinas.index')}}">Disciplina</a></li>
        <li><a href="{{route('departamentos.index')}}">Departamento</a></li>
        <li><a href="{{route('predios.index')}}">Predio</a></li>
        <li><a href="{{route('locais.index')}}">Local</a></li>



    </ul>
    <br>
    @livewire('logout-button')
    <br>
@endsection