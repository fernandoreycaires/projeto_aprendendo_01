<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //RECEBE DADOS DE COLAB_LISTA.PHP para editar dados 
        $idcolab = isset($_POST['tID'])?$_POST['tID']:''; 


        $sql = ("DELETE FROM cnpj_user WHERE id_u_cnpj = '".$idcolab."' limit 1; ");
        $envia = $cx->query($sql);
        if ($envia){
            header("location:colab_lista.php");
        }else{
            $msg = "OCORREU UM PROBLEMA, INFORME AO ADMINISTRADOR";
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="colab_lista.php">
                        <input type="hidden" name="erro" value="<?php echo $msg;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
        }

     
    }else{
    header("location:../index.php");
}
?>