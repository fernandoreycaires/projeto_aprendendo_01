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
    $id = $perfil[id_u_cnpj];
    $nome = $perfil[nome_u];
    $cnpju = $perfil[cnpj_vinc];
    $razao = $perfil[razao_c];
 } 

$msg = isset($_POST['msg'])?$_POST['msg']:'';

//POST REFERENTE A BUSCA DESTA MESMA PAGINA
$filtro = isset($_POST['filtro'])?$_POST['filtro']:"";
    if ($filtro == ""){
        $ocultar = "oc";
    }else{
        $alturadiv = "height: 100px;";
    }
             
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset='UTF-8'>
        <title>Agenda</title>
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <link href='../_css/estilo.css' rel='stylesheet' type='text/css'>
        <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
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
                
                defaultView: 'agendaDay',
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
                    $('#visualizar #id').val(event.id);
                    $('#visualizar #title').text(event.title);
                    $('#visualizar #title').val(event.title);
                    $('#visualizar #cpf').text(event.cpf);
                    $('#visualizar #cpf').val(event.cpf);
                    $('#visualizar #cpfmod').text(event.cpfmod);
                    $('#visualizar #cpfmod').val(event.cpfmod);
                    $('#visualizar #cel').text(event.cel);
                    $('#visualizar #cel').val(event.cel);
                    $('#visualizar #celmod').text(event.celmod);
                    $('#visualizar #celmod').val(event.celmod);
                    $('#visualizar #remarcacao').text(event.remarcacao);
                    $('#visualizar #remarcacao').val(event.remarcacao);
                    $('#visualizar #convenio').text(event.convenio);
                    $('#visualizar #convenio').val(event.convenio);
                    $('#visualizar #doutor').text(event.doutor);
                    $('#visualizar #doutor').val(event.doutor);
                    $('#visualizar #start').text(event.start.format("DD/MM/YYYY HH:mm"));
                    $('#visualizar #start').val(event.start.format("DD/MM/YYYY HH:mm"));
                    $('#visualizar #end').text(event.end.format("DD/MM/YYYY HH:mm"));
                    $('#visualizar #end').val(event.end.format("DD/MM/YYYY HH:mm"));
                    $('#visualizar #obs').text(event.obs);
                    $('#visualizar #obs').val(event.obs);
                    $('#visualizar').modal('show');
                    return false;

                },
                
                selectable: true,
                selectHelper: true,
                select: function(start, end){
                    $('#cadastrar #start').val(moment(start).format("DD/MM/YYYY HH:mm"));
                    $('#cadastrar #end').val(moment(end).format("DD/MM/YYYY HH:mm"));
                    $('#cadastrar').modal('show');
                },
                    
                resources: [
                        <?php
                            //BUSCA INFORMAÇÕES DA TABELA CNPJ_USER
                            $mostra_sql1 = "SELECT referencia, nome_u, crm, cor FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' and crm != ''";
                            $mostra1 = $cx->query ($mostra_sql1);
                            while ($dados1 = $mostra1->fetch()){
                        ?>
                                { 
                                    id:  '<?php echo $dados1['referencia']; ?>',
                                    title: '<?php echo $dados1['nome_u']; ?>',
                                    color: '<?php echo $dados1['cor']; ?>'
                                },<?php
                            }
                        ?>
                        ],
                
                events: [
                      <?php
                        //BUSCA INFORMAÇÕES DA TABELA AGENDA
                        $mostra_sql = "SELECT * FROM agenda WHERE cnpj = '".$cnpj."'";
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
          
        //Máscara para o campo data e hora
	function DataHora(evento, objeto){
            var keypress=(window.event)?event.keyCode:evento.which;
		campo = eval (objeto);
		if (campo.value == '00/00/0000 00:00:00'){
                    campo.value=""
		}
			 
	caracteres = '0123456789';
	separacao1 = '/';
	separacao2 = ' ';
	separacao3 = ':';
	conjunto1 = 2;
	conjunto2 = 5;
	conjunto3 = 10;
	conjunto4 = 13;
	conjunto5 = 16;
	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (19)){
		if (campo.value.length == conjunto1 )
                    campo.value = campo.value + separacao1;
			else if (campo.value.length == conjunto2)
                            campo.value = campo.value + separacao1;
				else if (campo.value.length == conjunto3)
                                    campo.value = campo.value + separacao2;
                                    else if (campo.value.length == conjunto4)
					campo.value = campo.value + separacao3;
                                            else if (campo.value.length == conjunto5)
                                                campo.value = campo.value + separacao3;
	}else{
            event.returnValue = false;
            }
	}

        </script>
        <style>

            body {
                margin: 0 10px;
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
                max-width: 100%;
                margin: 0 auto;
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

            .visualizar{
                display: block;
            }

            .form{
                display: none;
            }
            
            /*OUTROS*/
            .form-control-busca {
                background-color: rgba(38,42,48,1);
                color: rgb(255,255,255);
                width: 250px;
                height:30px;
                padding:6px 12px;
                font-size:14px;
                line-height:1.42857143;
                border:1px solid #ccc;
                border-radius:4px;
                -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                }
            
            div#busca{
                display: block;
                width: 100%;
                <?php echo $alturadiv; ?>
            }
                
            div#busca1{
                float: left;
                width: 30%;
            }

            div#busca2{
                float: right;
                width: 69%;
            }

        </style>
    </head>
    <body>
        <div class="container-fluid theme-showcase estilo" role="main">
                <div class="logo1"></div>    
                <header class="cabecalho">
                        <a href="#" type="button" onclick="window.close()" class="dropdownvoltar">Voltar</a>
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
				<h1 align="center">Agenda</h1>
			</div>
            <h4 align="center"><?php echo $msg;?></h4>
            
            <div id="busca" class="">
                <div id="busca1" class="">
                    <form method="post" action="home_cal.php">
                        <input type="text" placeholder="Busca por Nome ou Celular" name="filtro" class="form-control-busca"> 
                        <button type="submit" class="btn btn-xs btn-success">Buscar</button>
                    </form>
                </div>
                
                <div id="busca2" class="<?php echo $ocultar;?>">
                    <table class="table">
                        <thead>
                        <th>Nome:</th>
                        <th>Celular:</th>
                        <th>Doutor: </th>
                        <th>Dia: </th>
                        <th>Hora:</th>
                        </thead>
                    <?php 
                    
                    // COMANDO PARA EXECUTAR BUSCA
                        $busca_sql = "SELECT id_data, nome, cel, doutor, inicio FROM agenda WHERE cnpj = '".$cnpj."' AND nome = '".$filtro."' OR cnpj = '".$cnpj."' AND cel = '".$filtro."' ORDER BY id_data DESC limit 1";
                        $busca_envia = $cx->query ($busca_sql);
                        while ($busca = $busca_envia ->fetch()){
                            $b_id = $busca['id_data'];
                            $b_nome = $busca['nome'];
                            $b_cel = $busca['cel'];
                            $b_doutor = $busca['doutor'];
                            $b_inicio = $busca['inicio'];
                            
                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                            $b_cel = substr_replace($b_cel, '(', 0, 0);
                            $b_cel = substr_replace($b_cel, ')', 3, 0);
                            $b_cel = substr_replace($b_cel, '-', 9, 0);
                            $b_cel = substr_replace($b_cel, ' ', 4, 0);
                            $b_cel = substr_replace($b_cel, ' ', 6, 0);
                            
                            //SEPARANDO DIA E HORA
                            list($dia_b, $hora_b ) = explode(' ', $b_inicio);
                            list($ano_b, $mes_b, $dia_bb ) = explode('-', $dia_b);
                            
                    ?>

                        <tr>
                            <td><?php echo $b_nome;?></td>
                            <td><?php echo $b_cel;?></td>
                            <td><?php echo $b_doutor;?></td>
                            <td><?php echo "$dia_bb/$mes_b/$ano_b";?></td>
                            <td><?php echo "$hora_b";?></td>
                        </tr>

                    <?php
                    }
                    ?>
                    </table>
                </div>
                <br><br>
            </div>
            <br>
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
                                    <dt>Fim extimado:</dt>
                                    <dd id="end"></dd>
                                    <dt>Observação:</dt>
                                    <dd id="obs"></dd>
                                </dl>
                                <form method="post" action="atendimento_abrir.php">
                                    <input type="hidden" class="form-control" name="id" id="id">
                                    <button type="submit" class="btn btn-primary">Abrir Ficha de Atendimento</button>
                                </form>
                                    <br>
                                    <form method="post" action="del_cad_agenda.php">
                                        <input type="hidden" class="form-control" name="id" id="id">
                                        <button type="button" class="btn btn-canc-vis btn-success">Editar</button>
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                            </div>
                            <div class="form">
                                   
                                <form class="form-horizontal" method="post" action="edit_cad_agenda.php">
                                        <div class="form-group">
                                            <label for="nome_cal" class="col-sm-2 control-label">Nome: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nome_cal" id="title" placeholder="Nome completo">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cpf_cal" class="col-sm-2 control-label">CPF: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="cpf_cal" id="cpf" placeholder="Somente Números">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cel_cal" class="col-sm-2 control-label">Celular: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="cel_cal" id="cel" placeholder="Somente Números com o DDD">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="rem_cal" class="col-sm-2 control-label">Remarcação: </label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="rem_cal">
                                                    <option id="remarcacao" selected>Não</option>
                                                    <option>Não</option>
                                                    <option>Sim</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="conv_cal" class="col-sm-2 control-label">Convênio: </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="conv_cal" id="convenio" >
                                                </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="start" class="col-sm-2 control-label">Inicio: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="inicio" id="start" onkeypress="DataHora(event, this)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="end" class="col-sm-2 control-label">Fim: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="fim" id="end" onkeypress="DataHora(event, this)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="hidden" class="form-control" name="id" id="id">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="obs_cal" class="col-sm-2 control-label">Observação: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="obs_cal" id="obs" placeholder="Seja breve">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-success">Executar Alteração</button>
                                                <button type="button" class="btn btn-canc-edit btn-primary">Cancelar</button>
                                            </div>  
                                        </div>
                                    </form>
                                
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title text-center">Inserir Agendamento</h4>
                        </div>
                        
                        <div class="modal-body">
                            
                            <form class="form-horizontal" method="post" action="proc_cad_agenda.php">
                                    <div class="form-group">
                                        <label for="nome_cal" class="col-sm-2 control-label">Nome: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nome_cal" id="nome_cal" placeholder="Nome completo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cpf_cal" class="col-sm-2 control-label">CPF: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="cpf_cal" id="cpf_cal" placeholder="Somente Números">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="cel_cal" class="col-sm-2 control-label">Celular: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="cel_cal" id="cel" placeholder="Somente Números com o DDD">
                                            </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="rem_cal" class="col-sm-2 control-label">Remarcação: </label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="rem_cal" id="remarcacao">
                                                    <option selected>Não</option>
                                                    <option>Sim</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="conv_cal" class="col-sm-2 control-label">Convênio: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="conv_cal" id="convenio" >
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="color" class="col-sm-2 control-label">Doutor: </label>
                                        <div class="col-sm-10">
                                            <select name="cal_crm" class="form-control" required="">
                                                    <option></option>
                                                    <?php 
                                                            $doc = "SELECT nome_u, crm FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' and crm != ''";
                                                            $docenviabanco = $cx->query($doc);
                                                            while ($docrecebe = $docenviabanco->fetch()){ 
                                                    ?>
                                                    <option value="<?php echo $docrecebe['crm'];?>"><?php echo $docrecebe['nome_u']; ?></option>
                                                    <?php        
                                                    }
                                                    ?>
                                                </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="start" class="col-sm-2 control-label">Inicio: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="inicio" id="start" onkeypress="DataHora(event, this)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="end" class="col-sm-2 control-label">Fim: </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="fim" id="end" onkeypress="DataHora(event, this)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="obs_cal" class="col-sm-2 control-label">Observação: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="obs_cal" id="obs" placeholder="Seja breve">
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">Cadastrar</button>
                                        </div>  
                                    </div>
                                </form>
                        </div>
                       
                    </div>
                </div>
            </div>
            
            <script>
                $('.btn-canc-vis').on("click", function(){
                   $('.form').slideToggle();
                   $('.visualizar').slideToggle();
                });
                
                $('.btn-canc-edit').on("click", function(){
                   $('.visualizar').slideToggle();
                   $('.form').slideToggle();
                });
                
            </script>
            
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

