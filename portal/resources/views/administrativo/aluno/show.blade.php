@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-md-12 bg-gray-apple shadow-sm p-3 mb-5 rounded">
            <div class="row">
                <div class="col-9">
                    <h2 class="font-weight-bold">Matrículas do(a) Aluno(a) {{ $aluno->name }}:</h2>
                </div>
                <div class="col-3">
                    <a class="btn btn-secondary w-100" href="{{ route('admin.student.index') }}">Voltar</a>
                </div>
            </div>

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

            <a class="btn btn-primary" href="{{ route('admin.matricula.create', ['student' => $aluno->id]) }}">Cadastrar
                nova
                matrícula</a>

            <div class="row">
                <div class="col-md-12 bg-gray-apple p-3 mb-5 rounded">
                    <div class="row">
                        @foreach ($matriculas as $matricula)
                            <div class="col-md-4 mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ asset('storage/cover/' . $matricula->curso()->first()->cover) }}"
                                            alt="{{ $matricula->curso()->first()->name }}"
                                            title="{{ $matricula->curso()->first()->name }}" class="w-100">
                                    </div>
                                    <div class="col-md-8">
                                        <p class="w-100 shadow-sm m-1 p-3 bg-gray-100 rounded">
                                            <b>Nome:</b><br>{{ $matricula->curso()->first()->name }}<br>
                                            <b>Início:</b>
                                            {{ date('d/m/Y', strtotime($matricula->curso()->first()->start_date)) }}<br>
                                            <b>Término:</b>
                                            {{ date('d/m/Y', strtotime($matricula->curso()->first()->end_date)) }}<br>
                                        </p>
                                    </div>
                                    <div class="col-md-4 align-self-center">
                                        <form
                                            onsubmit="return confirm('Tem certeza que deseja remover o(a) aluno(a) do curso?');"
                                            title="remover o(a) aluno(a) do curso"
                                            action="{{ route('admin.matricula.destroy', ['matricula' => $matricula->id]) }}"
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
        </div>
    </div>

@endsection
