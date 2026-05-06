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

<!-- Modal1 -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">


      </div>
      <div class="modal-body">
        Este site utiliza cookies e tecnologias semelhantes para melhorar sua experiência de navegação.
Ao navegar ou utilizar serviços neste site, consideramos que você aceita o uso. Saiba mais acessando nossa <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
  Política de Privacidade
                </a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok, entendi!</button>

      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-bs-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Política de Privacidade de Dados</h5>
        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

        </button>
      </div>
      <div class="modal-body">

<div class="divText">

<div class="titulo">

</div>

<div class="divConteudo">
	<div class="conteudo">
		<p>
			Para que possamos oferecer a você uma ótima experiência com nossa plataforma online e você
			possa realizar compras em nosso site, nós coletamos alguns dados pessoais e referentes à sua
			navegação. Esses dados são coletados quando você acessa os nossos serviços, navega pelo site,
			realiza seu cadastro em nossa plataforma e quando realiza compras. Ao longo deste documento
			descreveremos quais dados coletamos, como são utilizados, armazenados e compartilhados.
		</p>

		<p>
			Este documento foi escrito com base na Lei Geral de Proteção de Dados Pessoais (LGPD, Lei nº
			13.709/2018) que você pode ler na íntegra através deste link:
		</p>

		<a id="linkLGPD" href="http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/L13709.htm" target="_blank"> http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/L13709.htm </a>


		<p>
			Ao navegar em nosso site ou realizar seu cadastro, você concorda com a coleta de dados
			realizada pelos cookies e pelo formulário de cadastro (descritos no item 1 deste documento), o
			tratamento desses dados (descritos no item 2 deste documento) e o compartilhamento dos dados com
			nossa empresa.
		</p>

		<p>
			Desde já gostaríamos de ressaltar que nós não vendemos ou comercializamos informações
			que possam identificá-lo, nem compartilhamos ou transferimos informações pessoais para terceiros,
			 empresas filiais que compartilham a mesma base de
			clientes, autoridades competentes, entre outros, sempre tendo como objetivo o uso responsável dos
			seus dados e observando seus direitos descritos na Lei Geral de Proteção de Dados Pessoais.
		</p>

		<p>
			Todos os dados solicitados e coletados por nós são armazenados pela Lojas Imagem Foto e Ótica.,
			que mantém a segurança e proteção dos seus dados e não os compartilha ou comercializa com
			terceiros.
		</p>
	</div>
</div>

<div class="divConteudo">
	<div class="subtitulo">
		<h4> 1. Como e que tipo de dados nós coletamos </h4>
	</div>

	<div class="conteudo">
		<ul>
			<li>
				<strong>Dados pessoais</strong> <br>
				<p>
					Quando você cria uma conta em nosso site, são solicitados dados pessoais como nome
					completo, endereço, telefone, e-mail, CPF, data de nascimento e gênero. Eles ficam
					armazenados em nossa plataforma online para que você possa realizar compras utilizando
					login e senha.
				</p>
			</li>

			<li>
				<strong>Dados de cobrança</strong> <br>
				<p>
					Nós não armazenamos dados de cobrança. Quando você realiza um pedido através do
					nosso site e faz o pagamento online, por cartão de crédito, boleto bancário, entre outros,
					você é direcionado para plataformas de pagamento online (como PagSeguro, Cielo e
					PayPal) para que você realize o pagamento através delas. São estas plataformas que irão
					coletar e verificar seus dados de pagamento, como número do cartão de crédito, CPF,
					nome completo, endereço de cobrança, validade do cartão e código de segurança.
				</p>

				<p>
					Caso você utilize estas plataformas de pagamento, observe as políticas de privacidade de
					cada plataforma, disponíveis diretamente no site de cada empresa
				</p>
			</li>

			<li>
				<strong>Dados de navegação</strong> <br>
				<p>
					Você se declara ciente e fornece seu consentimento sobre a coleta, utilização e
					compartilhamento dos dados de navegação quando você acessa e navega pelo nosso site.
				</p>

				<p>
					Durante seu acesso ao site, algumas informações são coletadas através de cookies que
					servem para gravar dados referentes às suas visitas no site. Pelos cookies, coletamos dados
					como as páginas que você visitou, itens adicionados ao carrinho, salvamento de login e
					senha, dispositivos pelos quais você acessou nosso site (identificador da unidade, nome e
					sistema operacional do dispositivo), sua localização aproximada (latitude e longitude),
					endereço de IP, tipo do navegador e informação da conexão com a internet. Esses dados
					são gravados diretamente no navegador do dispositivo que você utilizou (computador,
					tablet ou smartphone) e ficam salvos para que sejam utilizados na próxima vez que você
					visitar o nosso site.
				</p>

				<p>
					Além disso, quando você interagir com nosso site, podemos solicitar o acesso à sua galeria
					de fotos, câmera e fotos em redes sociais.
				</p>
			</li>
		</ul>
	</div>
