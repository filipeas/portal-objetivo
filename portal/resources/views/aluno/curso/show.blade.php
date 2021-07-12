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

    <div class="row">
        <div class="col-md-12 bg-gray-apple pt-3 mb-5 rounded">
            <h3>Materiais do curso <b>{{ $curso->name }}</b></h3>
            <div class="row">

                <table class="table table-hover table-dark m-1 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Material</th>
                            <th scope="col"><i class="far fa-eye"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiais as $material)
                            <tr>
                                <th scope="row">{{ $material->pdf != null ? 'PDF, ' : '' }}
                                    {{ $material->doc != null ? 'DOC, ' : '' }}
                                    {{ $material->link_video != null ? 'Vídeo' : '' }}</th>
                                <td>
                                    <a class="btn btn-primary w-100 mt-1 mb-1" title="Visualizar Material"
                                        href="{{ route('student.material.show', ['material' => $material->id]) }}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
