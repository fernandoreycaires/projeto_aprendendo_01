<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    $atend = $_POST['atendimento'];
    $id_pac = $_POST['idpac'];
    $nome_pac = $_POST['nomepac'];
    $cpf_pac = $_POST['cpfpac'];
    $rg_pac = $_POST['rgpac'];
    $cn_pac = $_POST['cnpac'];
    $sexo_pac = $_POST['sexopac'];
    $data_nasc = $_POST['nascpac'];
    $convenio = $_POST['convenio'];
    $carteira = $_POST['carteira'];
    $respnome = $_POST['resp_nome'];
    $data_atual = $_POST['data_atual'];
    $hora_atual = $_POST['hora_atual'];
    $tipodoc = $_POST['tipodoc'];
    $crm = $_POST['doutorcrm'];
    $nome_doc = $_POST['doutor'];
    $especialidade = $_POST['especialidade'];
    $razao = $_POST['razao'];


                // CRIA COMANDO SQL
                $sql = "INSERT INTO enc_espec (atendimento, nome_pac,id_cli ,cpf_pac, rg_pac, certnasc ,sexo_pac, data_nasc, prontuario, convenio, carteira, respnome, data_atual, hora_atual, tipo_doc ,crm, nome_doc, especialidade, cnpj, razao) VALUES ('".$atend."','".$nome_pac."','".$id_pac."','".$cpf_pac."','".$rg_pac."','".$cn_pac."','".$sexo_pac."','".$data_nasc."','".$id_pac."','".$convenio."','".$carteira."','".$respnome."','".$data_atual."','".$hora_atual."','".$tipodoc."','".$crm."','".$nome_doc."','".$especialidade."','".$cnpj."','".$razao."')";
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