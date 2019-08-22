<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $cpf = $_POST['tCpf'];
    $cep = isset($_POST['tCep'])?$_POST['tCep']:'';
    $logra = $_POST['tLogra'];
    $num = $_POST['tNum'];
    $comp = $_POST['tComp'];
    $bairro = $_POST['tBai'];
    $cid = $_POST['tCid'];
    $uf = $_POST['tUF'];
    
    // CRIA COMANDO SQL
    $sql = "UPDATE clientes set cep='{$cep}'  , logradouro='{$logra}', numerolog='{$num}' , complemento='{$comp}' , bairro='{$bairro}', cidade='{$cid}' , estado='{$uf}' WHERE id='{$id}' limit 1";
                   
    
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);
    
    if ($q) {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="com_perfil.php">
                    <input type="hidden" name="cpfcli" value="<?php echo $cpf;?>">
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
                <form method="post" name="salva" id="salva" action="com_perfil.php">
                    <input type="hidden" name="cpfcli" value="<?php echo $cpf;?>">
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