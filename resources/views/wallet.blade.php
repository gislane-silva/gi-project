@extends('layout')
@section('content')
    <body class="app app-light">
        <div class="d-flex justify-content-start">
            <div class="w-50 vh-100 d-flex align-items-center justify-content-center bg-ilustration">
            </div>
            <div class="d-flex vh-100">
                <div class="flex m-auto">
                    <div class="bg-custom wallet rounded align-items-center shadow border-purple">
                        <div class="p-4">
                            <h4 class="mb-4">Olá, {{ $userLogged->name }}</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="mb-0 text-purple"><span id="textBalance" data-value="{{ $userLogged->wallet->amount ?? 0 }}">R$ {{ number_format(($userLogged->wallet->amount ?? 0), 2, ',', '.') }}</span></h2>
                                @if($userLogged->present()->getUserTypeEnum('user') == $userLogged->user_type_enum)
                                    <button class="btn btn-custom rounded-pill px-4" id="addTransfer" data-toggle="off">TRANSFERIR</button>
                                @endif
                            </div>
                            @if($userLogged->present()->getUserTypeEnum('user') == $userLogged->user_type_enum)
                                <div id="contentTransfer" style="display: none;">
                                <hr class="mb-4"/>
                                <form class="mb-0" id="formTransfer" action={{ route('.transactionsstore') }}>
                                    <input type="hidden" name="payer" value="{{ $userLogged->id }}">
                                    <div class="form-group">
                                        <label class="control-label" for="payee">Usuário</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text h-100 text-purple" id="basic-addon1"><i class="far fa-user"></i></span>
                                            </div>
                                            <select id="payee" name="payee" class="form-control" required>
                                                <option value="">Selecione</option>
                                                @if(count($allUsers ?? []) > 0)
                                                    @foreach($allUsers as $user)
                                                        @if($userLogged->id != $user->id)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="value">Valor</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text h-100 text-purple" id="basic-addon1">R$</span>
                                            </div>
                                            <input type="text" id="value" name="value" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4 mb-2">
                                        <button id="btnSend" class="btn btn-custom rounded-pill px-4">ENVIAR</button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    <a class="btn btn-outline-dark mt-3" href="{{ route('logout') }}">Sair</a>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('scripts')
  <script>
      $('#value').mask('000.000.000.000.000,00', {reverse: true});
      $('#addTransfer').on('click', function() {
          let toggle = $(this).data('toggle');
          if (toggle === 'off') {
              $('#contentTransfer').slideDown('slow');
              $(this).data('toggle', 'on');
              $(this).text('CANCELAR');
          } else {
              $('#contentTransfer').slideUp('slow');
              $(this).data('toggle', 'off');
              $(this).text('TRANSFERIR');
          }
      });

      $('#formTransfer').on('submit', function (e) {
          e.preventDefault();
          $('#btnSend').addClass('btn-disabled').prop('disabled', true);
          let payerId = parseInt($(this).find('input[name="payer"]').val());
          let payeeId = parseInt($(this).find('select[name="payee"]').val());
          let transferAmount = parseFloat($(this).find('input[name="value"]').val());
          let totalBalance = parseFloat($('#textBalance').data('value'));
          let result = parseFloat(totalBalance - transferAmount);
          let resultFormatted = result.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

          if (result < 0) {
              toastr['error']('Saldo insuficiente');
          } else {
              let url = $(this).attr('action');

              $.ajax({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  async: false,
                  method: "POST",
                  url: url,
                  data: {
                      payer: payerId,
                      payee: payeeId,
                      value: transferAmount,
                  },
              }).done(function(data) {
                  let textBalance = $('#textBalance');
                  textBalance.attr('data-value', result);
                  textBalance.text(resultFormatted);
                  toastr['success'](data.message);
              }).fail(function(data) {
                  if (typeof data.responseJSON.errors !== 'undefined') {
                      $.each(data.responseJSON.errors, function(key, value) {
                          toastr['error'](value);
                      });
                  } else {
                      toastr['error'](data.responseJSON.message);
                  }
              }).always(function () {
                  $('#btnSend').removeClass('btn-disabled').prop('disabled', false);
              });
          }
      });

  </script>
@endsection
