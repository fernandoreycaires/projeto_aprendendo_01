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
    
    $msg_erro = isset ($_POST['erro'])?$_POST['erro']:"";
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
                <script src='../_javascript/jquery.min.js'></script>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/funcoes.js'></script>
                
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
                    
                    .modal-content table tr td{
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }
                    
                    .modal-content thead th{
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }
                    
                    div#esquerda {
                        width: 49%;
                        float: left;
                    }
                    
                    div#direita {
                        width: 49%;
                        float: right;
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
				<h1 align="center">Leads / Mailing </h1>
			</div>
			<div class="row">
				<div class="col-md-12">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li role="presentation"><a href="mailing_home.php" target="_self">Leads</a></li>
                                        <li role="presentation"><a href="mailing_seminteresse.php" target="_self">Sem Interesse</a></li>
                                        <li role="presentation" class="active"><a href="mailing_agenda.php" target="_self">Agendados</a></li>
                                        <li role="presentation"><a href="mailing_relat.php" target="_self">Relatório</a></li>
                                    </ul>
                                </div>
			</div>
                    <br>
                    
                    <div class="alert <?php echo $status;?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p align="center" style="color:<?php echo $cor;?>; font-weight: bold"><?php echo $msg_erro;?></p>
                    </div>
                    
                    <div id="esquerda">
                        <table class="table">
                            <thead>
                            <th colspan="6">AGENDADOS PARA HOJE</th>
                            </thead>
                            <thead>
                                <th>ID Lead</th>
                                <th>Nome</th>
                                <th>cel</th>
                                <th>Hora</th>
                                <th>Ação</th>
                            </thead>
                            <?php 
                                $data_atual = date('Y-m-d');
                                //ESTE LAÇO FAZ UMA VERIFICAÇÃO DO PACIENTE EM ATENDIMENTO, PARA OCULTA-LO NA DIV DE EXIBIÇÃO DE AGENDAMENTOS.
                                $leadatend = "SELECT id_lead FROM atendimento WHERE id_lead != '' AND id_lead != '0' AND ini_data = '".$data_atual."' AND cnpj = '".$cnpj."'";
                                $leadatendcheck = $cx->query ($leadatend);
                                    while ($lc = $leadatendcheck->fetch()){
                                       $at_lead_id = $lc['id_lead'];
                                       $atendendo .= "AND id_lead != $at_lead_id ";
                                    }
                                
                                //ESTE LAÇO FAZ O SELECT DOS AGENDAMENTOS DO DIA ATUAL
                                $sqlag = "SELECT id_lead, nome, cel, doutor, crm , inicio, obs FROM agenda WHERE CAST(inicio AS date) = '".$data_atual."' AND cnpj = '".$cnpj."' $atendendo ORDER BY inicio";
                                $leadag = $cx->query ($sqlag);

                                    while ($ag = $leadag->fetch()){
                                        $ag_data_id = $ag['id_data'];
                                        $ag_lead_id = $ag['id_lead'];
                                        $ag_nome = $ag['nome'];
                                        $ag_cel = $ag['cel'];
                                        $ag_inicio = $ag['inicio'];
                                        $ag_dtr = $ag['doutor'];
                                        $ag_crm = $ag['crm'];
                                        $ag_obs = $ag['obs'];
                                        
                                        //ARRUMA DATA PARA EXIBIR 
                                        list($dataag, $horaag) = explode(' ', $ag_inicio);
                                        list($hora, $min, $seg) = explode(':', $horaag);
                                        $ag_hora = $hora.":".$min;

                                        //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                        $cel1n = substr_replace($ag_cel, '(', 0, 0);
                                        $cel1n = substr_replace($cel1n, ')', 3, 0);
                                        $cel1n = substr_replace($cel1n, '-', 9, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 6, 0);
                                        
                                        
                                
                            ?>
                            <tr>
                                <td><?php echo $ag_lead_id;?></td>
                                <td><?php echo $ag_nome;?></td>
                                <td><?php echo $cel1n;?></td>
                                <td><?php echo $ag_hora;?></td>
                                <td><button type="submit" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalatendlead<?php echo $ag_lead_id; ?>">Atendimento</button>
                                        <!-- MODAL REFERENTE A ABRIR UM ATENDIMENTO -->
                                        <div class="modal fade" id="modalatendlead<?php echo $ag_lead_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title text-center" id="myModalLabel">Abrir atendimento de <span style="font-weight: bold;"><?php echo $ag_nome;?></span></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="cad_atend.php">
                                                            <input type="hidden" value="<?php echo $ag_data_id;?>" name="id_cal">
                                                            <input type="hidden" value="<?php echo $ag_lead_id;?>" name="id_lead">
                                                            <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="4">
                                                                                <p><span class="banco"><?php echo date('d/m/Y H:i'); ?></span></p>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr><td colspan="2" align="center"><h4> Registre UM dos documentos abaixo</h4> </td></tr>
                                                                        <?php 
                                                                            $sqllead = "SELECT cpf, rg, cn FROM lead WHERE id_lead = '".$ag_lead_id."'";
                                                                            $leaddados = $cx->query ($sqllead);
                                                                                while ($lead_dados = $leaddados->fetch()){
                                                                        ?>
                                                                        <tr><td>CPF:</td><td><input type="text" name="tCpf" value="<?php echo $lead_dados['cpf'];?>" onkeypress="return onlynumber();" class="form-control"></td></tr>
                                                                        <tr><td>RG:</td><td><input type="text" name="tRG" value="<?php echo $lead_dados['rg'];?>" onkeypress="return onlynumber();" class="form-control"></td></tr>
                                                                        <tr><td>Certidão Nascimento:</td><td><input type="text" value="<?php echo $lead_dados['cn'];?>" onkeypress="return onlynumber();" name="tCN" class="form-control"></td></tr>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        <tr><td colspan="2" align="center"><h4>Dados Minimos para abrir a ficha </h4></td></tr>

                                                                        <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" value="<?php echo $ag_nome ?>"></td></tr>
                                                                        <tr><td>Celular:</td><td><input type="text" name="tCel" onkeypress="return onlynumber();" class="form-control" value="<?php echo $ag_cel ?>"></td></tr>
                                                                        <tr><td>Retorno:</td><td><input type="RADIO" name="tRet" id="sim" VALUE="S"><label for="sim" > SIM</label>
                                                                                <input type="RADIO" name="tRet" id="nao" VALUE="N" checked><label for="nao" > NÃO</label></td></tr>
                                                                        <tr><td>Doutor:</td><td><?php echo $ag_dtr ?><input type="hidden" name="tDoc" value="<?php echo $ag_dtr ?>"></td></tr>
                                                                        <tr><td>CRM:</td><td><?php echo $ag_crm ?><input type="hidden" name="tCrm" value="<?php echo $ag_crm ?>"></td></tr>
                                                                        <tr><td>Observação:</td><td><input type="text" name="tObs" class="form-control" value="<?php echo $ag_obs;?>"></td></tr>
                                                                    </tbody>

                                                            </table>
                                                        <p align='center'><button type="submit" class="btn btn-sm btn-success" >Confirmar</button></p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                <!-- Fim do modal REFERENTE A ABERTURA DE ATENDIMENTO-->
                                </td>
                            </tr>
                            <?php 
                                }
                            ?>
                        </table>
                    </div>
                    <div id="direita">
                        <table class="table">
                            <thead>
                            <th colspan="6">ATENDIMENTOS ABERTOS HOJE</th>
                            </thead>
                            <thead>
                                <th>ID Lead</th>
                                <th>Nome</th>
                                <th>cel</th>
                                <th>Hora</th>
                                <th>Ação</th>
                            </thead>
                            <?php 
                                //ESTE LAÇO FAZ O SELECT DOS ATENDIMENTOS DO DIA ATUAL
                                $leadatend = "SELECT * FROM atendimento WHERE ini_data = '".$data_atual."' AND cnpj = '".$cnpj."' ORDER BY ini_hora DESC";
                                $leadatendcheck = $cx->query ($leadatend);
                                    while ($lc = $leadatendcheck->fetch()){
                                        $at_lead_id = $lc['id_lead'];
                                        $at_nome = $lc['nome'];
                                        $at_cel = $lc['cel'];
                                        $at_inicio = $lc['ini_hora'];
                                        $at_dtr = $lc['doutor'];
                                        $at_crm = $lc['crm'];
                                        $at_obs = $lc['obs'];
                                        
                                        //ARRUMA DATA PARA EXIBIR 
                                        list($hora, $min, $seg) = explode(':', $at_inicio);
                                        $at_inicio = $hora.":".$min;

                                        //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                        $cel1n = substr_replace($at_cel, '(', 0, 0);
                                        $cel1n = substr_replace($cel1n, ')', 3, 0);
                                        $cel1n = substr_replace($cel1n, '-', 9, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 6, 0);
                                
                            ?>
                            <tr>
                                <td><?php echo $at_lead_id;?></td>
                                <td><?php echo $at_nome;?></td>
                                <td><?php echo $cel1n;?></td>
                                <td><?php echo $at_inicio;?></td>
                                <td><button type="submit" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modallead<?php echo $at_lead_id; ?>">Vizualizar</button>
                                        <!-- MODAL REFERENTE A ABRIR UM ATENDIMENTO -->
                                        <div class="modal fade" id="modallead<?php echo $at_lead_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title text-center" id="myModalLabel">Atendimento </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                                <tr><td>Nome:</td><td><?php echo $at_nome ?></td></tr>
                                                                <tr><td>Celular:</td><td><?php echo $cel1n ?></td></tr>
                                                                <tr><td>Hora do Atendimento:</td><td><?php echo $at_inicio ?></td></tr>
                                                                <tr><td>Doutor:</td><td><?php echo $at_dtr ?></td></tr>
                                                                <tr><td>Observação:</td><td><?php echo $at_obs;?></td></tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                <!-- Fim do modal REFERENTE A ABERTURA DE ATENDIMENTO-->
                                </td>
                            </tr>
                            <?php 
                                }
                            ?>
                        </table>
                        
                    </div>
                    
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