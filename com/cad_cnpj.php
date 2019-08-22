<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//RECEBE VALORES DE COM_CADCNPJ
$cadcnpj = $_POST['tCNPJ'];
$cadrazao = $_POST['tRS'];
$cadfant = $_POST['tFant'];
$caduni = $_POST['tUni'];
$cadtel1 = $_POST['Tel1'];
$cadtel2 = $_POST['Tel2'];
$cadtel3 = $_POST['Tel3'];
$cadmail = $_POST['tMail'];
$cadweb = $_POST['tWeb'];

//VERIFICA NO BANCO SE CNPJ JÁ EXISTE
$cadclisql = "select cnpj_c from cnpj WHERE cnpj_c = '".$cadcnpj."'";
$clienviasql = $cx->query ($cadclisql);
while ($checarcpf = $clienviasql->fetch()){
    $checar = $checarcpf['cnpj_c'];
 } 
 
if ($checar == $cadcnpj){
   $checado = 'CNPJ JÁ CADASTRADO';
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_cadcnpj.php">
                        <input type="hidden" name="tBusca" value="<?php echo $cadcnpj;?>">
                        <input type="hidden" name="msg" value="<?php echo $checado;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
   
}else{
    // CRIA COMANDO SQL
    $sql = "INSERT INTO cnpj (razao_c ,nfantasia_c , cnpj_c , unidade ,tel1_c , tel2_c , tel3_c , email_c , site_c ) VALUES ('{$cadrazao}' , '{$cadfant}' , '{$cadcnpj}' ,'{$caduni}' ,'{$cadtel1}' ,  '{$cadtel2}' , '{$cadtel3}' , '{$cadmail}' ,'{$cadweb}')";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpj.php">
                        <input type="hidden" name="cnpjcli" value="<?php echo $cadcnpj;?>">
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
    }

    
}else{
    header("location:index.php");
}
?>