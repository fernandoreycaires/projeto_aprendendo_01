<?php
    session_start();
    include '../_php/cx.php';
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        $cnpj = $_SESSION['cnpj_session'];
        $user = $_SESSION['user_session'];
        $pass = $_SESSION['pass_session'];

    //VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "select cu.nome_u from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
    $acesso_user = $cx->query ($acesso);

    while ($perfil = $acesso_user->fetch()){
        $nome = $perfil['nome_u'];
     } 
     
    $data_atual = date('Y-m-d');
    
    $msg = isset ($_POST['msg'])?$_POST['msg']:"";
    $cor = isset ($_POST['cor'])?$_POST['cor']:"";
    $status = isset ($_POST['status'])?$_POST['status']:"";
    if ($status == ""){
        $status = "hidden";
    }
     
     
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>LEAD / MAILING</title>
                <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
                <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <style>
                    a {
                        color: #D3D3D3;
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
                    
                    /* ALTERA AS CONFIGURAÇÕES de plano de fundo da janela modal*/
                    .modal-backdrop {
                        background-color: #1C1C1C;
                    }

                    /* ALTERA AS CONFIGURAÇÕES de conteudo da Janela Modal */
                    .modal-content {
                        background-color: rgb(38,42,48);
                    }

                    .modal-content input {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }
                    
                    .modal-content textarea {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }

                    .modal-content select {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }
                    
                    .modal-content table tr td {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }
                    
                    .form-control-textarea {
                        background-color: rgba(38,42,48,1);
                        color: rgb(255,255,255);
                        width: 100%;
                        height:80px;
                        padding:6px 12px;
                        font-size:14px;
                        line-height:1.42857143;
                        border:1px solid #ccc;
                        border-radius:4px;
                        -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                        box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                        -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                        -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                        transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
                        }
                        
                    
                    div#esquerda {
                        width: 49%;
                        float: left;
                    }
                    
                    div#direita {
                        width: 49%;
                        float: right;
                    }
                    
                    .direitacabeca{
                        font-size: 13pt;
                        background-color: rgba(130, 221, 255, .3);
                        padding: 8px 5px 2px 5px;
                        border-left: #006287 solid 10px;
                    }
                    
                    .direitacabeca button#btndelcont{
                        display: none;  
                        
                    }
                    
                    .direitacabeca:hover {
                        border-left: #006287 solid 13px;
                    }
                    
                    .direitacabeca:hover button#btndelcont{
                        display: block; 
                        float: right;
                    }
                    
                    .form-control-menor{
                        background-color: rgba(38,42,48,1);
                        color: rgb(255,255,255);
                        width: 170px;
                        height:35px;
                        padding:6px 12px;
                        font-size:14px;
                        line-height:1.42857143;
                        border:1px solid #ccc;
                        border-radius:4px;
                        -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                        box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                        -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                        -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                        transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
                        }
                    
                    div#ret_lig {
                        width: 49%;
                    }
                        
                </style>
                <script src='../_javascript/funcoes.js'></script>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/jquery.min.js'></script>
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
				<h1 align="center">Leads / Mailing </h1>
			</div>
			<div class="row">
				<div class="col-md-12">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li role="presentation" class="active"><a href="mailing_home.php" target="_self">Leads</a></li>
                                        <li role="presentation"><a href="mailing_seminteresse.php" target="_self">Sem Interesse</a></li>
                                        <li role="presentation"><a href="mailing_agenda.php" target="_self">Agendados</a></li>
                                        <li role="presentation"><a href="mailing_relat.php" target="_self">Relatório</a></li>
                                    </ul>
                                </div>
			</div>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                
                                <div class="alert <?php echo $status;?> alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p align="center" style="color:<?php echo $cor;?>; font-weight: bold"><?php echo $msg;?></p>
                                </div>
                                <div id="esquerda">
                                    <!--DIV QUE EXIBE AS LIGAÇÃO PARA SEREM RETORNADAS HOJE -->
                                    <div id="retornar_lig">
                                        <table class="table">
                                            <thead>
                                            <th colspan="5">LIGAÇÃO PARA RETORNAR HOJE</th>
                                            </thead>
                                            <thead>
                                            <th>Inserido</th>
                                            <th>Nome </th>
                                            <th>Celular</th>
                                            <th>Retornar</th>
                                            <th>Ação</th>
                                            </thead>
                                            <?php
                                            
                                            
                                            //ESTE SELECT COM O LAÇO BUSCA LEADS DA TABELA agenda PARA SEREM OCULTADOS
                                            $datahora_atual = date('Y-m-d H:i:s');
                                            $sqloculag = "SELECT id_lead, cpf FROM agenda WHERE cnpj = '".$cnpj."' and inicio >= '".$datahora_atual."'";
                                            $ocul_leadag = $cx->query ($sqloculag);
                                            
                                                while ($ocultarag = $ocul_leadag->fetch()){
                                                    $ocag_lead_id = $ocultarag['id_lead'];
                                                    if ($ocag_lead_id != ""){
                                                        $ocag_id = $ocag_lead_id;
                                                        $ocultarag_id .= " AND id_lead != "."'$ocag_id'";
                                                    }
                                                
                                                $ocag_lead_cpf = $ocultarag['cpf'];
                                                if ($ocag_lead_cpf != ""){
                                                    $ocag_cpf = $ocag_lead_cpf;
                                                }

                                                //ESTE LAÇO É PARA FAZER UMA COMPARAÇÃO DE CPF DA AGENDA COM CPF VINCULADOS À LEADs 
                                                        $comparacao = "SELECT id_lead FROM lead WHERE cnpj = '".$cnpj."' AND cpf = '".$ocag_cpf."'";
                                                        $comp_lead = $cx->query ($comparacao);
                                                            while ($comparar = $comp_lead->fetch()){
                                                                $comp_id = $comparar['id_lead'];
                                                                $ocultarag_idcpf .= " AND id_lead != "."'$comp_id'";
                                                            }
                                                }
                                                
                                            //ESTE LAÇO FAZ UMA VERIFICAÇÃO DO PACIENTE EM ATENDIMENTO, PARA OCULTA-LO NA DIV DE EXIBIÇÃO DE AGENDAMENTOS.
                                            $leadatend = "SELECT id_lead FROM atendimento WHERE id_lead != '' AND id_lead != '0' AND ini_data = '".$data_atual."' AND cnpj = '".$cnpj."'";
                                            $leadatendcheck = $cx->query ($leadatend);
                                                while ($lc = $leadatendcheck->fetch()){
                                                   $at_lead_id = $lc['id_lead'];
                                                   $atendendo .= "AND id_lead != $at_lead_id ";
                                                }
                                
                                                
                                            
                                            //LAÇO PARA  BUSCAR DADOS NA TABELA DE LIGAÇÕES PARA RETORNAR HOJE
                                            $sqlret = "SELECT id_lead, dia, hora FROM lead_retornar WHERE cnpj = '".$cnpj."' AND dia = '".$data_atual."' ".$ocultar_id." ".$ocultarag_id." ".$ocultarag_idcpf." ".$atendendo." ORDER BY hora ASC ";
                                            $ret_lead = $cx->query ($sqlret);

                                            while ($retornar = $ret_lead->fetch()){
                                                $ret_lead_id = $retornar['id_lead'];
                                                $ret_lead_hora = $retornar['hora'];
                                                    //ESTE LAÇO BUSCA DADOS DO LEAD
                                                    $acesso = "SELECT id_lead, nome, cel1, email, dia FROM lead WHERE cnpj = '".$cnpj."' and id_lead = '".$ret_lead_id."' AND interesse = 'S' ";
                                                    $acesso_lead = $cx->query ($acesso);

                                                    while ($lead = $acesso_lead->fetch()){
                                                        $lead_id = $lead['id_lead'];
                                                        $lead_nome = $lead['nome'];
                                                        $lead_cel1 = $lead['cel1'];
                                                        $lead_email = $lead['email'];
                                                        $lead_dia = $lead['dia'];

                                                        //ARRUMA DATA PARA EXIBIR 
                                                        list($anoh, $mesh, $diah) = explode('-', $lead_dia);
                                                        $lead_dia = $diah."/".$mesh."/".$anoh;

                                                        //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                                        $cel1n = substr_replace($lead_cel1, '(', 0, 0);
                                                        $cel1n = substr_replace($cel1n, ')', 3, 0);
                                                        $cel1n = substr_replace($cel1n, '-', 9, 0);
                                                        $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                                        $cel1n = substr_replace($cel1n, ' ', 6, 0);

                                                        
                                                    ?>
                                            <tr>
                                                <td><?php echo $lead_dia;?></td>
                                                <td><?php echo $lead_nome;?></td>
                                                <td><?php echo $cel1n;?></td>
                                                <td><?php echo $ret_lead_hora;?></td>
                                                <td>
                                                    <form method="post" action="mailing_home.php">
                                                        <input type="hidden" name="id_lead" value="<?php echo $lead_id;?>">
                                                        <button type="submit" class="btn btn-xs btn-primary">Vizualizar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php 
                                                }
                                            }
                                            ?>
                                        </table>                    
                                    </div>
                                    <!--DIV QUE EXIBE TODA A LISTA DE LEAD OCULTANDO LEADS QUE JÁ FORAM FEITOS UM CONTATO -->
                                    <div id="lista_lead">
                                        <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalnovolead">Novo Lead</button></p>
                                        <table class="table">
                                            <thead>
                                            <th colspan="4">FALTA ENTRAR EM CONTATO:</th>
                                            </thead>
                                            <thead>
                                            <th>Inserido</th>
                                            <th>Nome </th>
                                            <th>Celular</th>
                                            <th>Ação</th>
                                            </thead>
                                            <?php
                                            //ESTE SELECT COM O LAÇO BUSCA LEADS DA TABELA lead_retornar PARA SEREM OCULTADOS
                                            $sqlocul = "SELECT id_lead FROM lead_retornar WHERE cnpj = '".$cnpj."' and dia >= '".$data_atual."'";
                                            $ocul_lead = $cx->query ($sqlocul);
                                            
                                                while ($ocultar = $ocul_lead->fetch()){
                                                    $oc_lead_id = $ocultar['id_lead'];
                                                    $ocultar_id .= " AND id_lead != "."'$oc_lead_id'";
                                                }
                                            
                                            //ESTE SELECT COM O LAÇO MOSTRAM LEADS QUE NECESSITAM SER CONTACTADOS AINDA
                                            $acesso = "SELECT id_lead, nome, cel1, email, dia FROM lead WHERE cnpj = '".$cnpj."' AND interesse = 'S' ".$ocultar_id." ".$ocultarag_id." ".$ocultarag_idcpf." ".$atendendo." ";
                                            $acesso_lead = $cx->query ($acesso);

                                            while ($lead = $acesso_lead->fetch()){
                                                $lead_id = $lead['id_lead'];
                                                $lead_nome = $lead['nome'];
                                                $lead_cel1 = $lead['cel1'];
                                                $lead_email = $lead['email'];
                                                $lead_dia = $lead['dia'];

                                                //ARRUMA DATA PARA EXIBIR 
                                                list($anoh, $mesh, $diah) = explode('-', $lead_dia);
                                                $lead_dia = $diah."/".$mesh."/".$anoh;

                                                //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                                $cel1n = substr_replace($lead_cel1, '(', 0, 0);
                                                $cel1n = substr_replace($cel1n, ')', 3, 0);
                                                $cel1n = substr_replace($cel1n, '-', 9, 0);
                                                $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                                $cel1n = substr_replace($cel1n, ' ', 6, 0);


                                            ?>
                                            <tr>
                                                <td><?php echo $lead_dia;?></td>
                                                <td><?php echo $lead_nome;?></td>
                                                <td><?php echo $cel1n;?></td>
                                                <td>
                                                    <form method="post" action="mailing_home.php">
                                                        <input type="hidden" name="id_lead" value="<?php echo $lead_id;?>">
                                                        <button type="submit" class="btn btn-xs btn-primary">Vizualizar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php 
                                                }
                                            
                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <div id="direita">
                                    
                                        <?php
                                        $id_lead = isset($_POST['id_lead'])?$_POST['id_lead']:"0";
                                        
                                        $acesso = "SELECT * FROM lead WHERE cnpj = '".$cnpj."' and id_lead = '".$id_lead."' ";
                                        $acesso_lead = $cx->query ($acesso);

                                        while ($lead = $acesso_lead->fetch()){
                                            $lead_id = $lead['id_lead'];
                                            $lead_nome = $lead['nome'];
                                            $lead_cel1 = $lead['cel1'];
                                            $lead_cel2 = $lead['cel2'];
                                            $lead_cpf = $lead['cpf'];
                                            $lead_tel = $lead['tel'];
                                            $lead_email = $lead['email'];
                                            $lead_dia = $lead['dia'];
                                            $lead_obs = $lead['obs'];

                                            //ARRUMA DATA PARA EXIBIR 
                                            list($anoh, $mesh, $diah) = explode('-', $lead_dia);
                                            $lead_dia = $diah."/".$mesh."/".$anoh;
                                            
                                            
                                            
                                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                            $cel1n = substr_replace($lead_cel1, '(', 0, 0);
                                            $cel1n = substr_replace($cel1n, ')', 3, 0);
                                            $cel1n = substr_replace($cel1n, '-', 9, 0);
                                            $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                            $cel1n = substr_replace($cel1n, ' ', 6, 0);

                                            $cel2n = substr_replace($lead_cel2, '(', 0, 0);
                                            $cel2n = substr_replace($cel2n, ')', 3, 0);
                                            $cel2n = substr_replace($cel2n, '-', 9, 0);
                                            $cel2n = substr_replace($cel2n, ' ', 4, 0);
                                            $cel2n = substr_replace($cel2n, ' ', 6, 0);

                                            $fixon = substr_replace($lead_tel, '(', 0, 0);
                                            $fixon = substr_replace($fixon, ')', 3, 0);
                                            $fixon = substr_replace($fixon, '-', 8, 0);
                                            $fixon = substr_replace($fixon, ' ', 4, 0);
                                            
                                            if ($lead_cel2 == ""){
                                                $cel2 = "";
                                            } else {
                                                $cel2 = $cel2n;
                                            }
                                            
                                            if ($lead_tel == ""){
                                                $tel = "";
                                            } else {
                                                $tel = "| Telefone: $fixon";
                                            }

                                        ?>
                                            <div id="direitalista">
                                                <div class="direitacabeca">
                                                    <p>Nome: <?php echo $lead_nome; ?> | Celular: <?php echo $cel1n; ?> <?php echo $cel2; ?>  <?php echo $tel; ?></p>
                                                    <p>Email: <?php echo $lead_email; ?></p>
                                                    
                                                    <p align="right">
                                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modallead<?php echo $lead_id; ?>">Efetuar Contato</button>
                                                        <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalagendarlead<?php echo $lead_id; ?>">Agendar</button>
                                                        <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modaleditlead<?php echo $lead_id; ?>">Editar</button>
                                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalexcluilead<?php echo $lead_id; ?>">Excluir</button>
                                                        
                                                        <!-- MODAL REFERENTE INSERIR NOVO REGISTRO NO LEAD -->
                                                            <div class="modal fade" id="modallead<?php echo $lead_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title text-center" id="myModalLabel">Registrar contato com <?php echo $lead_nome;?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post" action="cad_leadcontato.php">
                                                                                <input type="hidden" value="<?php echo $lead_id; ?>" name="lead_id">
                                                                                <p>Informações sobre o contato efetuado:</p>
                                                                                <p><textarea name="tObs" class="form-control-textarea"></textarea></p>
                                                                                <div id="ret_lig">
                                                                                    <p>Retornar Ligação: <label for="S"> <input type="radio" name="tRet" id="S" value="S"/> SIM </label> <label for="N"><input type="radio" name="tRet" id="N" value="N" checked="checked"/> NÃO </label></p>
                                                                                    <p>Dia: <input type="date" name="data_ret" class="form-control-menor"> Hora: <input type="time" name="hora_ret" class="form-control-menor"></p>
                                                                                </div>
                                                                                <p>Não tem interesse: <input type="checkbox" name="tInter" value="N">
                                                                                <br>
                                                                                <p align="center"><button type="submit" class="btn btn-xm btn-success">Salvar</button></p>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                    <!-- Fim do modal INSERIR NOVO REGISTRO NO LEAD-->
                                                    
                                                    <!-- MODAL REFERENTE AGENDAR LEAD -->
                                                            <div class="modal fade" id="modalagendarlead<?php echo $lead_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title text-center" id="myModalLabel">Agendar vizita de <?php echo $lead_nome;?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            
                                                                            <form method="post" action="cad_leadagenda.php">
                                                                                <table class="table" >
                                                                                    <input type="hidden" value="<?php echo $lead_id; ?>" name="lead_id">
                                                                                    <input type="hidden" value="<?php echo $lead_nome; ?>" name="lead_nome">
                                                                                    <input type="hidden" value="<?php echo $lead_cel1; ?>" name="lead_cel1">
                                                                                    <input type="hidden" value="<?php echo $lead_cpf; ?>" name="lead_cpf">
                                                                                    <tr>
                                                                                        <td>Doutor:</td>
                                                                                        <td>
                                                                                            <select name="lead_crm" class="form-control" required="">
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
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr><td>Data:</td><td><input type="date" name="tData" class="form-control"></td></tr>
                                                                                    <tr><td>Hora:</td><td><input type="time" name="tHora" class="form-control"></td></tr>
                                                                                    <tr><td>Observação:</td><td><textarea name="tObs" class="form-control-textarea"></textarea></td></tr>
                                                                                    <br>
                                                                                </table>
                                                                                <p align="center"><button type="submit" class="btn btn-xm btn-success">Salvar</button></p>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                    <!-- Fim do modal AGENDAR LEAD-->
                                                    
                                                    <!-- MODAL REFERENTE EDITAR LEAD -->
                                                            <div class="modal fade" id="modaleditlead<?php echo $lead_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title text-center" id="myModalLabel">Editar dados de <?php echo $lead_nome; ?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post" action="edit_lead.php">
                                                                                <table class="table">
                                                                                    <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" value="<?php echo $lead_nome;?>" required=""></td></tr>
                                                                                    <tr><td>E-Mail:</td><td><input type="mail" name="tMail" class="form-control" value="<?php echo $lead_email;?>"></td></tr>
                                                                                    <tr><td>Celular (Opção 1):</td><td><input type="text" name="tCel1" class="form-control" value="<?php echo $lead_cel1;?>" placeholder="somente numeros, sem espaços"></td></tr>
                                                                                    <tr><td>Celular (Opção 2):</td><td><input type="text" name="tCel2" class="form-control" value="<?php echo $lead_cel2;?>" placeholder="somente numeros, sem espaços"></td></tr>
                                                                                    <tr><td>Tel Fixo:</td><td><input type="text" name="tFixo" class="form-control" value="<?php echo $lead_tel;?>" placeholder="somente numeros, sem espaços"></td></tr>
                                                                                    <tr><td colspan="2"><h4 align="center">O que esta sentindo ?</h4></td></tr>
                                                                                    <tr><td colspan="2"><textarea name="tObs" class="form-control-textarea"><?php echo $lead_obs;?></textarea></td></tr>
                                                                                </table>
                                                                                <input type="hidden" value="<?php echo $lead_id; ?>" name="tIDLead">
                                                                                <p align="center"><button type="submit" class="btn btn-xm btn-success">Salvar</button></p>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                    <!-- Fim do modal EDITAR LEAD -->
                                                    <!-- MODAL REFERENTE EXCLUIR LEAD -->
                                                            <div class="modal fade" id="modalexcluilead<?php echo $lead_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title text-center" id="myModalLabel">Deseja excluir <?php echo $lead_nome; ?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post" action="del_lead.php">
                                                                                <input type="hidden" value="<?php echo $lead_id; ?>" name="tIDLead">
                                                                                <p align="center"><button type="submit" class="btn btn-xm btn-danger">Excluir</button></p>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                    <!-- Fim do modal EXCLUIR LEAD -->
                                                    
                                                    </p>
                                                    
                                                    <p align="center" style="border-top: #e0e0e0 solid 1px; font-weight: bold;">O QUE ESTA SENTINDO OU ALGUMA OBSERVAÇÃO</p>
                                                    <p><?php echo $lead_obs; ?></p>
                                                </div>
                                            </div>
                                    <h4 align="center">REGISTROS </h4>
                                            <?php 
                                                }
                                                $sqlcontato = "SELECT * FROM lead_contato WHERE cnpj = '".$cnpj."' and id_lead = '".$id_lead."' ORDER BY dia DESC, hora DESC ";
                                                    $contato_lead = $cx->query ($sqlcontato);

                                                    while ($cont = $contato_lead->fetch()){
                                                        $leadc_id_c = $cont['id_lead_c'];
                                                        $leadc_dia = $cont['dia'];
                                                        $leadc_hora = $cont['hora'];
                                                        $leadc_obs = $cont['obs'];

                                                //ARRUMA DATA PARA EXIBIR 
                                                list($anoc, $mesc, $diac) = explode('-', $leadc_dia);
                                                $leadc_dia = $diac."/".$mesc."/".$anoc;


                                                ?>
                                            <br>
                                            <div id="direitalista">
                                                <div class="direitacabeca">
                                                    <p>ID: <?php echo $leadc_id_c; ?> | Dia do contato: <?php echo $leadc_dia; ?> | Hora do Contato <?php echo $leadc_hora;?>  <button type="button" id="btndelcont" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalexcluileadcont<?php echo $leadc_id_c; ?>">Apagar</button></p>
                                                    <p>Observação : <?php echo $leadc_obs; ?> </p>
                                                    
                                                        <!-- MODAL REFERENTE EXCLUIR LEAD_CONTATO -->
                                                                <div class="modal fade" id="modalexcluileadcont<?php echo $leadc_id_c; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title text-center" id="myModalLabel">Deseja apagar informação ID <?php echo $leadc_id_c; ?></h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form method="post" action="del_leadcontato.php">
                                                                                    <input type="hidden" value="<?php echo $leadc_id_c; ?>" name="tIDLead">
                                                                                    <p align="center"><button type="submit" class="btn btn-xm btn-danger">Excluir</button></p>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                        <!-- Fim do modal EXCLUIR LEAD_CONTATO -->
                                                </div>
                                            </div>
                                                <?php
                                                    }
                                                ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <br>
                    <!-- MODAL REFERENTE INSERIR NOVO LEAD -->
                        <div class="modal fade" id="modalnovolead" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Adicionar Novo LEAD</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="cad_lead.php">
                                            <table class="table">
                                                <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" required=""></td></tr>
                                                <tr><td>E-Mail:</td><td><input type="mail" name="tMail" class="form-control"></td></tr>
                                                <tr><td>Celular (Opção 1):</td><td><input type="text" name="tCel1" onkeypress="return onlynumber();" class="form-control" placeholder="somente numeros, sem espaços"></td></tr>
                                                <tr><td>Celular (Opção 2):</td><td><input type="text" name="tCel2" onkeypress="return onlynumber();" class="form-control" placeholder="somente numeros, sem espaços"></td></tr>
                                                <tr><td>Tel Fixo:</td><td><input type="text" name="tFixo" onkeypress="return onlynumber();" class="form-control" placeholder="somente numeros, sem espaços"></td></tr>
                                                <tr><td colspan="2"><h4 align="center">O que esta sentindo ?</h4></td></tr>
                                                <tr><td colspan="2"><textarea name="tObs" class="form-control-textarea"></textarea></td></tr>
                                            </table>
                                            <input type="hidden" value="S" name="tInteresse">
                                            <p align="center"><button type="submit" class="btn btn-xm btn-success">Salvar</button></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>  
                <!-- Fim do modal INSERIR NOVO LEAD -->
                    
                    <footer id="rodape">
                        <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                        <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                    </footer>
		</div>  
  </body>
    <script src='../_javascript/bootstrap.min.js'></script>
    <script src='../_javascript/jquery.min.js'></script>
</html>
<?php
}else{
    header("location:../index.php");
}
?>