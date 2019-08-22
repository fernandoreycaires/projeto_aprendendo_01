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
     
     $msg = isset($_POST["msg"])?$_POST["msg"]:"";
     
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
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <style>
                    a {
                        color: #D3D3D3;
                    }
                    
                    .listaverde{
                        font-size: 11pt;
                        color: rgb(255,255,255);
                        background-color: rgba(0,77,0,.3);
                    }

                    .listavermelha{
                        font-size: 11pt;
                        color: rgb(255,255,255);
                        background-color: rgba(102,0,0,.3);
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
                </style>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/jquery.min.js'></script>
                <script src='../_javascript/funcoes.js'></script>
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
                                        <li role="presentation" class="active"><a href="dtr_atendimento.php" target="_self">Atendimentos</a></li>
                                        <li role="presentation"><a href="dtr_prontuario.php" target="_self">Prontuários</a></li>
                                        <li role="presentation"><a href="dtr_agenda.php" target="_self">Agenda</a></li>
                                    </ul>
                                </div>
			</div>
                    <h4 align="center"><?php echo $msg;?></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Atendimento</th>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>RG</th>
                                            <th>Retorno</th>
                                            <th>Hora de Chegada</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    
                                    //BUSCA INFORMAÇÕES DA TABELA ATENDIMENTO
                                    $atend_sql = "SELECT * FROM atendimento WHERE cnpj = '".$cnpju."' and ini_data = '".$data_atual."' and crm = '".$crm."' order by ini_hora";
                                    $atend_acesso = $cx->query ($atend_sql);

                                    while ($atend = $atend_acesso->fetch()){
                                        $atendimento = $atend['id_atend'];
                                        $paciente = $atend['nome'];
                                        $pac_cpf = $atend['cpf'];
                                        $pac_rg = $atend['rg'];
                                        $pac_cn = $atend['certnasc'];
                                        $doutor = $atend['doutor'];
                                        $retorno = $atend['retorno'];
                                        $hora = $atend['ini_hora'];
                                        $data = $atend['ini_data'];
                                        $fim = $atend['fim_hora'];

                                        //ARRUMA A VARIAVEL RETORNO PARA SIM OU NÃO
                                        if ($retorno == 'N'){
                                            $ret = 'NÃO';
                                        }else if ($retorno == 'S'){
                                            $ret = 'SIM';
                                        }

                                        //BUSCA INFORMAÇÃO NO BANCO PARA ALIMENTAR A VARIAVEL STATUS
                                        if ($fim == ''){
                                            $status = 'AGUARDANDO SER ATENDIDO';
                                        } else {
                                            $status = 'ATENDIDO';
                                        }

                                        // MODIFICANDO AS CORES DAS LINHAS DA TABELA, PARA IDENTIFICAÇÃO VISUAL DE QUEM FALTA ATENDER E QUEM JÁ FOI ATENDIDO

                                        if ($status == 'AGUARDANDO SER ATENDIDO'){
                                            $cor_classe = 'listavermelha';
                                        }else{
                                            $cor_classe = 'listaverde';
                                        }

                                        //ARRUMA A VARIAVEL DATA PARA SER EXIBIDA 
                                        // Separa em dia, mês e ano
                                        list($ano, $mes, $dia) = explode('-', $data);

                                        //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                        $pac_cpfn = substr_replace($pac_cpf, '.', 3, 0);
                                        $pac_cpfn = substr_replace($pac_cpfn, '.', 7, 0);
                                        $pac_cpfn = substr_replace($pac_cpfn, '-', 11, 0);
                                        
                                        //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
                                        $rgn = substr_replace($pac_rg, '.', 2, 0);
                                        $rgn = substr_replace($rgn, '.', 6, 0);
                                        $rgn = substr_replace($rgn, '-', 10, 0);
                                        
                                       
                                        
                                        //VERIFICA O STATUS DO ATENDIMENTO PARA MUDAR O DESTINO DO FORM A SEGUIR
                                        if ($status == 'AGUARDANDO SER ATENDIDO'){
                                            $acao = 'diagnostico_ini.php';
                                        }else if($status == 'ATENDIDO'){
                                            $acao = 'diagnostico.php';
                                        }
                                            
                                        //ESTE LAÇO CONFERE SE OPACIENTE JÁ TEM CADASTRO NO SISTEMA
                                            $conf_cpf = "";  
                                            $conf_rg = "";  
                                            $conf_cn = "";  
                                            
                                            $pac_sql = "SELECT cpf, rg, certnasc FROM clientes WHERE  cpf = '".$pac_cpf."' OR rg = '".$pac_rg."' OR certnasc = '".$pac_cn."' ";
                                            $pac_acesso = $cx->query ($pac_sql);
                                            while ($chec_pac = $pac_acesso->fetch()){
                                                $conf_cpf = $chec_pac['cpf'];
                                                $conf_rg = $chec_pac['rg'];
                                                $conf_cn = $chec_pac['certnasc'];
                                            }
                                            
                                            //ESTE IF E ELSE, COLOCA BOTÃO PARA CADASTRO RAPIDO DE PACIENTE CASO NÃO TENHA CADASTRO
                                            if ($conf_cpf == ""){
                                                if($conf_rg == ""){
                                                    if($conf_cn == ""){
                                              
                                                        ?>
                                                            <tr class="<?php echo $cor_classe;?>">
                                                                <td><?php echo $atendimento;?></td>
                                                                <td><?php echo $paciente;?></td>
                                                                <td><?php echo $pac_cpfn;?></td>
                                                                <td><?php echo $rgn;?></td>
                                                                <td><?php echo $ret;?></td>
                                                                <td><?php echo $hora;?></td>
                                                                <td><?php echo "$dia/$mes/$ano";?></td>
                                                                <td><?php echo $status;?></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalcadcli<?php echo $atendimento;?>">Cadastrar</button>
                                                                    <!-- MODAL REFERENTE À ADICIONAR NOVO CLIENTE -->
                                                                        <div class="modal fade" id="modalcadcli<?php echo $atendimento;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="modal-title text-center" id="myModalLabel">Cadastrar Novo Cliente</h4>
                                                                                    </div>
                                                                                    <?php 
                                                                                        $lead_sql = "SELECT cel1, tel, email, cpf, rg, cn FROM lead WHERE cpf != '' AND cpf = '".$pac_cpf."' AND cnpj = '".$cnpju."' OR rg != '' AND rg = '".$pac_rg."' AND cnpj = '".$cnpju."' OR cn != '' AND cn = '".$pac_cn."' AND cnpj = '".$cnpju."'";
                                                                                        $lead_acesso = $cx->query ($lead_sql);
                                                                                        while ($chec_lead = $lead_acesso->fetch()){
                                                                                            $lead_cpf = $chec_lead['cpf'];
                                                                                            $lead_rg = $chec_lead['rg'];
                                                                                            $lead_cn = $chec_lead['cn'];
                                                                                            $lead_cel1 = $chec_lead['cel1'];
                                                                                            $lead_tel = $chec_lead['tel'];
                                                                                            $lead_email = $chec_lead['email'];
                                                                                            
                                                                                        }
                                                                                    ?>
                                                                                    <div class="modal-body">
                                                                                        <table class="table">
                                                                                            <form action="cad_paciente.php" method="post">
                                                                                                <tr><td colspan="2" align="center">CADASTRE UM TIPO DE DOCUMENTO (Obrigatório)</td></tr>
                                                                                                <tr><td>CPF:</td><td><input type="text" name="tCpf" value ="<?php echo $pac_cpf;?>" onkeypress="return onlynumber();" class="form-control"></td></tr>
                                                                                                <tr><td>RG:</td><td><input type="text" name="tRG" value ="<?php echo $pac_rg;?>"  onkeypress="return onlynumber();" class="form-control"></td></tr>
                                                                                                <tr><td>Cert. Nasc.:</td><td><input type="text" value ="<?php echo $pac_cn;?>" onkeypress="return onlynumber();" name="tCN" class="form-control"></td></tr>
                                                                                                <tr><td colspan="2" align="center"> CADASTRO PESSOAL MINIMO</td></tr>
                                                                                                <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" required=""></td></tr>
                                                                                                <tr><td>Nascimento:</td><td><input type="date" name="tNasc" class="form-control"></td></tr>
                                                                                                <tr><td>Sexo:</td><td>
                                                                                                        <select name="tSexo" class="form-control">
                                                                                                            <option selected>Selecione</option>
                                                                                                            <option value="M">Masculino</option>
                                                                                                            <option value="F">Feminino</option>
                                                                                                        </select>
                                                                                                    </td></tr>
                                                                                                <tr><td>Estado Civil:</td><td>
                                                                                                        <select name="tEst" class="form-control">
                                                                                                            <option selected>Selecione</option>
                                                                                                            <option>Solteiro(a)</option>
                                                                                                            <option>Casado(a)</option>
                                                                                                            <option>União Estavel</option>
                                                                                                            <option>Divorciado(a)</option>
                                                                                                            <option>Viúvo(a)</option>
                                                                                                        </select>
                                                                                                    </td></tr>
                                                                                                <tr><td>Profissão:</td><td><input type="text" name="tProf" class="form-control"></td></tr>
                                                                                                <tr><td>Celular:</td><td><input type="text" value ="<?php echo $lead_cel1;?>"  name="tCel" onkeypress="return onlynumber();" class="form-control" placeholder="com DDD e Somente Numeros"></td></tr>
                                                                                                <tr><td>Telefone Fixo:</td><td><input type="text" value ="<?php echo $lead_tel;?>" name="tFixo" onkeypress="return onlynumber();" class="form-control" placeholder="com DDD e Somente Numeros"></td></tr>
                                                                                                <tr><td>E-Mail:</td><td><input type="mail" value ="<?php echo $lead_email;?>" name="tMail" class="form-control"></td></tr>
                                                                                                <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                                                                            </form>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        <!-- Fim do modal para adicionar CLIENTE -->
                                                                </td>
                                                                        
                                                            </tr>
                                                            
                                                                        
                                                        <?php
                                                
                                                    }
                                                }
                                            }else{
                                            
                                                        ?>
                                                            <tr class="<?php echo $cor_classe;?>">
                                                                    <form method='post' action="<?php echo $acao; ?>">
                                                                        <input type='hidden' value ="<?php echo $atendimento;?>" name ='atendimento'>
                                                                        <input type='hidden' value ="<?php echo $pac_cpf;?>" name ='novo_diag'>
                                                                        <input type='hidden' value ="<?php echo $pac_rg;?>" name ='novo_diagrg'>
                                                                        <input type='hidden' value ="<?php echo $pac_cn;?>" name ='novo_diagcn'>
                                                                        <td><?php echo $atendimento;?></td>
                                                                        <td><?php echo $paciente;?></td>
                                                                        <td><?php echo $pac_cpfn;?></td>
                                                                        <td><?php echo $rgn;?></td>
                                                                        <td><?php echo $ret;?></td>
                                                                        <td><?php echo $hora;?></td>
                                                                        <td><?php echo "$dia/$mes/$ano";?></td>
                                                                        <td><?php echo $status;?></td>
                                                                        <td><input type='submit' value='Abrir' class="btn btn-xs btn-warning"></td>
                                                                    </form>
                                                            </tr>
                                                        <?php
                                            }
                                        }
                                        ?>
                                    
                                </table>
                                
                            </div>
                        </div>
                    <br>
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

