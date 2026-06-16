@extends('layouts.login')

@section('title', 'Cadastre-se')

@section('content_header')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@section('content')

@include('components.alerts')
    <div class="row register-card shadow-lg rounded-4 overflow-hidden w-100 mx-0">

    <!-- Brand side -->
    <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-between p-5 text-white brand-side">
      <div>
        <h2 class="fw-bold mb-0" style="letter-spacing:1px;">EASY<span class="fw-light">PHOTO</span></h2>
        <p class="mt-2 opacity-75 small">by Lojas Imagem</p>
      </div>

      <div>
        <h1 class="fw-bold display-6 lh-sm">Crie sua conta<br/>em poucos passos.</h1>
        <p class="opacity-75 mt-3">
          Tenha acesso a revelações, álbuns personalizados, presentes exclusivos e muito mais.
        </p>

        <ul class="list-unstyled mt-4 d-flex flex-column gap-3">
          <li class="d-flex align-items-center gap-3">
            <span class="step-badge"><i class="bi bi-check-lg"></i></span>
            <small>Pedidos rápidos e seguros</small>
          </li>
          <li class="d-flex align-items-center gap-3">
            <span class="step-badge"><i class="bi bi-check-lg"></i></span>
            <small>Histórico das suas revelações</small>
          </li>
          <li class="d-flex align-items-center gap-3">
            <span class="step-badge"><i class="bi bi-check-lg"></i></span>
            <small>Promoções exclusivas para clientes</small>
          </li>
        </ul>
      </div>

      <div class="opacity-50 small">© 2026 EasyPhoto</div>
    </div>

    <!-- Form side -->
    <div class="col-lg-7 p-4 p-md-5 text-white form-side">
      <div class="d-lg-none text-center mb-4">
        <h2 class="fw-bold mb-0">EASY<span class="fw-light">PHOTO</span></h2>
      </div>

      <h3 class="fw-bold mb-1">Cadastre-se ✨</h3>
      <p class="text-secondary mb-4">Preencha seus dados para criar sua conta</p>

      <form method ="post" action="{{ route('registro-cliente') }}" class="row g-3" id="registerForm">
        @csrf
        <!-- Dados pessoais -->
        <div class="col-12">
          <h6 class="text-uppercase small text-secondary fw-semibold mb-2">
            <i class="bi bi-person-fill me-1"></i> Dados Pessoais
          </h6>
        </div>

        <div class="col-md-12">
          <label class="form-label small text-secondary">Nome Completo</label>
          <div class="input-group">
            <span class="input-group-text input-icon"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control form-control-dark" name="nome" id="nome" placeholder="Seu nome completo" required/>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label small text-secondary">CPF</label>
          <div class="input-group">
            <span class="input-group-text input-icon"><i class="bi bi-card-text"></i></span>
            <input type="text" class="form-control form-control-dark" name="cpf" id="cpf" placeholder="000.000.000-00" maxlength="14" required/>
                              <div class="invalid-feedback">
    CPF inválido
