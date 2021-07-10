@extends('administrativo.app')

@section('content')

    <div class="row mb-1">
        <div class="col-9">

        </div>
        <div class="col-3">
            <a class="btn btn-secondary w-100" href="{{ route('admin.curso.index') }}">Voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 bg-gray-apple shadow-sm p-3 mb-5 rounded">
            <h2 class="font-weight-bold">Materiais do curso <br><b>{{ $curso->name }}</b>:</h2>

            @if (session()->get('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('message') }} <br>
                </div>
            @endif

            <a class="btn btn-primary"
                href="{{ route('admin.material.create', ['slug_curso' => $curso->slug]) }}">Cadastrar novo material</a>

            <table class="table table-hover table-dark m-1 text-center">
                <thead>
                    <tr>
                        <th scope="col">Material</th>
                        <th scope="col"><i class="far fa-eye"></i></th>
                        <th scope="col"><i class="fas fa-external-link-alt"></i></th>
                        <th scope="col"><i class="far fa-trash-alt"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materiais as $material)
                        <tr>
                            <th scope="row">{{ $material->pdf != null ? 'PDF, ' : '' }}
                                {{ $material->doc != null ? 'DOC, ' : '' }}
                                {{ $material->link_video != null ? 'Vídeo' : '' }}</th>
                            <td>
                                <a class="btn btn-primary w-100 mt-1 mb-1"
                                    href="{{ route('admin.material.show', ['material' => $material->id]) }}"><i
                                        class="far fa-eye"></i></a>
                            </td>
                            <td>
                                <a class="btn btn-success w-100 mt-1 mb-1"
                                    href="{{ route('admin.material.edit', ['material' => $material->id]) }}"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </td>
                            <td>
                                <form onsubmit="return confirm('Tem certeza que deseja excluir esse material?');"
                                    action="{{ route('admin.material.destroy', ['material' => $material->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger w-100 mt-1 mb-1 deleteCategory">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="col-md-6 bg-gray-apple shadow-sm p-3 mb-5 rounded">
            <h2 class="font-weight-bold">Matrículas do curso <br><b>{{ $curso->name }}</b>:</h2>

            @if (session()->get('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('message') }} <br>
                </div>
            @endif

            <a class="btn btn-primary" href="{{ route('admin.matricula.create') }}">Cadastrar matrícula</a>

        </div>
    </div>

@endsection
