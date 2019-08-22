<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


                $atendimento = $_POST['tatend'];
                $relato = $_POST['trelat'];
                $diagnostico = $_POST['tdiag'];
                $obs = $_POST['obs'];
                $data = $_POST['tdata'];
                $hora = $_POST['thora'];
                $idcli = $_POST['tidcli'];
                $cpfdiag = $_POST['tcpf'];
                $rgdiag = $_POST['trg'];
                $cndiag = $_POST['tcn'];
                $paciente = $_POST['tpac'];
                $profissao = $_POST['tprof'];
                $crmdiag = $_POST['tcrm'];
                $docdiag = $_POST['tdoc'];
                $especdiag = $_POST['tespec'];
                $cnpjdiag = $_POST['tcnpj'];
                $razaodiag = $_POST['trazao'];
                $conveniodiag = isset($_POST['tconv'])?$_POST['tconv']:'';
                $anamnese = $_POST['tanam'];

                // CRIA COMANDO SQL
                $sql = "INSERT INTO his_med (atendimento, id_pac, id_an ,relato , diagnostico, obs, data_h , hora ,cpf, nome_pac, prof, rg, certnasc ,crm , nome_doc , especialidade, cnpj, razao, convenio ) VALUES ('".$atendimento."','".$idcli."','".$anamnese."','".$relato."','".$diagnostico."','".$obs."','".$data."','".$hora."','".$cpfdiag."','".$paciente."','".$profissao."','".$rgdiag."','".$cndiag."','".$crmdiag."','".$docdiag."','".$especdiag."','".$cnpjdiag."','".$razaodiag."','".$conveniodiag."')";
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
