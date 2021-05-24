@extends('layout')
@section('content')
    <body class="app app-purple">
        <div class="d-flex vh-100">
        <div class="bg-custom flex m-auto rounded align-items-center w-25">
            <div class="p-4">
                <h4 class="mb-2">Entrar</h4>
                <form class="mb-0" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="control-label" for="email">E-mail</label>
                        <input type="text" id="email" name="email" class="form-control" required placeholder="exemplo@gmail.com">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Senha</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="********">
                    </div>
                    <div class="text-center">
                        <div class="mt-4 mb-2">
                            <button class="btn btn-custom rounded-pill px-4">ENTRAR</button>
                        </div>
                        <small><a href="{{ route('register') }}">Cadastre-se</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection
