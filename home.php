<?php
session_start();
include '_php/cx.php';
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
    $cli = $perfil['cli'];
    if ($cli == 'N'){
        $ocultarcli = 'oc';
    }
    
    $dtr = $perfil['dtr'];
    if ($dtr == 'N'){
        $ocultardtr = 'oc';
    }
    
    $cal = $perfil['cal'];
    if ($cal == 'N'){
        $ocultarcal = 'oc';
    }
    
    $con = $perfil['con'];
    if ($con == 'N'){
        $ocultarcon = 'oc';
    }
    
    $dp = $perfil['dp'];
    if ($dp == 'N'){
        $ocultardp = 'oc';
    }
    
    $adm = $perfil['adm'];
    if ($adm == 'N'){
        $ocultaradm = 'oc';
    }
    
    $fin = $perfil['fin'];
    if ($fin == 'N'){
        $ocultarfin = 'oc';
    }
    
    $com = $perfil['com'];
    if ($com == 'N'){
        $ocultarcom = 'oc';
    }
    
    $sys = $perfil['sys'];
    if ($sys == 'N'){
        $ocultarsys = 'oc';
    }
    
    $atend = $perfil['atend'];
    if ($atend == 'N'){
        $ocultaratend = 'oc';
    }
    
    $caixa = $perfil['caixa'];
    if ($caixa == 'N'){
        $ocultacaixa = 'oc';
    }
    
    $mai = $perfil['mai'];
    if ($mai == 'N'){
        $ocultamai = 'oc';
    }
        
 }  

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>HOME</title>
        <link rel="shortcut icon" href="_imagens/Logo_FRC_1.ico" type="image/x-icon" />
        <link href="_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="_css/fotos.css" rel="stylesheet" type="text/css"/>
        <link href="_css/cabecalho.css" rel="stylesheet" type="text/css"/>
        <link href='_css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <style>
        
    </style>
    <body>
        <div class="container-fluid theme-showcase estilo" role="main">
            <div class="logo1"></div>
            <header class="cabecalho">
                 
                <div class="dropdown">
                    <button class="dropbtn"><?php echo $nome;?></button>
                    <div class="dropdown-content">
                        <a href="home.php">Perfil</a>
                        <a href="_php/alterarsenhausuario.php">Alterar Senha</a>
                        <a href="_php/fechar_sessao.php">Sair</a>
                    </div>
                </div> 
            </header>
                    <ul id="fotos_home">
                        <a href="cli/home_cli.php" target="_self"><li id="clientes" class="<?php echo $ocultarcli?>"><span>CLIENTES</span></li></a>
                        <a href="dtr/dtr_atendimento.php" target="_self"><li id="doutores" class="<?php echo $ocultardtr?>"><span>DOUTORES</span></li></a>
                        <a href="cal/home_cal.php" target="_blank"><li id="calendario" class="<?php echo $ocultarcal?>"><span>AGENDA</span></li></a>
                        <a href="atend/home_atend.php" target="_blank"><li id="atendimento" class="<?php echo $ocultaratend?>"><span>ATENDIMENTOS</span></li></a>
                        <a href="caixa/home_caixa.php" target="_blank"><li id="caixa" class="<?php echo $ocultacaixa?>"><span>CAIXA</span></li></a>
                        <a href="mailing/mailing_home.php" target="_blank"><li id="mailing" class="<?php echo $ocultamai?>"><span>MAILING/LEADS</span></li></a>
                        <a href="rh/colab_lista.php" target="_self"><li id="rh" class="<?php echo $ocultardp?>"><span>CADASTRO USUÁRIOS</span></li></a>
                        <a href="adm/adm_home.php" target="_self"><li id="adm" class="<?php echo $ocultaradm?>"><span>ADMINISTRAÇÃO</span></li></a>
                        <a href="fin/home_fin.php" target="_self"><li id="financeiro" class="<?php echo $ocultarfin?>"><span>FINANCEIRO</span></li></a>
                        <a href="com/com_home.php" target="_self"><li id="comercial"class="<?php echo $ocultarcom;?>"><span>COMERCIAL</span></li></a>
                        <a href="sys/home_sys.php" target="_self"><li id="sistema" class="<?php echo $ocultarsys?>"><span>SISTEMA</span></li></a>
                    </ul>
                
            
            
            <footer id="rodape">
                <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
            </footer>
            </div>
    </body>
</html>

<?php
}else{
    header("location:index.php");
}
?>

