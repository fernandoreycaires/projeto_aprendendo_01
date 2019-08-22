<?php 
session_start();
if(!isset($_SESSION['cnpj_session']) and !isset($_SESSION['user_session']) and !isset($_SESSION['pass_session']) ){
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>ADM Consultório</title>
        <link rel="shortcut icon" href="_imagens/Logo_FRC_1.ico" type="image/x-icon" />
        <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/log.css" rel="stylesheet" type="text/css"/>
        <link href='../_css/bootstrap.min.css' rel='stylesheet'>
        
        <style>
            
            div#logo1 {
                display: block;
                width: 150px;
                height: 150px;
                margin: 0 0 0 35% ;
                padding: 0px;
                background: url('_imagens/Logo_FRC_1.png') no-repeat;
                background-size: 150px;
            }

            .campos {
                background-color: rgba(38,42,48,.5);
                color: rgb(206, 206, 206);
                width: 300px;
                height:34px;
                padding:6px 12px;
                font-size:15px;
                line-height:1.42857143;
                border:1px solid rgba(38,42,48,.0);
                border-radius:4px;
                -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            }
            
            .btn-entrar{
                color:#fff;
                background-color:#377768;
                border-color: rgba(0,0,0,0);
            }
            
            .btn-entrar:hover{
                color:#fff;
                background-color:#449d44;
                border-color: rgba(0,0,0,0);
            }
                    
                  
        </style>
        <script type="text/javascript" src="_javascript/acesso.js"></script>
    </head>
    <body>
        
            <div id="sec_log">
                <div id="log">
                    <div id="logo1">
                    </div>
                    <div id="cabecalho_log">
                        <p>Bem Vindo </p>
                    </div>
                    <form name="indexForm" method="post" action="" onsubmit=" return val();">
                        <p>Insira seu CNPJ, Usuário e Senha</p>
                        <p><input type="text" class="campos" placeholder="CNPJ" name="tCNPJ" id="cCNPJ" size="30"></p>
                        <p><input type="text" class="campos" placeholder="USUÁRIO" name="tUser" id="cUser" size="30"></p> 
                        <p><input type="password" class="campos" placeholder="SENHA" name="tPass" id="cPass" size="30"></p>
                        <p><input type="submit" value="Entrar" id="cEntrar" class="btn btn-xm btn-entrar"></p>    
                    </form>
                 </div>
            
                       
                <footer id="rodape_log">
                    <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                        <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                </footer>
            </div>
        
    </body>
</html>
<?php 
}else{
header("location:dtr/dtr_home.php");
}

//PEGUA INFORMAÇÃO DE ACESSO DO INDEX VIA POST
$cnpj = isset($_POST["tCNPJ"])?$_POST["tCNPJ"]:'Não Informado';
$user = isset($_POST["tUser"])?$_POST["tUser"]:'Não Informado';
$pass = isset($_POST["tPass"])?$_POST["tPass"]:'Não Informado';

//VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
include '../_php/cx.php';
$acesso = "SELECT usuario , pass , cnpj_vinc FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' AND pass='".$pass."' AND usuario='".$user."'";
$query = $cx->query ($acesso);

while ($acesso_user = $query->fetch()){
$cnpjbanco = $acesso_user['cnpj_vinc'];
$usuariobanco = $acesso_user['usuario'];
$senhabanco = $acesso_user['pass'];
}

//VALIDAÇÃO DE DADOS PARA INICIAR A SESSÃO DENTRO DO WHILE
if ($cnpjbanco != '' and $usuariobanco != '' and $senhabanco != ''){
    $_SESSION['cnpj_session']=$cnpjbanco;
    $_SESSION['user_session']=$usuariobanco;
    $_SESSION['pass_session']=$senhabanco;
    header("location:dtr/dtr_home.php"); 
}

?>