<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>EasyPhoto — Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="{{asset('assets/css/style_painel.css')}}" rel="stylesheet">
</head>
<body>
<div class="app">
  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="brand-logo"><i class="bi bi-camera-fill"></i></div>
      <div>
        <div class="brand-name">EasyPhoto</div>
        <div class="brand-sub">Portal de vendas</div>
      </div>
    </div>
@php
                    $nome = Auth::user()->name;
                    $iniciais = strstr($nome, ' ', true)[0] . trim(strstr($nome, ' ')[1]);
                @endphp
    {{-- <div class="sidebar-search">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Buscar no painel...">
      <kbd>⌘K</kbd>
    </div> --}}

    <nav class="sidebar-nav">
      <div class="nav-group-label">Principal</div>
    <a href="{{route("home")}}" class="nav-item @if(Route::is('home')) active @endif"><i class="bi bi-grid-1x2"></i><span>Dashboard</span></a>
     <a href="{{route("pedidos")}}" class="nav-item @if(Route::is('pedidos')) active @endif"><i class="bi bi-bag-check"></i><span>Pedidos</span><span class="badge-count">{{$pedidosPendentes}}</span></a>
@can('is_admin')
      <div class="nav-group-label">Módulos</div>
      <a href="{{route('usuarios')}}" class="nav-item @if(Route::is('usuarios')) active @endif"><i class="bi bi-person"></i><span>Usuários</span></a>
      <a href="{{route('clientes')}}" class="nav-item @if(Route::is('clientes')) active @endif"><i class="bi bi-people"></i><span>Clientes</span></a>
      <a href="{{route('laboratorios')}}" class="nav-item @if(Route::is('laboratorios')) active @endif"><i class="bi bi-building"></i><span>Laboratórios</span></a>
      <a href="{{route('formas-de-entrega')}}" class="nav-item @if(Route::is('formas-de-entrega')) active @endif"><i class="bi bi-truck"></i><span>Formas de Entrega</span></a>

      <div class="nav-group-label">Revelação</div>
      <a href="{{route('lab')}}" class="nav-item @if(Route::is('lab')) active @endif"><i class="bi bi-images"></i><span>Revelar</span></a>
      @endcan
      {{-- <a href="#" class="nav-item"><i class="bi bi-gear"></i><span>Configurações</span></a> --}}
    </nav>

    <div class="sidebar-footer">
      <div class="user-card">
        <div class="avatar">{{$iniciais}}</div>
        <div class="user-meta">
          <div class="user-name">{{Auth::user()->name}}</div>
          <div class="user-role">{{Auth::user()->nivel}}</div>
        </div>
           <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <i class="bi bi-box-arrow-right"></i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

      </div>
    </div>
  </aside>
   <!-- Main -->
  <main class="main">
    <header class="topbar">
      <button class="icon-btn d-lg-none" id="menuBtn"><i class="bi bi-list"></i></button>
      <div class="crumbs">
        <span class="text-muted">Painel</span>
        <i class="bi bi-chevron-right small"></i>
        <span>Dashboard</span>
      </div>
      <div class="topbar-actions">
        <button class="icon-btn"><i class="bi bi-search"></i></button>
        <button class="icon-btn"><i class="bi bi-bell"></i><span class="dot"></span></button>
        <button class="icon-btn"><i class="bi bi-arrows-fullscreen"></i></button>
        <div class="divider-v"></div>
        <div class="user-chip">
          <div class="avatar sm">{{$iniciais}}</div>
          <div class="d-none d-sm-block">
            <div class="fw-semibold small">{{Auth::user()->name}}</div>
            <div class="text-muted xsmall">{{Auth::user()->email}}</div>
          </div>

          <i class="bi bi-chevron-down small text-muted"></i>
        </div>
      </div>
    </header>
    <section class="content">
        @yield('content')

         </section>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
</body>
</html>
