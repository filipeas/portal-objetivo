@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Novo Aluno</h2>
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
        <form action="{{ route('admin.student.store') }}" name="formCreateStudent" method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputName">Nome do Aluno</label>
                        <input required name="name" type="text" class="form-control" id="inputName" placeholder="Ex: Filipe"
                            value="{{ old('name') }}">
                        <small class="form-text text-muted">Digite nome do aluno.</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputLastname">Sobrenome do Aluno</label>
                        <input required name="lastname" type="text" class="form-control" id="inputLastname"
                            placeholder="Ex: Sampaio" value="{{ old('lastname') }}">
                        <small class="form-text text-muted">Digite sobrenome do aluno.</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputEmail">E-mail</label>
                        <input required name="email" type="email" class="form-control" id="inputEmail"
                            placeholder="Ex: felipealvessampaio@hotmail.com" value="{{ old('email') }}">
                        <small class="form-text text-muted">Digite um email.</small>
                    </div>
                </div>
            </div>

            <br>

            <p>Observação: A senha dos alunos recém cadastrados sempre é: 123456. Para mudar a senha, somente o aluno poderá
                realizar em seu painel.</p>

            <input type="submit" class="btn btn-primary w-100" value="Cadastrar">
        </form>
    </div>

@endsection
