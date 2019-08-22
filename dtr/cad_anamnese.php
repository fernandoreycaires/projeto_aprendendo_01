<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];

            $atend = $_POST['tAtend'];
            $cpf = $_POST['tCliCpf'];
            $rg = $_POST['tCliRg'];
            $certnasc = $_POST['tCliCn'];
            
            //DADOS BASICOS

            $id_pac = $_POST['tCliId'];
            $doutor = $_POST['tDoutNome'];
            $tipo_doc = $_POST['tTipoDoc'];
            $doc = $_POST['tDocNum'];
            $dia = date('Y-m-d');
            $hora = date('H:i');
            $religiao = $_POST['tRel']; 
            $num_filho = $_POST['tNumF'];
            $num_irmaos = $_POST['tNumI'];
            $med_enc = $_POST['tME'];
            $prof_enc = $_POST['tPE'];
            $prob_drog_alc = $_POST['tPAD'];
            $prob_drog_alc_pq = $_POST['tPADs'];
            $fuma = $_POST['tFuma'];
            $sono = $_POST['tSono'];
            $como_soube = $_POST['tCNC'];

            //DADOS DOS PAIS

            $pai_nome = $_POST['tNP'];
            $pai_idade = $_POST['tIP'];
            $pai_prof = $_POST['tPProf'];
            $pai_instrucao = $_POST['tPInst'];
            $mae_nome = $_POST['tNM'];
            $mae_idade = $_POST['tIM'];
            $mae_prof = $_POST['tMProf'];
            $mae_instrucao = $_POST['tMInst'];

            //QUEIXA

            $qp = $_POST['tQP'];
            $qp_ini_q = $_POST['tIQ'];
            $qp_sub_prog = $_POST['tSP'];
            $qp_mud_afet = $_POST['tQMO'];
            $qp_sint = $_POST['tSint'];
            $qs = $_POST['tQS'];

            // HISTORIA CLINICA

            $dc = $_POST['tDCron'];
            $usa_med = $_POST['tMedi'];
            $usa_med_quais = $_POST['tQMed'];
            $prob_card = $_POST['PCard'];
            $prob_card_qual = $_POST['tPCardTipo'];
            $diab = $_POST['tDiab'];
            $diab_tipo = $_POST['tDiabTipo'];
            $epilep = $_POST['Epile'];
            $epilep_quando = $_POST['tEpiQuan'];
            $inter = $_POST['tIntern'];
            $enfr = $_POST['tEnfrent'];
            $sint_fis_psi = $_POST['tSintom'];
            $pffnp = $_POST['tPFFNP'];
            $hab_ali = $_POST['tHabAl'];
            $cond_nasc = $_POST['tCondNasc'];
            $desenv_neuro = $_POST['tDesenvNeuro'];
            $doen_inf = $_POST['tDoenInf'];
            $casos = $_POST['tConvEpil'];

            // HISTORIA FAMILIAR

            $comp_fam = $_POST['tCFgeno'];
            $din_fam = $_POST['tDinFam'];
            $event_sig = $_POST['tESig'];
            $rede_apo = $_POST['tRApoio'];

            // HISTORIA SOCIAL

            $info_social = $_POST['tHistSoc'];
            $caso_rep = $_POST['tCReprov'];
            $area_dific = $_POST['tADifi'];
            $hab_est = $_POST['tHabEstu'];

            // HIPNOTERAPIA

            $hipnotizado = $_POST['tHip'];                          
            $quem = $_POST['tHipQuem'];
            $motivo = $_POST['tHipMotivo'];
            $acreditou = $_POST['tAcreHip'];
            $hipno_pq = $_POST['tAcredhipnoPq'];
            $mot_busc_hip = $_POST['tHipBuscPq'];

            // CONSIDERAÇÕES FINAIS

            $cons_final = $_POST['tConsFinal'];
            $sug_enc = $_POST['tSugestEnc'];
                


                // INSERE DADOS INICIAIS DA TABELA ANAMNESE, CASO ESTE COMANDO FUNCIONE CORRETAMENTE, ELE INSERE DADOS NAS OUTRA TABELAS E RESERVA O ID DA ANAMNESE PARA ISERIR NAS OUTRAS TABELAS
                $sql_dados_ini = "INSERT INTO anamnese (id_pac, doutor, tipo_doc, doc, cnpj , dia, hora, religiao, num_filho , num_irmaos , med_enc, prof_enc, prob_drog_alc, prob_drog_alc_pq, fuma, sono, como_soube ) VALUES "
                        . "('".$id_pac."','".$doutor."' ,'".$tipo_doc."','".$doc."','".$cnpj."','".$dia."','".$hora."','".$religiao."','".$num_filho."','".$num_irmaos."','".$med_enc."','".$prof_enc."','".$prob_drog_alc."','".$prob_drog_alc_pq."','".$fuma."','".$sono."','".$como_soube."')";
                $envia_dados_ini = $cx->query ($sql_dados_ini);

                if ($envia_dados_ini) {
                    //ESTE COMANDO RESERVA O ID DA ANAMNESE PARA INSERIR NAS DEMAIS TABELAS
                    $busca_anam = "SELECT id_an FROM anamnese WHERE id_pac = '".$id_pac."' AND cnpj = '".$cnpj."' AND tipo_doc = '".$tipo_doc."' AND doc = '".$doc."' ORDER BY id_an DESC LIMIT 1 ";
                    $envia_busca_anam = $cx->query ($busca_anam);
                    while ($anamnese = $envia_busca_anam->fetch()){
                        $anam_id = $anamnese['id_an'];
                    }
                    
                    //VERIFICA SE TEM DADOS DOS PAIS PARA INBSERIR, CASO HOUVER IRÁ EXECUTAR O COMANDO PARA INSERIR
                    if ($pai_nome != '' and $mae_nome != ''){
                        $sql_dados_pais = "INSERT INTO anamnese_dad_p (id_an, pai_nome, pai_idade, pai_prof, pai_instrucao, mae_nome, mae_idade, mae_prof, mae_instrucao ) VALUES "
                        . "('".$anam_id."','".$pai_nome."' ,'".$pai_idade."','".$pai_prof."','".$pai_instrucao."','".$mae_nome."','".$mae_idade."','".$mae_prof."','".$mae_instrucao."')";
                        $envia_dados_pais = $cx->query ($sql_dados_pais);
                    }

                    //VERIFICA SE HṔA QUEIXA PARA INSERIR, CASO HOUVER, SERÁ INSERIDO
                    if ($qp != ''){
                        $sql_qp = "INSERT INTO anamnese_quei (id_an, qp, qp_ini_q, qp_sub_prog, qp_mud_afet, qp_sint, qs ) VALUES "
                        . "('".$anam_id."','".$qp."' ,'".$qp_ini_q."','".$qp_sub_prog."','".$qp_mud_afet."','".$qp_sint."','".$qs."')";
                        $envia_qp = $cx->query ($sql_qp);
                    }

                    //VERIFICA SE HÀ DADOS PARA INSERIR EM HISTÓRIA CLINICA, CASO HOUVER SERÁ INSERIDO
                    $verificar_dados_hist_clin = $dc.$usa_med_quais.$prob_card_qual.$diab_tipo.$epilep_quando.$inter.$cond_nasc.$desenv_neuro.$doen_inf.$casos;
                    if ($verificar_dados_hist_clin != ''){
                        $sql_hist_clin = "INSERT INTO anamnese_hist_clin (id_an, dc, usa_med, usa_med_quais, prob_card , prob_card_qual, diab, diab_tipo, epilep , epilep_quando , inter, enfr, sint_fis_psi, pffnp, hab_ali, cond_nasc, desenv_neuro, doen_inf, casos ) VALUES "
                        . "('".$anam_id."','".$dc."' ,'".$usa_med."','".$usa_med_quais."','".$prob_card."','".$prob_card_qual."','".$diab."','".$diab_tipo."','".$epilep."','".$epilep_quando."','".$inter."','".$enfr."','".$sint_fis_psi."','".$pffnp."','".$hab_ali."','".$cond_nasc."','".$desenv_neuro."','".$doen_inf."','".$casos."')";
                        $envia_hist_clin = $cx->query ($sql_hist_clin);
                    }
                        
                    //VERIFICA SE HÀ DADOS PARA INSERIR EM HISTÓRIA FAMILIAR, CASO HOUVER SERÁ INSERIDO
                    $verificar_dados_hist_fam = $comp_fam.$din_fam.$event_sig.$rede_apo;
                    if ($verificar_dados_hist_fam != ''){
                        $sql_hist_fam = "INSERT INTO anamnese_hist_fam (id_an, comp_fam, din_fam, event_sig, rede_apo ) VALUES "
                        . "('".$anam_id."','".$comp_fam."' ,'".$din_fam."','".$event_sig."','".$rede_apo."')";
                        $envia_hist_fam = $cx->query ($sql_hist_fam);
                    }
                    
                    //VERIFICA SE HÀ DADOS PARA INSERIR EM HISTÓRIA SOCIAL, CASO HOUVER SERÁ INSERIDO
                    $verificar_dados_hist_soc = $info_social.$caso_rep.$area_dific.$hab_est;
                    if ($verificar_dados_hist_soc != ''){
                        $sql_hist_soc = "INSERT INTO anamnese_hist_soc (id_an, info_social, caso_rep, area_dific, hab_est ) VALUES "
                        . "('".$anam_id."','".$info_social."' ,'".$caso_rep."','".$area_dific."','".$hab_est."')";
                        $envia_hist_soc = $cx->query ($sql_hist_soc);
                    }
                    
                    //VERIFICA SE HÀ DADOS PARA INSERIR EM HIPNOTERAPIA, CASO HOUVER SERÁ INSERIDO
                    $verificar_dados_hipno = $quem.$motivo.$hipno_pq.$mot_busc_hip;
                    if ($verificar_dados_hipno != ''){
                        $sql_hist_hipno = "INSERT INTO anamnese_hip (id_an, hipnotizado, quem, motivo, acreditou, hipno_pq, mot_busc_hip ) VALUES "
                        . "('".$anam_id."','".$hipnotizado."' ,'".$quem."','".$motivo."','".$acreditou."','".$hipno_pq."','".$mot_busc_hip."')";
                        $envia_hist_hipno = $cx->query ($sql_hist_hipno);
                    }
                    
                    //VERIFICA SE HÀ DADOS PARA INSERIR EM CONSIDERAÇÕES FINAIS, CASO HOUVER SERÁ INSERIDO
                    $verificar_consi_final = $cons_final.$sug_enc;
                    if ($verificar_consi_final != ''){
                        $sql_cf= "INSERT INTO anamnese_consi_fin (id_an, cons_final, sug_enc) VALUES "
                        . "('".$anam_id."','".$cons_final."','".$sug_enc."')";
                        $envia_cf = $cx->query ($sql_cf);
                    }
                    
                    ?>
                        <!DOCTYPE html>
                        <html lang="pt-br">
                            
                            <body>
                                <form method="post" name="salvadiag" id="salvadiag" action="diagnostico_ini.php">
                                    <input type="hidden" name="atendimento" value="<?php echo $atend;?>" >
                                    <input type="hidden" name="novo_diag" value="<?php echo $cpf;?>" >
                                    <input type="hidden" name="novo_diagrg" value="<?php echo $rg;?>" >
                                    <input type="hidden" name="novo_diagcn" value="<?php echo $certnasc;?>" >
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