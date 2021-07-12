@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Material do curso <b>{{ $curso->name }}</b>:</h2>
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
        <div class="row">
            <div class="col-md-6 text-center">
                <label for="">Baixar PDF</label>
                <a href="{{ asset('storage' . $material->pdf) }}"
                    class="btn btn-primary w-100 {{ $material->pdf == null ? 'disabled' : '' }}" download>
                    <i class="far fa-eye"></i>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <label for="">Excluir PDF</label>
                <a href="{{ route('admin.material.destroy.pdf', ['material' => $material->id]) }}"
                    class="btn btn-danger w-100 {{ $material->pdf == null ? 'disabled' : '' }}">
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-6 text-center">
                <label for="">Baixar DOC</label>
                <a href="{{ asset('storage' . $material->doc) }}"
                    class="btn btn-primary w-100 {{ $material->doc == null ? 'disabled' : '' }}" download>
                    <i class="far fa-eye"></i>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <label for="">Excluir DOC</label>
                <a href="{{ route('admin.material.destroy.doc', ['material' => $material->id]) }}"
                    class="btn btn-danger w-100 {{ $material->doc == null ? 'disabled' : '' }}">
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputLink">Link do vídeo (apenas o código do vídeo)</label>
                    <input name="link_video" type="text" disabled class="form-control" id="inputLink"
                        value="{{ old('link_video') ? old('link_video') : $material->link_video }}">
                    <small class="form-text text-muted">Link de vídeo para o material.</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-check">
                        <input disabled class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo1"
                            value="none" {{ $material->type_video == null ? 'checked' : '' }}>
                        <label class="form-check-label" for="RadioTypeVideo1">
                            Não será informado vídeo
                        </label>
                    </div>
                    <div class="form-check">
                        <input disabled class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo1"
                            value="youtube" {{ $material->type_video == true ? 'checked' : '' }}>
                        <label class="form-check-label" for="RadioTypeVideo1">
                            O vídeo informado é do Youtube
                        </label>
                    </div>
                    <div class="form-check">
                        <input disabled class="form-check-input" type="radio" name="type_video" id="RadioTypeVideo2"
                            value="vimeo" {{ $material->type_video == false ? 'checked' : '' }}>
                        <label class="form-check-label" for="RadioTypeVideo2">
                            O vídeo informado é do Vimeo
                        </label>
                    </div>
                </div>
            </div>

            @if ($material->type_video === 1)
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <h4>Vídeo</h4>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $material->link_video }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
                <div class="col-md-2"></div>
            @elseif($material->type_video === 0)
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <h4>Vídeo</h4>
                    <iframe src="https://player.vimeo.com/video/{{ $material->link_video }}" width="640" height="360"
                        frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="col-md-2"></div>
            @else
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <h4>Não há vídeo para esse material</h4>
                </div>
                <div class="col-md-2"></div>
            @endif
        </div>
    </div>

@endsection
