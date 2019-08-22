<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>ADM Consultório</title>
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/drt.css" rel="stylesheet" type="text/css"/>
        <?php include '../_php/cx.php';?>
    </head>
    <body>
        <div id="interface">
            <div class="logo1"></div>
            <header id="cabecalho">
                
                <p id="sair"><a href="../home.php">Voltar para Menu</a></p>
            </header>
            
            <footer id="rodape">
                <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
            </footer>
        </div>
    </body>
</html>
<?php
}else{
    header("location:index.php");
}
?>
