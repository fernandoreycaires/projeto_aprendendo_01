<?php
    session_start();
    include '../_php/cx.php';
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        $cnpj = $_SESSION['cnpj_session'];
        $user = $_SESSION['user_session'];
        $pass = $_SESSION['pass_session'];

    //VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
$acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c join clientes cli on cu.cpf_vinc = cli.cpf WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
$acesso_user = $cx->query ($acesso);

    while ($perfil = $acesso_user->fetch()){
        $id = $perfil['id_u_cnpj'];
        $nome = $perfil['nome_u'];
        $cnpju = $perfil['cnpj_vinc'];
        $razao = $perfil['razao_c'];
        $doutornome = $perfil['nome'];
        $tipodoc = $perfil['tipo_doc'];
        $doutorcrm = $perfil['crm'];
        $doutorarea = $perfil['area_m'];
     } 
     
   
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    $data_atual = date('d/m/Y');
    $hora_atual = date('H:i');
    
     
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
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/jquery.min.js'></script>
                <style>
                    table tr{
                        vertical-align: top;
                        
                    }
                    
                    ul {
                        list-style: none;
                        position: relative;
                        color: rgb(210,210,210);
                        
                    }
                    ul#paccab{
                       display: box;
                       float: left; 
                    }
                    
                    ul#paccorpo{
                       display: box;
                       float: left; 
                    }
                    ul#doccab{
                       display: box;
                       float: left; 
                    }
                    ul#doccorpo{
                       display: box;
                       float: left; 
                    }
                    div#dadospacdoc{
                        display: box;
                        position: relative;
                        width: 100%;
                        height: 200px;
                    }
                    
                    .form-control-option {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                        height:20px;
                        width: 100%;
                    }
                    
                    .form-control-textarea {
                        background-color: rgba(38,42,48,1);
                        color: rgb(255,255,255);
                        width: 100%;
                        height:70px;
                        padding:6px 12px;
                        font-size:14px;
                        line-height:1.42857143;
                        border:1px solid #ccc;
                        border-radius:4px;
                        -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                        box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                        -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                        -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                        transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
                        }
                        
                    /* ALTERA AS CONFIGURAÇÕES de plano de fundo da janela modal*/
                    .modal-backdrop {
                        background-color: #1C1C1C;
                    }

                    /* ALTERA AS CONFIGURAÇÕES de conteudo da Janela Modal */
                    .modal-content {
                        background-color: rgb(38,42,48);
                    }

                    .modal-content input {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }

                    .modal-content textarea {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }

                    .modal-content select {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }

                    .modal-content table tr td {
                        background-color: rgb(38,42,48);
                        color: rgba(255,255,255,1);
                    }
                </style>
                
	</head>
	<body>
                <div class="container-fluid theme-showcase estilo" role="main">
                    <div class="logo1"></div>
                    <header class="cabecalho">
                        <a href="dtr_atendimento.php" type="button" class="dropdownvoltar">Voltar</a>
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
                                
                                <?php 
                                    //Recebe ID através do POST vindo de DTR_PACIENTE
                                    $cpf_recebido = isset($_POST['novo_diag'])?$_POST['novo_diag']:'';
                                    $rg_recebido = isset($_POST['novo_diagrg'])?$_POST['novo_diagrg']:'';
                                    $cn_recebido = isset($_POST['novo_diagcn'])?$_POST['novo_diagcn']:'';
                                    $atend = isset($_POST['atendimento'])?$_POST['atendimento']:'';

                                    //VERIFICA SE ATENDIMENTO JÁ EXISTE NA TABELA his_med
                                    $pront_sql = "SELECT atendimento FROM his_med WHERE atendimento = '".$atend."' LIMIT 1";
                                    $pront_envia = $cx->query ($pront_sql);
                                        while ($pront = $pront_envia->fetch()){
                                            $atend_hismed = $pront['atendimento'];
                                        }
                                    //se caso atendimento já existir, ele reenvia para a pagina diagnostico.php
                                    if ($atend_hismed != ''){
                                    ?>
                                        <form method="post" name="salvadiag" id="salvadiag" action="diagnostico.php">
                                            <input type="hidden" name="atendimento" value="<?php echo $atend;?>" id="atendenvia">
                                        </form>

                                        <script type="text/javascript">
                                            document.salvadiag.submit();
                                        </script>
                                    <?php
                                    }

                                    //RESERVA DATA E HORA ATUAL EM UMA VARIAVEL
                                    $data = date('d/m/Y'); //esta para exibir na tela
                                    $datab = date('Y-m-d'); //este para ser enviado para o banco de dados
                                    $hora_atual = date('H:i');

                                    //VAI BUSCAR INFORMAÇÕES DO PACIENTE DO BANCO DE DADOS CLIENTES
                                    $mostra_sql = "SELECT id, nome, cpf, rg, certnasc, prof, nascimento  FROM clientes WHERE cpf != '' AND cpf = '".$cpf_recebido."' OR rg != '' AND rg = '".$rg_recebido."' OR certnasc != '' AND certnasc = '".$cn_recebido."' ";
                                    $mostra = $cx->query ($mostra_sql);
                                    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                    while ($dados = $mostra->fetch()){
                                        $idcli = $dados['id'];
                                        $nomecli = $dados['nome'];
                                        $cpfcli = $dados['cpf'];
                                        $rgcli = $dados['rg'];
                                        $cncli = $dados['certnasc'];
                                        $profcli = $dados['prof'];
                                        $nasc = $dados['nascimento'];
                                    }
                                    
                                    //VAI BUSCAR INFORMAÇÕES DO CONVENIO DO PACIENTE DCADASTRADO NO ATENDIMENTO
                                    $conv_atend_sql = "SELECT convenio FROM atendimento WHERE id_atend = '".$atend."' ";
                                    $envia_conv_atend = $cx->query ($conv_atend_sql);
                                        while ($atend_conv = $envia_conv_atend->fetch()){
                                            $conv_atendimento = $atend_conv['convenio'];
                                        }

                                    // Separa em dia, mês e ano a data de nascimento
                                    list($anonasc, $mesnasc, $dianasc) = explode('-', $nasc);

                                    //CALCULANDO IDADE
                                    // Separa em dia, mês e ano
                                    list($ano, $mes, $dia) = explode('-', $nasc);

                                    // Descobre que dia é hoje e retorna a unix timestamp
                                    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                    // Descobre a unix timestamp da data de nascimento do fulano
                                    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

                                    // Depois apenas fazemos o cálculo já citado :)
                                    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                                    //print $idade;
                                    //FIM DO CALCULO DE IDADE

                                    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                        $cpfn = substr_replace($cpfcli, '.', 3, 0);
                                        $cpfn = substr_replace($cpfn, '.', 7, 0);
                                        $cpfn = substr_replace($cpfn, '-', 11, 0);

                                    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
                                        $rgn = substr_replace($rgcli, '.', 2, 0);
                                        $rgn = substr_replace($rgn, '.', 6, 0);
                                        $rgn = substr_replace($rgn, '-', 10, 0);

                                    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
                                        $cnpjn = substr_replace($cnpju, '.', 2, 0);
                                        $cnpjn = substr_replace($cnpjn, '.', 6, 0);
                                        $cnpjn = substr_replace($cnpjn, '/', 10, 0);
                                        $cnpjn = substr_replace($cnpjn, '-', 15, 0);

                                    

                                    ?>
                                                
                                            <div id="dadospacdoc">
                                                <p align="center"><span class='banco'><?php echo $razao;?> </span> &nbsp;&nbsp;&nbsp; CNPJ: <span class='banco'><?php echo $cnpjn;?></span> </p>
                                                <p align="center"><span class='banco'><?php echo strftime('%A, %d de %B de %Y', strtotime('today'));?>&nbsp;&nbsp; - &nbsp;&nbsp;<?php echo $hora_atual;?> </span></p>
                                                    <ul id="paccab">                                       
                                                    <li>Dados do Paciente</li>
                                                    <li>Convenio:<span class='banco'>&nbsp;<?php echo $conv_atendimento;?></span> </li>
                                                    </ul>
                                                    <ul id="paccorpo">
                                                        <li><span class='banco'><?php echo $nomecli;?></span></li>
                                                        <li>CPF:<span class='banco'>&nbsp;<?php echo $cpfn;?></span></li>
                                                        <li>RG:<span class='banco'>&nbsp;<?php echo $rgn;?></span></li>
                                                        <li>Profissão:<span class='banco'>&nbsp;<?php echo $profcli;?></span></li>
                                                        <li>Nascimento:<span class='banco'>&nbsp;<?php echo "$dianasc/$mesnasc/$anonasc ($idade Anos de idade)"?></span></li>
                                                    </ul>
                                                    <ul id="doccab">
                                                        <li>Médico/ Doutor responsável</li>
                                                    </ul>
                                                    <ul id="doccorpo">
                                                        <li><span class='banco'><?php echo $doutornome;?></span></li>
                                                        <li><?php echo $tipodoc;?>:&nbsp;<span class='banco'><?php echo $doutorcrm;?></span></li>
                                                        <li>Especialização:&nbsp;<span class='banco'><?php echo $doutorarea;?></span></li>
                                                        <li>Atendimento:&nbsp;<span class='banco'><?php echo $atend;?></span></li>
                                                    </ul>
                                            </div>
                                            
                                        <?php
                                        //ESTE IF OCULTA CASO O TIPO DO DOCUMENTO NÃO SEJA DO TIPO DE PSICOLOGIA
                                        
                                            if ($tipodoc == "CRP" || $tipodoc == "CRTH/BR" ){
                                                //VERIFICA SE HÁ ALGUMA ANAMNESE REGISTRADA
                                                $anam_sql = "SELECT id_pac, id_an FROM anamnese WHERE id_pac != '' AND id_pac = '".$idcli."' AND doc = '".$doutorcrm."' AND cnpj = '".$cnpj."' ORDER BY id_an DESC LIMIT 1 ";
                                                $anam_mostra = $cx->query ($anam_sql);
                                                    while ($anam = $anam_mostra->fetch()){
                                                        $id_anam = $anam['id_an'];
                                                        $id_cli = $anam['id_pac'];
                                                    }

                                                    if ($id_cli == ""){
                                                        $anam_msg = "ANAMNESE NÃO ENCONTRADA, DESEJA CRIAR UMA ? <button type='button' class='btn btn-xs btn-primary' data-toggle='modal' data-target='#modalanam'>Adicionar</button>";
                                                        $cor = "#3a1a1a";
                                                        $status = "alert-danger";

                                                            } else if ($id_cli != ""){
                                                                $anam_msg = "ANAMNESE ENCONTRADA, DESEJA CONTINUAR UTILIZANDO ESTA  <button type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#modalanamvisu'>Visualizar</button> ? OU <button type='button' class='btn btn-xs btn-primary' data-toggle='modal' data-target='#modalanam'>Criar Novo</button>";
                                                                $cor = "#1f3a1a";
                                                                $status = "alert-success";
                                                            }
                                        ?>
                                        <div class="alert <?php echo $status;?> alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <p align="center" style="color:<?php echo $cor;?>; font-weight: bold"><?php echo $anam_msg;?> </p>
                                        </div>
                                        
                                        <form action="pdf_anamnese.php" method="post" target="_blank">
                                            <input type="hidden" name="id_cli" value="<?php echo $idcli;?>">
                                            <p>Anamnese para imressão <button type='submit' class='btn btn-xs btn-primary'>Gerar</button></p>
                                        </form>
                                                                <!-- MODAL REFERENTE À ADICIONAR NOVA ANAMNESE -->
                                                                    <div class="modal fade" id="modalanam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title text-center" id="myModalLabel">Inserir Anamnese</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="cad_anamnese.php" method="post">
                                                                                        <table class="table">
                                                                                            <thead><th colspan="4" style="text-align: center;">DADOS BÁSICOS </th></thead>
                                                                                            <tr><td >Dia: </td><td><?php echo $data_atual;?></td><td>Hora: </td><td><?php echo $hora_atual;?></td></tr>
                                                                                            <tr><td>Religião:</td><td colspan="3"><input type="text" name="tRel" class="form-control"></td></tr>
                                                                                            <tr><td>Numero de Filhos:</td><td><input type="text" name="tNumF" onkeypress="return onlynumber();" class="form-control"></td><td>Numero de Irmão:</td><td><input type="text" name="tNumI" onkeypress="return onlynumber();" class="form-control"></td></tr>
                                                                                            <tr><td>Médico que encaminhou:</td><td><input type="text" name="tME" class="form-control"></td><td>Profissional que encaminhou:</td><td><input type="text" name="tPE" class="form-control"></td></tr>
                                                                                            <tr><td>Problemas com álcool/drogas? </td><td colspan="3"><label for="S"> <input type="radio" name="tPAD" id="S" value="S"/> SIM </label> <label for="N"><input type="radio" name="tPAD" id="N" value="N" checked="checked"/> NÃO </label></td></tr>
                                                                                            <tr><td>Se sim, porque ? </td><td colspan="3"><textarea type="text" name="tPADs" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Fuma? </td><td colspan="3"><label for="FS"> <input type="radio" name="tFuma" id="FS" value="S"/> SIM </label> <label for="FN"><input type="radio" name="tFuma" id="FN" value="N" checked="checked"/> NÃO </label></td></tr>
                                                                                            <tr><td>Sono: </td><td colspan="3"><label for="B"> <input type="radio" name="tSono" id="B" value="BOM" /> BOM </label>&nbsp;  <label for="Normal"><input type="radio" name="tSono" id="Normal" value="NORMAL" checked="checked" /> NORMAL </label> &nbsp; <label for="M"> <input type="radio" name="tSono" id="M" value="MAU" /> MAU </label></td></tr>
                                                                                            <tr><td>Como nos conheceu ? </td><td colspan="3"><textarea type="text" name="tCNC" class="form-control" ></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">DADOS DOS PAIS </th></thead>
                                                                                            <tr><td>Pai Nome:</td><td><input type="text" name="tNP" class="form-control"></td><td>Pai Idade:</td><td><input type="number" name="tIP" class="form-control"></td></tr>
                                                                                            <tr><td>Pai Profissão:</td><td><input type="text" name="tPProf" class="form-control"></td><td>Pai Instrução:</td><td><input type="text" name="tPInst" class="form-control"></td></tr>
                                                                                            <tr><td>Mãe Nome:</td><td><input type="text" name="tNM" class="form-control"></td><td>Mãe Idade:</td><td><input type="number" name="tIM" class="form-control"></td></tr>
                                                                                            <tr><td>Mãe Profissão:</td><td><input type="text" name="tMProf" class="form-control"></td><td>Mãe Instrução:</td><td><input type="text" name="tMInst" class="form-control"></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">QUEIXA </th></thead>
                                                                                            <tr><td>Queixa Pricipal:</td><td colspan="3"><textarea type="text" name="tQP" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Inicio da queixa:</td><td colspan="3"><textarea type="text" name="tIQ" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Súbita ou progressiva :</td><td colspan="3"><textarea type="text" name="tSP" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Quais mudanças que ocorreram/ o que afetou:</td><td colspan="3"><textarea type="text" name="tQMO" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Sintomas:</td><td colspan="3"><textarea type="text" name="tSint" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Queixa Secundária:</td><td colspan="3"><textarea type="text" name="tQS" class="form-control" ></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">HISTÓRIA CLINICA </th></thead>
                                                                                            <tr><td>Doença Crônica:</td><td colspan="3"><input type="text" name="tDCron" class="form-control"></td></tr>
                                                                                            <tr><td>Toma Medicamentos?</td><td><label for="MedS"> <input type="radio" name="tMedi" id="MedS" value="S"/> SIM </label> <label for="MedN"><input type="radio" name="tMedi" id="MedN" value="N" checked="checked"/> NÃO </label></td><td colspan="2">Quais : <textarea type="text" name="tQMed" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Já teve problemas cardiacos ?</td><td><label for="PCardS"> <input type="radio" name="PCard" id="PCardS" value="S"/> SIM </label> <label for="PCardN"><input type="radio" name="PCard" id="PCardN" value="N" checked="checked"/> NÃO </label></td><td colspan="2">Qual : <input type="text" name="tPCardTipo" class="form-control" ></td></tr>
                                                                                            <tr><td>É Diabético ?</td><td><label for="tDiabS"> <input type="radio" name="tDiab" id="tDiabS" value="S"/> SIM </label> <label for="tDiabN"><input type="radio" name="tDiab" id="tDiabN" value="N" checked="checked"/> NÃO </label></td><td colspan="2">Tipo : <input type="text" name="tDiabTipo" class="form-control" ></td></tr>
                                                                                            <tr><td>Ocorrência de epilepsia? </td><td><label for="EpileS"> <input type="radio" name="Epile" id="EpileS" value="S"/> SIM </label> <label for="EpileN"><input type="radio" name="Epile" id="EpileN" value="N" checked="checked"/> NÃO </label></td><td colspan="2">Quando : <input type="text" name="tEpiQuan" class="form-control" ></td></tr>
                                                                                            <tr><td>Casos de internação :</td><td colspan="3"> <textarea type="text" name="tIntern" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Enfrentamento :</td><td colspan="3"> <textarea type="text" name="tEnfrent" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Sintomas fisicos e/ou psicologicos :</td><td colspan="3"> <textarea type="text" name="tSintom" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Psicoterapia/fono/fisio/neuro/psiquiatria :</td><td colspan="3"> <textarea type="text" name="tPFFNP" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Hábitos alimentares :</td><td colspan="3"> <textarea type="text" name="tHabAl" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td colspan="4" style="text-align: center;">HISTÓRIA CLINICA / CRIANÇA OU ADOLESCENTE</td></tr>
                                                                                            <tr><td>Condições de nascimento :</td><td colspan="3"> <textarea type="text" name="tCondNasc" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Desenvolvimento Neuropsicomotor :</td><td colspan="3"> <textarea type="text" name="tDesenvNeuro" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Doenças infantis :</td><td colspan="3"> <textarea type="text" name="tDoenInf" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Casos de convulções, epilepsia, desmaios etc:</td><td colspan="3"> <textarea type="text" name="tConvEpil" class="form-control" ></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">HISTÓRIA FAMILIAR</th></thead>
                                                                                            <tr><td>Composição Familiar (Genograma) :</td><td colspan="3"> <textarea type="text" name="tCFgeno" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Dinamica Familiar :</td><td colspan="3"> <textarea type="text" name="tDinFam" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Eventos significativos :</td><td colspan="3"> <textarea type="text" name="tESig" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Rede de apoio :</td><td colspan="3"> <textarea type="text" name="tRApoio" class="form-control" ></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">HISTÓRIA SOCIAL </th></thead>
                                                                                            <tr><td colspan="4"><textarea type="text" name="tHistSoc" class="form-control-textarea" placeholder="Informação específica sobre família, infância, adolescência, casamento, relações, sexualidade (Vida social, Habitos de lazer, inserção em grupos, rede de apoio) "></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">DADOS ESCOLARES </th></thead>
                                                                                            <tr><td>Casos de reprovação:</td><td colspan="3"><textarea type="text" name="tCReprov" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Áreas de dificuldade:</td><td colspan="3"><textarea type="text" name="tADifi" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Hábitos de estudo:</td><td colspan="3"><textarea type="text" name="tHabEstu" class="form-control" ></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">HIPNOTERAPIA</th></thead>
                                                                                            <tr><td>Alguém já tentou o hipnotizar?:</td><td colspan="3"><label for="HipS"> <input type="radio" name="tHip" id="HipS" value="S"/> SIM </label> <label for="HipN"><input type="radio" name="tHip" id="HipN" value="N" checked="checked"/> NÃO </label></td></td></tr>
                                                                                            <tr><td>Quem? :</td><td colspan="3"><input type="text" name="tHipQuem" class="form-control"></td></tr>
                                                                                            <tr><td>Motivo :</td><td colspan="3"> <textarea type="text" name="tHipMotivo" class="form-control" ></textarea></td></tr>
                                                                                            <tr><td>Você acredita que foi hipnotizado?</td><td colspan="3"><label for="HipSim"> <input type="radio" name="tAcreHip" id="HipSim" value="SIM" /> SIM </label>&nbsp;  <label for="HipNao"><input type="radio" name="tAcreHip" id="HipNao" value="NÃO" /> NÃO </label> &nbsp; <label for="HipNaoSei"> <input type="radio" name="tAcreHip" id="HipNaoSei" value="NÃO SEI" checked="" /> NÃO SEI </label></td></tr>
                                                                                            <tr><td>Por quê? </td><td colspan="3"><textarea type="text" name="tAcredhipnoPq" class="form-control"></textarea></td></tr>
                                                                                            <tr><td>Motivos para buscar ajuda com a hipnose: :</td><td colspan="3"> <textarea type="text" name="tHipBuscPq" class="form-control" ></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">CONSIDERAÇÕES FINAIS </th></thead>
                                                                                            <tr><td colspan="4"><textarea type="text" name="tConsFinal" class="form-control-textarea"></textarea></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">SUGESTÃO DE ENCAMINHAMENTO </th></thead>
                                                                                            <tr><td colspan="4"><textarea type="text" name="tSugestEnc" class="form-control-textarea"></textarea></td></tr>

                                                                                            <tr>
                                                                                                <input type="hidden" name="tCliId" value="<?php echo $idcli;?>">
                                                                                                <input type="hidden" name="tAtend" value="<?php echo $atend;?>">
                                                                                                <input type="hidden" name="tCliCpf" value="<?php echo $cpf_recebido;?>">
                                                                                                <input type="hidden" name="tCliRg" value="<?php echo $rg_recebido;?>">
                                                                                                <input type="hidden" name="tCliCn" value="<?php echo $cn_recebido;?>">
                                                                                                <input type="hidden" name="tDoutNome" value="<?php echo $doutornome;?>">
                                                                                                <input type="hidden" name="tTipoDoc" value="<?php echo $tipodoc;?>">
                                                                                                <input type="hidden" name="tDocNum" value="<?php echo $doutorcrm;?>">
                                                                                                <input type="hidden" name="tCNPJ" value="<?php echo $cnpj;?>">
                                                                                                <td colspan="4" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar</button></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>  
                                                                <!-- Fim do modal para adicionar ANAMNESE -->

                                                                <!-- MODAL REFERENTE À VIZUALIZAR ANAMNESE -->
                                                                    <div class="modal fade" id="modalanamvisu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title text-center" id="myModalLabel">Inserir Anamnese</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                        <table class="table">
                                                                                            <?php
                                                                                            $anamn_sql = "SELECT * FROM anamnese WHERE id_an = '".$id_anam."'";
                                                                                            $anamn_mostra = $cx->query ($anamn_sql);
                                                                                                while ($anamn = $anamn_mostra->fetch()){
                                                                                                    $anam_id = $anamn['id_pac'];
                                                                                                    $anam_dia= $anamn['dia'];
                                                                                                    $anam_hora = $anamn['hora'];
                                                                                                    $anam_religiao = $anamn['religiao'];
                                                                                                    $anam_num_filho = $anamn['num_filho'];
                                                                                                    $anam_num_irmaos = $anamn['num_irmaos'];
                                                                                                    $anam_med_enc = $anamn['med_enc'];
                                                                                                    $anam_prof_enc = $anamn['prof_enc'];
                                                                                                    $anam_prob_drog_alc = $anamn['prob_drog_alc'];
                                                                                                    $anam_prob_drog_alc_pq = $anamn['prob_drog_alc_pq'];
                                                                                                    $anam_fuma = $anamn['fuma'];
                                                                                                    $anam_sono = $anamn['sono'];
                                                                                                    $anam_como_soube = $anamn['como_soube'];

                                                                                                    //ARRUMANDO A DATA
                                                                                                    list($anoA, $mesA, $diaA) = explode('-', $anam_dia);
                                                                                                    $anam_dia = $diaA."/".$mesA."/".$anoA;

                                                                                                    //ARRUMANDO PROBLEMA ALCOOL OU DROGA
                                                                                                    if ($anam_prob_drog_alc == 'S'){
                                                                                                        $anam_prob_drog_alc = 'SIM';
                                                                                                    } else if ($anam_prob_drog_alc == 'N'){
                                                                                                        $anam_prob_drog_alc = 'NÃO';
                                                                                                    }

                                                                                                    //ARRUMANDO FUMA
                                                                                                    if ($anam_fuma == 'S'){
                                                                                                        $anam_fuma = 'SIM';
                                                                                                    } else if ($anam_fuma == 'N'){
                                                                                                        $anam_fuma = 'NÃO';
                                                                                                    }

                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">DADOS BÁSICOS </th></thead>
                                                                                            <tr><td>Dia: </td><td><?php echo $anam_dia;?></td><td>Hora: </td><td><?php echo $anam_hora;?></td></tr>
                                                                                            <tr><td>Religião:</td><td colspan="3"><?php echo $anam_religiao;?></td></tr>
                                                                                            <tr><td>Numero de Filhos:</td><td><?php echo $anam_num_filho;?></td><td>Numero de Irmão:</td><td><?php echo $anam_num_irmaos;?></td></tr>
                                                                                            <tr><td>Médico que encaminhou:</td><td><?php echo $anam_med_enc;?></td><td>Profissional que encaminhou:</td><td><?php echo $anam_prof_enc;?></td></tr>
                                                                                            <tr><td>Problemas com álcool/drogas? </td><td colspan="3"><?php echo $anam_prob_drog_alc;?></td></tr>
                                                                                            <tr><td>Se sim, porque ? </td><td colspan="3"><?php echo $anam_prob_drog_alc_pq;?></td></tr>
                                                                                            <tr><td>Fuma? </td><td colspan="3"><?php echo $anam_fuma;?></td></tr>
                                                                                            <tr><td>Sono: </td><td colspan="3"><?php echo $anam_sono;?></td></tr>
                                                                                            <tr><td>Como nos conheceu ? </td><td colspan="3"><?php echo $anam_como_soube; ?></td></tr>
                                                                                            <?php
                                                                                                }

                                                                                                $anamn_sql_dp = "SELECT * FROM anamnese_dad_p WHERE id_an = '".$id_anam."'";
                                                                                                $anamn_mostra_dp = $cx->query ($anamn_sql_dp);
                                                                                                    while ($anamn_dp = $anamn_mostra_dp->fetch()){
                                                                                                        $anam_pai_nome = $anamn_dp['pai_nome'];
                                                                                                        $anam_pai_idade= $anamn_dp['pai_idade'];
                                                                                                        $anam_pai_prof = $anamn_dp['pai_prof'];
                                                                                                        $anam_pai_intr = $anamn_dp['pai_instrucao'];
                                                                                                        $anam_mae_nome = $anamn_dp['mae_nome'];
                                                                                                        $anam_mae_idade= $anamn_dp['mae_idade'];
                                                                                                        $anam_mae_prof = $anamn_dp['mae_prof'];
                                                                                                        $anam_mae_instr= $anamn_dp['mae_instrucao'];
                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">DADOS DOS PAIS </th></thead>
                                                                                            <tr><td >Pai Nome: <?php echo $anam_pai_nome;?></td><td colspan="2">Pai Idade: <?php echo $anam_pai_idade;?></td></tr>
                                                                                            <tr><td >Pai Profissão: <?php echo $anam_pai_prof;?></td><td colspan="2">Pai Instrução: <?php echo $anam_pai_intr;?></td></tr>
                                                                                            <tr><td >Mãe Nome: <?php echo $anam_mae_nome;?></td><td colspan="2">Mãe Idade: <?php echo $anam_mae_idade;?></td></tr>
                                                                                            <tr><td >Mãe Profissão: <?php echo $anam_mae_prof;?></td><td colspan="2">Mãe Instrução: <?php echo $anam_mae_instr;?></td></tr>
                                                                                            <?php 
                                                                                                }

                                                                                                $anamn_sql_que = "SELECT * FROM anamnese_quei WHERE id_an = '".$id_anam."'";
                                                                                                $anamn_mostra_que = $cx->query ($anamn_sql_que);
                                                                                                    while ($anamn_que = $anamn_mostra_que->fetch()){
                                                                                                        $anam_qp = $anamn_que['qp'];
                                                                                                        $anam_qp_ini_q= $anamn_que['qp_ini_q'];
                                                                                                        $anam_qp_sub_prog = $anamn_que['qp_sub_prog'];
                                                                                                        $anam_qp_mud_afet = $anamn_que['qp_mud_afet'];
                                                                                                        $anam_qp_sint = $anamn_que['qp_sint'];
                                                                                                        $anam_qs= $anamn_que['qs'];

                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">QUEIXA </th></thead>
                                                                                            <tr><td>Queixa Pricipal:</td><td colspan="3"><?php echo $anam_qp;?></td></tr>
                                                                                            <tr><td>Inicio da queixa:</td><td colspan="3"><?php echo $anam_qp_ini_q;?></td></tr>
                                                                                            <tr><td>Súbita ou progressiva :</td><td colspan="3"><?php echo $anam_qp_sub_prog;?></td></tr>
                                                                                            <tr><td>Quais mudanças que ocorreram/ o que afetou:</td><td colspan="3"><?php echo $anam_qp_mud_afet;?></td></tr>
                                                                                            <tr><td>Sintomas:</td><td colspan="3"><?php echo $anam_qp_sint;?></td></tr>
                                                                                            <tr><td>Queixa Secundária:</td><td colspan="3"><?php echo $anam_qs;?></td></tr>
                                                                                            <?php 
                                                                                                    }

                                                                                                    $anamn_sql_hist_clin = "SELECT * FROM anamnese_hist_clin WHERE id_an = '".$id_anam."'";
                                                                                                    $anamn_mostra_hist_clin = $cx->query ($anamn_sql_hist_clin);
                                                                                                    while ($anamn_hist_clin = $anamn_mostra_hist_clin->fetch()){
                                                                                                        $anam_dc = $anamn_hist_clin['dc'];
                                                                                                        $anam_usa_med= $anamn_hist_clin['usa_med'];
                                                                                                        $anam_usa_med_quais= $anamn_hist_clin['usa_med_quais'];
                                                                                                        $anam_prob_card= $anamn_hist_clin['prob_card'];
                                                                                                        $anam_prob_card_qual = $anamn_hist_clin['prob_card_qual'];
                                                                                                        $anam_diab= $anamn_hist_clin['diab'];
                                                                                                        $anam_diab_tipo = $anamn_hist_clin['diab_tipo'];
                                                                                                        $anam_epilep= $anamn_hist_clin['epilep'];
                                                                                                        $anam_epilep_quando = $anamn_hist_clin['epilep_quando'];
                                                                                                        $anam_inter = $anamn_hist_clin['inter'];
                                                                                                        $anam_enfr = $anamn_hist_clin['enfr'];
                                                                                                        $anam_sint_fis_psi= $anamn_hist_clin['sint_fis_psi'];
                                                                                                        $anam_pffnp = $anamn_hist_clin['pffnp'];
                                                                                                        $anam_hab_ali= $anamn_hist_clin['hab_ali'];
                                                                                                        $anam_cond_nasc = $anamn_hist_clin['cond_nasc'];
                                                                                                        $anam_desenv_neuro = $anamn_hist_clin['desenv_neuro'];
                                                                                                        $anam_doen_inf = $anamn_hist_clin['doen_inf'];
                                                                                                        $anam_casos= $anamn_hist_clin['casos'];

                                                                                                        //ARRUMANDO USA REMEDIO
                                                                                                        if ($anam_usa_med == 'S'){
                                                                                                            $anam_usa_med = 'SIM';
                                                                                                        } else if ($anam_usa_med == 'N'){
                                                                                                            $anam_usa_med = 'NÃO';
                                                                                                        }

                                                                                                        //ARRUMANDO TEVE PROBLEMA CARDIACO
                                                                                                        if ($anam_prob_card == 'S'){
                                                                                                            $anam_prob_card = 'SIM';
                                                                                                        } else if ($anam_prob_card == 'N'){
                                                                                                            $anam_prob_card = 'NÃO';
                                                                                                        }

                                                                                                        //ARRUMANDO TEVE DIABETES
                                                                                                        if ($anam_diab == 'S'){
                                                                                                            $anam_diab = 'SIM';
                                                                                                        } else if ($anam_diab == 'N'){
                                                                                                            $anam_diab = 'NÃO';
                                                                                                        }

                                                                                                        //ARRUMANDO OCORRENCIA DE EPILEPSIA
                                                                                                        if ($anam_epilep == 'S'){
                                                                                                            $anam_epilep = 'SIM';
                                                                                                        } else if ($anam_epilep == 'N'){
                                                                                                            $anam_epilep = 'NÃO';
                                                                                                        }

                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">HISTÓRIA CLINICA </th></thead>
                                                                                            <tr><td>Doença Crônica:</td><td colspan="3"><?php echo $anam_dc;?></td></tr>
                                                                                            <tr><td>Toma Medicamentos?</td><td><?php echo $anam_usa_med;?></td><td colspan="2">Quais : <?php echo $anam_usa_med_quais;?></td></tr>
                                                                                            <tr><td>Já teve problemas cardiacos ?</td><td><?php echo $anam_prob_card;?></td><td colspan="2">Qual : <?php echo $anam_prob_card_qual;?></td></tr>
                                                                                            <tr><td>É Diabético ?</td><td><?php echo $anam_diab;?></td><td colspan="2">Tipo : <?php echo $anam_diab_tipo;?></td></tr>
                                                                                            <tr><td>Ocorrência de epilepsia? </td><td><?php echo $anam_epilep;?></td><td colspan="2">Quando : <?php echo $anam_epilep_quando;?></td></tr>
                                                                                            <tr><td>Casos de internação :</td><td colspan="3"><?php echo $anam_inter;?></td></tr>
                                                                                            <tr><td>Enfrentamento :</td><td colspan="3"><?php echo $anam_enfr;?></td></tr>
                                                                                            <tr><td>Sintomas fisicos e/ou psicologicos :</td><td colspan="3"><?php echo $anam_sint_fis_psi;?></td></tr>
                                                                                            <tr><td>Psicoterapia/fono/fisio/neuro/psiquiatria :</td><td colspan="3"><?php echo $anam_pffnp;?></td></tr>
                                                                                            <tr><td>Hábitos alimentares :</td><td colspan="3"><?php echo $anam_hab_ali;?></td></tr>
                                                                                            <tr><td colspan="4" style="text-align: center;">HISTÓRIA CLINICA / CRIANÇA OU ADOLESCENTE</td></tr>
                                                                                            <tr><td>Condições de nascimento :</td><td colspan="3"><?php echo $anam_cond_nasc;?></td></tr>
                                                                                            <tr><td>Desenvolvimento Neuropsicomotor :</td><td colspan="3"><?php echo $anam_desenv_neuro;?></td></tr>
                                                                                            <tr><td>Doenças infantis :</td><td colspan="3"><?php echo $anam_doen_inf;?></td></tr>
                                                                                            <tr><td>Casos de convulções, epilepsia, desmaios etc:</td><td colspan="3"><?php echo $anam_casos;?></td></tr>
                                                                                            <?php 
                                                                                                    }

                                                                                                    $anamn_sql_hf = "SELECT * FROM anamnese_hist_fam WHERE id_an = '".$id_anam."'";
                                                                                                    $anamn_mostra_hf = $cx->query ($anamn_sql_hf);
                                                                                                        while ($anamn_hf = $anamn_mostra_hf->fetch()){
                                                                                                            $anam_comp_fam = $anamn_hf['comp_fam'];
                                                                                                            $anam_din_fam = $anamn_hf['din_fam'];
                                                                                                            $anam_event_sig = $anamn_hf['event_sig'];
                                                                                                            $anam_rede_apo = $anamn_hf['rede_apo'];

                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">HISTÓRIA FAMILIAR</th></thead>
                                                                                            <tr><td>Composição Familiar (Genograma) :</td><td colspan="3"><?php echo $anam_comp_fam;?></td></tr>
                                                                                            <tr><td>Dinamica Familiar :</td><td colspan="3"><?php echo $anam_din_fam;?></td></tr>
                                                                                            <tr><td>Eventos significativos :</td><td colspan="3"><?php echo $anam_event_sig;?></td></tr>
                                                                                            <tr><td>Rede de apoio :</td><td colspan="3"><?php echo $anam_rede_apo;?></td></tr>
                                                                                            <?php 
                                                                                                        }
                                                                                                    $anamn_sql_hs = "SELECT * FROM anamnese_hist_soc WHERE id_an = '".$id_anam."'";
                                                                                                    $anamn_mostra_hs = $cx->query ($anamn_sql_hs);
                                                                                                        while ($anamn_hs = $anamn_mostra_hs->fetch()){
                                                                                                            $anam_info_social = $anamn_hs['info_social'];
                                                                                                            $anam_caso_rep = $anamn_hs['caso_rep'];
                                                                                                            $anam_area_dific = $anamn_hs['area_dific'];
                                                                                                            $anam_hab_est = $anamn_hs['hab_est'];
                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">HISTÓRIA SOCIAL </th></thead>
                                                                                            <tr><td colspan="4"><?php echo $anam_info_social;?></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">DADOS ESCOLARES </th></thead>
                                                                                            <tr><td>Casos de reprovação:</td><td colspan="3"><?php echo $anam_caso_rep;?></td></tr>
                                                                                            <tr><td>Áreas de dificuldade:</td><td colspan="3"><?php echo $anam_area_dific;?></td></tr>
                                                                                            <tr><td>Hábitos de estudo:</td><td colspan="3"><?php echo $anam_hab_est;?></td></tr>
                                                                                            <?php
                                                                                                        }

                                                                                                    $anamn_sql_hipno = "SELECT * FROM anamnese_hip WHERE id_an = '".$id_anam."'";
                                                                                                    $anamn_mostra_hipno = $cx->query ($anamn_sql_hipno);
                                                                                                    while ($anamn_hipno = $anamn_mostra_hipno->fetch()){
                                                                                                        $anam_hipnot = $anamn_hipno['hipnotizado'];
                                                                                                        $anam_quem = $anamn_hipno['quem'];
                                                                                                        $anam_motivo = $anamn_hipno['motivo'];
                                                                                                        $anam_acreditou= $anamn_hipno['acreditou'];
                                                                                                        $anam_hipno_pq = $anamn_hipno['hipno_pq'];
                                                                                                        $anam_mot_busc_hip= $anamn_hipno['mot_busc_hip'];

                                                                                                        //ARRUMANDO USA REMEDIO
                                                                                                        if ($anam_hipnot == 'S'){
                                                                                                            $anam_hipnot = 'SIM';
                                                                                                        } else if ($anam_hipnot == 'N'){
                                                                                                            $anam_hipnot = 'NÃO';
                                                                                                        }
                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">HIPNOTERAPIA</th></thead>
                                                                                            <tr><td>Alguém já tentou o hipnotizar?:</td><td colspan="3"><?php echo $anam_hipnot;?></td></td></tr>
                                                                                            <tr><td>Quem? :</td><td colspan="3"><?php echo $anam_quem;?></td></tr>
                                                                                            <tr><td>Motivo :</td><td colspan="3"><?php echo $anam_motivo;?></td></tr>
                                                                                            <tr><td>Você acredita que foi hipnotizado?</td><td colspan="3"><?php echo $anam_acreditou;?></td></tr>
                                                                                            <tr><td>Por quê? </td><td colspan="3"><?php echo $anam_hipno_pq;?></td></tr>
                                                                                            <tr><td>Motivos para buscar ajuda com a hipnose: :</td><td colspan="3"><?php echo $anam_mot_busc_hip;?></td></tr>
                                                                                            <?php 
                                                                                                        }
                                                                                                    $anamn_sql_consi_fin = "SELECT * FROM anamnese_consi_fin WHERE id_an = '".$id_anam."'";
                                                                                                    $anamn_mostra_consi_fin = $cx->query ($anamn_sql_consi_fin);
                                                                                                    while ($anamn_consi_fin = $anamn_mostra_consi_fin->fetch()){
                                                                                                        $anam_cons_final = $anamn_consi_fin['cons_final'];
                                                                                                        $anam_sug_enc = $anamn_consi_fin['sug_enc'];
                                                                                            ?>
                                                                                            <thead><th colspan="4" style="text-align: center;">CONSIDERAÇÕES FINAIS </th></thead>
                                                                                            <tr><td colspan="4"><?php echo $anam_cons_final;?></td></tr>

                                                                                            <thead><th colspan="4" style="text-align: center;">SUGESTÃO DE ENCAMINHAMENTO </th></thead>
                                                                                            <tr><td colspan="4"><?php echo $anam_sug_enc;?></td></tr>
                                                                                            <?php
                                                                                                    }
                                                                                            ?>

                                                                                        </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>  
                                                                <!-- Fim do modal para VIZUALIZAR ANAMNESE -->

                                                <?php
                                                }
                                                ?>

                                            <div id="diag">
                                                <form action="diagnostico_cad.php" method="post">    
                                                    <table class="table">
                                                        <tr><td align="right">Relato/ Reclamação do paciente:</td><td><textarea class="form-control-textarea" name="trelat"></textarea></td></tr>
                                                        <tr><td align="right">Diagnóstico:</td><td><textarea class="form-control-textarea" name="tdiag"></textarea></td></tr>
                                                        <tr><td align="right">Observações:</td><td><textarea class="form-control-textarea" name="obs"></textarea></td></tr>
                                                    </table>
                                                        <input type="hidden" name="tdata" value="<?php echo $datab;?>">
                                                        <input type="hidden" name="thora" value="<?php echo $hora_atual;?>">
                                                        <input type="hidden" name="tatend" value="<?php echo $atend;?>">
                                                        <input type="hidden" name="tidcli" value="<?php echo $idcli;?>">
                                                        <input type="hidden" name="tcpf" value="<?php echo $cpfcli;?>">
                                                        <input type="hidden" name="trg" value="<?php echo $rgcli;?>">
                                                        <input type="hidden" name="tcn" value="<?php echo $cncli;?>">
                                                        <input type="hidden" name="tpac" value="<?php echo $nomecli;?>">
                                                        <input type="hidden" name="tprof" value="<?php echo $profcli;?>">
                                                        <input type="hidden" name="tcrm" value="<?php echo $doutorcrm;?>">
                                                        <input type="hidden" name="tdoc" value="<?php echo $doutornome;?>">
                                                        <input type="hidden" name="tespec" value="<?php echo $doutorarea;?>">
                                                        <input type="hidden" name="trazao" value="<?php echo $razao;?>">
                                                        <input type="hidden" name="tcnpj" value="<?php echo $cnpj;?>">
                                                        <input type="hidden" name="tconv" value="<?php echo $conv_atendimento;?>">
                                                        <input type="hidden" name="tanam" value="<?php echo $id_anam;?>">
                                                        <p>
                                                            <input type="submit" value="Salvar e Continuar" class="btn btn-sm btn-primary">&nbsp;&nbsp;&nbsp;
                                                            <a href="dtr_atendimento.php" class="btn btn-sm btn-danger">Cancelar</a>
                                                        </p>
                                                </form>
                                            </div>
                            </div>
                            
                        </div>
                    <br>
                    <footer id="rodape">
                        <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                        <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                    </footer>
		</div>  
            

</body>
    <script src='../_javascript/bootstrap.min.js'></script>
    <script src='../_javascript/jquery.min.js'></script>
</html>
<?php
}else{
    header("location:../index.php");
}

?>
