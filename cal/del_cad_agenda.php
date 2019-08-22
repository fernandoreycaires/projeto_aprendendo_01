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
    $id = $perfil[id_u_cnpj];
    $nome = $perfil[nome_u];
    $cnpju = $perfil[cnpj_vinc];
    $razao = $perfil[razao_c];
 } 

// RECEBENDO DADOS DE HOME_CAL VIA POST E DADOS DO DOUTOR VIA O SELECT FEITO ACIMA, PARA CADASTRO DE NOVOS EVENTOS NA AGENDA
    $idcal = isset($_POST['id'])?$_POST['id']:'0';

    
    //PREPARANDO COMANDO SQL PARA SER ENVIADO PARA BANCO
    $sql_cad = "DELETE FROM agenda WHERE id_data = '".$idcal."'";

    //ENVIANDO COMANDO PARA O BANCO                    
    $query_cad = $cx->query ($sql_cad);
    
    if ($query_cad) {
    $msg_cad = "AGENDAMENTO DELETADO COM SUCESSO ! ";
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">

        <body>
            <form method="post" name="salvadiag" id="salvadiag" action="home_cal.php">
                <input type="hidden" name="msg" value="<?php echo $msg_cad;?>">
            </form>
        </body>
        <script type="text/javascript">
            document.salvadiag.submit();
        </script>
    </html>
    <?php
    } else {
    $msg_cad = "OCORREU UM ERRO AO DELETAR O AGENDAMENTO ! ";
    }
    
    
 ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="UTF-8">
        <title>ADM Consultório</title>
        <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
        <style>
            h2 {
                text-align: center;
            }
        </style>

    </head>
    <body>
        <div id="interface">
        <header id="cabecalho">
            <p id="user"><?php print $nome?></p>
            <p id="cat"> Agendamento </p>
            <p id="sair"><a href="home_cal.php">Voltar para Agenda</a></p>
        </header>
            <h2><?php echo $msg_cad ?></h2><br>
        </div>
    </body>
</html>

<?php
}else{
    header("location:../index.php");
}
?>