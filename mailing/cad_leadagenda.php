<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
                //dados recebidos de mailing_home
                $lead_id      =$_POST['lead_id'];
                $lead_nome    =$_POST['lead_nome'];
                $lead_cpf     =$_POST['lead_cpf'];
                $lead_cel     =$_POST['lead_cel1'];
                $lead_crm     =$_POST['lead_crm'];
                $lead_dataag  =$_POST['tData'];
                $lead_horaag  =$_POST['tHora'];
                $lead_obs     =$_POST['tObs'];
                
                
                
                //dados para alterar outras tabelas
                $data_atual = date('Y-m-d');
                $hora_atual = date('H:i:s');
                
                
                //--- ESTE BLOCO ADICIONA O TEMPO MÉDIO DA CONSULTA AO HORARIO ESCOLHIDO PARA O AGENDAMENTO
                
                    $tmediasql = "SELECT atend_h, atend_m FROM cnpj WHERE cnpj_c = '".$cnpj."'";
                    $tmedia = $cx->query ($tmediasql);
                        while ($media = $tmedia->fetch()){
                            $media_min = $media['atend_m'];
                            $media_hora = $media['atend_h'];
                        }

                    // SOMAR AO TEMPO DE ATENDIMENTO MÉDIO
                    $soma_min = date('H:i:s', strtotime('+'.$media_min.' minute', strtotime($lead_horaag)));
                    $soma_hora = date('H:i:s', strtotime('+'.$media_hora.' hour', strtotime($soma_min)));
                    
                    //ADICIONA DATA E HORA EM UMA VARIAVEL
                    $inicio = "$lead_dataag $lead_horaag";
                    $fim = "$lead_dataag $soma_hora";
                
                //--- fim doa bloco que adiciona o tempo médio da consulta
                    
                //--- ESTE BLOCO BUSCA DADOS SOBRE O DOUTOR
                
                    $docql = "SELECT nome_u, cor, referencia FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' and crm = '".$lead_crm."'";
                    $doc_envia = $cx->query ($docql);
                        while ($doc = $doc_envia->fetch()){
                            $doc_nome = $doc['nome_u'];
                            $doc_cor = $doc['cor'];
                            $doc_ref = $doc['referencia'];
                        }

                //--- fim do bloco da dados sobre o doutor
                
                
                //--- COMANDO PARA INSERIR AGENDAMENTO
                    $remarcacao = "Não";
                    $lead_compareceu ="N";
                    $sql = "INSERT INTO agenda (id_lead,compareceu,nome,cpf,cel,crm,doutor,cnpj,cor,inicio,fim,referencia,obs,remarcacao) VALUES "
                            . "('".$lead_id."','".$lead_compareceu."','".$lead_nome."','".$lead_cpf."','".$lead_cel."','".$lead_crm."','".$doc_nome."','".$cnpj."','".$doc_cor."','".$inicio."','".$fim."','".$doc_ref."','".$lead_obs."','".$remarcacao."')";
                    $q = $cx->query ($sql);

                    // CRIA COMANDO CASO TIVER QUE RETORNAR LIGAÇÃO
                    if ($q){
                        $obs_contato = "Fez o agendamento | $lead_obs ";
                        $agenda = "S";
                        $retornar = "N";
                        $sql = "INSERT INTO lead_contato (id_lead,cnpj,dia,hora,obs,agendado,retornar) VALUES "
                            . "('".$lead_id."','".$cnpj."','".$data_atual."','".$hora_atual."','".$obs_contato."','".$agenda."','".$retornar."')";
                        $q = $cx->query ($sql);
                    } 
                //--- Fim da inserção na agenda
                
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

                        
 
                                
                                