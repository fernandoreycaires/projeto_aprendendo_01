<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

    $cadID = $_POST['tID'];
    $cadcpf = $_POST['tCpf'];
    $cadparent = isset($_POST['tPar'])?$_POST['tPar']:"";
    $cadnome = $_POST['tNome'];
    $cadnasc = $_POST['tNasc'];
    $cadsexo = $_POST['tSex'];
    $cadconv= isset($_POST['tConv'])?$_POST['tConv']:"";
    $cadcarteira = isset($_POST['tCart'])?$_POST['tCart']:"";
    $cadrg = isset($_POST['tRG'])?$_POST['tRG']:"";
    $cadcertnasc = isset($_POST['tCN'])?$_POST['tCN']:"";

    // CRIA COMANDO SQL
    $sql = "UPDATE dependentes SET nome_dep = '".$cadnome."', sexo_dep = '".$cadsexo."', data_nasc ='".$cadnasc."', parentesco='".$cadparent."' , convenio='".$cadconv."', carteira= '".$cadcarteira."', rg='".$cadrg."' , certnasc ='".$cadcertnasc."' WHERE id_dep = '".$cadID."' limit 1";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="perfil_cli.php">
                        <input type="hidden" name="cpfcli" value="<?php echo $cadcpf;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
        } else {
            $msg = 'OCORREU UM ERRO AO EDITAR ESSE DEPENDENTE ! ';
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="perfil_cli.php">
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
    header("location:index.php");
}
?>