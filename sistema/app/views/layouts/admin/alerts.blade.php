
@if (Session::has('success'))
    <div class="alert-sistema alert alert-success no-print" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4>{{ Session::get('success') }}</h4>
    </div>
@elseif (Session::has('fail'))
    <div class="alert-sistema alert alert-danger no-print" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
        <h4>{{ Session::get('fail') }}</h4>
    </div>
@endif
@if (count($errors) > 0)
  <div class="alert-sistema alert alert-danger no-print" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
  </div>
@endif
