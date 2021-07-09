<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Http\Requests\CreateCurso;
use App\Http\Requests\UpdateCurso;
use App\Http\Resources\Curso as ResourcesCurso;
use Exception;

class CursoController extends Controller
{
    /**
     * Método responsável por listar todos os cursos.
     * 
     * Retorna a view que será usada para mostrar os dados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrativo.curso.index', [
            'cursos' => ResourcesCurso::collection(Curso::all()),
        ]);
    }

    /**
     * Método responsável por mostrar tela de cadastro de curso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrativo.curso.create');
    }

    /**
     * Método responsável por cadastrar um curso no sistema.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCurso $request)
    {
        try {
            $curso = Curso::create([
                'name' => $request->name,
                'cover' => $request->cover,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.curso.index');
    }

    /**
     * Método responsável por retornar tela para mostrar 
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug_curso)
    {
        $curso = Curso::where('slug', $slug_curso)->first();

        if (is_null($curso)) {
            return redirect()->route('admin.curso.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        return view('administrativo.curso.show', [
            'curso' => $curso,
        ]);
    }

    /**
     * Método responsável por retornar view para atualizar dados do curso.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(string $slug_curso)
    {
        $curso = Curso::where('slug', $slug_curso)->first();

        if (is_null($curso)) {
            return redirect()->route('admin.curso.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        return view('administrativo.curso.edit', [
            'curso' => $curso,
        ]);
    }

    /**
     * Método responsável por atualizar dados do curso no sistema.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurso $request, string $slug_curso)
    {
        $curso = Curso::where('slug', $slug_curso)->first();

        if (is_null($curso)) {
            return redirect()->route('admin.curso.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        try {
            $curso->name = $request->name;
            $curso->slug = $curso->createSlug($request->name);
            $curso->cover = $request->cover;
            $curso->start_date = $request->start_date;
            $curso->end_date = $request->end_date;
            $curso->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.curso.index');
    }

    /**
     * Método responsável por excluir curso do sistema.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $slug_curso)
    {
        $curso = Curso::where('slug', $slug_curso)->first();

        if (is_null($curso)) {
            return redirect()->route('admin.curso.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        $curso->delete();

        return redirect()->route('admin.curso.index');
    }
}
