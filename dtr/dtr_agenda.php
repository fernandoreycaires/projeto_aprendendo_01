<?php
    session_start();
    include '../_php/cx.php';
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        $cnpj = $_SESSION['cnpj_session'];
        $user = $_SESSION['user_session'];
        $pass = $_SESSION['pass_session'];

    //VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
    $acesso_user = $cx->query ($acesso);

    while ($perfil = $acesso_user->fetch()){
        $id = $perfil['id_u_cnpj'];
        $nome = $perfil['nome_u'];
        $cnpju = $perfil['cnpj_vinc'];
        $crm = $perfil['crm'];
     }  
     
     $data_atual = date('Y-m-d');
     
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ADM Consultório</title>
                <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
                <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
		<link href="../_css/dtr.css" rel="stylesheet" type="text/css"/>
                <!--Não alterar a ordem de busca dessas bibliotecas -->
                <link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <link href='../_css/fullcalendar.min.css' rel='stylesheet'>
                <link href='../_css/fullcalendar.print.min.css' rel='stylesheet' media='print'>
                <link href='../_css/scheduler.min.css' rel='stylesheet'>
                <script src='../_javascript/jquery.min.js'></script>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/moment.min.js'></script>
                <script src='../_javascript/fullcalendar.min.js'></script>
                <script src='../_javascript/pt-br.js'></script>
                <script src='../_javascript/scheduler.min.js'></script>
                <script>

                    $(document).ready(function() {

                      $('#calendar').fullCalendar({
                          schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                        header: {
                          left: 'prev,next today',
                          center: 'title',
                          right: 'month,agendaWeek,agendaDay'
                        },
                          defaultView: 'month',
                          defaultDate: Date(),
                          nowIndicator: true,
                          navLinks: true, // can click day/week names to navigate views
                          editable: true,
                          eventLimit: true, // allow "more" link when too many events

                          <?php 
                              $acessohoras = "select atend_h, atend_m, ini_h, ini_m, fim_h, fim_m from cnpj WHERE cnpj_c = '".$cnpj."'";
                              $acesso_userhoras = $cx->query ($acessohoras);

                              while ($horas = $acesso_userhoras->fetch()){
                                  $atendh = $horas[atend_h];
                                  $atendm = $horas[atend_m];
                                  $inicioh = $horas[ini_h];
                                  $iniciom = $horas[ini_m];
                                  $fimh = $horas[fim_h];
                                  $fimm = $horas[fim_m];
                              } 
                          ?>

                          slotDuration: "<?php echo $atendh?>:<?php echo $atendm?>:00",
                          minTime: "<?php echo $inicioh?>:<?php echo $iniciom?>:00",
                          maxTime: "<?php echo $fimh?>:<?php echo $fimm?>:00",

                          eventClick: function(event) {

                              $('#visualizar #id').text(event.id);
                              $('#visualizar #title').text(event.title);
                              $('#visualizar #cpf').text(event.cpf);
                              $('#visualizar #cpfmod').text(event.cpfmod);
                              $('#visualizar #cel').text(event.cel);
                              $('#visualizar #celmod').text(event.celmod);
                              $('#visualizar #remarcacao').text(event.remarcacao);
                              $('#visualizar #convenio').text(event.convenio);
                              $('#visualizar #doutor').text(event.doutor);
                              $('#visualizar #start').text(event.start.format("DD/MM/YYYY HH:mm"));
                              $('#visualizar #end').text(event.end.format("DD/MM/YYYY HH:mm"));
                              $('#visualizar #obs').text(event.obs);
                              $('#visualizar').modal('show');
                              return false;

                          },


                          selectHelper: true,
                          select: function(start, end){
                              $('#cadastrar #start').val(moment(start).format("DD/MM/YYYY HH:mm"));
                              $('#cadastrar #end').val(moment(end).format("DD/MM/YYYY HH:mm"));
                              $('#cadastrar').modal('show');
                          },

                          events: [
                                <?php
                                  //BUSCA INFORMAÇÕES DA TABELA AGENDA
                                  $mostra_sql = "SELECT * FROM agenda WHERE cnpj = '".$cnpj."' and crm = '".$crm."'";
                                  $mostra = $cx->query ($mostra_sql);
                                  while ($dados = $mostra->fetch()){

                                          //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                          $celmod = $dados['cel'];
                                          $celn = substr_replace($celmod, '(', 0, 0);
                                          $celn = substr_replace($celn, ')', 3, 0);
                                          $celn = substr_replace($celn, '-', 9, 0);
                                          $celn = substr_replace($celn, ' ', 4, 0);
                                          $celn = substr_replace($celn, ' ', 6, 0);

                                          //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                          $cpfmod = $dados['cpf'];
                                          $cpfn = substr_replace($cpfmod, '.', 3, 0);
                                          $cpfn = substr_replace($cpfn, '.', 7, 0);
                                          $cpfn = substr_replace($cpfn, '-', 11, 0);
                                          ?>
                                          {
                                              id: '<?php echo $dados['id_data']; ?>',
                                              resourceIds: '<?php echo $dados['referencia']; ?>',
                                              title: '<?php echo $dados['nome']; ?>',
                                              cpf: '<?php echo $dados['cpf']; ?>',
                                              cpfmod: '<?php echo $cpfn; ?>',
                                              cel: '<?php echo $dados['cel']; ?>',
                                              celmod: '<?php echo $celn; ?>',
                                              remarcacao: '<?php echo $dados['remarcacao']; ?>',
                                              convenio: '<?php echo $dados['convenio']; ?>',
                                              doutor: '<?php echo $dados['doutor']; ?>',
                                              start: '<?php echo $dados['inicio']; ?>',
                                              end: '<?php echo $dados['fim']; ?>',
                                              obs: '<?php echo $dados['obs']; ?>',
                                              color: '<?php echo $dados['cor']; ?>'
                                          },<?php
                                      }
                                  ?>
                              ]


                      });

                    });

                </script>
                <style>
                                        
                    body {
                        margin: 0px 0px;
                        padding: 0;
                        font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                        font-size: 14px;
                        color: rgba(255,255,255,1);

                    }
                    
                    a {
                        color: #D3D3D3;
                    }
                    
                    /* ALTERA AS CONFIGURAÇÕES de plano de fundo da janela modal*/
                    .modal-backdrop {
                        background-color: #1C1C1C;
                    }

                    /* ALTERA AS CONFIGURAÇÕES de conteudo da Janela Modal */
                    .modal-content {
                        background-color: rgba(38,42,48,.9);
                    }

                    .modal-content input {
                        background-color: rgba(38,42,48,1);
                        color: rgba(255,255,255,1);
                    }

                    .modal-content select {
                        background-color: rgba(38,42,48,1);
                        color: rgba(255,255,255,1);
                    }

                    #calendar {
                        max-width: 98%;
                        margin: 0 auto 0 auto;
                    }

                    /* ALTERA AS CONFIGURAÇÕES dos dados NO CALENDARIO*/
                    #calendar .fc-content{
                        font-size: 11pt;
                    }

                    /* ALTERA AS CONFIGURAÇÕES do background EM DATA ATUAL NO CALENDARIO*/
                    #calendar .fc-today{
                        background-color: rgba(0,0,0,.6);
                        font-size: 12pt;
                    }
                    
                    
                    
                    /* MENUS DE NAVEGAÇÃO */
                    .nav-tabs {
                        border-bottom:1px solid #ddd;
                    }

                    .nav-tabs>li{
                        float:left;
                        margin-bottom: -1px;
                    }
                    
                    .nav-tabs>li>a{
                        margin-right:2px;
                        line-height:1.42857143;
                        border:1px solid rgb(122, 121, 121);
                        border-radius:4px 4px 0 0;
                        background-color:rgba(96,96,96,.5);
                    }
                    
                    .nav-tabs>li>a:hover{
                        border-color:rgba(85, 129, 130, .5);
                        background-color:rgba(85, 129, 130, .5);
                    }

                    .nav-tabs>li.active>a,.nav-tabs>li.active>a:focus,.nav-tabs>li.active>a:hover{
                        color:#e0e0e0;
                        cursor:default;
                        background-color:rgb(122, 121, 121);
                        border:1px solid rgb(122, 121, 121);
                        border-bottom-color:rgb(122, 121, 121);
                    }
                    
                    .nav-tabs.nav-justified>.active>a,.nav-tabs.nav-justified>.active>a:focus,.nav-tabs.nav-justified>.active>a:hover{
                        border:1px solid rgb(122, 121, 121);
                    }
                    
                    /*FIM DO MENU DE NAVEGAÇÃO*/
                </style>
	</head>
	<body>
                <div class="container-fluid theme-showcase estilo" role="main">
                    <div class="logo1"></div>
                    <header class="cabecalho">
                        <a href="../home.php" type="button" class="dropdownvoltar">Voltar</a>
                        <div class="dropdown">
                            <button class="dropbtn"><?php echo $nome;?></button>
                            <div class="dropdown-content">
                                <a href="../home.php">Perfil</a>
                                <a href="../_php/alterarsenhausuario.php">Alterar Senha</a>
                                <a href="../_php/fechar_sessao.php">Sair</a>
                            </div>
                        </div>
                    </header>
			<div class="page-header">
				<h1 align="center">Doutores </h1>
			</div>
			<div class="row">
				<div class="col-md-12">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li role="presentation"><a href="dtr_perfil.php" target="_self">Perfil</a></li>
                                        <li role="presentation"><a href="dtr_atendimento.php" target="_self">Atendimentos</a></li>
                                        <li role="presentation"><a href="dtr_prontuario.php" target="_self">Prontuários</a></li>
                                        <li role="presentation" class="active"><a href="dtr_agenda.php" target="_self">Agenda</a></li>
                                    </ul>
                                </div>
			</div>
                    <br>
                        <div class="row">
                            <div id='calendar'></div>
                                <div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title text-center">Dados do Agendamento</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="visualizar">
                                                    <dl class="dl-horizontal">
                                                        <dt>ID do Agendamento:</dt>
                                                        <dd id="id"></dd>
                                                        <dt>Nome do Paciente:</dt>
                                                        <dd id="title"></dd>
                                                        <dt>CPF:</dt>
                                                        <dd id="cpfmod"></dd>
                                                        <dt>Celular:</dt>
                                                        <dd id="celmod"></dd>
                                                        <dt>Remarcação:</dt>
                                                        <dd id="remarcacao"></dd>
                                                        <dt>Convênio:</dt>
                                                        <dd id="convenio"></dd>
                                                        <dt>Doutor:</dt>
                                                        <dd id="doutor"></dd>
                                                        <dt>Inicio da consulta:</dt>
                                                        <dd id="start"></dd>
                                                        <dt>Fim da consulta:</dt>
                                                        <dd id="end"></dd>
                                                        <dt>Observação:</dt>
                                                        <dd id="obs"></dd>
                                                    </dl>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                            
                        </div>
                    <br>
                    <footer id="rodape">
                        <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                        <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                    </footer>
		</div>  
            

  </body>
</html>
<?php
}else{
    header("location:../index.php");
}
?>

