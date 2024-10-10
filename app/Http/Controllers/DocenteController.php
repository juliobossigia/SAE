<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use App\Models\Disciplina;
use App\Models\Departamento;
use App\Models\Curso;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::all();
        return view('docentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $disciplinas = Disciplina::all();
        $departamentos = Departamento::all(); // Busca todos os departamentos
        $cursos = Curso::all();
        
        // Passa tanto as disciplinas quanto os departamentos para a view
        return view('docentes.create', compact('disciplinas', 'departamentos','cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:docentes',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|unique:docentes',
            'departamento_id' => 'required|exists:departamentos,id', // Valida que o departamento existe
            'disciplinas' => 'required|array', // Valida que disciplinas sejam um array de IDs
            'disciplinas.*' => 'exists:disciplinas,id', // Valida que os IDs existam na tabela disciplinas
            'is_coordenador' => 'boolean',
            'curso_id' => 'nullable|exists:cursos,id',
        ]);

        // Cria o docente com os dados fornecidos e associa o departamento
        $docente = Docente::create($request->only(['nome', 'email', 'data_nascimento', 'cpf', 'departamento_id','is_coordenador']));

        // Relaciona o docente com as disciplinas selecionadas
        $docente->disciplinas()->sync($request->disciplinas);

        if ($request->is_coordenador){
            $docente->curso_id = $request->curso_id;
            $docente->save();
        }

        return redirect()->route('docentes.index')->with('success', 'Docente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $docente = Docente::findOrFail($id);
        return view('docentes.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $docente = Docente::findOrFail($id);
        $disciplinas = Disciplina::all();
        $departamentos = Departamento::all(); // Busca todos os departamentos
        $cursos = Curso::all();

        // Passa tanto os departamentos quanto as disciplinas para a view de edição
        return view('docentes.edit', compact('docente', 'disciplinas', 'departamentos','cursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:docentes,email,' . $docente->id, // Permite o email do próprio docente
            'data_nascimento' => 'required|date',
            'cpf' => 'required|unique:docentes,cpf,' . $docente->id, // Permite o CPF do próprio docente
            'departamento_id' => 'required|exists:departamentos,id', // Valida que o departamento existe
            'disciplinas' => 'required|array', // Valida que disciplinas sejam um array de IDs
            'disciplinas.*' => 'exists:disciplinas,id', // Valida que os IDs existam na tabela disciplinas
            'is_coordenador' => 'boolean',
            'curso_id' => 'nullable|exists:cursos,id',
        ]);

        // Atualiza os dados do docente e o departamento associado
        $docente->update($request->only(['nome', 'email', 'data_nascimento', 'cpf', 'departamento_id','is_coordenador']));

        // Atualiza as disciplinas associadas ao docente
        $docente->disciplinas()->sync($request->disciplinas);

        if ($request->is_coordenador){
            $docente->curso_id = $request->curso_id;
            $docente->save();
        }

        return redirect()->route('docentes.index')->with('success', 'Docente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')->with('success', 'Docente deletado com sucesso!');
    }
}
