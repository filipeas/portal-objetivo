<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Http\Requests\CreateStudent;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateStudent;
use App\Http\Resources\Student;
use App\Matricula;
use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Método responsável por retornar view da página inicial do aluno.
     * 
     */
    public function home()
    {
        return view('aluno.home', [
            'cursos' => Matricula::where('student', auth()->user()->id)->first()->curso()->orderBy('created_at', 'DESC')->take(8)->get(),
        ]);
    }

    /**
     * Método responsável por retornar todos os aluno cadastrados no sistema.
     * 
     */
    public function index()
    {
        return view('administrativo.aluno.index', [
            'alunos' => Student::collection(User::where('type', true)->paginate(15)),
        ]);
    }

    /**
     * Método responsável por retornar view de cadastro de aluno.
     * 
     */
    public function create()
    {
        return view('administrativo.aluno.create');
    }

    /**
     * Método responsável por realizar cadastro de aluno no sistema.
     * 
     */
    public function store(CreateStudent $request)
    {
        try {
            $aluno = User::create([
                'type' => true,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make('123456'),
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('student.config.edit');
    }

    /**
     * Método responsável por retornar view de visualização de um aluno específico.
     * 
     */
    public function show(int $student)
    {
        $aluno = User::where('id', $student)->first();

        if (is_null($aluno)) {
            return redirect()->route('student.config.edit')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o aluno informado.',
            ]);
        }

        return view('administrativo.aluno.show', [
            'aluno' => $aluno,
            'matriculas' => $aluno->getMatriculasStudent()->get(),
        ]);
    }

    /**
     * Método responsável por retornar view de edição dos dados pessoais
     * do aluno.
     * 
     */
    public function edit(int $student)
    {
        $aluno = User::where('id', $student)->first();

        if (is_null($aluno)) {
            return redirect()->route('student.config.edit')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o aluno informado.',
            ]);
        }

        return view('aluno.edit');
    }

    /**
     * Método responsável por retornar view de edição de senha.
     * 
     */
    public function editPassword(int $student)
    {
        $aluno = User::where('id', $student)->first();

        if (is_null($aluno)) {
            return redirect()->route('student.config.edit')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o aluno informado.',
            ]);
        }

        return view('aluno.password');
    }

    /**
     * Método responsável por realizar atualização dos dados pessoais
     * do aluno.
     * 
     */
    public function update(UpdateStudent $request, int $student)
    {
        $aluno = User::where('id', $student)->first();

        if (is_null($aluno)) {
            return redirect()->route('student.config.edit')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o aluno informado.',
            ]);
        }

        try {
            $aluno->name = $request->name;
            $aluno->lastname = $request->lastname;
            $aluno->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('student.config.edit', ['aluno' => $aluno->id]);
    }

    public function updatePassword(UpdatePassword $request, int $student)
    {
        $aluno = User::where('id', $student)->first();

        if (is_null($aluno)) {
            return redirect()->route('student.config.edit')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o aluno informado.',
            ]);
        }

        try {
            $aluno->password = Hash::make($request->password);
            $aluno->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with([
                'error' => true,
                'message' => $ex->getMessage(),
            ]);
        }

        return redirect()->route('student.config.edit', ['aluno' => $aluno->id]);
    }

    /**
     * Método responsável por excluir aluno do sistema.
     * 
     */
    public function destroy(int $student)
    {
        $aluno = User::where('id', $student)->first();

        if (is_null($aluno)) {
            return redirect()->route('student.config.edit')->withErrors([
                'error' => true,
                'message' => 'Não foi possível encontrar o aluno informado.',
            ]);
        }

        $aluno->delete();

        return redirect()->route('student.config.edit');
    }
}
