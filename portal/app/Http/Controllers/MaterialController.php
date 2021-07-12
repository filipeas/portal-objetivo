<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Http\Requests\CreateMaterial;
use App\Http\Requests\UpdateMaterial;
use App\Http\Resources\Curso as ResourcesCurso;
use App\Material;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MaterialController extends Controller
{
    /**
     * Método responsável por guardar imagem do produto no servidor.
     * 
     */
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

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
            return redirect()->route('admin.curso.index')->withErrors([
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
    public function create(string $slug_curso)
    {
        $curso = Curso::where('slug', $slug_curso)->first();

        if (is_null($curso)) {
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        return view('administrativo.material.create', [
            'curso' => new ResourcesCurso($curso),
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
        if ($request->pdf == null && $request->doc == null && $request->link_video == null) {
            return redirect()->back()->withInput()->withErrors([
                'error' => true,
                'message' => 'Você não pode criar um material vazio.',
            ]);
        }

        $curso = Curso::where('id', $request->curso)->first();

        try {
            $material = new Material();
            $material->user = auth()->user()->id;
            $material->curso = $request->curso;

            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');

                $name = Str::slug('material-PDF-' . time());
                $folder = '/material/';
                $filePathPDF = $folder . $name . '.' . $file->getClientOriginalExtension();

                $this->uploadOne($file, $folder, 'public', $name);
                $material->pdf = $filePathPDF;
            }

            if ($request->hasFile('doc')) {
                $file = $request->file('doc');

                $name = Str::slug('material-DOC-' . time());
                $folder = '/material/';
                $filePathDOC = $folder . $name . '.' . $file->getClientOriginalExtension();

                $this->uploadOne($file, $folder, 'public', $name);
                $material->doc = $filePathDOC;
            }

            if ($request->link_video != null) {
                $material->link_video = $request->link_video;
                if ($request->type_video == 'youtube' || $request->type_video == 'vimeo') {
                    $material->type_video = ($request->type_video == 'youtube' ? true : false);
                } else {
                    return redirect()->back()->withInput()->withErrors([
                        'error' => true,
                        'message' => 'Você deve informar se o vídeo é da plataforma Youtube ou Vimeo.',
                    ]);
                }
            }
            $material->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('admin.curso.show', ['slug_curso' => $curso->slug]);
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

        if (is_null($materialObj)) {
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o material informado.',
            ]);
        }

        return view('administrativo.material.show', [
            'curso' => $materialObj->curso()->first(),
            'material' => $materialObj,
        ]);
    }

    public function showStudent(int $material)
    {
        $materialObj = Material::where('id', $material)->first();

        if (is_null($materialObj)) {
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o material informado.',
            ]);
        }

        return view('aluno.material.show', [
            'curso' => $materialObj->curso()->first(),
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

        if (is_null($materialObj)) {
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o material informado.',
            ]);
        }

        return view('administrativo.material.edit', [
            'curso' => $materialObj->curso()->first(),
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

        if (is_null($materialObj)) {
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o material informado.',
            ]);
        }

        try {
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');

                $name = Str::slug('material-PDF-' . time());
                $folder = '/material/';
                $filePathPDF = $folder . $name . '.' . $file->getClientOriginalExtension();

                $this->uploadOne($file, $folder, 'public', $name);
                if ($materialObj->pdf != null)
                    File::delete(storage_path('app/public' . $materialObj->pdf));
                $materialObj->pdf = $filePathPDF;
            }

            if ($request->hasFile('doc')) {
                $file = $request->file('doc');

                $name = Str::slug('material-DOC-' . time());
                $folder = '/material/';
                $filePathDOC = $folder . $name . '.' . $file->getClientOriginalExtension();

                $this->uploadOne($file, $folder, 'public', $name);
                if ($materialObj->doc != null)
                    File::delete(storage_path('app/public' . $materialObj->doc));
                $materialObj->doc = $filePathDOC;
            }

            if ($request->link_video != null) {
                $materialObj->link_video = $request->link_video;
                if ($request->type_video == 'youtube' || $request->type_video == 'vimeo') {
                    $materialObj->type_video = ($request->type_video == 'youtube' ? true : false);
                } else {
                    return redirect()->back()->withInput()->withErrors([
                        'error' => true,
                        'message' => 'Você deve informar se o vídeo é da plataforma Youtube ou Vimeo.',
                    ]);
                }
            } else {
                $materialObj->link_video = null;
                $materialObj->type_video = null;
            }
            $materialObj->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        // verificando se material está vazio
        $materialObj->checkRemoveMaterial();

        return redirect()->route('admin.curso.show', ['slug_curso' => $materialObj->curso()->first()->slug]);
    }

    /**
     * Método responsável por excluir PDF vinculado ao material.
     * 
     */
    public function destroyPDF(int $material)
    {
        $materialObj = Material::where('id', $material)->first();

        if (is_null($materialObj)) {
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o material informado.',
            ]);
        }

        if ($materialObj->pdf != null)
            File::delete(storage_path('app/public' . $materialObj->pdf));
        $materialObj->pdf = null;
        $materialObj->save();

        // verificando se material está vazio
        $materialObj->checkRemoveMaterial();

        return redirect()->route('admin.curso.show', ['slug_curso' => $materialObj->curso()->first()->slug]);
    }

    /**
     * Método responsável por excluir DOC vinculado ao material.
     * 
     */
    public function destroyDOC(int $material)
    {
        $materialObj = Material::where('id', $material)->first();

        if (is_null($materialObj)) {
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o material informado.',
            ]);
        }

        if ($materialObj->doc != null)
            File::delete(storage_path('app/public' . $materialObj->doc));
        $materialObj->doc = null;
        $materialObj->save();

        // verificando se material está vazio
        $materialObj->checkRemoveMaterial();

        return redirect()->route('admin.curso.show', ['slug_curso' => $materialObj->curso()->first()->slug]);
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
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o material informado.',
            ]);
        }

        $materialObj->delete();

        return redirect()->route('admin.curso.show', ['slug_curso' => $slug]);
    }
}
