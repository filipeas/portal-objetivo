@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Novo Material do curso <b>{{ $curso->name }}</b>:</h2>
        </div>
        <div class="col-3">
            <a class="btn btn-secondary w-100"
                href="{{ route('admin.curso.show', ['slug_curso' => $curso->slug]) }}">Voltar</a>
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
        <form action="{{ route('admin.material.store') }}" name="formCreateMaterial" method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="row">
                <input required type="hidden" name="curso" id="curso" value="{{ $curso->id }}">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputPDF">PDF</label>
                        <input name="pdf" type="file" class="form-control" id="inputPDF">
                        <small class="form-text text-muted">Informe um PDF (tamanho máximo de 2mb).</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputDOC">DOC</label>
                        <input name="doc" type="file" class="form-control" id="inputDOC">
                        <small class="form-text text-muted">Informe um DOC (tamanho máximo de 2mb).</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputLink">Link do vídeo (apenas o código do vídeo)</label>
                        <input name="link_video" type="text" class="form-control" id="inputLink" placeholder="Ex: pG2BMnPqfgo"
                            value="{{ old('link_video') }}">
                        <small class="form-text text-muted">Informe um link de vídeo para o material (apenas o código do vídeo).</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo1" value="none"
                                checked>
                            <label class="form-check-label" for="RadioTypeVideo1">
                                Não será informado vídeo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo1"
                                value="youtube">
                            <label class="form-check-label" for="RadioTypeVideo1">
                                O vídeo informado é do Youtube
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo2"
                                value="vimeo">
                            <label class="form-check-label" for="RadioTypeVideo2">
                                O vídeo informado é do Vimeo
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-primary w-100" value="Cadastrar">
        </form>
    </div>

@endsection
