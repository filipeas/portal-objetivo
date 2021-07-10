@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Editar Curso: {{ $curso->name }}</h2>
        </div>
        <div class="col-3">
            <a class="btn btn-secondary w-100" href="{{ route('admin.curso.index') }}">Voltar</a>
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
        <div class="row p-5">
            <div class="col-md-12" style="padding-top:30px;">
                <div class="row text-center">
                    <div class="col-md-6">
                        <strong>Selecionar imagem de capa:</strong>
                        <input type="file" id="upload" class="m-2">
                        <button class="btn btn-success upload-result">Cortar imagem</button>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('storage/cover/' . $curso->cover) }}" alt="{{ $curso->name }}"
                            title="{{ $curso->name }}" class="w-50 m-2">
                    </div>
                </div>
            </div>

            <div class="col-md-5 text-center bg-dark">
                <div id="upload-demo" style="width:350px"></div>
            </div>

            <div class="col-md-7 text-center bg-white" style="">
                <div id="upload-demo-i"></div>
            </div>
        </div>

        <form action="{{ route('admin.curso.update', ['slug_curso' => $curso->slug]) }}" name="formCreateCurso"
            method="POST" enctype="multipart/form-data">

            @csrf

            @method('put')

            <div class="row">
                <input type="hidden" name="cover" id="cover">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputTitulo">Nome do Curso</label>
                        <input required name="name" type="text" class="form-control" id="inputCurso"
                            placeholder="Ex: Ciência da Computação"
                            value="{{ old('name') ? old('name') : $curso->name }}">
                        <small class="form-text text-muted">Digite nome do curso.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputTitulo">Data de Início do Curso</label>
                        <input required name="start_date" type="date" class="form-control" id="inputCurso"
                            placeholder="Ex: Ciência da Computação"
                            value="{{ old('start_date') ? old('start_date') : date('Y-m-d', strtotime($curso->start_date)) }}">
                        <small class="form-text text-muted">Digite a data de início do curso.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputTitulo">Data de Término do Curso</label>
                        <input required name="end_date" type="date" class="form-control" id="inputCurso"
                            placeholder="Ex: Ciência da Computação"
                            value="{{ old('end_date') ? old('end_date') : date('Y-m-d', strtotime($curso->end_date)) }}">
                        <small class="form-text text-muted">Digite a data de término do curso.</small>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-success w-100" value="Editar">
        </form>
    </div>

@endsection
