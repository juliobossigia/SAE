@extends('layouts.admin')

@section('content')
<h1>Dashboard de Administração</h1>
<ul>
    <li><a href="{{ route('admin.alunos.index') }}">Alunos</a></li>
    <li><a href="{{ route('admin.docentes.index') }}">Docentes</a></li>
    <li><a href="{{ route('admin.turmas.index') }}">Turmas</a></li>
    <li><a href="{{ route('admin.cursos.index') }}">Cursos</a></li>
    <li><a href="{{ route('admin.servidores.index') }}">Servidores</a></li>
    <li><a href="{{ route('admin.setores.index') }}">Setores</a></li>
    <li><a href="{{ route('admin.disciplinas.index') }}">Disciplinas</a></li>
    <li><a href="{{ route('admin.departamentos.index') }}">Departamentos</a></li>
    <li><a href="{{ route('admin.predios.index') }}">Prédios</a></li>
    <li><a href="{{ route('admin.locais.index') }}">Locais</a></li>
    <li><a href="{{ route('admin.pending-registrations') }}">Registros Pendentes</a></li>
    <li><a href="{{ route('admin.registros.index') }}">Registros</a></li>
</ul>
<br>
@livewire('logout-button')
<br>
@endsection