</div>


<div class="divConteudo">
	<div class="subtitulo">
		<h4> 2. Como os dados são utilizados</h4>
	</div>

	<div class="conteudo">
		<p>
			Os dados que coletamos quando você acessa e interage com os recursos do nosso site são
			utilizados por nós para alguns fins:
		</p>

		<ul>
			<li>
				<strong>Dados pessoais</strong> <br>
				<p>
					Solicitamos e armazenamos dados pessoais para:
				</p>

				<p>
					(I) Que a compra e entrega dos produtos possa ser viabilizada através do nosso e-commerce;<br>

					(II) Verificar sua identidade ao realizar compras e transações em nosso site; <br>

					(III) Elaborar e manter um registro das operações realizadas, bem como informá-lo sobre elas e
					realizar acompanhamento adequado;<br>

					(IV) Enviar conteúdo digital como promoções, comunicados, novos serviços ofertados ou
					atualizações dessa Política de Privacidade;<br>

					(V) Processar o pagamento quando você realizar compras;<br>

					(VI) Enviar confirmações e informações sobre o andamento do pedido;<br>

					(VII) Prover suporte técnico e operacional para garantir a segurança e funcionalidade dos
					serviços e também responder às suas solicitações;<br>

					(VIII) Proteger nossos direitos e propriedades, inclusive de invasões e hackeamento;<br>

					(IX) Otimizar sua experiência de compra e navegação em nossas plataformas digitais.<br>

					(X) Contribuir para a segurança das relações, comunicações e transações entre os colaboradores
					e os usuários da plataforma.<br>

					(XI) Cumprir quaisquer normas, requisitos ou regulamentos referentes à regimes tributários de
					arrecadação, registro, auditoria e cobrança, entre outros, conforme leis em vigor em nosso país.<br>
				</p>
			</li>

			<li>
				<strong>Dados de navegação e cookies</strong> <br>
				<p>
					Os dados de navegação que coletamos e o processamento desses dados são realizados por
					algumas tecnologias, como os cookies e o Google Analytics. Nós utilizamos estas plataformas para que
					possamos, mas não está limitado a:
				</p>

				<p>
					(I) Otimizar a sua experiência de navegação, para não consumir tantos dados de internet ou
					gerar lentidão na plataforma toda vez que você a acessa;<br>

					(II) Realizar pesquisas internas da empresa de forma a adaptar nossa estratégia de marketing e
					publicidade para fornecer serviços e produtos mais adequados à nossa clientela e leads; <br>

					(III) Aprimorar nossas iniciativas de promoções, oferta de produtos e conteúdo para as
					necessidades dos nossos clientes, com base nos dados de compra e visitação;<br>

					(IV) Processar os dados e oferecer serviços digitais cada vez melhores e mais personalizados;<br>

					(V) Evitar fraudes e crimes, visando garantir a sua segurança e a sustentabilidade da plataforma;<br>

					(VI)  Proteger seus direitos, os direitos de outros usuários e os direitos da nossa empresa;<br>


				</p>

				<p>
					Ao utilizar nosso site, você também concorda com as políticas da Google sobre privacidade e
					termos de serviços. Você pode conferir as políticas da Google nos links abaixo:

					<a href="https://policies.google.com/technologies/partner-sites?hl=pt-BR" target="_blank">
						https://policies.google.com/technologies/partner-sites?hl=pt-BR
					</a>
					<a href="https://policies.google.com/privacy" target="_blank">
						https://policies.google.com/privacy
					</a>
					<a href="https://policies.google.com/privacy" target="_blank">
						https://policies.google.com/privacy
					</a>
				</p>
			</li>
		</ul>
	</div>
</div>


