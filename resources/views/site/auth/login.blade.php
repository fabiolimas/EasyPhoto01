@extends('layouts.login')

@section('title', 'Login - EasyPhoto')

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at 20% 20%, #2a2a2a 0%, #0d0d0d 60%, #000 100%);
            min-height: 100vh;
        }
        .login-card {
            max-width: 980px;
            background: #111;
            border: 1px solid #1f1f1f;
        }
        .brand-side {
            background: linear-gradient(135deg, #e10b1e 0%, #b3081a 50%, #1a1a1a 100%);
        }
        .form-side { background: #141414; }
        .input-dark, .input-group-text-dark {
            background: #1f1f1f !important;
            color: #fff;
            border: 0;
        }
        .input-group-text-dark { color: #888; }
        .input-dark::placeholder { color: #666; }
        .input-dark:focus {
            background: #1f1f1f;
            color: #fff;
            box-shadow: none;
        }
        .btn-primary-red {
            background: linear-gradient(135deg, #e10b1e, #b3081a);
            border: 0;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(225,11,30,0.35);
        }
        .btn-primary-red:hover { color: #fff; opacity: .95; }
        .text-red { color: #ff4757; }
        .btn-social {
            background: #1f1f1f;
            color: #fff;
            border: 0;
        }
        .btn-social:hover { color: #fff; background: #2a2a2a; }
    </style>
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-center p-3" style="min-height:100vh;">
    <div class="row login-card shadow-lg rounded-4 overflow-hidden w-100 g-0">

        {{-- Brand side --}}
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5 text-white brand-side">
            <div>
                <h2 class="fw-bold mb-0" style="letter-spacing:1px;">
                    EASY<span class="fw-light">PHOTO</span>
                </h2>
                <p class="mt-2 opacity-75 small">by Lojas Imagem</p>
            </div>

            <div>
                <h1 class="fw-bold display-5 lh-sm">
                    Suas fotos,<br>do seu jeito.
                </h1>
                <p class="opacity-75 mt-3">
                    Revele momentos, crie álbuns e personalize lembranças com toda a praticidade que você merece.
                </p>

                <div class="d-flex gap-3 mt-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-camera-fill fs-5"></i><small>Revelações</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-book-fill fs-5"></i><small>Álbuns</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-gift-fill fs-5"></i><small>Presentes</small>
                    </div>
                </div>
            </div>

            <div class="opacity-50 small">© {{ date('Y') }} EasyPhoto</div>
        </div>

        {{-- Form side --}}
        <div class="col-lg-6 p-4 p-md-5 text-white form-side">
            <div class="d-lg-none text-center mb-4">
                <h2 class="fw-bold mb-0">EASY<span class="fw-light">PHOTO</span></h2>
            </div>

            <h3 class="fw-bold mb-1">Bem-vindo de volta 👋</h3>
            <p class="text-secondary mb-4">Acesse sua conta para continuar</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label small text-secondary">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-dark">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}"
                               class="form-control input-dark"
                               placeholder="seu@email.com" required autofocus>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label small text-secondary">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-dark">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="password" id="password"
                               class="form-control input-dark"
                               placeholder="••••••••" required>
                        <button type="button" class="input-group-text input-group-text-dark"
                                onclick="togglePassword()" aria-label="Mostrar senha">
                            <i id="pwdIcon" class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-secondary" for="remember">
                            Lembrar-me
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small text-decoration-none text-red">
                        Esqueceu a senha?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary-red w-100 fw-semibold py-2">
                    Entrar <i class="bi bi-arrow-right ms-1"></i>
                </button>

                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1 border-secondary opacity-25">
                    <span class="px-3 small text-secondary">ou</span>
                    <hr class="flex-grow-1 border-secondary opacity-25">
                </div>

                {{-- <div class="d-flex gap-2">
                    <a href="{{ url('/auth/google') }}" class="btn btn-social flex-grow-1">
                        <i class="bi bi-google me-2"></i>Google
                    </a>
                    <a href="{{ url('/auth/facebook') }}" class="btn btn-social flex-grow-1">
                        <i class="bi bi-facebook me-2"></i>Facebook
                    </a>
                </div> --}}

                <p class="text-center text-secondary small mt-4 mb-0">
                    Não tem cadastro?
                    <a href="{{route('registro_cliente')}}" class="text-decoration-none fw-semibold text-red">
                        Cadastre-se
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('pwdIcon');
        const isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';
        icon.className = isPwd ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    }
</script>
@endpush
@endsection
