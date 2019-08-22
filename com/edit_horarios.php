<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $media = $_POST['tMedia'];
    $inicio = $_POST['tInicio'];
    $fim = $_POST['tFim'];
    
    //ARRUMA HORA PARA INSERIR NA TABELA CNPJ 
    list($mediah, $mediam) = explode(':', $media); 
    list($inicioh, $iniciom) = explode(':', $inicio); 
    list($fimh, $fimm) = explode(':', $fim); 
    
    
    // CRIA COMANDO SQL
    $sql = "UPDATE cnpj SET atend_h='{$mediah}' , atend_m='{$mediam}' , ini_h ='{$inicioh}' , ini_m ='{$iniciom}', fim_h ='{$fimh}' , fim_m ='{$fimm}' WHERE id_c='{$id}' limit 1";
                   
    
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
    $q = $cx->query ($sql);
    
    if ($q) {
        
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