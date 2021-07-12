@extends('aluno.app')

@section('content')

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

    {{-- cursos --}}
    <div class="row">
        <div class="col-md-12 bg-gray-apple pt-3 mb-5 rounded">
            <h3>Meus Cursos</h3>
            <div class="row">
                @foreach ($cursos as $curso)
                    <div class="col-md-3 mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ asset('storage/cover/' . $curso->cover) }}" alt="{{ $curso->name }}"
                                    title="{{ $curso->name }}" class="w-100">
                            </div>
                            <div class="col-md-8">
                                <p class="w-100 shadow-sm m-1 p-3 bg-gray-100 rounded">
                                    <b>Nome:</b><br>{{ $curso->name }}<br>
                                    <b>Início:</b> {{ date('d/m/Y', strtotime($curso->start_date)) }}<br>
                                    <b>Término:</b> {{ date('d/m/Y', strtotime($curso->end_date)) }}<br>
                                </p>
                            </div>
                            <div class="col-md-4 align-self-center">
                                <a class="btn btn-primary w-100 mt-1 mb-1" title="Visualizar Curso"
                                    href="{{ route('student.curso.show', ['slug_curso' => $curso->slug]) }}">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
