<?php
    session_start();
    include '../_php/cx.php';
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        $cnpj = $_SESSION['cnpj_session'];
        $user = $_SESSION['user_session'];
        $pass = $_SESSION['pass_session'];

    //VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "SELECT * FROM cnpj_user cu JOIN cnpj c ON cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' AND pass='".$pass."' AND usuario='".$user."'";
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
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/jquery.min.js'></script>
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
                                        <li role="presentation" class="active"><a href="dtr_prontuario.php" target="_self">Prontuários</a></li>
                                        <li role="presentation"><a href="dtr_agenda.php" target="_self">Agenda</a></li>
                                    </ul>
                                </div>
			</div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <form method="post" action="dtr_prontuario.php">
                                            <tr>
                                                <th colspan="6"><input type="text" name="nBuscapac" autofocus="" size="30" placeholder="Busque por CPF, RG ou Nome" required="" class="filtro">&nbsp;&nbsp;&nbsp;
                                                    <input type="submit" value="Buscar" class="btn btn-sm btn-warning"></th>
                                            </tr>
                                        </form>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td>Nome:</td>
                                            <td>CPF: </td>
                                            <td>RG: </td>
                                            <td>Idade: </td>
                                            <td>Prontuário Geral: </td>
                                            <td>Prontuário Local: </td>
                                        </tr>
                                    </thead>
                                        <?php
                                        // Pega os dados enviados por POST desta mesma pagina, comando logo acima
                                        $b = isset($_POST["nBuscapac"]) ? $_POST["nBuscapac"] : "Busca não informada";
                                        
                                        //declara variavel inicial para modificar as divs abaixo
                                        $ocultar = "oc";
                                        
                                        //VAI BUSCAR INFORMAÇÕES DO BANCO DE DADOS
                                        $mostra_sql = "SELECT id, nome , cpf , rg , nascimento FROM clientes WHERE nome = '".$b."' OR cpf = '".$b."' OR rg = '".$b."' ";
                                        $mostra = $cx->query($mostra_sql);

                                        //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                        while ($dados = $mostra->fetch()) {
                                            $idcli = $dados['id'];
                                            $cpf = $dados['cpf'];
                                            $rg = $dados['rg'];
                                            $nometab = $dados['nome'];

                                            // CALCULAR A IDADE 
                                            // Declara a data! :P
                                            $nasc = $dados[nascimento];
                                            $data = $nasc;

                                            // Separa em dia, mês e ano
                                            list($ano, $mes, $dia) = explode('/', $data);

                                            // Descobre que dia é hoje e retorna a unix timestamp
                                            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                            // Descobre a unix timestamp da data de nascimento do fulano
                                            $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

                                            // Depois apenas fazemos o cálculo já citado :)
                                            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                                            //print $idade;
                                            //FIM DO CALCULO DE IDADE
                                            //RECEBENDO E ACRESCENTANDO PONTOS E TRAÇOS NO CPF
                                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                            $cpfn = substr_replace($cpf, '.', 3, 0);
                                            $cpfn = substr_replace($cpfn, '.', 7, 0);
                                            $cpfn = substr_replace($cpfn, '-', 11, 0);
                                            
                                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
                                            $rgn = substr_replace($rg, '.', 2, 0);
                                            $rgn = substr_replace($rgn, '.', 6, 0);
                                            $rgn = substr_replace($rgn, '-', 10, 0);
                                            
                                            if ($cpf != ''){
                                                $documento = $idcli;
                                            }else if ($rg != ''){
                                                $documento = $idcli;
                                            }
                                            
                                            ?>
                                    <tbody>
                                        <!-- FORM EXECUTA AÇÃO NAS DIVS ABAIXO-->
                                        
                                                <tr>
                                                    <td><?php echo $nometab; ?></td>
                                                    <td><?php echo $cpfn; ?></td>
                                                    <td><?php echo $rgn; ?></td>
                                                    <td><?php echo $idade; ?> anos de Idade</td>
                                                    <td>
                                                        <form method='post' action='dtr_prontuario.php'>
                                                            <input type='hidden' value ="<?php echo $documento; ?>" name ='idenvia'>
                                                            <input type='hidden' value ="<?php echo $b; ?>" name ='nBuscapac'>
                                                            <input type='hidden' value ="" name ="geral">
                                                            <input type='hidden' value ="oc" name ="local">
                                                                <button type='submit' class="btn btn-xs btn-primary">Geral</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method='post' action='dtr_prontuario.php'>
                                                            <input type='hidden' value ="<?php echo $documento; ?>" name ='envia'>
                                                            <input type='hidden' value ="<?php echo $b; ?>" name ='nBuscapac'>
                                                            <input type='hidden' value ="oc" name ="geral">
                                                            <input type='hidden' value ="" name ="local">
                                                                <button type='submit' class="btn btn-xs btn-primary">Local</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                        
                                    </tbody>
                                    <?php
                                    }
                                    ?>
                                </table>
                                
                                <!-- DIV REFERENTE AOS PRONTUARIOS GERAL -->
                                <?php 
                                $ocultar = isset($_POST['geral'])?($_POST['geral']):"$ocultar";
                                $idrecebe = isset($_POST['idenvia']) ? $_POST['idenvia'] : '';
                                ?>
                                <div class="<?php echo $ocultar;?>">
                                        <h4 align="center">Ultimos Prontuários (Geral)</h4>
                                        <p align="center">Neste prontuario será apenas informado o CID (Caso ele tenha sido divulgado) e medicamentos resceitados</p>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Paciente</td>
                                                    <td>Especialidade</td>
                                                    <td>Data</td>
                                                    <td>Visualizar</td>
                                                </tr>
                                            </tbody>
                                            
                                                <?php
                                                    //VAI BUSCAR INFORMAÇÕES DO BANCO DE DADOS
                                                    $mostrag_sql = "SELECT * FROM his_med WHERE id_pac = '" . $idrecebe . "' order by id desc";
                                                    $mostrag = $cx->query($mostrag_sql);
                                                    while ($geral = $mostrag->fetch()) {
                                                            //TRAZ INFORMAÇÕES DAS RECEITAS NORMAIS
                                                            $receitageral = '';
                                                            $receitag_sql = "SELECT * FROM receita WHERE id_cli = '" . $idrecebe . "' and atendimento = '".$geral['atendimento']."'";
                                                            $receitag_mostra = $cx->query($receitag_sql);
                                                            While ($rec_geral = $receitag_mostra->fetch()) {
                                                                            $gidrec    = $rec_geral['id_rec'];
                                                                            $gremedio1 = $rec_geral['remedio1'];
                                                                            $gtipouso1 = "-".$rec_geral['tipouso1'];
                                                                            $gmodouso1 = "-".$rec_geral['modouso1'];
                                                                            $gobs1     = "-".$rec_geral['obs1'];
                                                                            $gremedio2 = $rec_geral['remedio2'];
                                                                            $gtipouso2 = "-".$rec_geral['tipouso2'];
                                                                            $gmodouso2 = "-".$rec_geral['modouso2'];
                                                                            $gobs2     = "-".$rec_geral['obs2'];
                                                                            $gremedio3 = $rec_geral['remedio3'];
                                                                            $gtipouso3 = "-".$rec_geral['tipouso3'];
                                                                            $gmodouso3 = "-".$rec_geral['modouso3'];
                                                                            $gobs3     = "-".$rec_geral['obs3'];
                                                                            $gremedio4 = $rec_geral['remedio4'];
                                                                            $gtipouso4 = "-".$rec_geral['tipouso4'];
                                                                            $gmodouso4 = "-".$rec_geral['modouso4'];
                                                                            $gobs4     = "-".$rec_geral['obs4'];
                                                                            $receitageral .= "Receita: ".$gidrec."<br>".$gremedio1."&nbsp;".$gtipouso1."&nbsp;".$gmodouso1."&nbsp;".$gobs1."<br>".$gremedio2."&nbsp;".$gtipouso2."&nbsp;".$gmodouso2."&nbsp;".$gobs2."<br>".$gremedio3."&nbsp;".$gtipouso3."&nbsp;".$gmodouso3."&nbsp;".$gobs3."<br>".$gremedio4."&nbsp;".$gtipouso4."&nbsp;".$gmodouso4."&nbsp;".$gobs4."<br><br>"; 
                                                                        }

                                                        //TRAZ INFORMAÇÕES DAS RECEITAS_ESPECIAIS
                                                            $receitaespecgeral = '';
                                                            $receitaespecialg_sql = "SELECT * FROM receita_especial WHERE id_cli = '" . $idrecebe . "' and atendimento = '".$geral['atendimento']."'";
                                                            $receitaespecialg_mostra = $cx->query($receitaespecialg_sql);
                                                            While ($recespec_geral = $receitaespecialg_mostra->fetch()) {
                                                                            $gidrecespec    = $recespec_geral['id_rec_espec'];
                                                                            $gespecremedio1 = $recespec_geral['remedio1'];
                                                                            $gespectipouso1 = $recespec_geral['tipouso1'];
                                                                            $gespecmodouso1 = $recespec_geral['modouso1'];
                                                                            $gespecobs1     = "-".$recespec_geral['obs1'];
                                                                            $gespecremedio2 = $recespec_geral['remedio2'];
                                                                            $gespectipouso2 = $recespec_geral['tipouso2'];
                                                                            $gespecmodouso2 = $recespec_geral['modouso2'];
                                                                            $gespecobs2     = "-".$recespec_geral['obs2'];
                                                                            $gespecremedio3 = $recespec_geral['remedio3'];
                                                                            $gespectipouso3 = $recespec_geral['tipouso3'];
                                                                            $gespecmodouso3 = $recespec_geral['modouso3'];
                                                                            $gespecobs3     = "-".$recespec_geral['obs3'];
                                                                            $gespecremedio4 = $recespec_geral['remedio4'];
                                                                            $gespectipouso4 = $recespec_geral['tipouso4'];
                                                                            $gespecmodouso4 = $recespec_geral['modouso4'];
                                                                            $gespecobs4     = "-".$recespec_geral['obs4'];
                                                                            $receitaespecgeral .= "Receita: ".$gidrecespec."<br>".$gespecremedio1."&nbsp;".$gespectipouso1."&nbsp;".$gespecmodouso1."&nbsp;".$gespecobs1."<br>".$gespecremedio2."&nbsp;".$gespectipouso2."&nbsp;".$gespecmodouso2."&nbsp;".$gespecobs2."<br>".$gespecremedio3."&nbsp;".$gespectipouso3."&nbsp;".$gespecmodouso3."&nbsp;".$gespecobs3."<br>".$gespecremedio4."&nbsp;".$gespectipouso4."&nbsp;".$gespecmodouso4."&nbsp;".$gespecobs4."<br><br>"; 
                                                                        }
                                                        
                                                        $geralid = $geral['id'];
                                                        $geralnome = $geral['nome_pac'];
                                                        $geralcpf = $geral['cpf'];
                                                        $geralrg = $geral['rg'];
                                                        $geralcn = $geral['certnasc'];
                                                        $geralespec = $geral['especialidade'];
                                                        $geraldata = $geral['data_h'];
                                                        $geralciddiv = $geral['ciddiv'];
                                                        $geralcidcod= $geral['cidcod'];
                                                        $geralciddesc = $geral['ciddesc'];
                                                        
                                                        list($anog, $mesg, $diag) = explode('-', $geraldata);
                                                        
                                                        //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                                        $cpfgeraln = substr_replace($geralcpf, '.', 3, 0);
                                                        $cpfgeraln = substr_replace($cpfgeraln, '.', 7, 0);
                                                        $cpfgeraln = substr_replace($cpfgeraln, '-', 11, 0);
                                                        
                                                        //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
                                                        $geralrgn = substr_replace($geralrg, '.', 2, 0);
                                                        $geralrgn = substr_replace($geralrgn, '.', 6, 0);
                                                        $geralrgn = substr_replace($geralrgn, '-', 10, 0);
                                                        
                                                        //MEXENDO NA VARIALVEL CID
                                                        
                                                        if ($geralciddiv == 'N'){
                                                            $divulgacid = 'CID não divulgado';
                                                        } else if ($geralciddiv == 'S'){
                                                            $divulgacid = $geralcidcod."&nbsp;-&nbsp;".$geralciddesc;
                                                        }
                                                        
                                                        ?> 
                                                <tr>
                                                    <td><?php echo $geralnome;?></td>
                                                    <td><?php echo $geralespec;?></td>
                                                    <td><?php echo "$diag/$mesg/$anog";?></td> 
                                                    <td>
                                                        <button type='button' class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalvizugeral<?php echo $geralid;?>">Visualizar</button>
                                                                <!-- MODAL REFERENTE À VIZUALIZAR ATENDIMENTO -->
                                                                                <div class="modal fade" id="modalvizugeral<?php echo $geralid;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                                    <div class="modal-dialog" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                <h4 class="modal-title text-center" id="myModalLabel">Prontuário Geral</h4>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <table class="table">

                                                                                                    <tr><td colspan="2"><h4 align="center">Dados do Atendimento</h4></td></tr>
                                                                                                    <tr><td>Paciente:</td><td><?php echo $geralnome;?></td></tr>
                                                                                                    <tr><td>CPF:</td><td><?php echo $cpfgeraln;?></td></tr>
                                                                                                    <tr><td>RG:</td><td><?php echo $geralrgn;?></td></tr>
                                                                                                    <tr><td>Cert. Nasc.:</td><td><?php echo $geralcn;?></td></tr>
                                                                                                    <tr><td>Data:</td><td><?php echo "$diag/$mesg/$anog";?></td></tr>
                                                                                                    <tr><td>CID:</td><td><?php echo "$divulgacid";?></td></tr>
                                                                                                    <tr><td>Especialidade:</td><td><?php echo $geralespec;?></td></tr>
                                                                                                    <tr><td colspan="2"><h4 align="center">Receitas Normais</h4></td></tr>
                                                                                                    <tr><td colspan="2"><?php echo $receitageral;?></td></tr>
                                                                                                    <tr><td colspan="2"><h4 align="center">Receitas Especiais</h4></td></tr>
                                                                                                    <tr><td colspan="2"><?php echo $receitaespecgeral;?></td></tr>

                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>  
                                                                    <!-- Fim do modal do ATENDIMENTO -->
                                                    </td>
                                            </tr>
                                            
                                            <?php
                                                }
                                                ?>
                                        </table>
                                </div>
                                
                                <!-- DIV REFERENTE AOS PRONTUARIOS LOCAL -->
                                <?php 
                                $ocultar = isset($_POST['local'])?($_POST['local']):"$ocultar";
                                $idrecebe = isset($_POST['envia']) ? $_POST['envia'] : '';
                                ?>
                                <div class="<?php echo $ocultar;?>">
                                        <h4 align="center">Ultimos Prontuários (Local)</h4>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Atendimento</td>
                                                    <td>Paciente</td>
                                                    <td>Doutor</td>
                                                    <td>Especialidade</td>
                                                    <td>Convenio</td>
                                                    <td>Data</td>
                                                    <td>Visualizar</td>
                                                </tr>
                                            </tbody>
                                                <?php
                                                
                                                //VAI BUSCAR INFORMAÇÕES DO BANCO DE DADOS REFERENTE AO HISTORICO MEDICO
                                                $mostra_sql = "SELECT * FROM his_med WHERE id_pac = '" . $idrecebe . "' and cnpj = '".$cnpj."' and crm = ".$crm." order by id desc";
                                                $mostra = $cx->query($mostra_sql);
                                                while ($local = $mostra->fetch()) {
                                                        
                                                    //TRAZ INFORMAÇÕES DAS RECEITAS NORMAIS
                                                        $receitalocal = '';
                                                        $receita_sql = "SELECT * FROM receita WHERE id_cli = '" . $idrecebe . "' and atendimento = '".$local['atendimento']."'";
                                                        $receita_mostra = $cx->query($receita_sql);
                                                        While ($rec_local = $receita_mostra->fetch()) {
                                                                        $idrec    = $rec_local['id_rec'];
                                                                        $remedio1 = $rec_local['remedio1'];
                                                                        $tipouso1 = "-".$rec_local['tipouso1'];
                                                                        $modouso1 = "-".$rec_local['modouso1'];
                                                                        $obs1     = "-".$rec_local['obs1'];
                                                                        $remedio2 = $rec_local['remedio2'];
                                                                        $tipouso2 = "-".$rec_local['tipouso2'];
                                                                        $modouso2 = "-".$rec_local['modouso2'];
                                                                        $obs2     = "-".$rec_local['obs2'];
                                                                        $remedio3 = $rec_local['remedio3'];
                                                                        $tipouso3 = "-".$rec_local['tipouso3'];
                                                                        $modouso3 = "-".$rec_local['modouso3'];
                                                                        $obs3     = "-".$rec_local['obs3'];
                                                                        $remedio4 = $rec_local['remedio4'];
                                                                        $tipouso4 = "-".$rec_local['tipouso4'];
                                                                        $modouso4 = "-".$rec_local['modouso4'];
                                                                        $obs4     = "-".$rec_local['obs4'];
                                                                        $receitalocal .= "Receita: ".$idrec."<br>".$remedio1."&nbsp;".$tipouso1."&nbsp;".$modouso1."&nbsp;".$obs1."<br>".$remedio2."&nbsp;".$tipouso2."&nbsp;".$modouso2."&nbsp;".$obs2."<br>".$remedio3."&nbsp;".$tipouso3."&nbsp;".$modouso3."&nbsp;".$obs3."<br>".$remedio4."&nbsp;".$tipouso4."&nbsp;".$modouso4."&nbsp;".$obs4."<br><br>"; 
                                                                    }
                                                                    
                                                    //TRAZ INFORMAÇÕES DAS RECEITAS_ESPECIAIS
                                                        $receitaespeclocal = '';
                                                        $receitaespecial_sql = "SELECT * FROM receita_especial WHERE id_cli = '" . $idrecebe . "' and atendimento = '".$local['atendimento']."'";
                                                        $receitaespecial_mostra = $cx->query($receitaespecial_sql);
                                                        While ($recespec_local = $receitaespecial_mostra->fetch()) {
                                                                        $idrecespec    = $recespec_local['id_rec_espec'];
                                                                        $especremedio1 = $recespec_local['remedio1'];
                                                                        $espectipouso1 = $recespec_local['tipouso1'];
                                                                        $especmodouso1 = $recespec_local['modouso1'];
                                                                        $especobs1     = "-".$recespec_local['obs1'];
                                                                        $especremedio2 = $recespec_local['remedio2'];
                                                                        $espectipouso2 = $recespec_local['tipouso2'];
                                                                        $especmodouso2 = $recespec_local['modouso2'];
                                                                        $especobs2     = "-".$recespec_local['obs2'];
                                                                        $especremedio3 = $recespec_local['remedio3'];
                                                                        $espectipouso3 = $recespec_local['tipouso3'];
                                                                        $especmodouso3 = $recespec_local['modouso3'];
                                                                        $especobs3     = "-".$recespec_local['obs3'];
                                                                        $especremedio4 = $recespec_local['remedio4'];
                                                                        $espectipouso4 = $recespec_local['tipouso4'];
                                                                        $especmodouso4 = $recespec_local['modouso4'];
                                                                        $especobs4     = "-".$recespec_local['obs4'];
                                                                        $receitaespeclocal .= "Receita: ".$idrecespec."<br>".$especremedio1."&nbsp;".$espectipouso1."&nbsp;".$especmodouso1."&nbsp;".$especobs1."<br>".$especremedio2."&nbsp;".$espectipouso2."&nbsp;".$especmodouso2."&nbsp;".$especobs2."<br>".$especremedio3."&nbsp;".$espectipouso3."&nbsp;".$especmodouso3."&nbsp;".$especobs3."<br>".$especremedio4."&nbsp;".$espectipouso4."&nbsp;".$especmodouso4."&nbsp;".$especobs4."<br><br>"; 
                                                                    }
                                                                    
                                                    
                                                    $localid = $local['id'];
                                                    $localatend = $local['atendimento'];
                                                    $localrelato = $local['relato'];
                                                    $localdiag = $local['diagnostico'];
                                                    $localcidcod= $local['cidcod'];
                                                    $localciddesc = $local['ciddesc'];
                                                    $localobs = $local['obs'];
                                                    $localdata = $local['data_h'];
                                                    $localhora = $local['hora'];
                                                    $localcpf = $local['cpf'];
                                                    $localrg = $local['rg'];
                                                    $localcn = $local['certnasc'];
                                                    $localpac = $local['nome_pac'];
                                                    $localprof = $local['prof'];
                                                    $localdoc = $local['nome_doc'];
                                                    $localespec = $local['especialidade'];
                                                    $localconv = $local['convenio'];
                                                    
                                                    $cidlocal = $localcidcod . "&nbsp;-&nbsp;" . $localciddesc;
                                                    list($anol, $mesl, $dial) = explode('-', $localdata);
                                                    
                                                    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                                    $cpflocaln = substr_replace($localcpf, '.', 3, 0);
                                                    $cpflocaln = substr_replace($cpflocaln, '.', 7, 0);
                                                    $cpflocaln = substr_replace($cpflocaln, '-', 11, 0);
                                                    
                                                    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
                                                    $localrgn = substr_replace($localrg, '.', 2, 0);
                                                    $localrgn = substr_replace($localrgn, '.', 6, 0);
                                                    $localrgn = substr_replace($localrgn, '-', 10, 0);   
                                                    
                                                    ?> 
                                            
                                                <tr>
                                                    <td><?php echo $localatend;?></td>
                                                    <td><?php echo $localpac;?></td>
                                                    <td><?php echo $localdoc;?></td>
                                                    <td><?php echo $localespec;?></td>
                                                    <td><?php echo $localconv;?></td>
                                                    <td><?php echo "$dial/$mesl/$anol";?></td> 
                                                    <td>
                                                        <button type='button' class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalvizulocal<?php echo $localid;?>">Vizualizar</button>
                                                
                                                        <!-- MODAL REFERENTE À VIZUALIZAR ATENDIMENTO -->
                                                                    <div class="modal fade" id="modalvizulocal<?php echo $localid;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title text-center" id="myModalLabel">Prontuário Local</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <table class="table">
                                                                                        
                                                                                        <tr><td colspan="2"><h4 align="center">Dados do Atendimento</h4></td></tr>
                                                                                        <tr><td>Paciente:</td><td><?php echo $localpac;?></td></tr>
                                                                                        <tr><td>CPF:</td><td><?php echo $cpflocaln;?></td></tr>
                                                                                        <tr><td>RG:</td><td><?php echo $localrgn;?></td></tr>
                                                                                        <tr><td>Cert. Nasc.:</td><td><?php echo $localcn;?></td></tr>
                                                                                        <tr><td>Profissão:</td><td><?php echo $localprof;?></td></tr>
                                                                                        <tr><td>Atendimento:</td><td><?php echo $localatend;?></td></tr>
                                                                                        <tr><td>Data:</td><td><?php echo "$dial/$mesl/$anol";?></td></tr>
                                                                                        <tr><td>Hora:</td><td><?php echo $localhora;?></td></tr>
                                                                                        <tr><td>Relato:</td><td><?php echo $localrelato;?></td></tr>
                                                                                        <tr><td>Diagnóstico:</td><td><?php echo $localdiag;?></td></tr>
                                                                                        <tr><td>Observação:</td><td><?php echo $localobs;?></td></tr>
                                                                                        <tr><td>CID:</td><td><?php echo $cidlocal;?></td></tr>
                                                                                        <tr><td>Convênio:</td><td><?php echo $localconv;?></td></tr>
                                                                                        <tr><td>Doutor:</td><td><?php echo $localdoc;?></td></tr>
                                                                                        <tr><td>Especialidade:</td><td><?php echo $localespec;?></td></tr>
                                                                                        <tr><td colspan="2"><h4 align="center">Receitas Normais</h4></td></tr>
                                                                                        <tr><td colspan="2"><?php echo $receitalocal;?></td></tr>
                                                                                        <tr><td colspan="2"><h4 align="center">Receitas Especiais</h4></td></tr>
                                                                                        <tr><td colspan="2"><?php echo $receitaespeclocal;?></td></tr>
                                                                                        
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>  
                                                        <!-- Fim do modal do ATENDIMENTO -->
                                                    </td>
                                                </tr>    
                                            <?php
                                                
                                                }
                                                ?>
                                        </table>
                                        
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


