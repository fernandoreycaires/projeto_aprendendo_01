<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
$acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
$acesso_user = $cx->query ($acesso);

while ($perfil = $acesso_user->fetch()){
    $id = $perfil['id_u_cnpj'];
    $nome = $perfil['nome_u'];
    $cnpju = $perfil['cnpj_vinc'];
    $razao = $perfil['razao_c'];
 }  
 
 $cadcpf = $_POST['tCpf'];
 $cadnome = $_POST['tNome'];
 $cadnasc = $_POST['tNasc'];
 $cadsexo = $_POST['tSexo'];
 $cadestciv = $_POST['tEst'];
 $cadprof = $_POST['tProf'];
 $cadtipo = $_POST['tTipo'];
 $cadcrm = $_POST['tCRM'];
 $cadcrmuf = $_POST['tUFCRM'];
 $cadarea = $_POST['tArea'];
 $cadcel1 = $_POST['tCel'];
 $cadfixo = $_POST['tFixo'];
 $cademail = $_POST['tMail'];
 
 //VERIFICA NO BANCO SE CPF JÁ EXISTE
$cadclisql = "SELECT cpf FROM clientes WHERE cpf = '".$cadcpf."'";
$clienviasql = $cx->query ($cadclisql);
while ($checarcpf = $clienviasql->fetch()){
    $checar = $checarcpf[cpf];
 } 
 
if ($checar == $cadcpf){
   $checado = 'CPF JÁ CADASTRADO';
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_cadcrm.php">
                        <input type="hidden" name="cpf" value="<?php echo $cadcpf;?>">
                        <input type="hidden" name="msg" value="<?php echo $checado;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
   
}else{
    // CRIA COMANDO SQL
    $sql = "INSERT INTO clientes (nome ,cpf , nascimento , sexo , estadocivil , prof , cel1 , tel , email, tipo_doc ,crm, estado_crm, area_m) VALUES ('{$cadnome}' , '{$cadcpf}' , '{$cadnasc}' , '{$cadsexo}' ,  '{$cadestciv}' , '{$cadprof}' , '{$cadcel1}' ,'{$cadfixo}' , '{$cademail}' ,'{$cadtipo}' ,'{$cadcrm}' , '{$cadcrmuf}' , '{$cadarea}')";
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);

    if ($q) {
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_perfil.php">
                        <input type="hidden" name="cpfcli" value="<?php echo $cadcpf;?>">
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

    
}else{
    header("location:index.php");
}
?>