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
        $crm = $perfil['crm'];
    }  
    
    //RESERVA DE DATAS E HORA EM VARIEAVEIS
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
     
    $data_atual = date('Y-m-d');
    $hora_atual = date('H:i');
    list($anoatu, $mesatu, $diaatu) = explode('-', $data_atual);     
    
    //BUSCA INFORMAÇÕES DO DR(A) NA TABELA CLIENTES
    $dr_sql = "SELECT nome, nascimento, tipo_doc, crm, estado_crm, area_m, sexo, estadocivil, cel1, email FROM clientes WHERE crm = '".$crm."' limit 1";
    $acesso_dr = $cx->query ($dr_sql);

    while ($dr = $acesso_dr->fetch()){
        $dr_nome = $dr['nome'];
        $dr_nasc = $dr['nascimento'];
        $dr_tipo = $dr['tipo_doc'];
        $dr_crm = $dr['crm'];
        $dr_ufcrm = $dr['estado_crm'];
        $dr_area = $dr['area_m'];
        $dr_sx = $dr['sexo'];
        $dr_ec = $dr['estadocivil'];
        $dr_cel1 = $dr['cel1'];
        $dr_email = $dr['email'];
    }
    
    if ($dr_sx == 'F'){
        $dr_sx = 'Feminino';
    }else if ($dr_sx == 'M'){
        $dr_sx = 'Masculino';
    }
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
    $cel1n = substr_replace($dr_cel1, '(', 0, 0);
    $cel1n = substr_replace($cel1n, ')', 3, 0);
    $cel1n = substr_replace($cel1n, '-', 9, 0);
    $cel1n = substr_replace($cel1n, ' ', 4, 0);
    $cel1n = substr_replace($cel1n, ' ', 6, 0);
    
    //QUANTIDADE DE ATENDIMENTOS DO ANO
    //Janeiro
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-01-%' GROUP BY ini_data LIKE '".$anoatu."-01-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $janeiro = $atendimento['count(*)'];
    }
    if ($janeiro == ''){
        $janeiro = "0";
    }
    
    //Fevereiro
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-02-%' GROUP BY ini_data LIKE '".$anoatu."-02-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $fevereiro= $atendimento['count(*)'];
    }
    if ($fevereiro == ''){
        $fevereiro = "0";
    }
    
    //Março
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-03-%' GROUP BY ini_data LIKE '".$anoatu."-03-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $marco= $atendimento['count(*)'];
    }
    if ($marco == ''){
        $marco = "0";
    }
    
    //Abril
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-04-%' GROUP BY ini_data LIKE '".$anoatu."-04-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $abril= $atendimento['count(*)'];
    }
    if ($abril == ''){
        $abril = "0";
    }
    
    //Maio
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-05-%' GROUP BY ini_data LIKE '".$anoatu."-05-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $maio= $atendimento['count(*)'];
    }
    if ($maio == ''){
        $maio = "0";
    }
    
    //Junho
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-06-%' GROUP BY ini_data LIKE '".$anoatu."-06-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $junho= $atendimento['count(*)'];
    }
    if ($junho == ''){
        $junho = "0";
    }
    
    //Julho
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-07-%' GROUP BY ini_data LIKE '".$anoatu."-07-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $julho= $atendimento['count(*)'];
    }
    if ($julho == ''){
        $julho = "0";
    }
    
    //Agosto
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-08-%' GROUP BY ini_data LIKE '".$anoatu."-08-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $agosto= $atendimento['count(*)'];
    }
    if ($agosto == ''){
        $agosto = "0";
    }
    
    //setembro
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-09-%' GROUP BY ini_data LIKE '".$anoatu."-09-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $setembro = $atendimento['count(*)'];
    } 
    if ($setembro == ''){
        $setembro = "0";
    }
    
    //Outubro
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-10-%' GROUP BY ini_data LIKE '".$anoatu."-10-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $outubro = $atendimento['count(*)'];
    } 
    if ($outubro == ''){
        $outubro = "0";
    }
    
    //Novembro
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-11-%' GROUP BY ini_data LIKE '".$anoatu."-11-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $novembro = $atendimento['count(*)'];
    } 
    if ($novembro == ''){
        $novembro = "0";
    }
    
    //Dezembro
    $atend_sql = "SELECT ini_data, count(*) FROM atendimento WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND ini_data LIKE '".$anoatu."-12-%' GROUP BY ini_data LIKE '".$anoatu."-12-%'";
    $recebe_sql = $cx->query ($atend_sql);
    while ($atendimento = $recebe_sql->fetch()){
        $dezembro = $atendimento['count(*)'];
    } 
    if ($dezembro == ''){
        $dezembro = "0";
    }
    
    
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ADM Consultório</title>
                <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
                <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <style>
                    a {
                        color: #D3D3D3;
                    }
                    
                    .listaverde{
                        font-size: 11pt;
                        color: rgb(47,79,79);
                        background-color: rgba(72,209,204,.3);
                    }

                    .listavermelha{
                        font-size: 11pt;
                        color: rgb(61,17,17);
                        background-color: rgba(0255,182,193,.3);
                    }
                    
                                        
                    /* MENUS DE NAVEGAÇÃO */
                    .nav-tabs {
                        border-bottom:1px solid #ddd;
                    }

                    .nav-tabs>li{
                        float:left;
                        margin-bottom: -1px;
                    }
                    
                    .nav-tabs>li>a{
                        margin-right:2px;
                        line-height:1.42857143;
                        border:1px solid rgb(122, 121, 121);
                        border-radius:4px 4px 0 0;
                        background-color:rgba(96,96,96,.5);
                    }
                    
                    .nav-tabs>li>a:hover{
                        border-color:rgba(85, 129, 130, .5);
                        background-color:rgba(85, 129, 130, .5);
                    }

                    .nav-tabs>li.active>a,.nav-tabs>li.active>a:focus,.nav-tabs>li.active>a:hover{
                        color:#e0e0e0;
                        cursor:default;
                        background-color:rgb(122, 121, 121);
                        border:1px solid rgb(122, 121, 121);
                        border-bottom-color:rgb(122, 121, 121);
                    }
                    
                    .nav-tabs.nav-justified>.active>a,.nav-tabs.nav-justified>.active>a:focus,.nav-tabs.nav-justified>.active>a:hover{
                        border:1px solid rgb(122, 121, 121);
                    }
                    
                    /*FIM DO MENU DE NAVEGAÇÃO*/
                    
                    /*ALTERANDO O GRAFICO*/
                    
                    div#piechart_3d {
                        position: relative; 
                        width: 900px; 
                        height: 500px;
                        margin: 0 0 0 15% ;
                    }
                    
                    
                </style>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    /* GRAFICOS EXEMPLO EXTRAIDO DE https://www.youtube.com/watch?v=qE7C4x0-4iY  e  https://www.youtube.com/watch?v=mKOz5fZ8HV0
                     * Buscar sobre ChartJS */
                    
                    google.charts.load("current", {packages:["corechart"]});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Tipo', 'Quantidade'],
                            ['Janeiro',     <?php echo $janeiro;?>],
                            ['Fevereiro',   <?php echo $fevereiro;?>],
                            ['Março',       <?php echo $marco;?>],
                            ['Abril',       <?php echo $abril;?>],
                            ['Maio',        <?php echo $maio;?>],
                            ['Junho',       <?php echo $junho;?>],
                            ['Julho',       <?php echo $julho;?>],
                            ['Agosto',      <?php echo $agosto;?>],
                            ['Setembro',    <?php echo $setembro;?>],
                            ['Outubro',     <?php echo $outubro;?>],
                            ['Novembro',    <?php echo $novembro;?>],
                            ['Dezembro',    <?php echo $dezembro;?>]
                        ]);

                      var options = {
                        
                        backgroundColor: 'transparent',
                        is3D: true,
                        title: "ATENDIMENTOS DE <?php echo $anoatu;?>",
                        'titleTextStyle': {
                                fontName: 'Arial',
                                fontSize: 14,
                                bold: true,
                                italic: false,
                                // The color of the text.
                                color: '#cccccc',
                                // The color of the text outline.
                                auraColor: 'none',
                                // The transparency of the text.
                                opacity: 0.8
                        },
                        
                        'legend':{
                            position:'left',
                            textStyle: {
                                fontName: 'Arial',
                                fontSize: 14,
                                bold: false,
                                italic: false,
                                // The color of the text.
                                color: '#cccccc',
                                // The color of the text outline.
                                auraColor: 'none',
                                // The transparency of the text.
                                opacity: 0.8
                            }
                        }
                        
                      };

                      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                      chart.draw(data, options);
                    }
                </script>
	</head>
	<body>
                <div class="container-fluid theme-showcase estilo" role="main">
                    <div class="logo1"></div>
                    <header class="cabecalho">
                        <a href="../home.php" type="button" class="dropdownvoltar">Voltar</a>
                        <div class="dropdown">
                            <button class="dropbtn"><?php echo $nome;?></button>
                            <div class="dropdown-content">
                                <a href="../home.php">Perfil</a>
                                <a href="../_php/alterarsenhausuario.php">Alterar Senha</a>
                                <a href="../_php/fechar_sessao.php">Sair</a>
                            </div>
                        </div>
                    </header>
			<div class="page-header">
				<h1 align="center">Doutores </h1>
			</div>
			<div class="row">
				<div class="col-md-12">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li role="presentation" class="active"><a href="dtr_perfil.php" target="_self">Perfil</a></li>
                                        <li role="presentation"><a href="dtr_atendimento.php" target="_self">Atendimentos</a></li>
                                        <li role="presentation"><a href="dtr_prontuario.php" target="_self">Prontuários</a></li>
                                        <li role="presentation"><a href="dtr_agenda.php" target="_self">Agenda</a></li>
                                    </ul>
                                </div>
			</div>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <p align="center"><span class='banco'><?php echo strftime('%A, %d de %B de %Y', strtotime('today')); ?>&nbsp;&nbsp; - &nbsp;&nbsp;<?php echo $hora_atual; ?> </span></p>
                                <table class="table">
                                    <thead>
                                        <th colspan="4"></th>
                                    </thead>
                                    <tr><td>Dr(a).:</td><td><?php echo $dr_nome;?></td><td><?php echo $dr_tipo;?>:</td><td><?php echo $dr_crm;?></td></tr>
                                    <tr><td>Especialização:</td><td><?php echo $dr_area;?></td><td><?php echo $dr_tipo;?>-UF:</td><td><?php echo $dr_ufcrm;?></td></tr>
                                    <tr><td>Sexo:</td><td><?php echo $dr_sx;?></td><td>Estado Civil:</td><td><?php echo $dr_ec;?></td></tr>
                                    <tr><td>Celular :</td><td><?php echo $cel1n;?></td><td>E-Mail:</td><td><?php echo $dr_email;?></td></tr>
                                </table>
                                <br>
                                <div id="piechart_3d"></div>
                                
                            </div>
                        </div>
                    <br>
                    <footer id="rodape">
                        <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                        <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                    </footer>
		</div>  
            

  </body>
</html>
<?php
}else{
    header("location:../index.php");
}
?>
