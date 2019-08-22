<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    $atend = $_POST['atendimento'];
    $especid = $_POST['id_espec'];
    $data_atual = $_POST['data_atual'];
    $hora_atual = $_POST['hora_atual'];
    $especialidade = $_POST['especialidade'];
    
                // CRIA COMANDO SQL
                $sql = "UPDATE enc_espec SET data_atual = '".$data_atual."', hora_atual = '".$hora_atual."', especialidade = '".$especialidade."' WHERE atendimento = '".$atend."' and id_enc = '".$especid."'";
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
          
}else{
    header("location:../index.php");
}
?>