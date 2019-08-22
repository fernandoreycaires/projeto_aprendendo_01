<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


//DADOS RECEBIDO DE PERFIL_CLI PARA ALTERAÇÃO DO CADASTRO DO CLIENTE    
    $id = $_POST['tID'];
    $tel1 = $_POST['tel1'];
    $tel2 = $_POST['tel2'];
    $tel3 = $_POST['tel3'];
    $mail = $_POST['tMail'];
    $web = $_POST['tWeb'];
    
    
    // CRIA COMANDO SQL
    $sql = "UPDATE mailing SET tel1='{$tel1}' , tel2='{$tel2}' , tel3='{$tel3}' , web='{$web}', email='{$mail}' WHERE id_m='{$id}' limit 1";
                   
    
    // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
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