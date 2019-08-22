<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//RECEBE VALORES DE COM_CADCNPJ
$cadprod = $_POST['tProd'];
$caddesc = $_POST['tDesc'];
$cadvalor = $_POST['tValor'];



    // CRIA COMANDO SQL
    $sql = "INSERT INTO produto (nome_prod ,descr_prod , valor_prod ) VALUES "
            . "('{$cadprod}' , '{$caddesc}' , '{$cadvalor}')";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
        $msg = 'PRODUTO CADASTRADO COM SUCESSO !';
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvaprod" id="salvaprod" action="servicos_home.php">
                        <input type="hidden" name="msg" value="<?php echo $msg;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvaprod.submit();
                </script>
            </html>
            <?php
        } else {
            $msg = 'OCORREU UM ERRO AO CADASTRAR O CLIENTE ! ';
        }
    

    
}else{
    header("location:index.php");
}
?>