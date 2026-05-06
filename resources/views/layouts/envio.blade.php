<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EasyPhoto - Envio de Imagens</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
<link href="{{asset('assets/css/style1.css')}}" rel="stylesheet">

</head>
<body>

  {{-- Navbar --}}
  <nav class="navbar navbar-custom">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <a class="navbar-brand-logo text-decoration-none" href="{{ url('/lab') }}">EASY<span>PHOTO</span></a>
      <div class="d-flex align-items-center gap-3">

         @if(Route::is(['pedidos-cliente', 'meus-dados']))

                            <a class="btn-store-switch text-decoration-none" href="{{ route('lab') }}" ><i class="bi bi-arrow-left-right"></i> Enviar Fotos</a>

                        @endif
                        @if(Route::is('enviar-fotos'))

                             <a href="{{ url('/lab') }}" class="btn-store-switch text-decoration-none">
          <i class="bi bi-arrow-left-right"></i> Mudar Loja
        </a>

                        @endif
        <div class="user-menu dropdown">
          <span data-bs-toggle="dropdown" role="button">
            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name ?? 'Usuário' }}
            <i class="bi bi-caret-down-fill small"></i>
          </span>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('meus-dados', ['id'=>Auth::user()->id]) }}"><i class="bi bi-person me-2"></i>Meu Perfil</a></li>
            <li><a class="dropdown-item" href="{{ route('pedidos-cliente') }}"><i class="bi bi-clock-history me-2"></i>Pedidos</a></li>
            @canany(['is_admin', 'is_laboratorio'])
                                    <a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-speedometer2"></i>
                                        Painel
                                    </a>
                                    @endcanany
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                 onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i>Sair
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    @yield('content')
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
