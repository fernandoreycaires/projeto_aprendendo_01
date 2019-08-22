<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $nresp = $_POST['tRespnome'];
    $celresp = $_POST['tRespcel'];
    $fxresp = $_POST['tRespfixo'];
    $mae = $_POST['tMae'];
    $cpfmae = $_POST['tCPFMae'];
    $pai = $_POST['tPai'];
    $cpfpai = $_POST['tCPFPai'];
    
    
    // CRIA COMANDO SQL
    $sql = "UPDATE clientes SET nome_mae='".$mae."', cpf_mae='".$cpfmae."', nome_pai = '".$pai."', cpf_pai = '".$cpfpai."' , respnome='{$nresp}' , respcel='{$celresp}' , resptel='{$fxresp}' WHERE id='{$id}' limit 1";
                   
    
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
                document.salva.submit()
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
                document.salva.submit()
            </script>
        </html>
        <?php
        
    }
}else{
    header("location:../index.php");
}
?>