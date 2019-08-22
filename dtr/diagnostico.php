<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']) {

    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c join clientes cli on cu.cpf_vinc = cli.cpf WHERE cnpj_c = '" . $cnpj . "' and pass='" . $pass . "' and usuario='" . $user . "'";
    $acesso_user = $cx->query($acesso);

    while ($perfil = $acesso_user->fetch()) {
	$id = $perfil['id_u_cnpj'];
	$nome = $perfil['nome_u'];
	$cnpju = $perfil['cnpj_vinc'];
	$razao = $perfil['razao_c'];
	$doutornome = $perfil['nome'];
	$tipodoc = $perfil['tipo_doc'];
	$doutorcrm = $perfil['crm'];
	$doutorcrmuf = $perfil['estado_crm'];
	$doutorarea = $perfil['area_m'];
    }
    
    if ($tipodoc != 'CRM'){
        $ocultareceita = 'oc';
    }

    //RECEBE DADOS DE diagnostico_cad.php 
    $atend = isset($_POST['atendimento']) ? $_POST['atendimento'] : 'Não funcionou';

    //BUSCA NO BANCO NA TABELA his_med AS INFORMAÇÕES REFERENTES AO NUMERO DO atendimento
    $mostra_sqlh = "SELECT * FROM his_med WHERE atendimento = '".$atend."' AND cnpj = '".$cnpj."'";
    $mostrah = $cx->query($mostra_sqlh);
    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
    while ($dadosh = $mostrah->fetch()) {
        $diag_atend = $dadosh['atendimento'];
        $diag_cliid = $dadosh['id_pac'];
        $diag_anamnese = $dadosh['id_an'];
        $diag_relato = $dadosh['relato'];
        $diag_diag = $dadosh['diagnostico'];
        $diag_obs = $dadosh['obs'];
        $diag_data = $dadosh['data_h'];
        $diag_hora = $dadosh['hora'];
        $diag_cpf = $dadosh['cpf'];
        $diag_pac = $dadosh['nome_pac'];
        $diag_prof = $dadosh['prof'];
        $ciddiv = $dadosh['ciddiv'];
        $cidcod = $dadosh['cidcod'];
        $ciddesc = $dadosh['ciddesc'];
        $atend_convenio = $dadosh['convenio'];

        if ($ciddiv == 'S') {
            $ciddiv = 'Autoriza a divulgação do CID: SIM';
        } else if ($ciddiv == 'N') {
            $ciddiv = 'Autoriza a divulgação do CID: NÃO';
        }

        if ($cidcod != '') {
            $botao = 'Editar';
        } else if ($cidcod == '') {
            $botao = 'Adicionar';
        }
    }
    
    //BUSCA NO BANCO NA TABELA clientes
    $mostra_sql = "SELECT * FROM clientes WHERE id != '' AND id = '".$diag_cliid."'";
    $mostra = $cx->query($mostra_sql);
    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
    while ($dados = $mostra->fetch()) {
        $nomecli = $dados['nome'];
        $cpfcli = $dados['cpf'];
        $rgcli = $dados['rg'];
        $cncli = $dados['certnasc'];
        $maecli = $dados['nome_mae'];
        $sexocli = $dados['sexo'];
        $cepcli = $dados['cep'];
        $logradourocli = $dados['logradouro'];
        $numerologcli = $dados['numerolog'];
        $bairrocli = $dados['bairro'];
        $cidadecli = $dados['cidade'];
        $estadocli = $dados['estado'];
        $profcli = $dados['prof'];
        $respcli = $dados['respnome'];
        $nasc = $dados['nascimento'];  
    }
    
    //BUSCA INFORMAÇÕES NA TABELA CONVENIO
    $conv_sql = "SELECT * FROM convenio WHERE empresa = '".$atend_convenio."' AND id_cli = '".$diag_cliid."'";
    $enviaconv_sql = $cx->query($conv_sql);
    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
    while ($convenio = $enviaconv_sql->fetch()) {
        $id_conv = $convenio['id_conv'];
        $conv = $convenio['empresa'];
        $numconv = $convenio['num_cart'];
    }
    
    //BUSCA NO BANCO NA TABELA atendimento
    $atend_sql = "SELECT ini_data, ini_hora FROM atendimento where id_atend = '".$atend."'";
    $atendmostra = $cx->query($atend_sql);
    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
    while ($atenddados = $atendmostra->fetch()) {
        $ini_data = $atenddados['ini_data'];
        $ini_hora = $atenddados['ini_hora'];
    }
    
    
    
    //RESERVA DE DATAS E HORA EM VARIEAVEIS
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    $hora_atual = date('H:i');
    $horab = date('H:i:s');//este para ser enviado para o banco
    $data = date('d/m/Y'); //esta para exibir na tela
    $datab = date('Y-m-d'); //este para ser enviado para o banco de dados
    // Separa em dia, mês e ano a data de nascimento
    list($anonasc, $mesnasc, $dianasc) = explode('-', $nasc);

    //-------------------------------------------------
    //CALCULANDO IDADE
    // Separa em dia, mês e ano
    list($ano, $mes, $dia) = explode('-', $nasc);

    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    //print $idade;
    //FIM DO CALCULO DE IDADE
    //-------------------------------------------------
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
    $cpfn = substr_replace($cpfcli, '.', 3, 0);
    $cpfn = substr_replace($cpfn, '.', 7, 0);
    $cpfn = substr_replace($cpfn, '-', 11, 0);

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
    $cnpjn = substr_replace($cnpju, '.', 2, 0);
    $cnpjn = substr_replace($cnpjn, '.', 6, 0);
    $cnpjn = substr_replace($cnpjn, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn, '-', 15, 0);
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
    $rgn = substr_replace($rgcli, '.', 2, 0);
    $rgn = substr_replace($rgn, '.', 6, 0);
    $rgn = substr_replace($rgn, '-', 10, 0);
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
                    }
                    
                    div#cid{
                        text-align: center;
                        width: 30%;
                        float: left;
                    }
                    
                    div#EncEspec{
                        width: 30%;
                        float: left;
                        border-left: 1px solid #666666 ;
                    }
                    
                    div#atestMed{
                        width: 30%;
                        border-left: 1px solid #666666;
                        float: left;
                    }
                    
                    div#emitir_pdf{
                        text-align: center;
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
                    
                    .form-control-sessao {
                        background-color: rgba(38,42,48,1);
                        color: rgb(255,255,255);
                        width: 100%;
                        height:200px;
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
                    
                    .form-control-text {
                        
                        width: 180px;
                        height:25px;
                        padding:6px 12px;
                        font-size:10pt;
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
                    
                    table {
                        font-family: Arial, sans-serif;
                        font-size: 10pt;
                        color: rgb(210,210,210);
                    }
                    
                    ul#blocopsicologia{
                        list-style: none;
                    }
                    
                    ul#blocopsicologia li#psic{
                        float: left;
                        width: 48%;
                    }
                    
                     
                </style>

        </head>
        <body>
            <div class="container-fluid theme-showcase estilo" role="main">
                <div class="logo1"></div>
                <div class="page-header">
                    <h1 align="center">Doutores </h1>
                </div>

                <div class="row">
                    <div class="col-md-12">
                            <div id="dadospacdoc">
                                <p align="center"><span class='banco'><?php echo $razao; ?> </span> &nbsp;&nbsp;&nbsp; CNPJ:<span class='banco'><?php echo $cnpjn; ?></span> </p>
                                <p align="center"><span class='banco'><?php echo strftime('%A, %d de %B de %Y', strtotime('today')); ?>&nbsp;&nbsp; - &nbsp;&nbsp;<?php echo $hora_atual; ?> </span></p>
                                <ul id="paccab">                                       
                                    <li>Dados do Paciente</li>
                                    <li>Convenio:<span class='banco'>&nbsp;<?php echo $atend_convenio; ?></span> </li>
                                    <li>Cartão Numero:<span class='banco'>&nbsp;<?php echo $numconv; ?></span> </li>
                                </ul>
                                <ul id="paccorpo">
                                    <li><span class='banco'><?php echo $nomecli; ?></span></li>
                                    <li>CPF:<span class='banco'>&nbsp;<?php echo $cpfn; ?></span></li>
                                    <li>RG:<span class='banco'>&nbsp;<?php echo $rgn; ?></span></li>
                                    <li>Profissão:<span class='banco'>&nbsp;<?php echo $profcli; ?></span></li>
                                    <li>Nascimento:<span class='banco'>&nbsp;<?php echo "$dianasc/$mesnasc/$anonasc ($idade Anos de idade)" ?></span></li>
                                    <li>Mãe:<span class='banco'>&nbsp;<?php echo $maecli; ?></span></li>
                                </ul>
                                <ul id="doccab">
                                    <li>Médico/ Doutor responsável</li>
                                </ul>
                                <ul id="doccorpo">
                                    <li><span class='banco'><?php echo $doutornome; ?></span></li>
                                    <li><?php echo $tipodoc;?>:&nbsp;<span class='banco'><?php echo $doutorcrm; ?></span></li>
                                    <li>Especialização:&nbsp;<span class='banco'><?php echo $doutorarea; ?></span></li>
                                    <li>Atendimento:&nbsp;<span class='banco'><?php echo $diag_atend; ?></span></li>
                                </ul>
                            </div>
                        
                            <?php
                            //ESTE IF OCULTA CASO O TIPO DO DOCUMENTO NÃO SEJA DO TIPO DE PSICOLOGIA  ? OU <button type='button' class='btn btn-xs btn-primary' data-toggle='modal' data-target='#modalanam'>Criar Novo</button>

                                if ($tipodoc == "CRP" || $tipodoc == "CRTH/BR" ){
                                    //VERIFICA SE HÁ ALGUMA ANAMNESE REGISTRADA
                                    $anam_sql = "SELECT id_pac, id_an FROM anamnese WHERE id_an = '".$diag_anamnese."' AND cnpj = '".$cnpj."' ORDER BY id_an DESC LIMIT 1 ";
                                    $anam_mostra = $cx->query ($anam_sql);
                                        while ($anam = $anam_mostra->fetch()){
                                            $id_anam = $anam['id_an'];
                                            $id_cli = $anam['id_pac'];
                                        }

                                        if ($id_cli == ""){
                                            $anam_msg = "NÃO EXISTE ANAMNESE CADASTRADA PARA ESTE PACIENTE, DESEJA CRIAR UMA ? <button type='button' class='btn btn-xs btn-primary' data-toggle='modal' data-target='#modalanam'>Adicionar</button>";
                                            $cor = "#3a1a1a";
                                            $status = "alert-danger";

                                                } else if ($id_cli != ""){
                                                    $anam_msg = "<span class='banco'>ANAMNESE ID:</span> $diag_anamnese - Visualizar <button type='button' class='btn btn-xs btn-warning' data-toggle='modal' data-target='#modalanamvisu'>Anamnese</button> ";
                                                    $cor = "#1f3a1a";
                                                    $status = "alert-success";
                                                }
                                    
                                    //CONTADOR DAS SESSÕES REALIZADAS
                                    $contsessaosql = "SELECT id_sessao, count(*) FROM relato_sessao WHERE id_pac != '' AND id_pac = '".$diag_cliid."' AND tipo_doc = '".$tipodoc."' AND doc = '".$doutorcrm."' AND cnpj = '".$cnpj."'";
                                    $recebe_contsessaosql = $cx->query ($contsessaosql);
                                    while ($contsessao = $recebe_contsessaosql->fetch()){
                                        $qtdsessao= $contsessao['count(*)'];
                                    }
                                    if ($qtdsessao == ''){
                                        $qtdsessao = "0";
                                    }           
                            ?>
                            <br><br><br><br><br><br><br><br>
                            <ul id="blocopsicologia">
                                <li id="psic">
                                    <div>
                                        <p><?php echo $anam_msg; ?></p>
                                        <p><span class="banco">QUANTIDADE DE SESSÕES REALIZADAS: </span> <?php echo $qtdsessao;?></p>
                                        <ul>
                                            <?php 
                                            //BUSCA REGISTRO DAS SESSÕES ANTERIORES, EM NOME DESTE PACIENTE COM ESSE DOUTOR
                                            $contador = $qtdsessao + 1; 
                                            
                                            $sessao_sql = "SELECT id_sessao, data_sessao, relato  FROM relato_sessao WHERE id_pac != '' AND id_pac = '".$diag_cliid."' AND tipo_doc = '".$tipodoc."' AND doc = '".$doutorcrm."' AND cnpj = '".$cnpj."' ORDER BY id_sessao DESC  ";
                                            $sessao_mostra = $cx->query ($sessao_sql);
                                                while ($sessao = $sessao_mostra->fetch()){
                                                    $contador--;
                                                    $sessao_id = $sessao['id_sessao'];
                                                    $sessao_data = $sessao['data_sessao'];
                                                    $sessao_relato = $sessao['relato'];

                                                    list($sessao_ano, $sessao_mes, $sessao_dia) = explode('-', $sessao_data);
                                                    $sessao_data = "$sessao_dia / $sessao_mes / $sessao_ano" ;
                                            ?>
                                            <li>
                                                Sessão <?php echo $contador;?> - Dia: <?php echo $sessao_data; ?> <button type='button' class='btn btn-xs btn-success' data-toggle='modal' data-target='#modalsessao<?php echo $sessao_id;?>'>Visualizar</button>
                                                    <!-- MODAL REFERENTE AO RELATO DE SESSÃO -->
                                                        <div class="modal fade" id="modalsessao<?php echo $sessao_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title text-center" id="myModalLabel">Relato da sessão: <?php echo $contador;?></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                            <table class="table">
                                                                                <tr><td >Dia : </td><td><?php echo $sessao_data;?></td></tr>
                                                                                <tr><td colspan="2"><?php echo nl2br("$sessao_relato");?></td></tr>
                                                                            </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    <!-- Fim do modal REFERENTE AO RELATO DE SESSÃO -->
                                            </li>
                                            <?php
                                                    }
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                                <li id="psic">
                                    <div>
                                        <p align="center">RELATO DE SESSÃO</p>
                                        <form method="post" action="cad_relato_sessao.php">
                                            <p><textarea class="form-control-sessao" name="relato" ></textarea></p>
                                        <input type="hidden" name='atendimento' value="<?php echo $atend; ?>">
                                        <input type="hidden" name='id_pac' value="<?php echo $diag_cliid; ?>">
                                        <input type="hidden" name='id_anam' value="<?php echo $diag_anamnese; ?>">
                                        <input type="hidden" name='cnpj' value="<?php echo $cnpju; ?>">
                                        <input type="hidden" name='doutor' value="<?php echo $doutornome; ?>">
                                        <input type="hidden" name='tipo_doc' value="<?php echo $tipodoc; ?>">
                                        <input type="hidden" name='doc' value="<?php echo $doutorcrm; ?>">
                                        <p align="right"><button type="submit" class="btn btn-xs btn-primary">Salvar Relato</button></p>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                            <br><br><br><br><br>
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
                                                                        <tr><td >Dia : </td><td><?php echo $data_atual;?></td><td>Hora: </td><td><?php echo $hora_atual;?></td></tr>
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
                                                                            <input type="hidden" name="tCliId" value="<?php echo $diag_cliid;?>">
                                                                            <input type="hidden" name="tAtend" value="<?php echo $diag_atend;?>">
                                                                            <input type="hidden" name="tCliCpf" value="<?php echo $cpfcli;?>">
                                                                            <input type="hidden" name="tCliRg" value="<?php echo $rgcli;?>">
                                                                            <input type="hidden" name="tCliCn" value="<?php echo $cncli;?>">
                                                                            <input type="hidden" name="tDoutNome" value="<?php echo $doutornome;?>">
                                                                            <input type="hidden" name="tTipoDoc" value="<?php echo $tipodoc;?>">
                                                                            <input type="hidden" name="tDocNum" value="<?php echo $doutorcrm;?>">
                                                                            <input type="hidden" name="tCNPJ" value="<?php echo $cnpju;?>">
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
                                                                        <tr><td>Dia da Inserção desta Anamnese: </td><td><?php echo $anam_dia;?></td><td>Hora: </td><td><?php echo $anam_hora;?></td></tr>
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
                            <table class="table">
                                <tr><td align="right">Relato/ Reclamação do paciente:</td><td><?php echo $diag_relato; ?></td><td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalrelato">Editar</button></td></tr>
                                <tr><td align="right">Diagnóstico:</td><td><?php echo $diag_diag; ?></td><td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaldiag">Editar</button></td></tr>
                                <tr><td align="right">Observações:</td><td><?php echo $diag_obs; ?></td><td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalobs">Editar</button></td></tr>
                                <tr class="<?php echo $ocultareceita;?>"><td align="right">Receita:</td>
                                        <td> 
                                            <?php
                                            //BUSCA NO BANCO NA TABELA receita AS RECEITAS REFERENTES AO NUMERO DO atendimento
                                            $mostra_sqlrec = "SELECT * FROM receita WHERE atendimento = '" . $atend . "' and cnpj = '" . $cnpj . "'";
                                            $mostrarec = $cx->query($mostra_sqlrec);
                                            //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                            while ($receita = $mostrarec->fetch()) {
                                                $id_rec = $receita['id_rec'];
                                                $editrem1 = $receita['remedio1'];
                                                $edittipo1 = $receita['tipouso1'];
                                                $editmodo1 = $receita['modouso1'];
                                                $editobs1 = $receita['obs1'];
                                                $editrem2 = $receita['remedio2'];
                                                $edittipo2 = $receita['tipouso2'];
                                                $editmodo2 = $receita['modouso2'];
                                                $editobs2 = $receita['obs2'];
                                                $editrem3 = $receita['remedio3'];
                                                $edittipo3 = $receita['tipouso3'];
                                                $editmodo3 = $receita['modouso3'];
                                                $editobs3 = $receita['obs3'];
                                                $editrem4 = $receita['remedio4'];
                                                $edittipo4 = $receita['tipouso4'];
                                                $editmodo4 = $receita['modouso4'];
                                                $editobs4 = $receita['obs4'];
                                                ?>
                                            <form method="post" action="pdf_receituario.php" target="blank">
                                                <input type="hidden" name="id_rec" value="<?php echo $id_rec; ?>">
                                                <p>ID <?php echo $id_rec; ?>&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modaleditrec<?php echo $id_rec; ?>">Editar</button>&nbsp;&nbsp;
                                                        <button type="submit" class="btn btn-xs btn-success">Vizualizar</button>
                                                </p>
                                            </form>
                                                <!-- MODAL REFERENTE À EDIÇÃO DA RECEITA -->
                                                <div class="modal fade" id="modaleditrec<?php echo $id_rec; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">Editar Medicação de Receita Normal ID <?php echo $id_rec; ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="receita_edit.php">
                                                                    <input type="hidden" name='data' value="<?php echo $datab; ?>">
                                                                    <input type="hidden" name='hora' value="<?php echo $horab; ?>">
                                                                    <input type="hidden" name='atend' value="<?php echo $atend; ?>">
                                                                    <input type="hidden" name='id_rec' value="<?php echo $id_rec; ?>">

                                                                    <p>Descreva a medicação para inserir na receita, total máximo por receita 4 medicações.</p>
                                                                    <table>
                                                                        <tr><td colspan="2" class="listacab">Descrição de medicação 01</td><td colspan="2" class="listacab">Descrição de medicação 02</td></tr>
                                                                        <tr><td>Modo de Uso:</td><td><input type="text" tabindex="1" class="form-control-text" name="modouso1" value="<?php echo $editmodo1; ?>" ></td><td>Modo de Uso:</td><td><input type="text" tabindex="5" class="form-control-text" name="modouso2" value="<?php echo $editmodo2; ?>"></td></tr>
                                                                        <tr><td>Medicação:</td><td><input type="text" tabindex="2" class="form-control-text" name="remedio1" value="<?php echo $editrem1; ?>"></td><td>Medicação:</td><td><input type="text" tabindex="6" class="form-control-text" name="remedio2" value="<?php echo $editrem2; ?>"></td></tr>
                                                                        <tr><td>Descrição de uso:</td><td><input type="text" tabindex="3" class="form-control-text" name="tipouso1" value="<?php echo $edittipo1; ?>"></td><td>Descrição de uso:</td><td><input type="text" tabindex="7" class="form-control-text" name="tipouso2" value="<?php echo $edittipo2; ?>"></td></tr>
                                                                        <tr><td>Observação:</td><td><input type="text" tabindex="4" class="form-control-text" name="obsrec1" value="<?php echo $editobs1; ?>"></td><td>Observação:</td><td><input type="text" tabindex="8" class="form-control-text" name="obsrec2" value="<?php echo $editobs2; ?>"></td></tr>

                                                                        <tr><td colspan="2" class="listacab">Descrição de medicação 03</td><td colspan="2" class="listacab">Descrição de medicação 04</td></tr>
                                                                        <tr><td>Modo de Uso:</td><td><input type="text" tabindex="9" class="form-control-text" name="modouso3" value="<?php echo $editmodo3; ?>"></td><td>Modo de Uso:</td><td><input type="text" tabindex="13" class="form-control-text" name="modouso4" value="<?php echo $editmodo4; ?>"></td></tr>
                                                                        <tr><td>Medicação:</td><td><input type="text" tabindex="10" class="form-control-text" name="remedio3" value="<?php echo $editrem3; ?>"></td><td>Medicação:</td><td><input type="text" tabindex="14" class="form-control-text" name="remedio4" value="<?php echo $editrem4; ?>"></td></tr>
                                                                        <tr><td>Descrição de uso:</td><td><input type="text" tabindex="11" class="form-control-text" name="tipouso3" value="<?php echo $edittipo3; ?>" ></td><td>Descrição de uso:</td><td><input type="text" tabindex="15" class="form-control-text" name="tipouso4" value="<?php echo $edittipo4; ?>"></td></tr>
                                                                        <tr><td>Observação:</td><td><input type="text" tabindex="12" class="form-control-text" name="obsrec3" value="<?php echo $editobs3; ?>"></td><td>Observação:</td><td><input type="text" tabindex="16" class="form-control-text" name="obsrec4" value="<?php echo $editobs4; ?>"></td></tr>
                                                                        <tr><td colspan="4"><button type="submit" tabindex="17" class="btn btn-xs btn-success">Salvar Modificação</button></td></tr>
                                                                    </table>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <!-- Fim do modal da edição da receita -->
                                                <?php
                                            }
                                            ?> 
                                        </td>
                                        <td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaladrec">Adicionar Receita</button></td>
                                </tr>
                                
                                <tr class="<?php echo $ocultareceita;?>">
                                    <td align="right">Receita Especial:</td>
                                    <td>
                                        <p>No caso de emição de receita especial, não esqueça de imprimir 2 (duas) vias </p>
                                        <?php
                                            //BUSCA NO BANCO NA TABELA receita_especial AS RECEITAS ESPECIAIS REFERENTES AO NUMERO DO atendimento
                                            $mostra_sqlrecespec = "SELECT * FROM receita_especial WHERE atendimento = '" . $atend . "' and cnpj = '" . $cnpj . "'";
                                            $mostrarecespec = $cx->query($mostra_sqlrecespec);
                                            //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                            while ($receitaespec = $mostrarecespec->fetch()) {
                                                $id_recespec = $receitaespec['id_rec_espec'];
                                                $editrem1espec = $receitaespec['remedio1'];
                                                $edittipo1espec = $receitaespec['tipouso1'];
                                                $editmodo1espec = $receitaespec['modouso1'];
                                                $editobs1espec = $receitaespec['obs1'];
                                                $editrem2espec = $receitaespec['remedio2'];
                                                $edittipo2espec = $receitaespec['tipouso2'];
                                                $editmodo2espec = $receitaespec['modouso2'];
                                                $editobs2espec = $receitaespec['obs2'];
                                                $editrem3espec = $receitaespec['remedio3'];
                                                $edittipo3espec = $receitaespec['tipouso3'];
                                                $editmodo3espec = $receitaespec['modouso3'];
                                                $editobs3espec = $receitaespec['obs3'];
                                                $editrem4espec = $receitaespec['remedio4'];
                                                $edittipo4espec = $receitaespec['tipouso4'];
                                                $editmodo4espec = $receitaespec['modouso4'];
                                                $editobs4espec = $receitaespec['obs4'];
                                                ?>
                                            
                                            <form method="post" action="pdf_receituario_especial.php" target="blank">
                                                <input type="hidden" name="id_rec_espec" value="<?php echo $id_recespec; ?>">
                                                <p>ID <?php echo $id_recespec; ?>&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modaleditrecespec<?php echo $id_recespec; ?>">Editar</button>&nbsp;&nbsp;
                                                        <button type="submit" class="btn btn-xs btn-success">Vizualizar</button>
                                                </p>
                                            </form>
                                                <!-- MODAL REFERENTE À EDIÇÃO DA RECEITA_ESPECIAL -->
                                                <div class="modal fade" id="modaleditrecespec<?php echo $id_recespec; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">Editar Medicação de Receita Especial ID <?php echo $id_recespec; ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="receita_espec_edit.php">
                                                                    <input type="hidden" name='data' value="<?php echo $datab; ?>">
                                                                    <input type="hidden" name='hora' value="<?php echo $horab; ?>">
                                                                    <input type="hidden" name='atend' value="<?php echo $atend; ?>">
                                                                    <input type="hidden" name='id_rec_espec' value="<?php echo $id_recespec; ?>">

                                                                    <p>Descreva a medicação para inserir na receita, total máximo por receita 4 medicações.</p>
                                                                    <table>
                                                                        <tr><td colspan="2" class="listacab">Descrição de medicação 01</td><td colspan="2" class="listacab">Descrição de medicação 02</td></tr>
                                                                        <tr><td>Modo de Uso:</td><td><input type="text" tabindex="1" class="form-control-text" name="modouso1" value="<?php echo $editmodo1espec; ?>" ></td><td>Modo de Uso:</td><td><input type="text" tabindex="5" class="form-control-text" name="modouso2" value="<?php echo $editmodo2espec; ?>"></td></tr>
                                                                        <tr><td>Medicação:</td><td><input type="text" tabindex="2" class="form-control-text" name="remedio1" value="<?php echo $editrem1espec; ?>"></td><td>Medicação:</td><td><input type="text" tabindex="6" class="form-control-text" name="remedio2" value="<?php echo $editrem2espec; ?>"></td></tr>
                                                                        <tr><td>Descrição de uso:</td><td><input type="text" tabindex="3" class="form-control-text" name="tipouso1" value="<?php echo $edittipo1espec; ?>"></td><td>Descrição de uso:</td><td><input type="text" tabindex="7" class="form-control-text" name="tipouso2" value="<?php echo $edittipo2espec; ?>"></td></tr>
                                                                        <tr><td>Observação:</td><td><input type="text" tabindex="4" class="form-control-text" name="obsrec1" value="<?php echo $editobs1espec; ?>"></td><td>Observação:</td><td><input type="text" tabindex="8" class="form-control-text" name="obsrec2" value="<?php echo $editobs2espec; ?>"></td></tr>

                                                                        <tr><td colspan="2" class="listacab">Descrição de medicação 03</td><td colspan="2" class="listacab">Descrição de medicação 04</td></tr>
                                                                        <tr><td>Modo de Uso:</td><td><input type="text" tabindex="9" class="form-control-text" name="modouso3" value="<?php echo $editmodo3espec; ?>"></td><td>Modo de Uso:</td><td><input type="text" tabindex="13" class="form-control-text" name="modouso4" value="<?php echo $editmodo4espec; ?>"></td></tr>
                                                                        <tr><td>Medicação:</td><td><input type="text" tabindex="10" class="form-control-text" name="remedio3" value="<?php echo $editrem3espec; ?>"></td><td>Medicação:</td><td><input type="text" tabindex="14" class="form-control-text" name="remedio4" value="<?php echo $editrem4espec; ?>"></td></tr>
                                                                        <tr><td>Descrição de uso:</td><td><input type="text" tabindex="11" class="form-control-text" name="tipouso3" value="<?php echo $edittipo3espec; ?>" ></td><td>Descrição de uso:</td><td><input type="text" tabindex="15" class="form-control-text" name="tipouso4" value="<?php echo $edittipo4espec; ?>"></td></tr>
                                                                        <tr><td>Observação:</td><td><input type="text" tabindex="12" class="form-control-text" name="obsrec3" value="<?php echo $editobs3espec; ?>"></td><td>Observação:</td><td><input type="text" tabindex="16" class="form-control-text" name="obsrec4" value="<?php echo $editobs4espec; ?>"></td></tr>
                                                                        <tr><td colspan="4"><button type="submit" tabindex="17" class="btn btn-xs btn-success">Salvar Modificação</button></td></tr>
                                                                    </table>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <!-- Fim do modal da edição da receita_especial -->
                                                <?php
                                            }
                                            ?> 
                                    </td>
                                    <td><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaladrecespec">Adicionar Receita</button></td>
                                </tr>
                            </table>
                        <div id="cid">
                            <h4>Divulgação do C.I.D.</h4>
                                <form method="post" action="cid.php">
                                    <input type="hidden" name='atend' value="<?php echo $atend; ?>">
                                    <p><?php echo $ciddiv; ?></p>
                                    <p>CID : &nbsp;<?php echo "$cidcod - $ciddesc"; ?> &nbsp;<button type="submit" class="btn btn-xs btn-primary"><?php echo $botao; ?></button> </p>
                                </form>
                        </div>
                        <div id="emitir_pdf">
                            <div id="EncEspec">
                                <h4>Encaminhamentos para Especialidades</h4>
                                
                                    <?php
                                    $especsql = "SELECT * FROM enc_espec WHERE atendimento = '" . $atend . "'";
                                    $especsqlexec = $cx->query($especsql);
                                    while ($espec = $especsqlexec->fetch()) {
                                        $especid = $espec['id_enc'];
                                        $especenc = $espec['especialidade'];
                                        ?>
                                        <form method="post" action="pdf_enc_especialidade.php" target="blank"> 
                                            <input type="hidden" name='atendimento' value="<?php echo $atend; ?>">
                                            <input type="hidden" name='id_espec' value="<?php echo $especid; ?>">
                                                <p>
                                                    ID: <?php echo $especid; ?> - Espec: <?php echo $especenc; ?>&nbsp;
                                                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalespecedit<?php echo $especid; ?>">Editar</button>
                                                        <button type="submit" class="<?php echo $botaovizu; ?> btn btn-xs btn-success">Visualizar</button>
                                                </p>
                                        </form>
                                        <!-- MODAL REFERENTE À EDIÇÃO DE ENCAMINHAMENTO PARA ESPECIALIDADE -->
                                        <div class="modal fade" id="modalespecedit<?php echo $especid; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title text-center" id="myModalLabel">Encaminhamento Especialidade ID <?php echo $especid; ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="enc_espec_edit.php">
                                                            <input type="hidden" name='atendimento' value="<?php echo $atend; ?>">
                                                            <input type="hidden" name='id_espec' value="<?php echo $especid; ?>">
                                                            <input type="hidden" name='data_atual' value="<?php echo $datab; ?>">
                                                            <input type="hidden" name='hora_atual' value="<?php echo $horab; ?>">
                                                            <textarea class="form-control" name="especialidade"><?php echo $especenc; ?></textarea><br>
                                                            <button type="submit" class="btn btn-xs btn-success">Salvar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fim do modal da edição do encaminhamento para especialidade -->
                                    <?php } ?>
                                <p><button type="submit" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalespec">Adicionar</button></p>
                            </div>
                                
                            <div id="atestMed">
                                <h4>Atestado Médico </h4>
                                <?php
                                $atestsql = "SELECT id_atest, dias_afastado FROM atestados WHERE atendimento = '" . $atend . "'";
                                $atestsqlexec = $cx->query($atestsql);
                                while ($atestado = $atestsqlexec->fetch()) {
                                    $atestid = $atestado['id_atest'];
                                    $diasafast = $atestado['dias_afastado'];
                                }

                                if ($atestid == '') {
                                    $botaoatest = '';
                                } else {
                                    $botaoatest = 'hidden';
                                }

                                if ($atestid == ''){
                                    $botaovizu = 'hidden';
                                } else {
                                    $botaovizu = '';
                                }

                                ?>
                                <form method="post" action="pdf_atestado.php" target="blank">
                                        <input type="hidden" name="atendimento" value="<?php echo $atend; ?>">
                                        <input type="hidden" name="atestado" value="<?php echo $atestid; ?>">
                                        <p>Atestado Médico:&nbsp; ID &nbsp;<?php echo $atestid; ?>&nbsp;
                                            <button type="button" class="<?php echo $botaovizu; ?> btn btn-xs btn-primary" data-toggle="modal" data-target="#modalatestadoedit">Editar</button>
                                            <button type="submit" class="<?php echo $botaovizu; ?> btn btn-xs btn-success">Visualizar</button>
                                            <button type="button" class="<?php echo $botaoatest; ?> btn btn-xs btn-primary" data-toggle="modal" data-target="#modalatestado">Adicionar</button></p>
                                </form>
                            </div>
                        </div>
                        <div>
                            <br><br><br><br><br><br>
                            <form action="dtr_atend_finalizar.php" method="post">
                                    <input type="hidden" value="<?php echo $horab; ?>" name="hora_final" >
                                    <input type="hidden" value="<?php echo $datab; ?>" name="data_final">
                                    <input type="hidden" value="<?php echo $atend; ?>" name="atendimento">
                                    <p align="center"><input type="submit" value="Salvar e Finalizar" class="btn btn-sm btn-primary"></p>
                            </form>
                        </div>

                        <!-- Inicio Modal -->
                        
                        
                        <!-- MODAL REFERENTE À EDIÇÃO DO RELATO -->
                        <div class="modal fade" id="modalrelato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Relato/Reclamação do Paciente</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="diag_edit_relato.php">
                                            <input type="hidden" name='atendimento' value="<?php echo $atend;?>">
                                            <textarea class="form-control" name="relato"><?php echo $diag_relato; ?></textarea><br>
                                            <button type="submit" class="btn btn-xs btn-success">Salvar Alteração</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal do relato -->
                        
                        <!-- MODAL REFERENTE À EDIÇÃO DO DIAGNOSTICO -->
                        <div class="modal fade" id="modaldiag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Diagnóstico</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="diag_edit_diagnostico.php">
                                            <input type="hidden" name='atendimento' value="<?php echo $atend;?>">
                                            <textarea class="form-control" name="diagnostico"><?php echo $diag_diag; ?></textarea><br>
                                            <button type="submit" class="btn btn-xs btn-success">Salvar Alteração</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal do diagnostico -->
                        
                        <!-- MODAL REFERENTE À EDIÇÃO DO OBSERVAÇÕES -->
                        <div class="modal fade" id="modalobs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Observações</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="diag_edit_obs.php">
                                            <input type="hidden" name='atendimento' value="<?php echo $atend;?>">
                                            <textarea class="form-control" name="obs"><?php echo $diag_obs; ?></textarea><br>
                                            <button type="submit" class="btn btn-xs btn-success">Salvar Alteração</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal do observações -->
                        
                        <!-- MODAL REFERENTE À ADIÇÃO DE NOVA RECEITA -->
                        <div class="modal fade" id="modaladrec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Medicação para Receita Normal</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="receita_cad.php">
                                            <input type="hidden" name='nome' value="<?php echo $nomecli;?>">
                                            <input type="hidden" name='cliid' value="<?php echo $diag_cliid;?>"> 
                                            <input type="hidden" name='cpf' value="<?php echo $cpfcli;?>"> 
                                            <input type="hidden" name='rg' value="<?php echo $rgcli;?>"> 
                                            <input type="hidden" name='cn' value="<?php echo $cncli;?>"> 
                                            <input type="hidden" name='sexo' value="<?php echo $sexocli;?>"> 
                                            <input type="hidden" name='nasc' value="<?php echo $nasc;?>"> 
                                            <input type="hidden" name='respcli' value="<?php echo $maecli;?>">
                                            <input type="hidden" name='cep' value="<?php echo $cepcli;?>">
                                            <input type="hidden" name='logradouro' value="<?php echo $logradourocli;?>">
                                            <input type="hidden" name='numlog' value="<?php echo $numerologcli;?>">
                                            <input type="hidden" name='bairro' value="<?php echo $bairrocli;?>">
                                            <input type="hidden" name='cidade' value="<?php echo $cidadecli;?>">
                                            <input type="hidden" name='estado' value="<?php echo $estadocli;?>">
                                            <input type="hidden" name='crm' value="<?php echo $doutorcrm;?>">
                                            <input type="hidden" name='doutor' value="<?php echo $doutornome;?>">
                                            <input type="hidden" name='razao' value="<?php echo $razao;?>">
                                            <input type="hidden" name='data' value="<?php echo $datab;?>">
                                            <input type="hidden" name='hora' value="<?php echo $horab;?>">
                                            <input type="hidden" name='atend' value="<?php echo $atend;?>">
                                            <input type="hidden" name='conv' value="<?php echo $conv;?>">
                                            <input type="hidden" name='carteira' value="<?php echo $numconv;?>">
                                            
                                            <p>Descreva a medicação para inserir na receita, total máximo por receita 4 medicações.</p>
                                            <table>
                                                <tr><td colspan="2" class="listacab">Descrição de medicação 01</td><td colspan="2" class="listacab">Descrição de medicação 02</td></tr>
                                                <tr><td>Modo de Uso:</td><td><input type="text" tabindex="1" class="form-control-text" name="modouso1" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td><td>Modo de Uso:</td><td><input type="text" tabindex="5" class="form-control-text" name="modouso2" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td></tr>
                                                <tr><td>Medicação:</td><td><input type="text" tabindex="2" class="form-control-text" name="remedio1"></td><td>Medicação:</td><td><input type="text" tabindex="6" class="form-control-text" name="remedio2"></td></tr>
                                                <tr><td>Descrição de uso:</td><td><input type="text" tabindex="3" class="form-control-text" name="tipouso1"></td><td>Descrição de uso:</td><td><input type="text" tabindex="7" class="form-control-text" name="tipouso2"></td></tr>
                                                <tr><td>Observação:</td><td><input type="text" tabindex="4" class="form-control-text" name="obsrec1"></td><td>Observação:</td><td><input type="text" tabindex="8" class="form-control-text" name="obsrec2"></td></tr>
                                                
                                                <tr><td colspan="2" class="listacab">Descrição de medicação 03</td><td colspan="2" class="listacab">Descrição de medicação 04</td></tr>
                                                <tr><td>Modo de Uso:</td><td><input type="text" tabindex="9" class="form-control-text" name="modouso3" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td><td>Modo de Uso:</td><td><input type="text" tabindex="13" class="form-control-text" name="modouso4" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td></tr>
                                                <tr><td>Medicação:</td><td><input type="text" tabindex="10" class="form-control-text" name="remedio3"></td><td>Medicação:</td><td><input type="text" tabindex="14" class="form-control-text" name="remedio4"></td></tr>
                                                <tr><td>Descrição de uso:</td><td><input type="text" tabindex="11" class="form-control-text" name="tipouso3"></td><td>Descrição de uso:</td><td><input type="text" tabindex="15" class="form-control-text" name="tipouso4"></td></tr>
                                                <tr><td>Observação:</td><td><input type="text" tabindex="12" class="form-control-text" name="obsrec3"></td><td>Observação:</td><td><input type="text" tabindex="16" class="form-control-text" name="obsrec4"></td></tr>
                                                <tr><td colspan="4"><button type="submit" tabindex="17" class="btn btn-xs btn-success">Adicionar</button></td></tr>
                                            </table>
                                        </form>
                                    </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal da adição de nova receita -->
                        
                        
                        <!-- MODAL REFERENTE À ADIÇÃO DE NOVA RECEITA_ESPECIAL -->
                        <div class="modal fade" id="modaladrecespec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Medicação para Receita Especial</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="receita_espec_cad.php">
                                            <input type="hidden" name='nome' value="<?php echo $nomecli;?>">
                                            <input type="hidden" name='cliid' value="<?php echo $diag_cliid;?>"> 
                                            <input type="hidden" name='cpf' value="<?php echo $cpfcli;?>"> 
                                            <input type="hidden" name='rg' value="<?php echo $rgcli;?>"> 
                                            <input type="hidden" name='cn' value="<?php echo $cncli;?>"> 
                                            <input type="hidden" name='sexo' value="<?php echo $sexocli;?>"> 
                                            <input type="hidden" name='nasc' value="<?php echo $nasc;?>"> 
                                            <input type="hidden" name='respcli' value="<?php echo $maecli;?>">
                                            <input type="hidden" name='cep' value="<?php echo $cepcli;?>">
                                            <input type="hidden" name='logradouro' value="<?php echo $logradourocli;?>">
                                            <input type="hidden" name='numlog' value="<?php echo $numerologcli;?>">
                                            <input type="hidden" name='bairro' value="<?php echo $bairrocli;?>">
                                            <input type="hidden" name='cidade' value="<?php echo $cidadecli;?>">
                                            <input type="hidden" name='estado' value="<?php echo $estadocli;?>">
                                            <input type="hidden" name='crm' value="<?php echo $doutorcrm;?>">
                                            <input type="hidden" name='crmuf' value="<?php echo $doutorcrmuf;?>">
                                            <input type="hidden" name='doutor' value="<?php echo $doutornome;?>">
                                            <input type="hidden" name='razao' value="<?php echo $razao;?>">
                                            <input type="hidden" name='data' value="<?php echo $datab;?>">
                                            <input type="hidden" name='hora' value="<?php echo $horab;?>">
                                            <input type="hidden" name='atend' value="<?php echo $atend;?>">
                                            <input type="hidden" name='conv' value="<?php echo $conv;?>">
                                            <input type="hidden" name='carteira' value="<?php echo $numconv;?>">
                                            
                                            <p>Descreva a medicação para inserir na receita, total máximo por receita 4 medicações.</p>
                                            <table>
                                                <tr><td colspan="2" class="listacab">Descrição de medicação 01</td><td colspan="2" class="listacab">Descrição de medicação 02</td></tr>
                                                <tr><td>Modo de Uso:</td><td><input type="text" tabindex="1" class="form-control-text" name="modouso1" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td><td>Modo de Uso:</td><td><input type="text" tabindex="5" class="form-control-text" name="modouso2" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td></tr>
                                                <tr><td>Medicação:</td><td><input type="text" tabindex="2" class="form-control-text" name="remedio1"></td><td>Medicação:</td><td><input type="text" tabindex="6" class="form-control-text" name="remedio2"></td></tr>
                                                <tr><td>Descrição de uso:</td><td><input type="text" tabindex="3" class="form-control-text" name="tipouso1"></td><td>Descrição de uso:</td><td><input type="text" tabindex="7" class="form-control-text" name="tipouso2"></td></tr>
                                                <tr><td>Observação:</td><td><input type="text" tabindex="4" class="form-control-text" name="obsrec1"></td><td>Observação:</td><td><input type="text" tabindex="8" class="form-control-text" name="obsrec2"></td></tr>
                                                
                                                <tr><td colspan="2" class="listacab">Descrição de medicação 03</td><td colspan="2" class="listacab">Descrição de medicação 04</td></tr>
                                                <tr><td>Modo de Uso:</td><td><input type="text" tabindex="9" class="form-control-text" name="modouso3" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td><td>Modo de Uso:</td><td><input type="text" tabindex="13" class="form-control-text" name="modouso4" placeholder="USO ORAL, AÉREA, PARENTAL ..."></td></tr>
                                                <tr><td>Medicação:</td><td><input type="text" tabindex="10" class="form-control-text" name="remedio3"></td><td>Medicação:</td><td><input type="text" tabindex="14" class="form-control-text" name="remedio4"></td></tr>
                                                <tr><td>Descrição de uso:</td><td><input type="text" tabindex="11" class="form-control-text" name="tipouso3"></td><td>Descrição de uso:</td><td><input type="text" tabindex="15" class="form-control-text" name="tipouso4"></td></tr>
                                                <tr><td>Observação:</td><td><input type="text" tabindex="12" class="form-control-text" name="obsrec3"></td><td>Observação:</td><td><input type="text" tabindex="16" class="form-control-text" name="obsrec4"></td></tr>
                                                <tr><td colspan="4"><button type="submit" tabindex="17" class="btn btn-xs btn-success">Adicionar</button></td></tr>
                                            </table>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Fim do modal da adição de nova receita_especial -->
                        
                        <!-- MODAL REFERENTE À ADIÇÃO DE ENCAMINHAMENTO DE ESPECIALIDADE -->
                        <div class="modal fade" id="modalespec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Encaminhamento Especialidade</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="enc_espec_cad.php">
                                            <input type="hidden" name='atendimento' value="<?php echo $atend;?>">
                                            <input type="hidden" name='nomepac' value="<?php echo $diag_pac;?>">
                                            <input type="hidden" name='idpac' value="<?php echo $diag_cliid;?>">
                                            <input type="hidden" name='cpfpac' value="<?php echo $cpfcli;?>">
                                            <input type="hidden" name='rgpac' value="<?php echo $rgcli;?>">
                                            <input type="hidden" name='cnpac' value="<?php echo $cncli;?>">
                                            <input type="hidden" name='sexopac' value="<?php echo $sexocli;?>">
                                            <input type="hidden" name='nascpac' value="<?php echo $nasc;?>">
                                            <input type="hidden" name='convenio' value="<?php echo $conv;?>">
                                            <input type="hidden" name='carteira' value="<?php echo $numconv;?>">
                                            <input type="hidden" name='resp_nome' value="<?php echo $maecli;?>">
                                            <input type="hidden" name='data_atual' value="<?php echo $datab;?>">
                                            <input type="hidden" name='hora_atual' value="<?php echo $horab;?>">
                                            <input type="hidden" name='tipodoc' value="<?php echo $tipodoc;?>">
                                            <input type="hidden" name='doutorcrm' value="<?php echo $doutorcrm;?>">
                                            <input type="hidden" name='doutor' value="<?php echo $doutornome;?>">
                                            <input type="hidden" name='razao' value="<?php echo $razao;?>">
                                            <textarea class="form-control" name="especialidade" placeholder="Coloque aqui a especialidade"></textarea><br>
                                            <button type="submit" class="btn btn-xs btn-success">Salvar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal do encaminhamento de especialidade -->
                        
                        <!-- MODAL REFERENTE À ADIÇÃO DO ATESTADO -->
                        <div class="modal fade" id="modalatestado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Atestado</h4>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <form method="post" action="atestado_cad.php">
                                            <input type="hidden" name='atendimento' value="<?php echo $atend;?>">
                                            <input type="hidden" name='idpac' value="<?php echo $diag_cliid;?>">
                                            <input type="hidden" name='nome' value="<?php echo $diag_pac;?>">
                                            <input type="hidden" name='cpfpac' value="<?php echo $cpfcli;?>">
                                            <input type="hidden" name='rgpac' value="<?php echo $rgcli;?>">
                                            <input type="hidden" name='cnpac' value="<?php echo $cncli;?>">
                                            <input type="hidden" name='tipodoc' value="<?php echo $tipodoc;?>">
                                            <input type="hidden" name='crm' value="<?php echo $doutorcrm;?>">
                                            <input type="hidden" name='doutor' value="<?php echo $doutornome;?>">
                                            <input type="hidden" name='razao' value="<?php echo $razao;?>">
                                            <table>
                                                <tr><td>Data Inicial:</td><td><input type="date" name='data_ini' class="form-control" value="<?php echo $ini_data;?>"></td><td>Hora inicial:</td><td> <input type="time" name='hora_ini' class="form-control" value="<?php echo $ini_hora;?>"></td></tr>
                                                <tr><td>Data Final:  </td><td><input type="date" name='data_atual' class="form-control" value="<?php echo $datab;?>"></td><td>Hora Final: </td><td><input type="time" name='hora_atual' class="form-control" value="<?php echo $horab;?>"></td></tr>
                                                <tr><td colspan="4">
                                                        <p><input type="radio" name="atestado" id="afastado" value="Deverá pernacer afastado de suas atividades por dia(s) a contar desta data." ><label for="afastado">Deverá pernacer afastado de suas atividades por <input type="text" name="dias" size="2"> dia(s) a contar desta data.</label></p>
                                                        <p><input type="radio" name="atestado" id="naoafastado" value="Deverá retornar ao serviço" checked><label for="naoafastado">Deverá retornar ao serviço</label> </p>
                                                    </td></tr>
                                                <tr><td colspan="4"><button type="submit" class="btn btn-xs btn-success">Gerar</button></td></tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal do atestado -->
                        
                        <!-- MODAL REFERENTE À EDIÇÃO DO ATESTADO -->
                        <div class="modal fade" id="modalatestadoedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Editar Atestado</h4>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <form method="post" action="atestado_edit.php">
                                            <input type="hidden" name='atendimento' value="<?php echo $atend;?>">
                                            <input type="hidden" name='idatestado' value="<?php echo $atestid;?>">
                                            <table>
                                                <tr><td>Data Inicial:</td><td><input type="date" name='data_ini' class="form-control" value="<?php echo $ini_data;?>"></td><td>Hora inicial:</td><td> <input type="time" name='hora_ini' class="form-control" value="<?php echo $ini_hora;?>"></td></tr>
                                                <tr><td>Data Final:  </td><td><input type="date" name='data_atual' class="form-control" value="<?php echo $datab;?>"></td><td>Hora Final: </td><td><input type="time" name='hora_atual' class="form-control" value="<?php echo $horab;?>"></td></tr>
                                                <tr><td colspan="4">
                                                        <p><input type="radio" name="atestado" id="afastadoe" value="Deverá pernacer afastado de suas atividades por dia(s) a contar desta data." ><label for="afastadoe">Deverá pernacer afastado de suas atividades por <input type="text" name="dias" size="2"> dia(s) a contar desta data.</label></p>
                                                        <p><input type="radio" name="atestado" id="naoafastadoe" value="Deverá retornar ao serviço"><label for="naoafastadoe">Deverá retornar ao serviço </label> </p>
                                                </td></tr>
                                                <tr><td colspan="4"><button type="submit" class="btn btn-xs btn-success">Salvar</button></td></tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal da edição do atestado -->
                        
                        <!-- Fim Modal -->
                    
                    </div>
                
                <br>
                <footer id="rodape">
                    <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                        <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                </footer>
                </div>
            </div>  
        </body>
        <script src='../_javascript/bootstrap.min.js'></script>
        <script src='../_javascript/jquery.min.js'></script>
    </html>
    <?php
} else {
    header("location:../index.php");
}
?>