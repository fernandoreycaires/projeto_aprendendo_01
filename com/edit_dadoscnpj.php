<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $fantasia = $_POST['tFant'];
    $cnpjcli = $_POST['tCNPJ'];
    $razao = $_POST['tRS'];
    $unidade = $_POST['tUni'];
    
    //BUSCA DADOS DO CNPJ, NA TABELA CNPJ, À SER ALTERADO, PARA FAZER ALTERAÇÃO DO CNPJ, NA TABELA DE USUARIOS
    $clisql = "SELECT cnpj_c FROM cnpj WHERE id_c = '".$id."' limit 1";
    $enviacli = $cx->query ($clisql);
    while ($cli = $enviacli->fetch()){
        $cnpj_old = $cli['cnpj_c'];
    }
    
    if ($cnpj_old != $cnpjcli){
    // ALTERA A TABELA CNPJ_USER CASO O CNPJ NOVO FOR DIFERENTE DO CNPJ ANTIGO
    $sqlU = "UPDATE cnpj_user SET cnpj_vinc='{$cnpjcli}' WHERE cnpj_vinc ='{$cnpj_old}'";
    $qU = $cx->query ($sqlU);
    }
    

    // ALTERA TABELA CNPJ
    $sql = "UPDATE cnpj SET razao_c='{$razao}' , nfantasia_c='{$fantasia}' , cnpj_c='{$cnpjcli}', unidade='{$unidade}' WHERE id_c ='{$id}' limit 1";
    $q = $cx->query ($sql);
    
    
    if ($q and $qU) {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="com_perfilcnpj.php">
                    <input type="hidden" name="idcnpj" value="<?php echo $id;?>">
                </form>
            </body>
            <script type="text/javascript">
                document.salva.submit()
            </script>
        </html>
        <?php
                        
        
    } else {
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

            <body>
                <form method="post" name="salva" id="salva" action="com_perfilcnpj.php">
                    <input type="hidden" name="idcnpj" value="<?php echo $id;?>">
                    <input type="hidden" name="erro" value="ALTERAÇÃO NÃO EXECUTADA, CONFIRA OS DADOS E/OU CONTATE O ADMINISTRADOR. ">
                </form>
            </body>
            <script type="text/javascript">
                document.salva.submit()
            </script>
        </html>
        <?php
        
    }
  
}else{
    header("location:../index.php");
}
?>