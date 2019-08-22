<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //RECEBE DADOS DE COLAB_LISTA.PHP para editar dados 
        $idcolab = isset($_POST['tID'])?$_POST['tID']:''; 
        $cnpjcli = isset($_POST['tCNPJ'])?$_POST['tCNPJ']:''; 

        $edit_usu = isset($_POST['tUsu'])?$_POST['tUsu']:'';
        $edit_pass = isset($_POST['tPass'])?$_POST['tPass']:'';
        $edit_cli = isset($_POST['tCli'])?$_POST['tCli']:'N';
        $edit_dtr = isset($_POST['tDoc'])?$_POST['tDoc']:'N';
        $edit_cal = isset($_POST['tCal'])?$_POST['tCal']:'N';
        $edit_atm = isset($_POST['tAten'])?$_POST['tAten']:'N';
        $edit_con = isset($_POST['tCon'])?$_POST['tCon']:'N';
        $edit_dp = isset($_POST['tDp'])?$_POST['tDp']:'N';
        $edit_adm = isset($_POST['tAdm'])?$_POST['tAdm']:'N';
        $edit_fin = isset($_POST['tFin'])?$_POST['tFin']:'N';
        $edit_come = isset($_POST['tCom'])?$_POST['tCom']:'N';
        $edit_sys = isset($_POST['tSys'])?$_POST['tSys']:'N';
        $edit_cai = isset($_POST['tCai'])?$_POST['tCai']:'N';
        $edit_mai = isset($_POST['tMai'])?$_POST['tMai']:'N';

        $sql = ("UPDATE cnpj_user SET usuario = '".$edit_usu."', pass = '".$edit_pass."', cli = '".$edit_cli."', dtr = '".$edit_dtr ."',cal = '".$edit_cal ."',con = '".$edit_con."',dp = '".$edit_dp."',adm = '".$edit_adm."',fin = '".$edit_fin."',com = '".$edit_come."',sys = '".$edit_sys."' ,atend = '".$edit_atm."' ,caixa = '".$edit_cai."' ,mai = '".$edit_mai."' WHERE id_u_cnpj = '".$idcolab."' limit 1; ");
        $envia = $cx->query($sql);
        if ($envia){
            $msg = "EDITADO COM SUCESSO !";
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpjuser.php">
                        <input type="hidden" name="erro" value="<?php echo $msg;?>">
                        <input type="hidden" name="cnpjcli" value="<?php echo $cnpjcli;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
        }else{
            $msg = "OCORREU UM PROBLEMA, INFORME AO ADMINISTRADOR";
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpjuser.php">
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
