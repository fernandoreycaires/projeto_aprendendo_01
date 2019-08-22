<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

                $atend       =$_POST['atendimento'];
                $idcli       =$_POST['idpac'];
                $nome        =$_POST['nome'];
                $cpf	     =$_POST['cpfpac'];
                $rg	     =$_POST['rgpac'];
                $cn	     =$_POST['cnpac'];
                $data_atual  =$_POST['data_atual'];
                $hora_atual  =$_POST['hora_atual'];
                $data_ini    =$_POST['data_ini'];
                $hora_ini    =$_POST['hora_ini'];
                $tipo	     =$_POST['tipodoc'];
                $crm	     =$_POST['crm'];
                $doutor	     =$_POST['doutor'];
                $razao	     =$_POST['razao'];
                $atestado    =$_POST['atestado'];
                $dias	     =$_POST['dias'];
                
                
                // CRIA COMANDO SQL
                $sql = "INSERT INTO atestados (atendimento, nome_pac , id_cli , cpf_pac, rg_pac , certnasc ,dias_afastado, atestado, data_atual, hora_atual ,data_ini ,hora_ini, tipo_doc ,crm ,nome_doc, cnpj, razao) VALUES ('".$atend."','".$nome."','".$idcli."','".$cpf."','".$rg."','".$cn."','".$dias."','".$atestado."','".$data_atual."','".$hora_atual."','".$data_ini."','".$hora_ini."','".$tipo."','".$crm."','".$doutor."','".$cnpj."','".$razao."')";
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