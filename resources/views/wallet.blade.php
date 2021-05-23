@extends('layout')
@section('content')
    <div class="d-flex vh-100">
        <div class="bg-custom flex m-auto rounded align-items-center">
            <div class="p-4">
                <h4 class="mb-4">Olá, Nome completo do usuário</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 text-purple">R$ 0,00</h2>
                    <button class="btn btn-custom rounded-pill px-4" id="addTransfer" data-toggle="off">TRANSFERIR</button>
                </div>
                <div id="contentTransfer" style="display: none;">
                    <hr class="mb-4"/>
                    <form class="mb-0">
                        <div class="form-group">
                            <label class="control-label" for="user">Usuário</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text h-100 text-purple" id="basic-addon1"><i class="far fa-user"></i></span>
                                </div>
                                <select id="user" name="user" class="form-control"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="value">Valor</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text h-100 text-purple" id="basic-addon1">R$</span>
                                </div>
                                <input type="text" id="value" name="value" class="form-control">
                            </div>
                        </div>
                        <div class="text-center mt-4 mb-2">
                            <button class="btn btn-custom rounded-pill px-4">ENVIAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  <script>
      $('#addTransfer').on('click', function() {
          let toggle = $(this).data('toggle');
          if (toggle === 'off') {
              $('#contentTransfer').slideDown('slow');
              $(this).data('toggle', 'on');
          } else {
              $('#contentTransfer').slideUp('slow');
              $(this).data('toggle', 'off');
          }

      });

  </script>
@endsection