<div class="divConteudo">
	<div class="subtitulo">
		<h4> 3. Compartilhamento de dados e sua privacidade </h4>
	</div>

	<div class="conteudo">
		<p>
			Como já falamos no início deste documento, nós não comercializamos ou cedemos seus dados
			pessoais ou de navegação a terceiros, exceto:
		</p>

		<ul>
			<li>
				<p>


					(I) Com possíveis filiais da nossa empresa, que compartilham a mesma base de clientes,
					estratégias de marketing e gerenciamento; <br>

					(II) Com entidades governamentais, com autorização específica, visando o cumprimento de suas
					competências legais, de acordo com a Lei Geral de Proteção de Dados Pessoais (LGPD, Lei nº
					13.709/2018);<br>


				</p>

				<p>
					Como observamos no tópico 2 deste documento, “Como os dados são utilizados”, seus dados
					são compartilhados com nossa empresa, a título de melhorar todos os
					serviços que oferecemos a você, viabilizar a compra de produtos em nossas plataformas, entre outros.
					Buscamos sempre utilizar de forma responsável os dados que coletamos e sempre observando seus
					direitos descritos na Lei Geral de Proteção de Dados Pessoais (LGPD, Lei nº 13.709/2018).
				</p>
			</li>

			<li>
				<strong>Sobre o tempo de armazenamento dos dados</strong> <br>
				<p>
					Estes dados ficam disponíveis para nossa consulta e são armazenados por tempo
					indeterminado, ou até que você realize a exclusão da sua conta ou modificação dos seus dados em
					nossa plataforma.
					em plataforma segura, que atende as medidas de boas práticas, sigilo de dados e segurança previstas
					na Lei Geral de Proteção de Dados Pessoais (LGPD, Lei nº 13.709/2018)
				</p>
			</li>
		</ul>

	</div>
</div>

<div class="divConteudo">
	<div class="subtitulo">
		<h4> 4. Gerenciamento de cookies e exclusão dos seus dados </h4>
	</div>

	<div class="conteudo">
		<p>
			Como já falamos no início deste documento, nós não comercializamos ou cedemos seus dados
			pessoais ou de navegação a terceiros, exceto:
		</p>

		<ul>
			<li>
				<strong>Google Chrome: </strong> <br>
				<a href="https://support.google.com/chrome/answer/95647?co=GENIE.Platform%3DDesktop&amp;oco=1&amp;hl=pt-BR" target="_blank">
					https://support.google.com/chrome/answer/95647?co=GENIE.Platform%3DDesktop&amp;oco=1&amp;hl=pt-BR
				</a>
			</li>

			<li>
				<strong>Mozilla Firefox: </strong> <br>
				<a href="https://support.mozilla.org/pt-BR/kb/gerencie-configuracoes-de-armazenamento-local-de-s" target="_blank">
					https://support.mozilla.org/pt-BR/kb/gerencie-configuracoes-de-armazenamento-local-de-s
				</a>
			</li>

			<li>
				<strong>Safari:</strong> <br>
				<a href="https://support.apple.com/pt-br/guide/safari/sfri11471/mac" target="_blank">
					https://support.apple.com/pt-br/guide/safari/sfri11471/mac
				</a>
			</li>

			<li>
				<strong>Internet Explorer</strong> <br>
				<a href="https://support.microsoft.com/pt-br/windows/excluir-e-gerenciar-cookies-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank">
					https://support.microsoft.com/pt-br/windows/excluir-e-gerenciar-cookies-168dab11-0753-043d-7c16-ede5947fc64d
				</a>
			</li>

			<li>
				<strong>Microsoft Edge</strong> <br>
				<a href="https://support.microsoft.com/pt-br/microsoft-edge/excluir-cookies-no-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank">
					https://support.microsoft.com/pt-br/microsoft-edge/excluir-cookies-no-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09
				</a>
			</li>

			<li>
				<strong>Opera</strong> <br>
				<a href="https://help.opera.com/en/latest/web-preferences/#cookies" target="_blank">
					https://help.opera.com/en/latest/web-preferences/#cookies
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="divConteudo">
	<div class="subtitulo">
		<h4> 5. Nossos dados </h4>
	</div>

	<div class="conteudo">
		<div class="dadosEmpresa">
			<p>
				<strong>Foto Imagem: </strong><br>
			</p>
			<p>
				Endereço:  Avenida Orlando Oliveira Pires, nº 206, Jacobina - BA.<br>
			</p>
			<p>
				CEP: 44702-292.<br>
			</p>
			<p>
				CNPJ: 16.480.857/0001-96  .<br>
			</p>
		</div>


	</div>
</div>


</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok Entendi</button>

      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
     <script>

  $(document).ready(function () {
    // $("#exampleModalLong").modal("show");
    let dataSalva = localStorage.getItem('modalExibida');

    if (!dataSalva) {
        $("#exampleModalLong").modal("show");
        localStorage.setItem('modalExibida', new Date().getTime());
    } else {
        let agora = new Date().getTime();
        let diferenca = agora - dataSalva;

        let umDia = 24 * 60 * 60 * 1000;

        if (diferenca > umDia) {
            $("#exampleModalLong").modal("show");
            localStorage.setItem('modalExibida', agora);
        }
    }
});
        </script>

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
