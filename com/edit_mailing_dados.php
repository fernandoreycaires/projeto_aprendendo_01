<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//DADOS RECEBIDO DE MAILING_VIZU PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $fantasia = $_POST['tFant'];
    $cnpjcli = $_POST['tCNPJ'];
    $razao = $_POST['tRS'];
    $unidade = $_POST['tUni'];
    $nome = $_POST['tNome'];
    $crm = $_POST['tCRM'];
    $cpf = $_POST['tCPF'];
    $area = $_POST['tArea'];
    $data_atual = date('Y-m-d');
    
    
    // ALTERA TABELA MAILING
    $sql = "UPDATE mailing SET razao='{$razao}' , nfan='{$fantasia}' , cnpj='{$cnpjcli}', unidade='{$unidade}', inserido='{$data_atual}', nome='{$nome}', cpf='{$cpf}', crm='{$crm}', area_m='{$area}' WHERE id_m = '".$id."' limit 1";
    $q = $cx->query ($sql);
    
    
    if ($q) {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="mailing_vizu.php">
                    <input type="hidden" name="id_m" value="<?php echo $id;?>">
                    <input type="hidden" name="msg" value="ALTERAÇÃO EFETUADA COM SUCESSO ! ">
                </form>
            </body>
            <script type="text/javascript">
                document.salva.submit();
            </script>
        </html>
        <?php
                        
        
    } else {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="mailing_vizu.php">
                    <input type="hidden" name="id_m" value="<?php echo $id;?>">
                    <input type="hidden" name="msg" value="ALTERAÇÃO NÃO EXECUTADA, CONFIRA OS DADOS E/OU CONTATE O ADMINISTRADOR. ">
                </form>
            </body>
            <script type="text/javascript">
                document.salva.submit();
            </script>
        </html>
        <?php
        
    }
  
}else{
    header("location:../index.php");
}
?>