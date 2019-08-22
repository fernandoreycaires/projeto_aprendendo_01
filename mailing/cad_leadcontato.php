<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];

                $lead_id      =$_POST['lead_id'];
                $lead_obs     =$_POST['tObs'];
                $lead_ret     =$_POST['tRet'];
                $lead_dataret =$_POST['data_ret'];
                $lead_horaret =$_POST['hora_ret'];
                $email        =$_POST['tMail'];
                $interesse    =$_POST['tInter'];
                $data_atual = date('Y-m-d');
                $hora_atual = date('H:i:s');
                $agenda = "N";
                
                if ($interesse != ""){
                    // CRIA COMANDO SQL PARA INSERIR CADASTRO DE CONTATO DE LEAD
                    $intersql = "UPDATE lead SET interesse = '".$interesse."' WHERE id_lead = '".$lead_id."'";
                    $insere_inter = $cx->query ($intersql);
                    }
                
                // CRIA COMANDO SQL PARA INSERIR CADASTRO DE CONTATO DE LEAD
                $sql = "INSERT INTO lead_contato (id_lead,cnpj,dia,hora,obs,agendado,retornar) VALUES "
                        . "('".$lead_id."','".$cnpj."','".$data_atual."','".$hora_atual."','".$lead_obs."','".$agenda."','".$lead_ret."')";
                $q = $cx->query ($sql);
                
                // CRIA COMANDO CASO TIVER QUE RETORNAR LIGAÇÃO
                if ($lead_ret == "S"){
                    $sql = "INSERT INTO lead_retornar (id_lead,cnpj,dia,hora) VALUES "
                        . "('".$lead_id."','".$cnpj."','".$lead_dataret."','".$lead_horaret."')";
                    $q = $cx->query ($sql);
                } 
                
                if ($q) {
                    $msg = "CADASTRADO COM SUCESSO !";
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
                    $msg = "OCORREU UM ERRO AO CADASTRAR !";
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