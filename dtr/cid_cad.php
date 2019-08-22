<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']) {

$atend = isset($_POST['atendimento']) ? $_POST['atendimento'] : 'Atendimento não informado';
$cidsubcat = isset($_POST['cidsubcat']) ? $_POST['cidsubcat'] : 'Atendimento não informado';
$ciddesc = isset($_POST['ciddesc']) ? $_POST['ciddesc'] : 'Atendimento não informado';
$ciddiv = isset($_POST['CIDdiv']) ? $_POST['CIDdiv'] : 'não informado';

// CRIA COMANDO SQL
                $sql = "UPDATE his_med SET ciddiv = '".$ciddiv."', cidcod = '".$cidsubcat."', ciddesc = '".$ciddesc."' WHERE atendimento = '".$atend."'";
                // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
                $q = $cx->query ($sql);

                if ($q) {
                        ?>
                        <!DOCTYPE html>
                        <html lang="pt-br">
                            <body>
                                <form method="post" name="salvadiag" id="salvadiag" action="diagnostico.php">
                                    <input type="hidden" name="atendimento" value="<?php echo $atend;?>" id="atendenvia">
                                </form>
                            </body>
                            <script type="text/javascript">
                                document.salvadiag.submit()
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
