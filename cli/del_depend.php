<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    //id do dependente
    $id = $_POST['iddep'];
    //cpf e ID do titular
    $cpf = $_POST['tCpf'];
    $cliid = $_POST['tID'];
    
    // CRIA COMANDO SQL
    $sql = "UPDATE clientes SET cpf_mae='', nome_mae='' WHERE id='".$id."' AND cpf_mae='".$cpf."' limit 1";
    $q = $cx->query ($sql);
    
    $sql = "UPDATE clientes SET cpf_pai = '', nome_pai='' WHERE id='".$id."' AND cpf_pai='".$cpf."' limit 1";
    $q2 = $cx->query ($sql);
    
    if ($q and $q2) {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="perfil_cli.php">
                    <input type="hidden" name="recebeid" value="<?php echo $cliid;?>">
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
                    <input type="hidden" name="recebeid" value="<?php echo $cliid;?>">
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