@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Editar Material do curso <b>{{ $curso->name }}</b>:</h2>
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
        <form action="{{ route('admin.material.update', ['material' => $material->id]) }}" name="formCreateMaterial"
            method="POST" enctype="multipart/form-data">

            @csrf

            @method('put')

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="inputPDF">PDF</label>
                        <input name="pdf" type="file" class="form-control" id="inputPDF">
                        <small class="form-text text-muted">Informe um PDF (tamanho máximo de 2mb).</small>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <label for="">Baixar PDF</label>
                    <a href="{{ asset('storage' . $material->pdf) }}"
                        class="btn btn-primary w-100 {{ $material->pdf == null ? 'disabled' : '' }}" download>
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <div class="col-md-2 text-center">
                    <label for="">Excluir PDF</label>
                    <a href="{{ route('admin.material.destroy.pdf', ['material' => $material->id]) }}"
                        class="btn btn-danger w-100 {{ $material->pdf == null ? 'disabled' : '' }}">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label for="inputDOC">DOC</label>
                        <input name="doc" type="file" class="form-control" id="inputDOC">
                        <small class="form-text text-muted">Informe um DOC (tamanho máximo de 2mb).</small>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <label for="">Baixar DOC</label>
                    <a href="{{ asset('storage' . $material->doc) }}"
                        class="btn btn-primary w-100 {{ $material->doc == null ? 'disabled' : '' }}" download>
                        <i class="far fa-eye"></i>
                    </a>
                </div>
                <div class="col-md-2 text-center">
                    <label for="">Excluir DOC</label>
                    <a href="{{ route('admin.material.destroy.doc', ['material' => $material->id]) }}"
                        class="btn btn-danger w-100 {{ $material->doc == null ? 'disabled' : '' }}">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputLink">Link do vídeo (apenas o código do vídeo)</label>
                        <input name="link_video" type="text" class="form-control" id="inputLink"
                            value="{{ old('link_video') ? old('link_video') : $material->link_video }}">
                        <small class="form-text text-muted">Informe um link de vídeo para o material.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo1" value="none"
                                {{ $material->type_video == null ? 'checked' : '' }}>
                            <label class="form-check-label" for="RadioTypeVideo1">
                                Não será informado vídeo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo1"
                                value="youtube" {{ $material->type_video == true ? 'checked' : '' }}>
                            <label class="form-check-label" for="RadioTypeVideo1">
                                O vídeo informado é do Youtube
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo2"
                                value="vimeo" {{ $material->type_video == false ? 'checked' : '' }}>
                            <label class="form-check-label" for="RadioTypeVideo2">
                                O vídeo informado é do Vimeo
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-success w-100" value="Editar">
        </form>
    </div>

@endsection
