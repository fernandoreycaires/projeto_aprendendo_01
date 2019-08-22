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

$msg = $_POST['msg'];            

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ADM Consultório</title>
        <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/log.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/acesso.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
	<link href='../_css/bootstrap.min.css' rel='stylesheet'>
        <script>
            //função que compara os campos das senhas, pra saber se são iguais
            function comparar() {
                var valor1 = document.getElementById("valor1").value;
                var valor2 = document.getElementById("valor2").value;
                var elemResult = document.getElementById("resultado");

                if (valor1 !== valor2){
                    elemResult.innerText = "AS SENHAS SÃO DIFERENTES";
                    return false; //Parar a execucao
                } else if (valor1 === valor2){
                    elemResult.innerText = "AS SENHAS SÃO IGUAIS";
                    return false; //Parar a execucao
                }
            }
        </script>
        <style>
            .senha {
                background-color: rgba(38,42,48,1);
                color: rgb(255,255,255);
                width: 300px;
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
                <h1 align="center">Alterar Senha</h1>
            </div>
            
            <div>
                <p>Você está conectado pela empresa<span class="banco"> <?php echo $razao;?></span> de CNPJ <span class="banco"><?php echo $cnpjn;?></span> </p>
                <h4 align="center"><?php echo $msg;?></h4>
                <form method="post" action="senhaalterada.php">
                    <p><input type="password" onblur="comparar();" id="valor1" name="newpassw" required="" placeholder="NOVA SENHA" class="senha"></p>
                    <p><input type="password" onblur="comparar();" id="valor2" required="" placeholder="CONFIRMAR SENHA" class="senha"></p>
                    <p><span class="valortotal" id="resultado"></span></p>
                    <p align="center"><input type="submit" class="btn btn-xs btn-success" value="Alterar"></p>
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
    header("location:index.php");
}
?>
