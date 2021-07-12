<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - Login</title>
    <!-- estilos do layout -->
    <link rel="stylesheet" href="{{ asset('site/style.css') }}">
    <link rel="stylesheet" href="{{ asset('site/style_login.css') }}">

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first p-5">
                <h4>Login</h4>
                <p>preencha seus dados para acessar o sistema.</p>
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

            <!-- Login Form -->
            <form action="{{ route('login.do') }}" name="formLogin" method="POST">
                @csrf
                <input required type="text" id="email" class="fadeIn second" name="email"
                    placeholder="E-mail do usuário">
                <input required type="password" id="password" class="fadeIn third" name="password" placeholder="Senha">
                <input type="submit" class="fadeIn fourth" value="Login">
            </form>

        </div>
    </div>
</body>

<!-- import da biblioteca do bootstrap -->
{{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
<!-- import do jquery -->
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<!-- import do jquery form -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script> --}}

<script src="{{ asset('site/jquery.js') }}"></script>
<script src="{{ asset('site/jquery-form.js') }}"></script>
<script src="{{ asset('site/bootstrap.js') }}"></script>
<script src="{{ asset('site/fontawesome.js') }}"></script>

<!-- import das mascaras do jquery -->
<script src="{{ asset('site/jquery-mask.js') }}"></script>

</html>
