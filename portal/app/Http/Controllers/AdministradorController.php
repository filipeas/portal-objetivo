<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdministrador;
use App\Http\Requests\UpdateAdministrador;
use App\Http\Resources\Administrador;
use App\User;
use Exception;

class AdministradorController extends Controller
{
    /**
     * Método responsável por retornar view inicial do administrativo
     */
    public function home()
    {
        return view('administrativo.home');
    }

    /**
     * Método responsável por retornar todos os administradores cadastrados no sistema.
     * 
     */
    public function index()
    {
        return view('administrativo.admin.index', [
            'alunos' => Administrador::collection(User::where('type', false)->get()),
        ]);
    }

    /**
     * Método responsável por retornar view de cadastro de administrador.
     * 
     */
    public function create()
    {
        return view('administrativo.admin.create');
    }

    /**
     * Método responsável por realizar cadastro de administrador no sistema.
     * 
     */
    public function store(CreateAdministrador $request)
    {
        try {
            $administrador = User::create([
                'type' => false,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $request->password,
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.all.index');
    }

    /**
     * Método responsável por retornar view de edição dos dados pessoais
     * do administrador.
     * 
     */
    public function edit(int $administrador)
    {
        $admin = User::where('id', $administrador)->first();

        if (is_null($admin)) {
            return redirect()->route('admin.all.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o administrador informado.',
            ]);
        }

        return view('administrativo.admin.edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * Método responsável por realizar atualização dos dados pessoais
     * do administrador.
     * 
     */
    public function update(UpdateAdministrador $request, int $administrador)
    {
        $admin = User::where('id', $administrador)->first();

        if (is_null($admin)) {
            return redirect()->route('admin.all.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o administrador informado.',
            ]);
        }

        try {
            $admin->name = $request->name;
            $admin->lastname = $request->lastname;
            $admin->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.all.index');
    }

    /**
     * Método responsável por excluir administrador do sistema.
     * 
     */
    public function destroy(int $administrador)
    {
        $admin = User::where('id', $administrador)->first();

        if (auth()->user()->id == $admin->id) {
            return redirect()->route('admin.all.index')->with([
                'error' => true,
                'message' => 'Você não pode excluir sua própria conta.',
            ]);
        }

        if (is_null($admin)) {
            return redirect()->route('admin.all.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o administrador informado.',
            ]);
        }

        $admin->delete();

        return redirect()->route('admin.all.index');
    }
}
