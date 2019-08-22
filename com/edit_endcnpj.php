<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $cep = isset($_POST['tCep'])?$_POST['tCep']:'';
    $logra = $_POST['tLogra'];
    $num = $_POST['tNum'];
    $comp = $_POST['tComp'];
    $bairro = $_POST['tBai'];
    $cid = $_POST['tCid'];
    $uf = $_POST['tUF'];
    
    // CRIA COMANDO SQL
    $sql = "UPDATE cnpj SET cep_c ='{$cep}'  , logradouro_c ='{$logra}', numerolog_c ='{$num}' , complemento_c ='{$comp}' , bairro_c ='{$bairro}', cidade_c ='{$cid}' , estado_c ='{$uf}' WHERE id_c ='{$id}' limit 1";
                   
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);
    
    if ($q) {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="com_perfilcnpj.php">
                    <input type="hidden" name="idcnpj" value="<?php echo $id;?>">
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
                <form method="post" name="salva" id="salva" action="com_perfilcnpj.php">
                    <input type="hidden" name="idcnpj" value="<?php echo $id;?>">
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