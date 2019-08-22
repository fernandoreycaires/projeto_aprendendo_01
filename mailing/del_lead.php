<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    
                $lead_id     =$_POST['tIDLead'];
                
                // CRIA COMANDO SQL
                $lead_cont = "DELETE FROM lead_contato WHERE id_lead = '".$lead_id."'";
                $del_lead_cont = $cx->query ($lead_cont);
                
                    if ($del_lead_cont){
                        //SE OS LEADS DA TABELA LEAD_CONTATO FOREM APAGADOS COM SUCESSO, EXECUTARÁ O COMANDO ABAIXO
                        $lead_ret = "DELETE FROM lead_retornar WHERE id_lead = '".$lead_id."'";
                        $del_lead_ret = $cx->query ($lead_ret);
                        
                        if ($del_lead_ret){
                            // CASO AS INFORMAÇÕES DE LEAD FOREM EXCLUIDAS DA TABELA LEAD_RETORNAR COM SUCESSO, EXECUTARÁ A EXCLUSÃO DO LEAD COM O COMANDO ABAIXO
                            $sql = "DELETE FROM lead WHERE id_lead = '".$lead_id."' LIMIT 1";
                            $q = $cx->query ($sql);
                        }
                    }
                

                if ($q) {
                    $msg = "LEAD DELETADO COM SUCESSO !";
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