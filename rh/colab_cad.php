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
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <link href="../_css/rh.css" rel="stylesheet" type="text/css"/>
                <style>
                    a {
                        color: #D3D3D3;
                    }
                    
                    .filtro {
                        background-color: rgba(38,42,48,1);
                        color: rgb(255,255,255);
                        width: 300px;
                        height:34px;
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
				<h1 align="center">Colaboradores </h1>
			</div>
			<div class="row">
				<div class="col-md-12">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li role="presentation"><a href="colab_lista.php" target="_self">Colaboradores</a></li>
                                        <li role="presentation" class="active"><a href="#" target="_self">Cadastrar Usuário</a></li>
                                    </ul>
                                </div>
			</div>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <p align="center">Buscar Nome , CPF ou CRM para cadastrar como novo usuário.</p>
                                <h3 align="center"><?php echo $msg_erro;?></h3>
                                <p>
                                    <form method="post" action="colab_cad.php">
                                        <input type="text" name="tBusca" autofocus="" placeholder="Consulte por CPF , Nome ou CRM" required="" class="filtro">&nbsp;&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-sm btn-warning">Buscar</button>&nbsp;&nbsp;&nbsp;
                                    </form>
                                </p>
                                <br>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Data Nascimento</th>
                                            <th>Celular</th>
                                            <th>E-Mail</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            // Pega os dados enviados por POST de home_cli
                                            $b = "";
                                            $b = isset($_POST["tBusca"]) ? $_POST["tBusca"] : "Busca não informada";
                                            $vizualizar = isset ($_POST["vizu"])?$_POST["vizu"]:"oc";

                                            //VAI BUSCAR INFORMAÇÕES DO BANCO DE DADOS
                                            $mostra_sql = "SELECT * FROM clientes WHERE nome = '".$b."' or cpf = '".$b."' or crm = '".$b."' order by nome";
                                            $mostra = $cx->query($mostra_sql);

                                            //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                            while ($dados = $mostra->fetch()) {
                                                $id = $dados['id'];
                                                $nomeuser = $dados['nome'];
                                                $sexo = $dados['sexo'];
                                                $crm = $dados['crm'];
                                                $crm_uf = $dados['estado_crm'];
                                                $crm_area = $dados['area_m'];
                                                
                                                //OCULTAR DADOS CASO NÃO TIVER CRM
                                                if ($crm == ""){
                                                    $ocultar = "oc";
                                                }
                                                //MODIFICANDO E ACRESCENTANDO A VARIAVEL SEXO
                                                if ($sexo = 'M'){
                                                    $sexo = 'Masculino';
                                                } else if($sexo = 'F'){
                                                    $sexo = 'Feminino';
                                                }

                                                //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                                $cpfbusca = $dados['cpf'];
                                                $cpfn = substr_replace($cpfbusca, '.', 3, 0);
                                                $cpfn = substr_replace($cpfn, '.', 7, 0);
                                                $cpfn = substr_replace($cpfn, '-', 11, 0);

                                                //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                                $celular = $dados['cel1'];
                                                $cel1n = substr_replace($celular, '(', 0, 0);
                                                $cel1n = substr_replace($cel1n, ')', 3, 0);
                                                $cel1n = substr_replace($cel1n, '-', 9, 0);
                                                $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                                $cel1n = substr_replace($cel1n, ' ', 6, 0);

                                                $fixo=$dados[tel];
                                                $fixon = substr_replace($fixo, '(', 0, 0);
                                                $fixon = substr_replace($fixon, ')', 3, 0);
                                                $fixon = substr_replace($fixon, '-', 8, 0);
                                                $fixon = substr_replace($fixon, ' ', 4, 0);

                                                //ARRUMANDO DATA DE NASCIMENTO E CALCULANDO A IDADE
                                                $nasc = $dados['nascimento'];
                                                // CALCULAR A IDADE 
                                                // Separa em dia, mês e ano
                                                list($ano, $mes, $dia ) = explode('-', $nasc);
                                                // Descobre que dia é hoje e retorna a unix timestamp
                                                $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                                // Descobre a unix timestamp da data de nascimento do fulano
                                                $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

                                                // Depois apenas fazemos o cálculo já citado :)
                                                $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                                                //print $idade;
                                                //FIM DO CALCULO DE IDADE
                                                ?>
                                        <tr>
                                            <input type="hidden" name="envia" value="<?php echo $id; ?>">
                                            <td><?php echo $dados['nome']; ?></td>
                                            <td><?php echo $cpfn; ?></td>
                                            <td><?php echo "$dia/$mes/$ano - $idade anos de idade."; ?></td>
                                            <td><?php echo $cel1n; ?></td>
                                            <td><?php echo $dados['email']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalcli<?php echo $id;?>">Visualizar</button>

                                                <!-- MODAL REFERENTE À VIZUALIZAR CLIENTE -->
                                                        <div class="modal fade" id="modalcli<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title text-center" id="myModalLabel">Dados do Cliente</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                                <tr><td>CPF:</td><td colspan="2"><?php echo $cpfn; ?></td></tr>
                                                                                <tr><td>Paciente:</td><td colspan="2"><?php echo $dados['nome']; ?></td></tr>
                                                                                <tr><td>Nascimento:</td><td colspan="2"><?php echo "$dia/$mes/$ano - $idade anos de idade."; ?></td></tr>
                                                                                <tr><td>Sexo:</td><td colspan="2"><?php echo "$sexo"; ?></td></tr>
                                                                                <tr><td>Estado Civil:</td><td colspan="2"><?php echo $dados['estadocivil']; ?></td></tr>
                                                                                <tr><td>Profissão:</td><td colspan="2"><?php echo $dados['prof']; ?></td></tr>
                                                                                    
                                                                                <tr class="<?php echo $ocultar;?>"><td>CRM:</td><td colspan="2"><?php echo $crm; ?></td></tr>
                                                                                <tr class="<?php echo $ocultar;?>"><td>UF CRM:</td><td colspan="2"><?php echo $crm_uf; ?></td></tr>
                                                                                <tr class="<?php echo $ocultar;?>"><td>Área:</td><td colspan="2"><?php echo $crm_area; ?></td></tr>
                                                                                    
                                                                                <tr><td>Celular:</td><td colspan="2"><?php echo $cel1n; ?></td></tr>
                                                                                <tr><td>Telefone Fixo:</td><td colspan="2"><?php echo $fixon; ?></td></tr>
                                                                                <tr><td>E-Mail:</td><td colspan="2"><?php echo $dados['email']; ?></td></tr>
                                                                                <tr><td colspan="3" align="center">
                                                                                <form action="colab_cad.php" method="post">
                                                                                    <input type="hidden" value="<?php echo $cpfbusca; ?>" name="tBusca">
                                                                                    <input type="hidden" value="1" name="vizu">
                                                                                    <button type="submit" class="btn btn-ms btn-primary">Confirmar e Continuar</button>
                                                                                </form>
                                                                            </td></tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                <!-- Fim do modal da vizualização CLIENTE -->
                                            </td>
                                        </tr>
                                        <?php    
                                                }
                                        
                                                if ($crm == ''){
                                                    $colordoc = "oc";
                                                }else{
                                                    $colordoc = "";
                                                }
                                                
                                        ?>
                                    </tbody>
                                </table>
                                
                                <div class="<?php echo $vizualizar;?>" id="cad_user">
                                    
                                    <h2>Gerar novo Usuário</h2>
                                    <form method="post" action="cad_colab.php">
                                        <p><input type="text" name="cad_usu" placeholder="Novo Usuário" required="" class="filtro"></p>
                                        <p><input type="password" name="pass_usu" placeholder="Senha" required="" class="filtro"></p>
                                        <!-- TABELA EXIBIDA QUANDO CRM FOR INFORMADO -->
                                        <table class="<?php echo $colordoc;?>">
                                            <tr>
                                                <td>Cor: </td>  
                                                <td><input type="radio" name="tCor" id="070d48" value="#070d48"><label for="070d48"><div class="azulescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="480747" value="#480747"><label for="480747"><div class="rosaescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="892c03" value="#892c03"><label for="892c03"><div class="laranjaescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="063e06" value="#063e06"><label for="063e06"><div class="verdeescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="3e3d06" value="#3e3d06"><label for="3e3d06"><div class="amareloescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="3e060a" value="#3e060a"><label for="3e060a"><div class="vermelhoescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="063e21" value="#063e21"><label for="063e21"><div class="musgoescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="121413" value="#121413"><label for="121413"><div class="cinzaescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="051a1d" value="#051a1d"><label for="051a1d"><div class="piscinaescuro"></div></label>&nbsp;&nbsp;</td>
                                                <td><input type="radio" name="tCor" id="1c051c" value="#1c051c"><label for="1c051c"><div class="roxoescuro"></div></label>&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                        <!-- esta tabela é exibida sempre -->
                                        <table>
                                            <tr><td colspan="2"><h3>Permições de acesso</h3></td></tr>
                                            <tr><td>Clientes (CLI):</td><td> <input type="radio" name="tCli" id="clisim" value="S" checked><label for="clisim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tCli" id="clinao" value="N"/><label for="clinao" >Não</label></td></tr>
                                            <tr class="<?php echo $colordoc;?>"><td>Doutores (DTR):</td><td> <input type="radio" name="tDoc" id="docsim" value="S"><label for="docsim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tDoc" id="docnao" value="N" checked=""/><label for="docnao" >Não</label></td></tr>
                                            <tr><td>Calendário (CAL):</td><td> <input type="radio" name="tCal" id="clisim" value="S" checked><label for="calsim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tCal" id="calnao" value="N"/><label for="calnao" >Não</label></td></tr>
                                            <tr><td>Atendimento (ATD):</td><td> <input type="radio" name="tAtm" id="atmsim" value="S" checked><label for="atmsim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tAtm" id="atmnao" value="N"/><label for="atmnao" >Não</label></td></tr>
                                            <tr><td>Caixa (CAI):</td><td> <input type="radio" name="tCaixa" id="caisim" value="S"><label for="caisim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tCaixa" id="cainao" value="N" checked=""/><label for="cainao" >Não</label></td></tr>
                                            <tr><td>Mailing/Lead (MAI):</td><td> <input type="radio" name="tMai" id="maisim" value="S"><label for="maisim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tMai" id="mainao" value="N" checked=""/><label for="mainao" >Não</label></td></tr>
                                            <tr><td>Colaboradores (DP):</td><td> <input type="radio" name="tDp" id="dpsim" value="S" checked><label for="dpsim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tDp" id="dpnao" value="N"/><label for="dpnao" >Não</label></td></tr>
                                            <tr class="oc"><td>Administração (ADM):</td><td> <input type="radio" name="tAdm" id="admsim" value="S"><label for="admsim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tAdm" id="admnao" value="N" checked/><label for="admnao" >Não</label></td></tr>
                                            <tr class="oc"><td>Financeiro (FIN):</td><td> <input type="radio" name="tFin" id="finsim" value="S"><label for="finsim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tFin" id="finnao" value="N" checked/><label for="finnao" >Não</label></td></tr>
                                            <tr><td>Sistema (SIS): </td><td> <input type="radio" name="tSys" id="syssim" value="S" checked><label for="syssim">Sim</label>&nbsp;&nbsp;<input type="radio" name="tSys" id="sysnao" value="N" ><label for="sysnao" >Não</label></td></tr>
                                            <tr><td colspan="2" align="center"><input type="submit" value="Gerar Usuário" class="btn btn-xs btn-success"></td></tr>
                                        </table>
                                        <input type="hidden" name="cad_crm" value="<?php echo $crm; ?>">
                                        <input type="hidden" name="cad_nome" value="<?php echo $nomeuser; ?>">
                                        <input type="hidden" name="cad_cpf" value="<?php echo $cpfbusca;?>">
                                        <input type="hidden" name='cad_cnpj_user' value="<?php echo $cnpj?>">
                                    </form>
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
    <script src='../_javascript/bootstrap.min.js'></script>
    <script src='../_javascript/jquery.min.js'></script>
</html>
<?php
}else{
    header("location:../index.php");
}
?>