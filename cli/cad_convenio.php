<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];


//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $convenio = $_POST['tConv'];
    $tipo = $_POST['tTipo'];
    $carteirinha = $_POST['tNcart'];
    
    // CRIA COMANDO SQL
    $sql = "INSERT INTO convenio (id_cli, empresa, tipo, num_cart) VALUES ('".$id."', '".$convenio."', '".$tipo."', '".$carteirinha."')";             
    
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);
    
    if ($q) {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="perfil_cli.php">
                    <input type="hidden" name="recebeid" value="<?php echo $id;?>">
                </form>
            </body>
            <script type="text/javascript">
                document.salva.submit();
            </script>
        </html>
        <?php
                        
        
    } else {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="perfil_cli.php">
                    <input type="hidden" name="recebeid" value="<?php echo $id;?>">
                    <input type="hidden" name="erro" value="ALTERAÇÃO NÃO EXECUTADA, CONFIRA OS DADOS E/OU CONTATE O ADMINISTRADOR. ">
                </form>
            </body>
            <script type="text/javascript">
                document.salva.submit();
            </script>
        </html>
        <?php
        
    }
}else{
    header("location:../index.php");
}
?>