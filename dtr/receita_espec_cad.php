<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


                $cliid       =$_POST['cliid'];
                $nome        =$_POST['nome'];
                $cpf	     =$_POST['cpf'];
                $rg	     =$_POST['rg'];
                $cn	     =$_POST['cn'];
                $sexo	     =$_POST['sexo'];
                $nasc	     =$_POST['nasc'];
                $respcli     =$_POST['respcli'];
                $conv	     =$_POST['conv'];
                $numconv     =$_POST['carteira'];
                $cep	     =$_POST['cep'];
                $logradouro  =$_POST['logradouro'];
                $numlog      =$_POST['numlog'];
                $bairro      =$_POST['bairro'];
                $cidade      =$_POST['cidade'];
                $estado      =$_POST['estado'];
                $crm	     =$_POST['crm'];
                $crmuf	     =$_POST['crmuf'];
                $doutor	     =$_POST['doutor'];
                $razao	     =$_POST['razao'];
                $data	     =$_POST['data'];
                $hora	     =$_POST['hora'];
                $atendimento =$_POST['atend'];
                $remedio1    =$_POST['remedio1'];
                $tipouso1    =$_POST['tipouso1'];
                $modouso1    =$_POST['modouso1'];
                $obs1	     =$_POST['obsrec1'];
                $remedio2    =$_POST['remedio2'];
                $tipouso2    =$_POST['tipouso2'];
                $modouso2    =$_POST['modouso2'];
                $obs2	     =$_POST['obsrec2']; 
                $remedio3    =$_POST['remedio3']; 
                $tipouso3    =$_POST['tipouso3'];
                $modouso3    =$_POST['modouso3'];
                $obs3	     =$_POST['obsrec3'];
                $remedio4    =$_POST['remedio4'];
                $tipouso4    =$_POST['tipouso4'];
                $modouso4    =$_POST['modouso4'];
                $obs4	     =$_POST['obsrec4'];
                

                // CRIA COMANDO SQL
                $sql = "INSERT INTO receita_especial (nome, id_cli ,cpf,rg,certnasc,sexo, nasc, nome_resp, convenio, carteira, cep, logradouro, numlog, bairro, cidade, estado, crm, estado_crm , doutor, cnpj, razao, data, hora, atendimento, remedio1, tipouso1, modouso1, obs1, remedio2, tipouso2, modouso2, obs2, remedio3, tipouso3, modouso3, obs3, remedio4, tipouso4, modouso4, obs4) VALUES ('".$nome."','".$cliid."','".$cpf."','".$rg."','".$cn."','".$sexo."','".$nasc."','".$respcli."','".$conv."','".$numconv."','".$cep."','".$logradouro."','".$numlog."','".$bairro."','".$cidade."','".$estado."','".$crm."','".$crmuf."','".$doutor."','".$cnpj."','".$razao."','".$data."','".$hora."','".$atendimento."','".$remedio1."','".$tipouso1."','".$modouso1."','".$obs1."','".$remedio2."','".$tipouso2."','".$modouso2."','".$obs2."','".$remedio3."','".$tipouso3."','".$modouso3."','".$obs3."','".$remedio4."','".$tipouso4."','".$modouso4."','".$obs4."')";
                // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
                $q = $cx->query ($sql);

                if ($q) {
                        ?>
                        <!DOCTYPE html>
                        <html lang="pt-br">
                            
                            <body>
                                <form method="post" name="salvadiag" id="salvadiag" action="diagnostico.php">
                                    <input type="hidden" name="atendimento" value="<?php echo $atendimento;?>" id="atendenvia">
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
           
}else{
    header("location:../index.php");
}
?>
