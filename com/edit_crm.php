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
    $tipo = $_POST['tTipo'];
    $crm = $_POST['tCrm'];
    $crmuf = $_POST['tCRMUF'];
    $crmarea = $_POST['tArea'];
    
    
    // CRIA COMANDO SQL
    $sql = "UPDATE clientes set crm='{$crm}' , estado_crm='{$crmuf}' , area_m='{$crmarea}', tipo_doc='{$tipo}' WHERE id='{$id}' limit 1";
                   
    
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);
    
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