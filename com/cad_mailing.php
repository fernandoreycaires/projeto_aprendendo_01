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
$cadarea = $_POST['tAM'];
$caduni = $_POST['tUni'];
$cadcont = $_POST['tCont'];
$cadcpf = $_POST['tCPF'];
$cadcrm = $_POST['tCRM'];
$cadtel1 = $_POST['Tel1'];
$cadtel2 = $_POST['Tel2'];
$cadtel3 = $_POST['Tel3'];
$cadmail = $_POST['tMail'];
$cadweb = $_POST['tWeb'];
$data_atual = date('Y-m-d');


    // CRIA COMANDO SQL
    $sql = "INSERT INTO mailing (razao ,nfan , cnpj , unidade, inserido, nome, cpf, crm, area_m ,tel1 , tel2 , tel3 , email , web ) VALUES "
            . "('{$cadrazao}' , '{$cadfant}' , '{$cadcnpj}' ,'{$caduni}' ,'{$data_atual}','{$cadcont}','{$cadcpf}','{$cadcrm}','{$cadarea}','{$cadtel1}' ,  '{$cadtel2}' , '{$cadtel3}' , '{$cadmail}' ,'{$cadweb}')";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
        $msg = 'CONTATO CADASTRADO COM SUCESSO !';
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="mailing_busca.php">
                        <input type="hidden" name="msg" value="<?php echo $msg;?>">
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