<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    
                $lead_id     =$_POST['tIDLead'];
                $nome        =$_POST['tNome'];
                $cel1	     =$_POST['tCel1'];
                $cel2	     =$_POST['tCel2'];
                $tel	     =$_POST['tFixo'];
                $email       =$_POST['tMail'];
                $obs         =$_POST['tObs'];
                
                // CRIA COMANDO SQL
                $sql = "UPDATE lead SET nome = '".$nome."', cel1 = '".$cel1."', cel2 = '".$cel2."', tel = '".$tel."', email = '".$email."', obs = '".$obs."' WHERE id_lead = '".$lead_id."'";
                // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
                $q = $cx->query ($sql);

                if ($q) {
                    $msg = "EDITADO COM SUCESSO !";
                    $status = "alert-success";
                    $cor = "#1f3a1a";
                        ?>
                        <!DOCTYPE html>
                        <html lang="pt-br">
                            
                            <body>
                                <form method="post" name="salvalead" id="salvalead" action="mailing_home.php">
                                    <input type="hidden" name="msg" value="<?php echo $msg;?>" id="salvalead">
                                    <input type="hidden" name="status" value="<?php echo $status;?>" id="salvalead">
                                    <input type="hidden" name="cor" value="<?php echo $cor;?>" id="salvalead">
                                </form>
                            </body>
                            <script type="text/javascript">
                                document.salvalead.submit();
                            </script>
                        </html>
                        <?php
                        
                } else {
                    $msg = "OCORREU UM ERRO AO EDITAR, CONTATE O ADMINISTRADOR !";
                    $status = "alert-danger";
                    $cor = "#3a1a1a";
                        ?>
                        <!DOCTYPE html>
                        <html lang="pt-br">
                            
                            <body>
                                <form method="post" name="salvalead" id="salvalead" action="mailing_home.php">
                                    <input type="hidden" name="msg" value="<?php echo $msg;?>" id="salvalead">
                                    <input type="hidden" name="status" value="<?php echo $status;?>" id="salvalead">
                                    <input type="hidden" name="cor" value="<?php echo $cor;?>" id="salvalead">
                                </form>
                            </body>
                            <script type="text/javascript">
                                document.salvalead.submit();
                            </script>
                        </html>
                        <?php
                }
                
           
}else{
    header("location:../index.php");
}
?>