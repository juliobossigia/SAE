<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Responsavel;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlunoResponsavelController extends Controller
{
    public function create()
    {
        $responsaveis = Responsavel::all();
        $cursos = Curso::all();
        $alunos = Aluno::whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('aluno_responsavel')
                      ->whereRaw('aluno_responsavel.aluno_id = alunos.id');
            })
            ->when(request('curso_id'), function($query) {
                return $query->where('curso_id', request('curso_id'));
            })
            ->when(request('search'), function($query) {
                return $query->where('nome', 'like', '%'.request('search').'%');
            })
            ->paginate(10);

        if (request()->ajax()) {
            return view('admin.aluno-responsavel._alunos_list', compact('alunos'));
        }

        return view('admin.aluno-responsavel.create', compact('responsaveis', 'cursos', 'alunos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'responsavel_id' => 'required|exists:responsaveis,id',
            'aluno_ids' => 'required|array',
            'aluno_ids.*' => 'exists:alunos,id'
        ]);

        try {
            DB::beginTransaction();

            $responsavel = Responsavel::find($request->responsavel_id);
            
            foreach ($request->aluno_ids as $alunoId) {
                DB::table('aluno_responsavel')->insert([
                    'aluno_id' => $alunoId,
                    'responsavel_id' => $request->responsavel_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Alunos vinculados com sucesso ao responsável');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao vincular alunos: ' . $e->getMessage());
        }
    }
}