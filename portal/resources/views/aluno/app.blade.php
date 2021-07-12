<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - Painel do Aluno</title>

    <link rel="stylesheet" href="{{ asset('site/style.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('site/fontawesome.css') }}">

    <link rel="stylesheet" href="{{ asset('site/croppie.css') }}">
</head>

<body>
    @section('sidebar')
        <!-- header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('student.home') }}">Início</a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('student.curso.index') }}" title="Meus Cursos">Meus Cursos</a>
                    </li>
                </ul>

                <div class="text-center">
                    <a class="btn text-gray mr-sm-2" title="Editar perfil" alt="Editar perfil"
                        href="{{ route('student.config.edit', ['aluno' => Auth::user()->id]) }}">
                        Olá, {{ Auth::user()->name }}
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown"
                            title="Pedidos da loja" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-2x fa-user-circle"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item"
                                href="{{ route('student.config.edit', ['aluno' => Auth::user()->id]) }}">Editar
                                perfil</a>
                            <a class="dropdown-item"
                                href="{{ route('student.config.edit.password', ['aluno' => Auth::user()->id]) }}">Editar
                                Senha</a>
                            <a class="dropdown-item" href="{{ route('logout.do') }}">Sair</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end header -->
    @show

    <!-- content -->
    <div class="container">
        @yield('content')
    </div>
    <!-- end content -->

    <!-- footer -->
    <!-- end footer -->

    <!-- include scripts -->
    <script src="{{ asset('site/jquery.js') }}"></script>
    <script src="{{ asset('site/jquery-form.js') }}"></script>
    <script src="{{ asset('site/bootstrap.js') }}"></script>
    <script src="{{ asset('site/fontawesome.js') }}"></script>
    <script src="{{ asset('site/jquery-mask.js') }}"></script>
    <script src="{{ asset('site/croppie.js') }}"></script>
    {{-- <!-- <script src="{{ asset('site/store/site.js') }}"></script> --> --}}
</body>

</html>
