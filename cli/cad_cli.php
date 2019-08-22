<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];
  
 
    $cadcpf = isset($_POST['tCpf'])?$_POST['tCpf']:NULL;
    $cadrg = isset($_POST['tRG'])?$_POST['tRG']:NULL;
    $cadcn = isset($_POST['tCN'])?$_POST['tCN']:NULL;
    $cadnome = $_POST['tNome'];
    $cadnasc = $_POST['tNasc'];
    $cadsexo = $_POST['tSexo'];
    $cadestciv = $_POST['tEst'];
    $cadprof = $_POST['tProf'];
    $cadcel1 = $_POST['tCel'];
    $cadfixo = $_POST['tFixo'];
    $cademail = $_POST['tMail'];
 
 
 
if($cadcpf == "" and $cadrg == "" and $cadcn == ""){
    $checado = 'NECESSÁRIO INSERIR AO MENOS UM DOS DOCUMENTOS (CPF, RG OU CERTIDÃO DE NASCIMENTO)';
    ?>
        <!DOCTYPE html>
        <html lang="pt-br">
            <body>
                <form method="post" name="salvacli" id="salvacli" action="home_cli.php">
                    <input type="hidden" name="msg" value="<?php echo $checado;?>">
                </form>
            </body>
            <script type="text/javascript">
                document.salvacli.submit();
            </script>
        </html>
    <?php
}else{
    
    //VERIFICA NO BANCO SE CPF , RG ou CERTID. DE NASCIMENTO  JÁ EXISTE
    $cadclisql = "SELECT cpf, rg, certnasc FROM clientes WHERE cpf = '".$cadcpf."' OR rg = '".$cadrg."' OR certnasc = '".$cadcn."' ";
    $clienviasql = $cx->query ($cadclisql);
    while ($checar = $clienviasql->fetch()){
        $checarcpf = $checar['cpf'];
        $checarrg = $checar['rg'];
        $checarcn = $checar['certnasc'];
        }
 
    if ($checarcpf != "" and $checarcpf == $cadcpf or $checarrg != "" and $checarrg == $cadrg or $checarcn != "" and $checarcn==$cadcn){
       $checado = 'DOCUMENTO JÁ CADASTRADO';
                ?>
                <!DOCTYPE html>
                <html lang="pt-br">
                    <body>
                        <form method="post" name="salvacli" id="salvacli" action="home_cli.php">
                            <input type="hidden" name="tBusca" value="<?php echo $cadcpf;?>">
                            <input type="hidden" name="msg" value="<?php echo $checado;?>">
                        </form>
                    </body>
                    <script type="text/javascript">
                        document.salvacli.submit();
                    </script>
                </html>
                <?php

    }else{
        
        if($cadcpf!=""){
            $documento = "cpf";
            $documentovar = $cadcpf;
        } else if ($cadrg!=""){
            $documento = "rg";
            $documentovar = $cadrg;
        } else if ($cadcn!=""){
            $documento = "certnasc";
            $documentovar = $cadcn;
        }
        
        // CRIA COMANDO SQL
        $sql = "INSERT INTO clientes (nome , ".$documento." , nascimento , sexo , estadocivil , prof , cel1 , tel , email) VALUES ('{$cadnome}' , '{$documentovar}' , '{$cadnasc}' , '{$cadsexo}' ,  '{$cadestciv}' , '{$cadprof}' , '{$cadcel1}' ,'{$cadfixo}' , '{$cademail}')";
        // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
        $q = $cx->query ($sql);

        if ($q) {
                ?>
                <!DOCTYPE html>
                <html lang="pt-br">
                    <body>
                        <form method="post" name="salvacli" id="salvacli" action="perfil_cli.php">
                            <input type="hidden" name="cpfcli" value="<?php echo $cadcpf;?>">
                            <input type="hidden" name="rgcli" value="<?php echo $cadrg;?>">
                            <input type="hidden" name="cncli" value="<?php echo $cadcn;?>">
                        </form>
                    </body>
                    <script type="text/javascript">
                        document.salvacli.submit();
                    </script>
                </html>
                <?php
            } else {
                $msg = 'OCORREU UM ERRO AO CADASTRAR O CLIENTE ! ';
            }
        }
    
}
    
    

    
}else{
    header("location:../index.php");
}
?>
