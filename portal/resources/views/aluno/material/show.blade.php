@extends('aluno.app')

@section('content')

    <div class="row">
        <div class="col-9">
            <h2 class="font-weight-bold">Material do curso <b>{{ $curso->name }}</b>:</h2>
        </div>
        <div class="col-3">
            <a class="btn btn-secondary w-100"
                href="{{ route('student.curso.show', ['slug_curso' => $curso->slug]) }}">Voltar</a>
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
                <label for="">Baixar DOC</label>
                <a href="{{ asset('storage' . $material->doc) }}"
                    class="btn btn-primary w-100 {{ $material->doc == null ? 'disabled' : '' }}" download>
                    <i class="far fa-eye"></i>
                </a>
            </div>

            <div class="col-md-12">
                <hr>
            </div>

            @if ($material->type_video)
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <h4>Vídeo</h4>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $material->link_video }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
                <div class="col-md-2"></div>
            @else
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <h4>Vídeo</h4>
                    <iframe src="https://player.vimeo.com/video/{{ $material->link_video }}" width="640" height="360"
                        frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="col-md-2"></div>
            @endif
        </div>
    </div>

@endsection
