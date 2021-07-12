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
            <a class="btn btn-primary" href="{{ route('student.curso.index') }}">Ver mais</a>
            <div class="row">
                @foreach ($cursos as $matricula)
                    <div class="col-md-3 mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="{{ asset('storage/cover/' . $matricula->curso()->first()->cover) }}" alt="{{ $matricula->curso()->first()->name }}"
                                    title="{{ $matricula->curso()->first()->name }}" class="w-100">
                            </div>
                            <div class="col-md-8">
                                <p class="w-100 shadow-sm m-1 p-3 bg-gray-100 rounded">
                                    <b>Nome:</b><br>{{ $matricula->curso()->first()->name }}<br>
                                    <b>Início:</b> {{ date('d/m/Y', strtotime($matricula->curso()->first()->start_date)) }}<br>
                                    <b>Término:</b> {{ date('d/m/Y', strtotime($matricula->curso()->first()->end_date)) }}<br>
                                </p>
                            </div>
                            <div class="col-md-4 align-self-center">
                                <a class="btn btn-primary w-100 mt-1 mb-1" title="Visualizar Curso"
                                    href="{{ route('student.curso.show', ['slug_curso' => $matricula->curso()->first()->slug]) }}">
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
