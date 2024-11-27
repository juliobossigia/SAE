<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf' => 'required|string|size:11|unique:admins',
            'telefone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'ativo'
            ]);

            Admin::create([
                'user_id' => $user->id,
                'cpf' => $request->cpf,
                'email' => $request->email,
                'telefone' => $request->telefone
            ]);

            $user->assignRole('admin');

            DB::commit();
            return redirect()->route('admin.index')->with('success', 'Administrador criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao criar administrador: ' . $e->getMessage());
        }
    }

    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->user_id,
            'cpf' => 'required|string|size:11|unique:admins,cpf,' . $admin->id,
            'telefone' => 'required|string|max:15',
        ]);

        try {
            DB::beginTransaction();

            $admin->user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $admin->update([
                'cpf' => $request->cpf,
                'email' => $request->email,
                'telefone' => $request->telefone
            ]);

            DB::commit();
            return redirect()->route('admin.index')->with('success', 'Administrador atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar administrador: ' . $e->getMessage());
        }
    }

    public function destroy(Admin $admin)
    {
        try {
            DB::beginTransaction();
            
            $admin->user->delete(); // Isso também deletará o admin devido ao onDelete('cascade')
            
            DB::commit();
            return redirect()->route('admin.index')->with('success', 'Administrador removido com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao remover administrador: ' . $e->getMessage());
        }
    }

    public function pendingRegistrations()
    {
        // Busca usuários com status pendente
        $registrations = User::where('status', 'pendente')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pending-registrations', compact('registrations'));
    }

    public function approveRegistration($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'ativo';
        $user->save();

        return redirect()
            ->route('admin.pending-registrations')
            ->with('success', 'Cadastro aprovado com sucesso!');
    }

    public function rejectRegistration($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejeitado';
        $user->save();

        return redirect()
            ->route('admin.pending-registrations')
            ->with('success', 'Cadastro rejeitado com sucesso!');
    }
}