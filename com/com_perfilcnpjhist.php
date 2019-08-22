<?php
session_start();
include '../_php/cx.php';
include 'com_menunav.php';
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
    $razao = $perfil['razao_c'];
 } 

//RECEBE CPF VINDO DA TELA HOME_CLI
 $idcnpj = isset($_POST['idcnpj'])?$_POST['idcnpj']:'';
 $cnpjclirecebe = isset($_POST['cnpjcli'])?$_POST['cnpjcli']:'';
 $msgerro = isset($_POST['erro'])?$_POST['erro']:'';
 
//BUSCA DADOS DO CLIENTE COM O CPF INFORMADO ACIMA
$clisql = "SELECT id_c, razao_c, cnpj_c, nfantasia_c  FROM cnpj WHERE id_c = '".$idcnpj."' or cnpj_c = '".$cnpjclirecebe."' limit 1";
$enviacli = $cx->query ($clisql);

while ($cli = $enviacli->fetch()){
    $cliid = $cli['id_c'];
    $clirazao = $cli['razao_c'];
    $clifantasia = $cli['nfantasia_c'];
    $clicnpj = $cli['cnpj_c'];
} 
 
 
//MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
    $cnpjn = substr_replace($clicnpj, '.', 2, 0);
    $cnpjn = substr_replace($cnpjn, '.', 6, 0);
    $cnpjn = substr_replace($cnpjn, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn, '-', 15, 0);
        
    ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>ADM Consultório</title>
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/com.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
        <link href='../_css/bootstrap.min.css' rel='stylesheet'>
        <style>
            /* MENUS DE NAVEGAÇÃO */
            button#navegador {
                color: #fff;
                background: transparent;
                border-color: transparent;
                width: 100%;
                padding:10px 15px;
            }
            
            button#navegador:hover {
                color: #0ed3b5;
                background: transparent;
                border-color: transparent;
                width: 100%;
                height: 100%;
            }
            
            .nav{
                padding-left:0;
                margin-bottom:0;
                list-style:none;
            }
            .nav>li{
                position:relative;
                display:block;
            }
            
            .nav>li>form{
                position:relative;
                display:block;
                
            }

            .nav>li>form:focus,.nav>li>form:hover{
                text-decoration:none;
                background-color:#eee;
            }

            .nav>li.disabled>form{
                color:#777;
            }

            .nav>li.disabled>form:focus,.nav>li.disabled>form:hover{
                color:#777;
                text-decoration:none;
                cursor:not-allowed;
                background-color:transparent;
            }

            .nav .open>form,.nav .open>form:focus,.nav .open>form:hover{
                background-color:#eee;
                border-color:#337ab7;
            }

            .nav .nav-divider{
                height:1px;
                margin:9px 0;
                overflow:hidden;
                background-color:#e5e5e5;
            }

            .nav>li>form>img{
                max-width:none;
            }

            .nav-tabs {
                border-bottom:1px solid #ddd;
            }

            .nav-tabs>li{
                float:left;
                margin-bottom: -1px;
            }

            .nav-tabs>li>form{
                margin-right:2px;
                line-height:1.42857143;
                border:1px solid rgb(122, 121, 121);
                border-radius:4px 4px 0 0;
                background-color:rgba(96,96,96,.5);
            }

            .nav-tabs>li>form:hover{
                border-color:rgba(85, 129, 130, .5);
                background-color:rgba(85, 129, 130, .5);
            }

            .nav-tabs>li.active>form,.nav-tabs>li.active>form:focus,.nav-tabs>li.active>form:hover{
                color:#e0e0e0;
                cursor:default;
                background-color:rgb(122, 121, 121);
                border:1px solid rgb(122, 121, 121);
                border-bottom-color:rgb(122, 121, 121);
            }

            .nav-tabs.nav-justified{
                width:100%;
                border-bottom:0;
            }

            .nav-tabs.nav-justified>li{
                float:none;
            }

            .nav-tabs.nav-justified>li>form{
                margin-bottom:5px;
                text-align:center;
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
                    <h1 align="center">Comercial</h1>
            </div>
            
            <div class="row">
                    <div class="col-md-12">
                        <?php echo $menunav; ?>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-justified">
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpj.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Dados da Empresa</button>
                                        </form>
                                    </li>
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpjuser.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Lista de Usuário</button>
                                        </form>
                                    </li>
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpjusercad.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Cadastrar Usúario</button>
                                        </form>
                                    </li>
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpjobs.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Negociações e Obs</button>
                                        </form>
                                    </li>
                                    <li role="presentation" class="active">
                                        <form method="post" action="com_perfilcnpjhist.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Histórico</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
			</div>
                        <br>
                        <h4 align="center"><?php echo $clifantasia;?></h4>
                        <p align="center"><?php echo $cnpjn;?></p>
                            
                
                
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