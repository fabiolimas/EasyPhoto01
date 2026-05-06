<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EasyPhoto - Login</title>
  <meta name="description" content="Acesse sua conta EasyPhoto - Lojas Imagem" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

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
    .input-icon, .form-control-dark {
      background: #1f1f1f !important;
      color: #fff !important;
      border: 0;
    }
    .input-icon { color: #888 !important; }
    .form-control-dark::placeholder { color: #666; }
    .form-control-dark:focus {
      background: #1f1f1f;
      color: #fff;
      box-shadow: none;
    }
    .btn-primary-red {
      background: linear-gradient(135deg, #e10b1e, #b3081a);
      border: 0;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(225,11,30,0.35);
      color: #fff;
    }
    .btn-primary-red:hover { color: #fff; opacity: .95; }
    .btn-social {
      background: #1f1f1f;
      color: #fff;
      border: 0;
    }
    .btn-social:hover { background: #2a2a2a; color: #fff; }
    .link-red { color: #ff4757; }
    .link-red:hover { color: #ff6b78; }
    .divider hr { border-color: rgba(255,255,255,.15); }

        #exampleModalCenter, #exampleModalLong, #modalObservacao {
    transform: none;
    --bs-modal-width: 869px;
}
div#exampleModalLong

 {
    margin-top: 18%;
    margin-left: -32px;
}
  </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
 @yield('content')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggle = document.getElementById('togglePwd');
    const pwd = document.getElementById('password');
    const icon = document.getElementById('pwdIcon');
    toggle.addEventListener('click', () => {
      const isPwd = pwd.type === 'password';
      pwd.type = isPwd ? 'text' : 'password';
      icon.className = isPwd ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });
  </script>
</body>
</html>
