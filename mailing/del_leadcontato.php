<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    
                $lead_id_CONT     =$_POST['tIDLead'];
                
                // CRIA COMANDO SQL
                $lead_cont = "DELETE FROM lead_contato WHERE id_lead_C = '".$lead_id_CONT."'";
                $del_lead_cont = $cx->query ($lead_cont);
                
                if ($del_lead_cont) {
                    $msg = "INFORMAÇÃO DELETADA COM SUCESSO !";
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
                    $msg = "OCORREU UM ERRO AO DELETAR O LEAD, CONTATE O ADMINISTRADOR !";
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