@extends('layout')
@section('content')
    <body class="app app-purple">
    <div class="d-flex vh-100">
        <div class="bg-custom flex m-auto rounded align-items-center w-25">
            <div class="p-4">
                <h4 class="mb-2">Cadastrar-se</h4>
                <form class="mb-0" id="formRegister" action="{{ route('.usersstore') }}" data-url-login="{{ route('login') }}">
                    <div class="form-group">
                        <label class="control-label" for="name">Nome completo</label>
                        <input type="text" id="name" name="name" class="form-control" required placeholder="Nome Sobrenome" minlength="3" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="cpf_cnpj">CPF/CNPJ</label>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="form-control" required placeholder="000.000.000-00">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="exemplo@gmail.com">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Senha</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="********" minlength="8">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password_confirmation">Confirmar senha</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="********" minlength="8">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="user_type_enum" name="user_type_enum">
                        <label class="control-label" for="user_type_enum">Cadastrar como lojista</label>
                    </div>
                    <div class="text-center">
                        <div class="mt-4 mb-2">
                            <button id="btnSubmit" class="btn btn-custom rounded-pill px-4">CADASTRAR</button>
                        </div>
                        <small>
                            <a href="{{ route('login') }}">Entrar</a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection
@section('scripts')
    <script>
        let options = {
            onKeyPress: function (cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('#cpf_cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }

        $('#cpf_cnpj').length > 11 ? $('#cpf_cnpj').mask('00.000.000/0000-00', options) : $('#cpf_cnpj').mask('000.000.000-00#', options);

        $('#formRegister').on('submit', function (e) {
            e.preventDefault();
            $('#btnSubmit').addClass('btn-disabled').prop('disabled', true);
            let url = $(this).attr('action');
            let urlLogin = $(this).data('url-login');
            let name = $(this).find('input[name="name"]').val();
            let cpfCnpj = $(this).find('input[name="cpf_cnpj"]').val();
            let email = $(this).find('input[name="email"]').val();
            let password = $(this).find('input[name="password"]').val();
            let passwordConfirmation = $(this).find('input[name="password_confirmation"]').val();
            let userTypeEnum = 1;

            if ($(this).find('input[name="user_type_enum"]').is(':checked')) {
                userTypeEnum = 2;
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                method: "POST",
                url: url,
                data: {
                    name: name,
                    cpf_cnpj: cpfCnpj,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirmation,
                    user_type_enum: userTypeEnum
                },
            }).done(function () {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: urlLogin,
                    data: {
                        email: email,
                        password: password,
                    },
                }).done(function () {
                    window.location.href = "/home";
                }).fail(function (data) {
                    if (typeof data.responseJSON.errors !== 'undefined') {
                        $.each(data.responseJSON.errors, function(key, value) {
                            toastr['error'](value);
                        });
                    } else {
                        toastr['error']('Não foi possível realizar o login');
                    }
                });
            }).fail(function (data) {
                if (typeof data.responseJSON.errors !== 'undefined') {
                    $.each(data.responseJSON.errors, function(key, value) {
                        toastr['error'](value);
                    });
                } else {
                    toastr['error'](data.responseJSON.message);
                }
            }).always(function () {
                $('#btnSubmit').removeClass('btn-disabled').prop('disabled', false);
            });

        });
    </script>
@endsection
