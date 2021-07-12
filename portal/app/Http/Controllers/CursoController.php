<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Curso;
use App\Http\Requests\CreateCurso;
use App\Http\Requests\UpdateCurso;
use App\Http\Resources\Curso as ResourcesCurso;
use App\Http\Resources\CursosMatricula;
use App\Matricula;
use Exception;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CursoController extends Controller
{
    public function getImageCrop()
    {
    }

    public function postImageCrop(Request $request)
    {
        // limpar diretório upload
        // $file = new Filesystem;
        // $file->cleanDirectory(public_path('upload'));

        $data = $request->image;

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $image_name = time() . '.png';
        $path = public_path() . "/upload/" . $image_name;

        file_put_contents($path, $data);

        return response()->json(['success' => 'done', 'image' => $path]);
    }

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
            'cursos' => ResourcesCurso::collection(Curso::get()),
        ]);
    }

    public function indexStudent()
    {
        return view('aluno.curso.index', [
            'cursos' => CursosMatricula::collection(Matricula::where('student', auth()->user()->id)->get()),
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
        if (file_exists($request->cover)) {
            $str = explode('/', $request->cover);
            File::copy($request->cover, storage_path('app/public/cover/' . $str[count($str) - 1]));
        } else {
            return redirect()->back()->withErrors([
                'error' => true,
                'message' => 'Você deve informar uma capa.',
            ]);
        }

        // remove cover tmp
        File::delete($request->cover);

        try {
            $curso = Curso::create([
                'user' => auth()->user()->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . time(),
                'cover' => $str[count($str) - 1],
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
            'matriculas' => $curso->matricula()->get(),
            'materiais' => $curso->material()->get(),
        ]);
    }

    public function showStudent(string $slug_curso)
    {
        $curso = Curso::where('slug', $slug_curso)->first();

        if (is_null($curso)) {
            return redirect()->route('admin.curso.index')->with([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        $matricula = Matricula::where('student', auth()->user()->id)->where('curso', $curso->id)->first();

        if (is_null($matricula)) {
            return redirect()->route('student.curso.index')->with([
                'error' => true,
                'message' => 'Você não está matriculado nesse curso.',
            ]);
        }

        return view('aluno.curso.show', [
            'curso' => $curso,
            'materiais' => $curso->material()->get(),
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
            return redirect()->route('admin.curso.index')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o curso informado.',
            ]);
        }

        if ($request->cover != null) {
            if (file_exists($request->cover)) {
                $str = explode('/', $request->cover);
                File::copy($request->cover, storage_path('app/public/cover/' . $str[count($str) - 1]));
                File::delete(storage_path('app/public/cover/' . $curso->cover));

                $curso->cover = $str[count($str) - 1];
            } else {
                return redirect()->back()->withErrors([
                    'error' => true,
                    'message' => 'Você deve informar uma capa.',
                ]);
            }
        }

        // remove cover tmp
        File::delete($request->cover);

        try {
            $curso->name = $request->name;
            $curso->slug = Str::slug($request->name) . time();
            $curso->start_date = $request->start_date;
            $curso->end_date = $request->end_date;
            $curso->save();
        } catch (Exception $ex) {
            return redirect()->back()->withErrors([
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
