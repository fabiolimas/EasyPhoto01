@extends('layouts.site')

@section('title', 'Dashboard')

@section('content_header')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )

@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@section('auth_header', __('adminlte::adminlte.login_message'))@section('content')
@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop
@include('components.alerts')


    <div class="row d-flex justify-content-center align-itens-center mt-5">
        <div class="col-md-6">
            <div class="logoEasyPHoto">
                <img src="{{asset('assets/img/logo_easy_photo.png')}}" class="w-100">
            </div>

        </div>
            <div class="col-md-6 ">
                <h4>Login</h4>
                <form id="loginForm" method ="post" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" required>
                               @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
                    </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Senha" required>
                 @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
                </div>


                    <div class="form-group">
                        <button type="submit" id="entrar" class="btn btn-dark">Entrar</button>
                    </div>

                </form>
                <hr>
                <div class="row text-center mt-3">
                    <div class="col-md-6 mb-3">
                        <h5>Esqueceu a senha?</h5>
                                         {{-- Password reset link --}}
    @if($password_reset_url)
        <p class="my-0">
            <a href="{{ $password_reset_url }}" class="text-white" target="_blank">
                {{ __('Redefinir senha!') }}
            </a>
        </p>
    @endif
                    </div>
                    <div class="col-md-6 mb-3">
 <h5>Não tem Cadastro?</h5>
                    <a href="{{route('registro_cliente')}}" class="item-link text-white">Clique aqui e cadastre-se</a>

                    </div>

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
     <script>

  $(document).ready(function () {
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
        @section('css')
        {{-- Add here extra stylesheets --}}
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @stop

    @section('js')
        <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>


    @stop
    @stop
