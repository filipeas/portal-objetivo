<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Http\Requests\CreateMatricula;
use App\Matricula;
use App\User;
use App\Http\Resources\Curso as ResourceCurso;
use App\Http\Resources\Matricula as ResourcesMatricula;
use App\Http\Resources\Student as ResourceStudent;
use Illuminate\Http\Request;
use Exception;

class MatriculaController extends Controller
{
    /**
     * Método responsável por retornar todas as matrículas cadastradas
     * no sistema.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrativo.matricula.index', [
            'matriculas' => ResourcesMatricula::collection(Matricula::all()),
        ]);
    }

    /**
     * Método responsável por retornar view de cadastro de matricula.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrativo.matricula.create', [
            'alunos' => ResourceStudent::collection(User::where('type', true)->get()),
            'cursos' => ResourceCurso::collection(Curso::all()),
        ]);
    }

    /**
     * Método responsável por realizar cadastro de uma matricula no sistema.
     * 
     * A matricula deve ser única para o cruzamento (aluno - curso).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMatricula $request)
    {
        if (Matricula::where('aluno', $request->aluno)->where('curso', $request->curso)->exists()) {
            return redirect()->route('admin.matricula.index')->with([
                'error' => true,
                'message' => 'Você não pode criar essa matrícula, pois o aluno já está matriculado no curso selecionado.',
            ]);
        }

        try {
            $matricula = Matricula::create([
                'aluno' => $request->aluno,
                'curso' => $request->curso,
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.matricula.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function show(int $matricula)
    {
        $matricula = Matricula::where('id', $matricula)->first();

        if (is_null($matricula)) {
            return redirect()->route('admin.matricula.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar a matrícula informado.',
            ]);
        }

        return view('administrativo.matricula.show', [
            'matricula' => new ResourcesMatricula($matricula),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function edit(Matricula $matricula)
    {
        // desativado
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matricula $matricula)
    {
        // desativado
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $matricula)
    {
        $matricula = Matricula::where('id', $matricula)->first();

        if (is_null($matricula)) {
            return redirect()->route('admin.matricula.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar a matrícula informado.',
            ]);
        }

        $matricula->delete();

        return redirect()->route('admin.matricula.index');
    }
}
