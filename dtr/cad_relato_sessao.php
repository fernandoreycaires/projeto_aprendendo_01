<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']) {

$atend = isset($_POST['atendimento']) ? $_POST['atendimento'] : 'Atendimento não informado';
$id_pac = $_POST['id_pac'];
$id_an = $_POST['id_anam'];
$cnpj = $_POST['cnpj'];
$doutor = $_POST['doutor'];
$tipo_doc = $_POST['tipo_doc'];
$doc = $_POST['doc'];
$data_sessao = date('Y-m-d');
$relato = $_POST['relato'];       
       

// CRIA COMANDO SQL
    $sql = "INSERT INTO relato_sessao (id_pac, id_an, cnpj, doutor, tipo_doc, doc, data_sessao, relato) VALUES ('".$id_pac."','".$id_an."','".$cnpj."','".$doutor."','".$tipo_doc."','".$doc."','".$data_sessao."','".$relato."')";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvadiag" id="salvadiag" action="diagnostico.php">
                        <input type="hidden" name="atendimento" value="<?php echo $atend;?>" >
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvadiag.submit();
                </script>
            </html>
            <?php

    } else {
        $message = 'OCORREU UM ERRO AO EFETUAR O CADASTRO ! ';
    }
    echo "<h1> $message </h1>";

} else {
    header("location:../index.php");
}
?>
