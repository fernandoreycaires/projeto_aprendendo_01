<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];
 
 $cnpjuserid = $_POST['tID'];
 $cnpjcli = $_POST['tCNPJ'];

    // CRIA COMANDO SQL
    $sql = "DELETE FROM cnpj_user WHERE id_u_cnpj = '".$cnpjuserid."' AND cnpj_vinc = '".$cnpjcli."' ";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpjuser.php">
                        <input type="hidden" name="cnpjcli" value="<?php echo $cnpjcli;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
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