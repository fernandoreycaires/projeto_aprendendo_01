<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

    $msg = '';
    /** @var string $_POST */
    $novasenha = $_POST['newpassw'];
    
    $cmdsql = "UPDATE cnpj_user SET pass = '".$novasenha."' WHERE id_u_cnpj = '".$id."' LIMIT 1";
    $alterabanco = $cx->query ($cmdsql);
        if ($alterabanco) {
            $msg = "SENHA ALTERADA COM SUCESSO, ENTRE NOVAMENTE NO SISTEMA, UTILIZANDO SUA NOVA SENHA";
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvapss" id="salvapss" action="alterarsenhausuario.php">
                        <input type="hidden" name="msg" value="<?php echo $msg;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvapss.submit();
                </script>
            </html>
            <?php
    } else {
        $msg = "OCORREU UM ERRO AO ALTERAR A SENHA ! ";
        ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvapss" id="salvapss" action="alterarsenhausuario.php">
                        <input type="hidden" name="msg" value="<?php echo $msg;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvapss.submit();
                </script>
            </html>
            <?php
    }

}else{
    header("location:../index.php");
}
