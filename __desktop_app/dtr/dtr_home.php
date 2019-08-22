<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
        $cnpj = $_SESSION['cnpj_session'];
        include '../_php/cx.php';
        include '../_php/rodape.php';
        include '../_php/dtr.php';
        include '../_php/objetos.php';
        
        
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADM Consultório</title>
    <link rel='shortcut icon' href='../../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
    <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
    <link href="../_css/dtr.css" rel="stylesheet" type="text/css"/>
    <link href='../_css/bootstrap.min.css' rel='stylesheet'>
    <script src='../_javascript/jquery.min.js'></script>
    <script src='../_javascript/bootstrap.min.js'></script>
    <style>
        
        
    </style>
</head>
<body>
    <div class="container-fluid theme-showcase estilo col-md-12" role="main" id="corpo">
        <div class="row col-md-1" role="main">
            <div class="row menu">
                <div class="menudiv">
                    <img src="../../_imagens/Logo_FRC_1.png" width="115" height="60" id="img_logo" alt=""/>
                    <p></p>
                </div>
                <div class="menudiv">
                    <p align="center"><div id="imgprofile"></div></p>
                    <ul id="perfildados">
                        <li id="perfiledit"><button class="botaomenuperfil"></button></li>
                        <li id="mensagem"><button class="botaomenuperfil"></button></li>
                        <li id="system"><button class="botaomenuperfil"></button></li>
                    </ul>
                    <br><br>
                </div>
                <div class="menudiv">
                    <p align="center">ATENDIMENTOS</p>
                </div>
                <div class="menudiv">
                    <ul id="listamenu">
                        <li id="atend"><button class="botaomenulista"><span>ATENDIMENTOS</span></button></li>
                        <li id="pront"><button class="botaomenulista"><span>PRONTUARIOS</span></button></li>
                        <li id="agenda"><button class="botaomenulista"><span>AGENDA</span></button></li>
                    </ul>
                </div>
                <div class="menudiv">
                    <p align="center">MAILING / LEADS</p>
                </div>
                <div class="menudiv">
                    <ul id="listamenu">
                        <li id="lead"><button class="botaomenulista"><span>LEADS ATIVOS</span></button></li>
                        <li id="leadsint"><button class="botaomenulista"><span>LEADS SEM INTERESSE</span></button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row col-md-11" id="cabecalho">
            <div id="imgprofilecabecalho"></div>
            <div id="dadoscabecalho">
                <div id="direito">
                    <p><?php echo $nome;?></p>
                    <p><a href="../_php/fechar_sessao.php">Sair</a></p>
                </div>
                <div id="esquerdo">
                    <p><?php echo $nome_fantasia;?></p>
                    <p><?php print($cnpjn); ?></p>
                </div>
            </div>
        </div>
        <div id="dadoscorpo" class="row col-md-11">
            <div class="">
                <ul id="dado_inicial">
                    <li><span id="agendado">Agendados</span><span id="contador"><?php echo $qtdagenda;?></span></li>
                    <li><span id="leadS">Leads Ativos</span><span id="contador"><?php echo $qtdleadS;?></span></li>
                    <li><span id="leadN">Leads s/ int.</span><span id="contadorN"><?php echo $qtdleadN;?></span></li>
                    <li>Testando 04</li>
                    <li>Testando 05</li>
                    <li>Testando 06</li>
                </ul>
            </div>
        </div>
        <div class="row col-md-12" id="divrodape">
            <?php echo $rodape;?>
        </div>
    </div>
</body>
</html>
<?php
}else{
    header("location:../index.php");
}

