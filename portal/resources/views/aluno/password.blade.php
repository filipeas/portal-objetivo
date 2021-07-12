@extends('aluno.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Editar Dados do Aluno {{ Auth()->user()->name }}:</h2>
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

    <div class="bg-gray-apple shadow-sm p-3 mb-5 rounded">
        <form action="{{ route('student.config.update.password', ['aluno' => Auth()->user()->id]) }}" name="formCreateStudent"
            method="POST" enctype="multipart/form-data">

            @csrf

            @method('put')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputPass">Senha Atual</label>
                        <input required name="c_password" type="password" class="form-control" id="inputPass">
                        <small class="form-text text-muted">Digite sua senha atual.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputPass">Nova Senha</label>
                        <input required name="password" type="password" class="form-control" id="inputPass">
                        <small class="form-text text-muted">Digite a nova senha.</small>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-success w-100" value="Editar">
        </form>
    </div>

@endsection
