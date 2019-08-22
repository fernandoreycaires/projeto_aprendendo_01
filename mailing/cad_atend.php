<?php
    session_start();
    include '../_php/cx.php';
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        $cnpj = $_SESSION['cnpj_session'];
        $user = $_SESSION['user_session'];
        $pass = $_SESSION['pass_session'];

        

        //RECEBE DADOS DO AGENDAMENTO PARA FAZER A ABERTURA DO ATENDIMENTO 
        $id_cal = $_POST['id_cal'];
        $id_lead = $_POST['id_lead'];
        $atend_nome = isset($_POST['tNome'])?$_POST['tNome']:'';
        $atend_cpf = isset($_POST['tCpf'])?$_POST['tCpf']:'';
        $atend_rg = isset($_POST['tRG'])?$_POST['tRG']:'';
        $atend_cn = isset($_POST['tCN'])?$_POST['tCN']:'';
        $atend_cel = isset($_POST['tCel'])?$_POST['tCel']:'';
        $atend_ret = isset($_POST['tRet'])?$_POST['tRet']:'';
        $atend_doc = isset($_POST['tDoc'])?$_POST['tDoc']:'';
        $atend_crm = isset($_POST['tCrm'])?$_POST['tCrm']:'';
        $atend_obs = isset($_POST['tObs'])?$_POST['tObs']:'';
        $atend_ini_data = date('Y-m-d');
        $atend_ini_hora = date('H:i:s');
        
        //VALIDA SE TEM PELO MENOS UM CAMPO DE DOCUMENTO PREENCHIDO
        if($atend_cpf == "" and $atend_rg == "" and $atend_cn == ""){
            $checado = 'NECESSÁRIO INSERIR AO MENOS UM DOS DOCUMENTOS (CPF, RG OU CERTIDÃO DE NASCIMENTO)';
            $status = "alert-danger";
            $cor = "#3a1a1a";
            ?>
                <!DOCTYPE html>
                <html lang="pt-br">
                    <body>
                        <form method="post" name="salvacli" id="salvacli" action="mailing_agenda.php">
                            <input type="hidden" name="erro" value="<?php echo $checado;?>">
                            <input type="hidden" name="status" value="<?php echo $status;?>">
                            <input type="hidden" name="cor" value="<?php echo $cor;?>">
                        </form>
                    </body>
                    <script type="text/javascript">
                        document.salvacli.submit();
                    </script>
                </html>
            <?php
        }
        
        //VERIFICA A EXISTENCIA DO PACIENTE NO CADASTRO DE CLIENTES
        $paciente_sql = "SELECT id, nome, cel1, convenio_empresa FROM clientes WHERE cpf != '' AND cpf = '".$atend_cpf."' OR rg != '' AND rg = '".$atend_rg."' OR certnasc != '' AND certnasc = '".$atend_cn."'";
        $pac_query = $cx->query ($paciente_sql);

        while ($pac = $pac_query->fetch()){
            $pac_id = $pac['id'];
            $pac_nome = $pac['nome'];
            $pac_cel = $pac['cel1'];
            $pac_conv = $pac['convenio_empresa'];
        }
        
        if ($pac_nome != ""){
            $atend_nome = $pac_nome;
            $atend_cel = $pac_cel;
            $atend_conv = $pac_conv;
        } 
        
        //VERIFICA SE O LEAD JÁ TEM ALGUM CPF OU DOCUMENTO VINCULADO
        $cpflead = "SELECT cpf, rg, cn FROM lead WHERE id_lead = '".$id_lead."'";
        $leaddoc_query = $cx->query ($cpflead);
        while ($lead_doc = $leaddoc_query->fetch()){
            $lead_cpf = $lead_doc['cpf'];
            $lead_rg = $lead_doc['rg'];
            $lead_cn = $lead_doc['cn'];
        }
                //INSERE DOCUMENTOS PARA VINCULAR O LEAD COM UM CONTATO
                    //CPF
                    if($lead_cpf == ""){    
                        if ($atend_cpf != ""){
                            $leadcpfsql = "UPDATE lead SET cpf = '".$atend_cpf."' WHERE id_lead = '".$id_lead."'";
                            $leadcpf_query = $cx->query ($leadcpfsql);
                            }
                    }
                    //RG
                    if($lead_rg == ""){
                        if ($atend_rg != ""){
                            $leadrgsql = "UPDATE lead SET rg = '".$atend_rg."' WHERE id_lead = '".$id_lead."'";
                            $leadrg_query = $cx->query ($leadrgsql);
                            }
                    }
                    //CN
                    if($lead_cn == ""){
                        if ($atend_cn != ""){
                            $leadcnsql = "UPDATE lead SET cn = '".$atend_cn."' WHERE id_lead = '".$id_lead."'";
                            $leadcn_query = $cx->query ($leadcnsql);
                            }
                    }
        
        
        //CONFIRMAÇÃO PARA O MESMO CPF NÃO TER DOIS ATENDIMENTOS ABERTO COM O MESMO DOUTOR
        $agendamento = "SELECT * FROM atendimento WHERE cpf !='' and cpf = '".$atend_cpf."' and crm = '".$atend_crm."'and cnpj = '".$cnpj."' OR rg !='' and rg = '".$atend_rg."' and crm = '".$atend_crm."'and cnpj = '".$cnpj."' OR certnasc !='' and certnasc = '".$atend_cn."' and crm = '".$atend_crm."'and cnpj = '".$cnpj."'";
        $queryagend = $cx->query ($agendamento);

        while ($atend = $queryagend->fetch()){
            $confirm_cpf= $atend['cpf'];
            $confirm_crm= $atend['crm'];
            $confirm_doc= $atend['doutor'];
            $confirm_ini= $atend['ini_data'];
            $confirm_id = $atend['id_atend'];
        }
        if ($confirm_ini != "$atend_ini_data" or $confirm_ini == ""){
                
            if($atend_cpf!=""){
                $documento = "cpf";
                $documentovar = $atend_cpf;
            } else if ($atend_rg!=""){
                $documento = "rg";
                $documentovar = $atend_rg;
            } else if ($atend_cn!=""){
                $documento = "certnasc";
                $documentovar = $atend_cn;
            }
                
            //PREPARANDO COMANDO SQL PARA SER ENVIADO PARA TABELA ATENDIMENTO
                $sql_cad = "INSERT INTO atendimento (nome , id_pac, id_lead ,".$documento." , cel, convenio , crm , doutor , cnpj , retorno , ini_data, ini_hora, obs) values ('{$atend_nome}' , '{$pac_id}', '{$id_lead}' ,'{$documentovar}' , '{$atend_cel}', '{$atend_conv}' ,'{$atend_crm}' , '{$atend_doc}' , '{$cnpj}' , '{$atend_ret}' , '{$atend_ini_data}', '{$atend_ini_hora}', '{$atend_obs}')";
                $query_cad = $cx->query ($sql_cad);

                if ($query_cad) {
                    //ESSE COMANDO ATUALIZA O CAMPO "COMPARECEU" DA TABELA AGENDA, CASO O INSERT ACIMA DÊ CERTO
                    $upcal = "UPDATE agenda SET compareceu = 'S' WHERE id_data = '".$id_cal."'";
                    $compareceu = $cx->query ($upcal);
                    
                    //ESSE COMANDO INSERE INFORMAÇÃO NA TABELA LEAD_CONTATO PARA REGISTRAR QUE PACIENTE FOI AO CONSULTÓRIO E ABRIU UM ATENDIMENTO
                    $lead_contato = "INSERT INTO lead_contato (id_lead, cnpj, dia, hora, obs,agendado, retornar) VALUES ('".$id_lead."','".$cnpj."','".$atend_ini_data."','".$atend_ini_hora."','Abriu ficha de atendimento','S','N')";
                    $exec_sql_lead_contato = $cx->query ($lead_contato);
                    
                    //ALIMENTA VARIAVEIS DE RETORNO
                    $checado = 'ATENDIMENTO ABERTO COM SUCESSO !';
                    $status = "alert-success";
                    $cor = "#1f3a1a";
                    ?>
                        <!DOCTYPE html>
                        <html lang="pt-br">
                            <body>
                                <form method="post" name="salvacli" id="salvacli" action="mailing_agenda.php">
                                    <input type="hidden" name="erro" value="<?php echo $checado;?>">
                                    <input type="hidden" name="status" value="<?php echo $status;?>">
                                    <input type="hidden" name="cor" value="<?php echo $cor;?>">
                                </form>
                            </body>
                            <script type="text/javascript">
                                document.salvacli.submit();
                            </script>
                        </html>
                    <?php
                    
                } else {
                $msg_cad = "OCORREU UM ERRO AO ABRIR O ATENDIMENTO ! ";
                }
        }else{
            $confirma = "ATENDIMENTO DESTE PACIENTE JÁ ABERTO COM O DOUTOR(a)  ";
        }
    
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
            <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>ADM Consultório</title>
                    <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                    <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
                    <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
                    <link href='../_css/bootstrap.min.css' rel='stylesheet'>
            </head>
            <body>
                    <div class="container-fluid theme-showcase estilo" role="main">
                        
                            <div class="page-header">
                                    <h1 align="center">Abertura da Ficha de Atendimento</h1>
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                            <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4"><p>Numero do Atendimento:<span class="banco"> <?php echo $confirm_id; ?></span></p>
                                                                <p><?php echo $confirma;?> <span class="banco">&nbsp; <?php echo $confirm_doc; ?></span></p></th>
                                                        </tr>
                                                    </thead>
                                                    
                                            </table>
                                        <p align='center'><a href="mailing_agenda.php" class="btn btn-sm btn-success">Entendi</a></p>
                                    </div>
                            </div>
                        <br>
                        <footer id="rodape">
                            <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                            <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                        </footer>
                    </div>


      </body>
    </html>
    <?php
    }else{
        header("location:../index.php");
    }
?>