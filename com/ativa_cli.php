<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //RECEBE VALORES DE MAILING_OBS, QUANDO CLICADO EM "ATIVAR CLIENTE"
    $cadcnpj = $_POST['tCnpj'];
    $cadrazao = $_POST['tRazao'];
    $cadfant = $_POST['tFant'];

    $id_mailing = $_POST['tIDmailing'];
    $operador = $_POST['tOperador'];
    $idoperador = $_POST['tIDop'];

    $caduni = $_POST['tUni'];
    $cadtel1 = $_POST['tTel1'];
    $cadtel2 = $_POST['tTel2'];
    $cadtel3 = $_POST['tTel3'];
    $cadmail = $_POST['tMail'];
    $cadweb = $_POST['tWeb'];
    
//VERIFICA NO BANCO SE CNPJ JÁ EXISTE
$cadclisql = "SELECT cnpj_c FROM cnpj WHERE cnpj_c = '".$cadcnpj."'";
$clienviasql = $cx->query ($cadclisql);
while ($checarcpf = $clienviasql->fetch()){
    $checar = $checarcpf['cnpj_c'];
 } 
 
if ($checar == $cadcnpj){
   $checado = 'CNPJ JÁ CADASTRADO';
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="mailing_obs.php">
                        <input type="hidden" name="id_m" value="<?php echo $id_mailing;?>">
                        <input type="hidden" name="msg" value="<?php echo $checado;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
   
}else{
    // CADASTRA CLIENTE EM TABELA CNPJ
    $sql = "INSERT INTO cnpj (id_m, razao_c ,nfantasia_c , cnpj_c , unidade ,tel1_c , tel2_c , tel3_c , email_c , site_c ) VALUES ('{$id_mailing}' ,'{$cadrazao}' , '{$cadfant}' , '{$cadcnpj}' ,'{$caduni}' ,'{$cadtel1}' ,  '{$cadtel2}' , '{$cadtel3}' , '{$cadmail}' ,'{$cadweb}')";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);
    
    // NESTE IF , CASO O COMANDO ACIMA SEJA EXECUTADO, CRIAREMOS OUTRO COMANDO PARA INCLUIR DADOS NA TABELA DE NEGOCIAÇÃO, INFORMANDO QUE O CLIENTE FOI ATIVADO 
    if ($q) {
        //AQUI IRÁ ALTERAR A INFORMAÇÃO NA TABELA MAILING
            $sqlmailing = "UPDATE mailing SET ativo='S' limit 1";
            $m = $cx->query ($sqlmailing);
                if ($m) {
                        
                    //AQUI IRÁ ADICIONAR INFORMAÇÕES DE ATIVAÇÃO NA TABELA MAILING_OBS
                        $obsmailing = "CLIENTE FOI ATIVADO";
                        $data_atual = date('Y-m-d');
                        $hora_atual = date('H:i:s');

                        $sqlmailingobs = "INSERT INTO mailing_obs (id_m, obs, dia, hora, operador, id_op ) VALUES ('{$id_mailing}' ,'{$obsmailing}' , '{$data_atual}' , '{$hora_atual}' ,'{$operador}' ,'{$idoperador}')";
                        $mo = $cx->query ($sqlmailingobs);
                            if ($mo) {
                                
                                ?>
                                    <!DOCTYPE html>
                                    <html lang="pt-br">
                                        <body>
                                            <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpj.php">
                                                <input type="hidden" name="cnpjcli" value="<?php echo $cadcnpj;?>">
                                            </form>
                                        </body>
                                        <script type="text/javascript">
                                            document.salvacli.submit();
                                        </script>
                                    </html>
                                <?php
                                } else {
                                    
                                    echo 'OCORREU UM ERRO AO CADASTRAR ALTERAÇÃO NA TABELA MAILING_OBS ! ';
                                     
                                }
                        
                            echo 'OCORREU UM ERRO AO CADASTRAR ALTERAÇÃO NA TABELA MAILING ! ';    
                            }
            }
            echo 'OCORREU UM ERRO AO CADASTRAR ALTERAÇÃO NA TABELA CNPJ ! ';
    }
    echo 'OCORREU UM ERRO AO FAZER CHECAGEM DE EXISTENCIA DO CNPJ ! ';
            
}else{
    header("location:index.php");
}
?>