<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//RECEBE VALORES DE COM_CADCNPJ para cadastro de observações
$cnpj_id_cli = $_POST['tID'];
$cadop = $_POST['tOperador'];
$cadidop = $_POST['tIDop'];
$cadobs = $_POST['tObs'];
$cadret = $_POST['tRet'];
$cadretdata = $_POST['tData'];
$cadirethora = $_POST['tHora'];
$data_atual = date('Y-m-d');
$hora_atual = date('H:i:s');

//ESSES DADOS SÃO PARA CADASTRO DE ORÇAMENTO

$orc_cont = $_POST['tCont'];
$orc_prod = $_POST['tProd'];
$orc_negoc = $_POST['vNeg'];
$orc_prod2 = $_POST['tProd2'];
$orc_negoc2 = $_POST['vNeg2'];
$orc_pagdata = $_POST['tPagdata'];
$orc_modopag = $_POST['tModopag'];
$orc_tipopag = $_POST['tTipopag'];
$orc_cortesia= $_POST['tCort'];
$orc_cortesia2= $_POST['tCort2'];


    
    // CRIA COMANDO SQL PARA INSERÇÃO DE DADOS DE OBSERVAÇÃO
    $sql = "INSERT INTO cnpj_obs (id_c ,obs , dia , hora, operador, id_op, ret_dia, ret_hora, retornar ) VALUES ('{$cnpj_id_cli}' , '{$cadobs}' , '{$data_atual}' ,'{$hora_atual}' ,'{$cadop}','{$cadidop}','{$cadretdata}','{$cadirethora}','{$cadret}')";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
        $msg = 'Negociação , Observação ou Orçamento cadastrada com sucesso !';
            
        
        // CRIA COMANDO PARA INSERÇÃO, CASO HAJA DADOS PARA ORÇAMENTO
        if ($orc_prod != "" and $orc_negoc != ""){
            
                        //PRIMEIRO FAZ UM SELECT PARA BUSCAR ID DA OBSERVAÇÃO QUE ACABOU DE SER CRIADA
                            $obssql = "SELECT LAST_INSERT_ID(id_co) FROM cnpj_obs WHERE id_c = '{$cnpj_id_cli}' ORDER BY id_co DESC LIMIT 1";
                            $enviaobs = $cx->query ($obssql);
                                while ($obs = $enviaobs->fetch()){
                                    $obs_idco = $obs['LAST_INSERT_ID(id_co)'];
                                }

                        // CRIA COMANDO SQL PARA INSERÇÃO NA TABELA ORÇAMENTO (orc)
                            $orcsql = "INSERT INTO orc (modo_pag ,tipo_pag , dia_pag , dia, hora, contato, operador, id_op, id_co, id_cnpj ) VALUES "
                                    . "('{$orc_modopag}' , '{$orc_tipopag}' , '{$orc_pagdata}' , '{$data_atual}' ,'{$hora_atual}' ,'{$orc_cont}','{$cadop}','{$cadidop}','{$obs_idco}','{$cnpj_id_cli}')";
                            $orc = $cx->query ($orcsql);
            
                            if ($orc){
                                    // FAZ UM SELECT PARA BUSCAR ID DO ORÇAMENTO QUE ACABOU DE SER CRIADO, DENTRO DE UM IF, PARA TER CERTEZA DE QUE SERÁ EXECUTADO APÓS A INSERÇÃO ACIMA
                                    $orcsql = "SELECT id_orc FROM orc WHERE id_co = '{$obs_idco}'";
                                    $enviaorc = $cx->query ($orcsql);
                                        while ($orcselect = $enviaorc->fetch()){
                                            $orc_id = $orcselect['id_orc'];
                                        }
                                    
                                    // FAZ UM SELECT PARA BUSCAR VALOR DO PRIMEIRO PRODUTO/SERVIÇO
                                    $prodsql = "SELECT valor_prod FROM produto WHERE id_prod = '{$orc_prod}'";
                                    $enviaprod = $cx->query ($prodsql);
                                        while ($prodselect = $enviaprod->fetch()){
                                            $prod_valor = $prodselect['valor_prod'];
                                        }
                                    
                                    //INSERE DADOS NA TABELA ORC_PROD
                                    $orcprodsql = "INSERT INTO orc_prod (id_orc ,id_prod , valor_prod , valor_negoci, cortesia ) VALUES "
                                    . "('{$orc_id}' , '{$orc_prod}' , '{$prod_valor}' , '{$orc_negoc}' ,'{$orc_cortesia}' )";
                                    $orcprod = $cx->query ($orcprodsql);
                                
                                        //VERIFICA SE HÁ ALGUM VALOR NO SEGUNDO ITEM, CASO HOUVER, FAZ A INSERÇÃO
                                        if ($orc_prod2 != "" and $orc_negoc2 != ""){
                                            
                                            // FAZ UM SELECT PARA BUSCAR VALOR DO SEGUNDO PRODUTO/SERVIÇO
                                            $prodsql = "SELECT valor_prod FROM produto WHERE id_prod = '{$orc_prod2}'";
                                            $enviaprod = $cx->query ($prodsql);
                                                while ($prodselect = $enviaprod->fetch()){
                                                    $prod_valor = $prodselect['valor_prod'];
                                                }

                                            //INSERE DADOS NA TABELA ORC_PROD
                                            $orcprodsql2 = "INSERT INTO orc_prod (id_orc ,id_prod , valor_prod , valor_negoci, cortesia ) VALUES "
                                            . "('{$orc_id}' , '{$orc_prod2}' , '{$prod_valor}' , '{$orc_negoc2}' ,'{$orc_cortesia2}' )";
                                            $orcprod2 = $cx->query ($orcprodsql2);
                                        }
                                    
                                    }
                            
                        } 
        
        
        ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpjobs.php">
                        <input type="hidden" name="msg" value="<?php echo $msg;?>">
                        <input type="hidden" name="idcnpj" value="<?php echo $cnpj_id_cli;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
        } else {
            echo 'OCORREU UM ERRO AO CADASTRAR  ! ';
        }
    


        
    
}else{
    header("location:index.php");
}
?>

