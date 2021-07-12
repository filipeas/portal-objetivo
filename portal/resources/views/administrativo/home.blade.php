@extends('administrativo.app')

@section('content')

    @if (session()->get('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('message') }} <br>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->messages() as $message)
                @foreach ($message as $error)
                    * {{ $error }} <br>
                @endforeach
            @endforeach
        </div>
    @endif

    {{-- cursos --}}
    <div class="row">
        <div class="col-md-12 bg-gray-apple pt-3 mb-5 rounded">
            <h3>Cursos recentes</h3>
            <a class="btn btn-primary mb-2" href="{{ route('admin.curso.index') }}">Ver mais cursos</a>
            <div class="row">
                @foreach ($cursos as $curso)
                    <div class="col-md-3 mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ asset('storage/cover/' . $curso->cover) }}" alt="{{ $curso->name }}"
                                    title="{{ $curso->name }}" class="w-100">
                            </div>
                            <div class="col-md-8">
                                <p class="w-100 shadow-sm m-1 p-3 bg-gray-100 rounded">
                                    <b>Nome:</b><br>{{ $curso->name }}<br>
                                    <b>Início:</b> {{ date('d/m/Y', strtotime($curso->start_date)) }}<br>
                                    <b>Término:</b> {{ date('d/m/Y', strtotime($curso->end_date)) }}<br>
                                </p>
                            </div>
                            <div class="col-md-4 align-self-center">
                                <a class="btn btn-primary w-100 mt-1 mb-1"
                                    href="{{ route('admin.curso.show', ['slug_curso' => $curso->slug]) }}"><i
                                        class="far fa-eye"></i></a>
                                <a class="btn btn-success w-100 mt-1 mb-1"
                                    href="{{ route('admin.curso.edit', ['slug_curso' => $curso->slug]) }}"><i
                                        class="fas fa-external-link-alt"></i></a>
                                <form onsubmit="return confirm('Tem certeza que deseja excluir esse curso?');"
                                    action="{{ route('admin.curso.destroy', ['slug_curso' => $curso->slug]) }}"
                                    method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger w-100 mt-1 mb-1 deleteCategory">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- matriculas --}}
    <div class="row">
        <div class="col-md-12 bg-gray-apple p-3 mb-5 rounded">
            <h3>Matrículas recentes</h3>
            <a class="btn btn-primary mb-2" href="{{ route('admin.student.index') }}">Ver mais alunos</a>
            <table class="table table-hover table-dark m-1 text-center">
                <thead>
                    <tr>
                        <th scope="col">Aluno</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Matriculado em</th>
                        <th scope="col"><i class="far fa-eye"></i></th>
                        <th scope="col"><i class="far fa-trash-alt"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matriculas as $matricula)
                        <tr>
                            <th scope="row">
                                {{ $matricula->aluno()->first()->name . ' ' . $matricula->aluno()->first()->lastname }}
                            </th>
                            <th scope="row">
                                {{ $matricula->curso()->first()->name }}
                            </th>
                            <th scope="row">
                                {{ date('d/m/Y', strtotime($matricula->created_at)) }}
                            </th>
                            <td>
                                <a class="btn btn-primary w-100 mt-1 mb-1"
                                    href="{{ route('admin.student.show', ['student' => $matricula->aluno()->first()->id]) }}"><i
                                        class="far fa-eye"></i></a>
                            </td>
                            <td>
                                <form onsubmit="return confirm('Tem certeza que deseja remover o(a) aluno(a) do curso?');"
                                    title="remover o(a) aluno(a) do curso"
                                    action="{{ route('admin.matricula.destroy', ['matricula' => $matricula->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger w-100 mt-1 mb-1 deleteCategory">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
