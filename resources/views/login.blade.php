@extends('layout')
@section('content')
    <div class="d-flex vh-100">
        <div class="bg-custom flex m-auto rounded align-items-center">
            <div class="p-4">
                <h4 class="mb-2">Entrar</h4>
                <form class="mb-0">
                    <div class="form-group">
                        <label class="control-label" for="email">E-mail</label>
                        <input type="text" id="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Senha</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="text-center">
                        <div class="mt-4 mb-2">
                            <button class="btn btn-custom rounded-pill px-4">ENTRAR</button>
                        </div>
                        <small><a href="">Cadastre-se</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
