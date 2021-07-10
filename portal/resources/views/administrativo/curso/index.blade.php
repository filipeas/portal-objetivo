@extends('administrativo.app')

@section('content')

    <div class="row">
        <div class="col-md-12 bg-gray-apple shadow-sm p-3 mb-5 rounded">
            <h2 class="font-weight-bold">Todos os Cursos:</h2>

            @if (session()->get('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('message') }} <br>
                </div>
            @endif

            <a class="btn btn-primary" href="{{ route('admin.curso.create') }}">Cadastrar novo curso</a>

            <div class="row">
                <div class="col-md-12 bg-gray-apple p-3 mb-5 rounded">
                    <div class="row">
                        @foreach ($cursos as $curso)
                            <div class="col-md-4 mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <img src="{{ asset('storage/cover/' . $curso->cover) }}"
                                            alt="{{ $curso->name }}" title="{{ $curso->name }}" class="w-100">
                                    </div>
                                    <div class="col-md-8">
                                        <p class="w-100 shadow-sm m-1 p-3 bg-gray-100 rounded">
                                            <b>Nome:</b><br>{{ $curso->name }}<br>
                                            <b>Início:</b> {{ date('d/m/Y', strtotime($curso->start_date)) }}<br>
                                            <b>Término:</b> {{ date('d/m/Y', strtotime($curso->end_date)) }}<br>
                                        </p>
                                    </div>
                                    <div class="col-md-4 align-self-center">
                                        <a class="btn btn-primary w-100 mt-1 mb-1"
                                            href="{{ route('admin.curso.show', ['slug_curso' => $curso->slug]) }}"><i
                                                class="far fa-eye"></i></a>
                                        <a class="btn btn-success w-100 mt-1 mb-1"
                                            href="{{ route('admin.curso.edit', ['slug_curso' => $curso->slug]) }}"><i
                                                class="fas fa-external-link-alt"></i></a>
                                        <form onsubmit="return confirm('Tem certeza que deseja excluir esse curso?');"
                                            action="{{ route('admin.curso.destroy', ['slug_curso' => $curso->slug]) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger w-100 mt-1 mb-1 deleteCategory">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
