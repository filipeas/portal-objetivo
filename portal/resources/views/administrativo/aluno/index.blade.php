@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-md-12 bg-gray-apple shadow-sm p-3 mb-5 rounded">
            <h2 class="font-weight-bold">Todos os Alunos:</h2>

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

            <a class="btn btn-primary" href="{{ route('admin.student.create') }}">Cadastrar novo aluno</a>
            <br>
            <b class="m-2">Para cadastrar uma matrícula de um curso a um aluno, selecione o aluno desejado.</b>

            <div class="row">
                <div class="col-md-12 bg-gray-apple p-3 mb-5 rounded">
                    <div class="row">

                        <table class="table table-hover table-dark m-1 text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Nome Completo</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"><i class="far fa-eye"></i></th>
                                    <th scope="col"><i class="fas fa-external-link-alt"></i></th>
                                    <th scope="col"><i class="far fa-trash-alt"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alunos as $aluno)
                                    <tr>
                                        <th scope="row">{{ $aluno->name . ' ' . $aluno->lastname }}</th>
                                        <th scope="row">{{ $aluno->email }}</th>
                                        <td>
                                            <a class="btn btn-primary w-100 mt-1 mb-1"
                                                href="{{ route('admin.student.show', ['student' => $aluno->id]) }}"><i
                                                    class="far fa-eye"></i></a>
                                        </td>
                                        <td>
                                            <a class="btn btn-success w-100 mt-1 mb-1"
                                                href="{{ route('admin.student.edit', ['student' => $aluno->id]) }}"><i
                                                    class="fas fa-external-link-alt"></i></a>
                                        </td>
                                        <td>
                                            <form onsubmit="return confirm('Tem certeza que deseja excluir esse aluno?');"
                                                action="{{ route('admin.student.destroy', ['student' => $aluno->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger w-100 mt-1 mb-1">
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
            </div>
        </div>
    </div>

@endsection
