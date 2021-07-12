@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Nova Matrícula do(a) aluno(a) {{ $aluno->name }}</h2>
        </div>
        <div class="col-3">
            <a class="btn btn-secondary w-100"
                href="{{ route('admin.student.show', ['student' => $aluno->id]) }}">Voltar</a>
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

    <div class="bg-gray-apple shadow-sm p-3 mb-5 rounded">
        <form action="{{ route('admin.matricula.store') }}" name="formCreateMatricula" method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="row">
                <input type="hidden" name="aluno" value="{{ $aluno->id }}">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="selectCursos">Cursos Disponíveis</label>
                        <select required name="curso" class="form-control" id="selectCursos">
                            <option value="">Selecione um curso</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-primary w-100" value="Cadastrar">
        </form>
    </div>

@endsection
