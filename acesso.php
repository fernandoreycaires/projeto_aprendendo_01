<?php
session_start();
include '_php/cx.php';
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

             //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
            $cnpjnn = $cnpju;
            $cnpjn = substr_replace($cnpjnn, '.', 2, 0);
            $cnpjn = substr_replace($cnpjn, '.', 6, 0);
            $cnpjn = substr_replace($cnpjn, '/', 10, 0);
            $cnpjn = substr_replace($cnpjn, '-', 15, 0);
            

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>ADM Consultório</title>
        <link href="_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="_css/log.css" rel="stylesheet" type="text/css"/>
        <link href="_css/acesso.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="interface">
            <header id="cabecalho_log">
                <p>Bem Vindo </p>
            </header>
            <p>Seja Bem vindo <?php echo $nome;?></p>
            <p>Você está conectado pela empresa<span class="banco"> <?php echo $razao;?></span> de CNPJ <span class="banco"><?php echo $cnpjn;?></span> </p>
            <p>Selecione abaixo o proximo passo:</p>
            <ul id="acesso">
                <a href="home.php"><li id="sistema"><span>Sistema</span></li></a>
                <a href="_php/alterarsenhausuario.php"><li id="alt_pass"><span>Alterar Senha</span></li></a>
                <a href="_php/fechar_sessao.php"><li id="sair"><span>Sair</span></li></a>
            </ul>
            <footer id="rodape_log">
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
