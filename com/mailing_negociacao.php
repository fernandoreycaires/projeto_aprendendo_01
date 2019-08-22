<?php 
session_start();
include '../_php/cx.php';
include 'com_menunav.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "select id_u_cnpj, cu.nome_u from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
    $acesso_user = $cx->query ($acesso);

    while ($perfil = $acesso_user->fetch()){
        $nome = $perfil['nome_u'];
        $id_user = $perfil['id_u_cnpj'];
     } 
 
$msg = $_POST['msg'];
$data_atual = date('Y-m-d');
$hora_atual = date('H:i:s');

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Comercial</title>
                <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
                <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/com.css" rel="stylesheet" type="text/css"/>
                <link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <style>
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
                    

                    
                    .negociacao{
                        display: block;
                        position: relative;
                        border: 1px rgb(85,87,91) solid;
                        border-radius: 10px;
                        width: 100%;
                        margin: 8px;
                        padding: 5px;
                        font-size:14px;
                        box-shadow: 0px 0px 15px rgba(85,87,91,.5);
                        background-color: rgba(40,40,40,.8);
                    }

                    .negociacao:hover{
                        box-shadow: 0px 0px 10px rgba(255,255,255,0.5);
                        -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                        -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                        transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
                    }

                    .diahoraneg {
                        display: block;
                        position: absolute;
                        left: 80%;
                        top: 0px;
                        margin: 8px;
                        padding: 5px;
                    }

                    .observacao {
                        display: block;
                        width: 60%;
                        margin: 8px;
                        padding: 5px;
                    }
                    
                    .btn-negociacao{
                        width: 100%;
                        background-color: rgba(0,0,0,0);
                        text-align: left;
                        border: none;
                        margin: 0;
                        padding: 0;
                        
                    }
                    
                    
                </style>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                                <h1 align="center">Comercial</h1>
                        </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $menunav; ?>
                        
                        <h4 align="center">Mailing Negociações em aberto</h4>    
                        
                            <h4 align='center'>Retornar Ligações </h4>
                            <?php
                            //BUSCANDO INFORMAÇÕES DA TABELA MAILING_OBS
                                $obssql = "SELECT * FROM mailing_obs WHERE ret_dia = '".$data_atual."' ORDER BY ret_hora ASC";
                                $enviaobs = $cx->query ($obssql);

                                while ($obs = $enviaobs->fetch()){
                                    $obs_idmo = $obs['id_mo'];
                                    $obs_idm = $obs['id_m'];
                                    $obs_obs = $obs['obs'];
                                    $obs_operador = $obs['operador'];
                                    $obs_idop = $obs['id_op'];
                                    $obs_retdia = $obs['ret_dia'];
                                    $obs_rethora = $obs['ret_hora'];
                                    $obs_retornar = $obs['retornar'];
                                    
                                    if ($obs_retornar == "S"){
                                        $classeret = "diahoraneg";
                                    } else if ($obs_retornar == "N" or $obs_retornar == ""){
                                        $classeret = "oc";
                                    }
                                    
                                    
                                    list($anor, $mesr, $diar) = explode('-', $obs_retdia);
                                    $obs_retdia = $diar." / ".$mesr." / ".$anor ;
                                    
                                    //BUSCA DADOS DO CLIENTE COM O ID informado
                                            $clisql = "SELECT * FROM mailing WHERE id_m = '".$obs_idm."' limit 1";
                                            $enviacli = $cx->query ($clisql);

                                            while ($cli = $enviacli->fetch()){
                                                $cliid = $cli['id_m'];
                                                $clirazao = $cli['razao'];
                                                $clifantasia = $cli['nfan'];
                                                $clinome = $cli['nome'];
                                                $clicpf = $cli['cpf'];
                                                $clicrm = $cli['crm'];
                                                $cliarea = $cli['area_m'];
                                            } 
                                            if ($clirazao != ""){
                                                $climailing = $clirazao;
                                            } else if ($clifantasia != ""){
                                                $climailing = $clifantasia;
                                            } 
                                                

                            ?>
                            
                            <div class="negociacao">
                                <form method="post" action="mailing_obs.php">
                                    <input type="hidden" value="<?php echo $cliid;?>" name="id_m">
                                    <button class="btn-negociacao" type="submit">
                                        <div class="observacao" >
                                            <p><span class="banco">ID Cliente:</span> <?php echo $obs_idm;?></p>
                                            <p><span class="banco">Cliente:</span> <?php echo $climailing;?></p> 
                                            <p><span class="banco">Área:</span> <?php echo $cliarea;?></p>
                                            <p><span class="banco">ID Observações:</span> <?php echo $obs_idmo;?></p>
                                            <p><span class="banco">Observações:</span> <?php echo $obs_obs;?></p> 
                                            <p><span class="banco">Operador:</span> <?php echo $obs_operador;?></p>
                                            <p><span class="banco">ID Operador:</span> <?php echo $obs_idop;?></p>
                                        </div>
                                    </button>
                                        <div class="diahoraneg">
                                            <h4 align="center">Retornar</h4>
                                            <p><span class="banco">Dia:</span> <?php echo $obs_retdia;?></p> 
                                            <p><span class="banco">Hora:</span> <?php echo $obs_rethora;?></p>
                                        </div>
                                </form>
                            </div>
                            
                            <?php 
                                } 
                            ?>
                        
                        
                    </div>
                </div>
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