</div>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label small text-secondary">Telefone</label>
          <div class="input-group">
            <span class="input-group-text input-icon"><i class="bi bi-telephone-fill"></i></span>
            <input type="tel" class="form-control form-control-dark" name="telefone" id="telefone" placeholder="(00) 00000-0000" required/>
          </div>
        </div>

        <!-- Endereço -->
        <div class="col-12 mt-4">
          <h6 class="text-uppercase small text-secondary fw-semibold mb-2">
            <i class="bi bi-geo-alt-fill me-1"></i> Endereço
          </h6>
        </div>

        <div class="col-md-8">
          <label class="form-label small text-secondary">Endereço</label>
          <div class="input-group">
            <span class="input-group-text input-icon"><i class="bi bi-house-fill"></i></span>
            <input type="text" class="form-control form-control-dark" name="endereco" id="endereco" placeholder="Rua, número" required/>
          </div>
        </div>

        <div class="col-md-4">
          <label class="form-label small text-secondary">CEP</label>
          <div class="input-group">
            <span class="input-group-text input-icon"><i class="bi bi-mailbox"></i></span>
            <input type="text" class="form-control form-control-dark"  name="cep" id="cep" placeholder="00000-000" maxlength="9" required/>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label small text-secondary">Bairro</label>
          <input type="text" class="form-control form-control-dark" name="bairro" id="bairro" placeholder="Bairro" required/>
        </div>

        <div class="col-md-4">
          <label class="form-label small text-secondary">Cidade</label>
          <input type="text" class="form-control form-control-dark" name="cidade" id="cidade" placeholder="Cidade" required/>
        </div>

        <div class="col-md-2">
          <label class="form-label small text-secondary">Estado</label>
          <select class="form-select form-select-dark" name="uf" id="uf" required>
            <option value="">UF</option>
            <option>AC</option><option>AL</option><option>AP</option><option>AM</option>
            <option>BA</option><option>CE</option><option>DF</option><option>ES</option>
            <option>GO</option><option>MA</option><option>MS</option><option>MT</option>
            <option>MG</option><option>PA</option><option>PB</option><option>PR</option>
            <option>PE</option><option>PI</option><option>RJ</option><option>RN</option>
            <option>RS</option><option>RO</option><option>RR</option><option>SC</option>
            <option>SP</option><option>SE</option><option>TO</option>
          </select>
        </div>

        <!-- Acesso -->
        <div class="col-12 mt-4">
          <h6 class="text-uppercase small text-secondary fw-semibold mb-2">
            <i class="bi bi-shield-lock-fill me-1"></i> Dados de Acesso
          </h6>
        </div>

        <div class="col-md-6">
          <label class="form-label small text-secondary">E-mail</label>
          <div class="input-group">
            <span class="input-group-text input-icon"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" class="form-control form-control-dark" name="email" id="email"  placeholder="seu@email.com" required/>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label small text-secondary">Senha</label>
          <div class="input-group">
            <span class="input-group-text input-icon"><i class="bi bi-lock-fill"></i></span>
            <input id="password" type="password" class="form-control form-control-dark" name="password" id="password" placeholder="••••••••" required/>
            <button type="button" class="input-group-text input-icon" id="togglePwd" aria-label="Mostrar senha">
              <i id="pwdIcon" class="bi bi-eye-fill"></i>
            </button>
          </div>
        </div>

        <div class="col-12 mt-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms" required/>
            <label class="form-check-label small text-secondary" for="terms">
              Concordo com a <a href="#" class="link-red text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Política de Privacidade</a>
            </label>
          </div>
        </div>

        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary-red w-100 fw-semibold py-2">
            Criar minha conta <i class="bi bi-arrow-right ms-1"></i>
          </button>
        </div>

        <p class="text-center text-secondary small mt-3 mb-0">
          Já possui cadastro?
          <a href="{{route('login_cliente')}}" class="text-decoration-none fw-semibold link-red">Faça login aqui!</a>
        </p>
      </form>
    </div>
  </div>

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
<script src="https://unpkg.com/imask"></script>
<script>


    const telefone = document.getElementById('telefone');
    const cpf = document.getElementById('cpf');
const maskOptions = {
  mask: '(00) 00000-0000'
};
const maskcpf={
    mask:'000.000.000-00'
}
const mask = IMask(telefone, maskOptions);
const maskc = IMask(cpf, maskcpf);

    </script>

    <script>

// ===============================
// VALIDADOR DE CPF
// ===============================
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');

    if (cpf.length !== 11) return false;

    // elimina CPFs inválidos conhecidos
    if (/^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    let resto;

    // 1º dígito
    for (let i = 1; i <= 9; i++)
        soma += parseInt(cpf.substring(i-1, i)) * (11 - i);

    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;

    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    soma = 0;

    // 2º dígito
    for (let i = 1; i <= 10; i++)
        soma += parseInt(cpf.substring(i-1, i)) * (12 - i);

    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;

    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

// ===============================
// VALIDAÇÃO EM TEMPO REAL
// ===============================
cpf.addEventListener('blur', function () {
    if (!validarCPF(this.value)) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

// ===============================
// BLOQUEAR SUBMIT
// ===============================
document.getElementById('registerForm').addEventListener('submit', function(e){

    if (!validarCPF(cpf.value)) {
        e.preventDefault();
        cpf.classList.add('is-invalid');
        alert('CPF inválido!');
        return;
    }

});

</script>

    <!-- Adicionando JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>

    <!-- Adicionando Javascript -->
    <script>

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#endereco").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");

            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#endereco").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");


                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#endereco").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);

                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>


        @section('css')
        {{-- Add here extra stylesheets --}}
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @stop

    @section('js')
        <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    @stop
    @stop
