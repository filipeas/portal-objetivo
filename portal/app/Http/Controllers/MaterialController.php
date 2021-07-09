<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Http\Requests\CreateMaterial;
use App\Http\Requests\UpdateMaterial;
use App\Http\Resources\Curso as ResourcesCurso;
use App\Material;
use Illuminate\Http\Request;
use Exception;

class MaterialController extends Controller
{
    /**
     * Método responsável por retornar view para visualizar todos os materiais
     * de um curso.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $slug_curso)
    {
        $curso = Curso::where('slug', $slug_curso)->first();

        if (is_null($curso)) {
            return redirect()->route('admin.curso.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        return view('administrativo.material.index', [
            'curso' => new ResourcesCurso($curso),
        ]);
    }

    /**
     * Método responsável por retornar view de cadastro de material 
     * do curso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrativo.material.create', [
            'cursos' => ResourcesCurso::collection(Curso::all()),
        ]);
    }

    /**
     * Método responsável por cadastrar um material, vinculando
     * a um curso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMaterial $request)
    {
        $curso = Curso::where('id', $request->curso)->first();

        try {
            $material = Material::create($request->all(), 200);
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.material.index', ['slug_curso' => $curso->slug]);
    }

    /**
     * Método responsável por retornar view de visualização do material
     * de um curso.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(int $material)
    {
        $materialObj = Material::where('id', $material)->first();
        $slug = $materialObj->curso()->first()->slug;

        if (is_null($materialObj)) {
            return redirect()
                ->route('admin.material.index', ['slug_curso' => $slug])
                ->with([
                    'error' => true,
                    'message' => 'Não foi possível encontrar o material informado.',
                ]);
        }

        return view('administrativo.material.show', [
            'material' => $materialObj,
        ]);
    }

    /**
     * Método responsável por retornar view de edição de um material
     * de um curso
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(int $material)
    {
        $materialObj = Material::where('id', $material)->first();
        $slug = $materialObj->curso()->first()->slug;

        if (is_null($materialObj)) {
            return redirect()
                ->route('admin.material.index', ['slug_curso' => $slug])
                ->with([
                    'error' => true,
                    'message' => 'Não foi possível encontrar o material informado.',
                ]);
        }

        return view('administrativo.material.edit', [
            'material' => $materialObj,
        ]);
    }

    /**
     * Método responsável por realizar edição do material informado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaterial $request, int $material)
    {
        $materialObj = Material::where('id', $material)->first();
        $slug = $materialObj->curso()->first()->slug;

        if (is_null($materialObj)) {
            return redirect()
                ->route('admin.material.index', ['slug_curso' => $slug])
                ->with([
                    'error' => true,
                    'message' => 'Não foi possível encontrar o material informado.',
                ]);
        }

        try {
            $materialObj->curso = $request->curso;
            $materialObj->pdf = $request->pdf;
            $materialObj->doc = $request->doc;
            $materialObj->link_video = $request->link_video;
            $materialObj->type_video = $request->type_video;
            $materialObj->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.material.index', ['slug_curso' => $slug]);
    }

    /**
     * Método responsável por excluir um material do sistema.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $material)
    {
        $materialObj = Material::where('id', $material)->first();
        $slug = $materialObj->curso()->first()->slug;

        if (is_null($materialObj)) {
            return redirect()
                ->route('admin.material.index', ['slug_curso' => $slug])
                ->with([
                    'error' => true,
                    'message' => 'Não foi possível encontrar o material informado.',
                ]);
        }

        $materialObj->delete();

        return redirect()->route('admin.material.index', ['slug_curso' => $slug]);
    }
}
