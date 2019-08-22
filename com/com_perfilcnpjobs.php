<?php
session_start();
include '../_php/cx.php';
include 'com_menunav.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "select id_u_cnpj, cu.nome_u from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
    $acesso_user = $cx->query ($acesso);

    while ($perfil = $acesso_user->fetch()){
        $nome = $perfil['nome_u'];
        $id_user = $perfil['id_u_cnpj'];
     } 

//RECEBE cnpj VINDO DA TELA HOME_CLI
 $idcnpj = isset($_POST['idcnpj'])?$_POST['idcnpj']:'';
 $cnpjclirecebe = isset($_POST['cnpjcli'])?$_POST['cnpjcli']:'';
 $msgerro = isset($_POST['erro'])?$_POST['erro']:'';
 
//BUSCA DADOS DO CLIENTE COM O CNPJ INFORMADO ACIMA
$clisql = "SELECT id_c, id_m, razao_c, cnpj_c, nfantasia_c  FROM cnpj WHERE id_c = '".$idcnpj."' or cnpj_c = '".$cnpjclirecebe."' limit 1";
$enviacli = $cx->query ($clisql);

while ($cli = $enviacli->fetch()){
    $cliid = $cli['id_c'];
    $clirazao = $cli['razao_c'];
    $clifantasia = $cli['nfantasia_c'];
    $clicnpj = $cli['cnpj_c'];
    $id_m = $cli['id_m'];
} 
 
 
//MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
    $cnpjn = substr_replace($clicnpj, '.', 2, 0);
    $cnpjn = substr_replace($cnpjn, '.', 6, 0);
    $cnpjn = substr_replace($cnpjn, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn, '-', 15, 0);
    
$hora_atual = date('H:i');
$data_atual = date('d / m / Y');
        
    ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Comercial</title>
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/com.css" rel="stylesheet" type="text/css"/>
        <link href='../_css/bootstrap.min.css' rel='stylesheet'>
        <style>
            /* MENUS DE NAVEGAÇÃO */
            button#navegador {
                color: #fff;
                background: transparent;
                border-color: transparent;
                width: 100%;
                padding:10px 15px;
            }
            
            button#navegador:hover {
                color: #0ed3b5;
                background: transparent;
                border-color: transparent;
                width: 100%;
                height: 100%;
            }
            
            .nav{
                padding-left:0;
                margin-bottom:0;
                list-style:none;
            }
            .nav>li{
                position:relative;
                display:block;
            }
            
            .nav>li>form{
                position:relative;
                display:block;
               
            }

            .nav>li>form:focus,.nav>li>form:hover{
                text-decoration:none;
                background-color:#eee;
            }

            .nav>li.disabled>form{
                color:#777;
            }

            .nav>li.disabled>form:focus,.nav>li.disabled>form:hover{
                color:#777;
                text-decoration:none;
                cursor:not-allowed;
                background-color:transparent;
            }

            .nav .open>form,.nav .open>form:focus,.nav .open>form:hover{
                background-color:#eee;
                border-color:#337ab7;
            }

            .nav .nav-divider{
                height:1px;
                margin:9px 0;
                overflow:hidden;
                background-color:#e5e5e5;
            }

            .nav>li>form>img{
                max-width:none;
            }

            .nav-tabs {
                border-bottom:1px solid #ddd;
            }

            .nav-tabs>li{
                float:left;
                margin-bottom: -1px;
            }

            .nav-tabs>li>form{
                margin-right:2px;
                line-height:1.42857143;
                border:1px solid rgb(122, 121, 121);
                border-radius:4px 4px 0 0;
                background-color:rgba(96,96,96,.5);
            }

            .nav-tabs>li>form:hover{
                border-color:rgba(85, 129, 130, .5);
                background-color:rgba(85, 129, 130, .5);
            }

            .nav-tabs>li.active>form,.nav-tabs>li.active>form:focus,.nav-tabs>li.active>form:hover{
                color:#e0e0e0;
                cursor:default;
                background-color:rgb(122, 121, 121);
                border:1px solid rgb(122, 121, 121);
                border-bottom-color:rgb(122, 121, 121);
            }

            .nav-tabs.nav-justified{
                width:100%;
                border-bottom:0;
            }

            .nav-tabs.nav-justified>li{
                float:none;
            }

            .nav-tabs.nav-justified>li>form{
                margin-bottom:5px;
                text-align:center;
            }
            
            /* ALTERA AS CONFIGURAÇÕES de plano de fundo da janela modal*/
            .modal-backdrop {
                background-color: #1C1C1C;
            }

            
            
            /*DIV ESQUERDA E DIREITA*/
            div#esquerda{
                float: left;
                width: 40%;
            }

            div#direita{
                float: right;
                width: 60%;
            }
            
            .form-control-textarea {
                background-color: rgba(38,42,48,1);
                color: rgb(255,255,255);
                width: 400px;
                height:130px;
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
            
            .form-control-valor{
                background-color: rgba(38,42,48,1);
                color: rgb(255,255,255);
                width: 70%;
                height:30px;
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
            
            .diahoraneg {
                display: block;
                position: relative;
                float: right;
                top: -130px;
                margin: 8px;
                padding: 5px;
            }

            .observacao {
                display: block;
                position: relative;
                width: 60%;
                margin: 8px;
                padding: 5px;
            }

            .valortotal{
                color:  #0ed3b5;
                font-family: Arial, sans-serif;
                font-size: 24pt;
                font-weight: bold;
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
            
            .modal-content thead th{
                background-color: rgb(38,42,48);
                color: rgba(255,255,255,1);
            }
            
        </style>
        <script src='../_javascript/bootstrap.min.js'></script>
        <script src='../_javascript/jquery.min.js'></script>
        <script>
            function calcular() {
                var num1 = Number(document.getElementById("num1").value);
                var num2 = Number(document.getElementById("num2").value);
                var elemResult = document.getElementById("resultado");

                if (elemResult.textContent === undefined) {
                   elemResult.textContent = "R$ " + String(num1 + num2) + ",00";
                }
                else { // IE
                   elemResult.innerText = "R$ " + String(num1 + num2) + ",00";
                }
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
                    <h1 align="center">Comercial</h1>
            </div>
            
            <div class="row">
                    <div class="col-md-12">
                        <?php echo $menunav; ?>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-justified">
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpj.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Dados da Empresa</button>
                                        </form>
                                    </li>
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpjuser.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Lista de Usuário</button>
                                        </form>
                                    </li>
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpjusercad.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Cadastrar Usúario</button>
                                        </form>
                                    </li>
                                    <li role="presentation" class="active">
                                        <form method="post" action="com_perfilcnpjobs.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Negociações e Obs</button>
                                        </form>
                                    </li>
                                    <li role="presentation">
                                        <form method="post" action="com_perfilcnpjhist.php">
                                            <input type="hidden" value="<?php echo $cliid;?>" name="idcnpj">
                                            <button type="submit" id="navegador">Histórico</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
			</div>
                        <br>
                        <h4 align="center"><?php echo $clifantasia;?></h4>
                        <p align="center"><?php echo $cnpjn;?></p>
                            
                        <div id="esquerda">
                            <h5 align="center">Negociações e/ou Observações <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalnovonegoci">Novo</button></h5>
                                
                            <!-- MODAL REFERENTE À INCLUSÃO DE NEGOCIAÇÃO OU OBSERVAÇÃO -->
                                <div class="modal fade" id="modalnovonegoci" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title text-center" id="myModalLabel">Negociação ou Observação</h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4 align="center"><?php echo "$data_atual - $hora_atual";?></h4>
                                                <form action="cad_cnpj_obs.php" method="post">
                                                    <table class="table">
                                                        <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                                        <input type="hidden" value="<?php echo $nome;?>" name="tOperador">
                                                        <input type="hidden" value="<?php echo $id_user;?>" name="tIDop">
                                                        <tr><td rowspan="4">Negociação ou observação:</td><td rowspan="4"><textarea name="tObs" class="form-control-textarea"></textarea></td></tr>
                                                        <tr><td>Retornar Ligação:</td><td><input type="radio" name="tRet" id="SIM" value="S"><label for="SIM">SIM</label>&nbsp;&nbsp;<input type="radio" name="tRet" id="NAO" value="N" checked=""><label for="NAO">NÃO</label></td></tr>
                                                        <tr><td>Dia:</td><td><input type="date" name="tData" class="form-control"></td></tr>
                                                        <tr><td>Hora:</td><td><input type="time" name="tHora" class="form-control"></td></tr>
                                                    </table>
                                                    <table class="table">
                                                        <thead>
                                                        <th colspan="6"><h4 align="center">Orçamento (Opcional)</h4></th>
                                                        </thead>
                                                        <tbody>
                                                            <tr><td>Contato:</td><td><input type="text" class="form-control" name="tCont"></td></tr>
                                                            <tr>
                                                                <td>Serviço</td>
                                                                <td>
                                                                    <select name="tProd" class="form-control">
                                                                            <option></option>
                                                                        <?php 
                                                                                $prod = "SELECT * FROM produto";
                                                                                $prodenviabanco = $cx->query($prod);
                                                                                while ($prodrecebe = $prodenviabanco->fetch()){ 
                                                                                    $prod_id = $prodrecebe['id_prod'];
                                                                                    $prod_nome = $prodrecebe['nome_prod'];
                                                                                    $prod_valor = $prodrecebe['valor_prod'];
                                                                        ?>
                                                                            <option value="<?php echo $prod_id;?>"><?php echo "$prod_nome - R$ $prod_valor" ; ?></option>
                                                                        <?php        
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td>Valor Negociado: </td>
                                                                <td>R$&nbsp;&nbsp; <input type="number" name="vNeg" id="num1" onblur="calcular();" class="form-control-valor"></td>
                                                                <td>Cortesia:</td><td><label for="cCortS">SIM<input type="radio" name="tCort" value="S" id="cCortS"></label> &nbsp;<label for="cCortN">NÃO<input type="radio" name="tCort" value="N" id="cCortN" checked=""></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Serviço</td>
                                                                <td>
                                                                    <select name="tProd2" class="form-control">
                                                                            <option></option>
                                                                        <?php 
                                                                                $prod = "SELECT * FROM produto";
                                                                                $prodenviabanco = $cx->query($prod);
                                                                                while ($prodrecebe = $prodenviabanco->fetch()){ 
                                                                                    $prod_id = $prodrecebe['id_prod'];
                                                                                    $prod_nome = $prodrecebe['nome_prod'];
                                                                                    $prod_valor = $prodrecebe['valor_prod'];
                                                                        ?>
                                                                            <option value="<?php echo $prod_id;?>"><?php echo "$prod_nome - R$ $prod_valor" ; ?></option>
                                                                        <?php        
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td>Valor Negociado: </td>
                                                                <td>R$&nbsp;&nbsp; <input type="number" name="vNeg2" id="num2" onblur="calcular();" class="form-control-valor"></td>
                                                                <td>Cortesia:</td><td><label for="cCortS2">SIM<input type="radio" name="tCort2" value="S" id="cCortS2"></label> &nbsp;<label for="cCortN2">NÃO<input type="radio" name="tCort2" value="N" id="cCortN2" checked=""></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Data para começar a pagar: </td>
                                                                <td><input type="date" name="tPagdata" class="form-control"></td>
                                                                <td>Total: </td><td> <span class="valortotal" id="resultado"></span> </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Modo de Pagamento: </td>
                                                                <td>
                                                                    <select name="tModopag" class="form-control-valor">
                                                                            <option></option>
                                                                            <option value="Mensal">Mensal</option>
                                                                            <option value="Trimestral">Trimestral</option>
                                                                            <option value="Semestral">Semestral</option>
                                                                            <option value="Anual">Anual</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tipo de pagamento: </td>
                                                                <td>
                                                                    <select name="tTipopag" class="form-control-valor">
                                                                            <option></option>
                                                                            <option value="Boleto">Boleto</option>
                                                                            <option value="Crédito">Cartão de Crédito</option>
                                                                            <option value="Depósito">Depósito/ Transferência</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr><td colspan="6" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar</button></td></tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                <!-- Fim do modal para INCLUSÃO DE NEGOCIAÇÃO OU OBSERVAÇÃO -->
                                
                                
                                <table class="table">
                                            <thead>
                                                <th colspan="4">Negociação após à ativação</th>
                                            </thead>
                                            <thead>
                                                <th>Dia</th>
                                                <th>Hora</th>
                                                <th>Operador</th>
                                                <th colspan="2">Ação</th>
                                            </thead>
                                        <?php
                                    //BUSCANDO INFORMAÇÕES DA TABELA CNPJ_OBS

                                        $obssql = "SELECT * FROM cnpj_obs WHERE id_c = '".$cliid."' ORDER BY id_co DESC";
                                        $enviaobs = $cx->query ($obssql);

                                        while ($obs = $enviaobs->fetch()){
                                            $obs_idco = $obs['id_co'];
                                            $obs_idc = $obs['id_c'];
                                            $obs_obs = $obs['obs'];
                                            $obs_dia = $obs['dia'];
                                            $obs_hora = $obs['hora'];
                                            $obs_operador = $obs['operador'];
                                            $obs_idop = $obs['id_op'];

                                            //MODIFICANDO A DATAs
                                            list($ano, $mes, $dia) = explode('-', $obs_dia);
                                            $obs_dia = $dia." / ".$mes." / ".$ano;

                                    ?>

                                        <tr>
                                            <td><?php echo $obs_dia;?></td>
                                            <td><?php echo $obs_hora;?></td>
                                            <td><?php echo $obs_operador;?></td>
                                            <td>
                                                <button type="submit" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalver<?php echo $obs_idco;?>">Ver</button>

                                                    <!-- MODAL REFERENTE À VIZUALIZAÇÃO-->
                                                    <div class="modal fade" id="modalver<?php echo $obs_idco;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title text-center" id="myModalLabel">Negociação/ Observação antes da ativação</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table">
                                                                        <tr><td>ID da Obs:</td><td><?php echo $obs_idco;?></td></tr>
                                                                        <tr><td>ID do Cliente CNPJ :</td><td><?php echo $obs_idc;?></td></tr>
                                                                        <tr><td>Negociação ou Observação:</td><td><?php echo $obs_obs;?></td></tr>
                                                                        <tr><td>Dia:</td><td><?php echo $obs_dia;?></td></tr>
                                                                        <tr><td>Hora:</td><td><?php echo $obs_hora;?></td></tr>
                                                                        <tr><td>Operador:</td><td><?php echo $obs_operador;?></td></tr>
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Fechar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    <!-- Fim do modal para VIZUALIZAÇÃO-->
                                            </td>
                                            <td>
                                                <?php
                                                $orcsql = "SELECT * FROM orc WHERE id_co = '".$obs_idco."' ORDER BY id_orc DESC";
                                                $enviaorc = $cx->query ($orcsql);

                                                while ($orc = $enviaorc->fetch()){
                                                    $orc_id = $orc['id_orc'];
                                                    $orc_modo = $orc['modo_pag'];
                                                    $orc_tipo = $orc['tipo_pag'];
                                                    $orc_diapag = $orc['dia_pag'];
                                                    $orc_dia = $orc['dia'];
                                                    $orc_hora = $orc['hora'];
                                                    $orc_contato = $orc['contato'];
                                                    $orc_operad = $orc['operador'];
                                                    $orc_idopera = $orc['id_op'];
                                                    $orc_mailing = $orc['id_m'];

                                                    list($anoorc, $mesorc, $diaorc) = explode('-', $orc_dia);
                                                    $orc_dia = $diaorc." / ".$mesorc." / ".$anoorc ;

                                                    list($anopag, $mespag, $diapag) = explode('-', $orc_diapag);
                                                    $orc_diapag = $diapag." / ".$mespag." / ".$anopag ;

                                                    if ($orc_id == ""){
                                                        $orcamentovizu = "oc";
                                                    } else {
                                                        $orcamentovizu = "btn btn-xs btn-warning";
                                                    }
                                                ?>
                                                <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalvizuorc<?php echo $orc_id;?>">Orçamento</button>
                                                    
                                                <!-- MODAL REFERENTE À VISUALIZAR ORÇAMENTOS-->
                                                        <div class="modal fade" id="modalvizuorc<?php echo $orc_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title text-center" id="myModalLabel">Orçamento</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                            <thead>
                                                                            <th colspan="4">Numero: <span class="valortotal"><?php echo $orc_id;?></span></th>
                                                                            </thead>
                                                                            <tr><td>Dia:</td><td><?php echo $orc_dia;?></td><td>Hora:</td><td><?php echo $orc_hora;?></td></tr>
                                                                            <tr><td>Contato:</td><td><?php echo $orc_contato;?></td></tr>
                                                                            <tr><td>Primeiro pagamento:</td><td><?php echo $orc_diapag;?></td></tr>
                                                                            <tr><td>Modo de Pagamento:</td><td><?php echo $orc_modo;?></td><td>Tipo de Pagamento:</td><td><?php echo $orc_tipo;?></td></tr>
                                                                            <tr><td>Operador:</td><td><?php echo $orc_idopera;?> - <?php echo $orc_operad;?></td></tr>
                                                                        </table>
                                                                        <table class="table">
                                                                            <thead>
                                                                                <th colspan="4" style="text-align:center">Produtos</th>
                                                                            </thead>
                                                                            <thead>
                                                                                <th>ID</th>
                                                                                <th>Produto/ Serviço</th>
                                                                                <th>Valor Negociado</th>
                                                                                <th>Cortesia</th>
                                                                            </thead>

                                                                            <?php 
                                                                            //LISTA OS PRODUTOS DESTE ORÇAMENTO
                                                                                $prodorcsql = "SELECT * FROM orc_prod WHERE id_orc = '".$orc_id."'";
                                                                                $enviaprodorc = $cx->query ($prodorcsql);
                                                                                    while ($prodorc = $enviaprodorc->fetch()){
                                                                                        $prod_id = $prodorc['id_prod'];
                                                                                        $prod_valor = $prodorc['valor_negoci'];
                                                                                        $prod_cortesia = $prodorc['cortesia'];

                                                                                        if ($prod_cortesia == "S"){
                                                                                            $prod_cortesia = "SIM";
                                                                                        }else if ($prod_cortesia == "N"){
                                                                                            $prod_cortesia = "NÃO";
                                                                                        }

                                                                                        $produtosql = "SELECT nome_prod FROM produto WHERE id_prod = '".$prod_id."'";
                                                                                        $enviaproduto = $cx->query ($produtosql);
                                                                                            while ($produto = $enviaproduto->fetch()){
                                                                                                $prod_nome = $produto['nome_prod'];
                                                                                           }
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $prod_id;?></td>
                                                                                <td><?php echo $prod_nome;?></td>
                                                                                <td>R$ <?php echo $prod_valor;?></td>
                                                                                <td><?php echo $prod_cortesia;?></td>
                                                                            </tr>   
                                                                            <?php
                                                                                    }
                                                                            ?>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <!-- Fim do modal para VIZUALIZAR ORÇAMENTOS-->
                                                <?php 
                                                    }
                                                ?>
                                            </td>
                                        </tr>

                                    <?php 
                                        } 
                                    ?>
                                </table>
                                
                                
                                <table class="table">
                                    <thead>
                                        <th colspan="4">Negociado antes da ativação</th>
                                    </thead>
                                    <thead>
                                        <th>Dia</th>
                                        <th>Hora</th>
                                        <th>Operador</th>
                                        <th colspan="2">Ação</th>
                                    </thead>
                                <?php
                            //BUSCANDO INFORMAÇÕES DA TABELA MAILING_OBS
                               
                                $obssql = "SELECT * FROM mailing_obs WHERE id_m = '".$id_m."' ORDER BY id_mo DESC";
                                $enviaobs = $cx->query ($obssql);

                                while ($obs = $enviaobs->fetch()){
                                    $obs_idmo = $obs['id_mo'];
                                    $obs_idm = $obs['id_m'];
                                    $obs_obs = $obs['obs'];
                                    $obs_dia = $obs['dia'];
                                    $obs_hora = $obs['hora'];
                                    $obs_operador = $obs['operador'];
                                    $obs_idop = $obs['id_op'];
                                                                        
                                    //MODIFICANDO A DATAs
                                    list($ano, $mes, $dia) = explode('-', $obs_dia);
                                    $obs_dia = $dia." / ".$mes." / ".$ano;
                                    
                            ?>
                            
                                <tr>
                                    <td><?php echo $obs_dia;?></td>
                                    <td><?php echo $obs_hora;?></td>
                                    <td><?php echo $obs_operador;?></td>
                                    <td>
                                        <button type="submit" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalver<?php echo $obs_idmo;?>">Ver</button>&nbsp;
                                            
                                            <!-- MODAL REFERENTE À VIZUALIZAÇÃO-->
                                            <div class="modal fade" id="modalver<?php echo $obs_idmo;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title text-center" id="myModalLabel">Negociação/ Observação antes da ativação</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <tr><td>ID da Obs no Mailing:</td><td><?php echo $obs_idmo;?></td></tr>
                                                                <tr><td>ID do Cadastro no Mailing :</td><td><?php echo $obs_idm;?></td></tr>
                                                                <tr><td>Negociação ou Observação:</td><td><?php echo $obs_obs;?></td></tr>
                                                                <tr><td>Dia:</td><td><?php echo $obs_dia;?></td></tr>
                                                                <tr><td>Hora:</td><td><?php echo $obs_hora;?></td></tr>
                                                                <tr><td>Operador:</td><td><?php echo $obs_operador;?></td></tr>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Fechar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            <!-- Fim do modal para VIZUALIZAÇÃO-->
                                    </td>
                                    <td>
                                        <?php
                                        $orcsql = "SELECT * FROM orc WHERE id_mo = '".$obs_idmo."' ORDER BY id_orc DESC";
                                        $enviaorc = $cx->query ($orcsql);

                                        while ($orc = $enviaorc->fetch()){
                                            $orc_id = $orc['id_orc'];
                                            $orc_modo = $orc['modo_pag'];
                                            $orc_tipo = $orc['tipo_pag'];
                                            $orc_diapag = $orc['dia_pag'];
                                            $orc_dia = $orc['dia'];
                                            $orc_hora = $orc['hora'];
                                            $orc_contato = $orc['contato'];
                                            $orc_operad = $orc['operador'];
                                            $orc_idopera = $orc['id_op'];
                                            $orc_mailing = $orc['id_m'];
                                            
                                            list($anoorc, $mesorc, $diaorc) = explode('-', $orc_dia);
                                            $orc_dia = $diaorc." / ".$mesorc." / ".$anoorc ;
                                            
                                            list($anopag, $mespag, $diapag) = explode('-', $orc_diapag);
                                            $orc_diapag = $diapag." / ".$mespag." / ".$anopag ;
                                            
                                            if ($orc_id == ""){
                                                $orcamentovizu = "oc";
                                            } else {
                                                $orcamentovizu = "btn btn-xs btn-warning";
                                            }
                                        ?>
                                        <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalvizuorc<?php echo $orc_id;?>">Orçamento</button>
                                            <!-- MODAL REFERENTE À VISUALIZAR ORÇAMENTOS-->
                                                <div class="modal fade" id="modalvizuorc<?php echo $orc_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">Orçamento</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table">
                                                                    <thead>
                                                                    <th colspan="4">Numero: <span class="valortotal"><?php echo $orc_id;?></span></th>
                                                                    </thead>
                                                                    <tr><td>Dia:</td><td><?php echo $orc_dia;?></td><td>Hora:</td><td><?php echo $orc_hora;?></td></tr>
                                                                    <tr><td>Contato:</td><td><?php echo $orc_contato;?></td></tr>
                                                                    <tr><td>Primeiro pagamento:</td><td><?php echo $orc_diapag;?></td></tr>
                                                                    <tr><td>Modo de Pagamento:</td><td><?php echo $orc_modo;?></td><td>Tipo de Pagamento:</td><td><?php echo $orc_tipo;?></td></tr>
                                                                    <tr><td>Operador:</td><td><?php echo $orc_idopera;?> - <?php echo $orc_operad;?></td></tr>
                                                                </table>
                                                                <table class="table">
                                                                    <thead>
                                                                    <th colspan="4" style="text-align:center">Produtos</th>
                                                                    </thead>
                                                                    <thead>
                                                                        <th>ID</th>
                                                                        <th>Produto/ Serviço</th>
                                                                        <th>Valor Negociado</th>
                                                                        <th>Cortesia</th>
                                                                    </thead>
                                                                    
                                                                    <?php 
                                                                    //LISTA OS PRODUTOS DESTE ORÇAMENTO
                                                                        $prodorcsql = "SELECT * FROM orc_prod WHERE id_orc = '".$orc_id."'";
                                                                        $enviaprodorc = $cx->query ($prodorcsql);
                                                                            while ($prodorc = $enviaprodorc->fetch()){
                                                                                $prod_id = $prodorc['id_prod'];
                                                                                $prod_valor = $prodorc['valor_negoci'];
                                                                                $prod_cortesia = $prodorc['cortesia'];
                                                                                
                                                                                if ($prod_cortesia == "S"){
                                                                                    $prod_cortesia = "SIM";
                                                                                }else if ($prod_cortesia == "N"){
                                                                                    $prod_cortesia = "NÃO";
                                                                                }
                                                                                
                                                                                $produtosql = "SELECT nome_prod FROM produto WHERE id_prod = '".$prod_id."'";
                                                                                $enviaproduto = $cx->query ($produtosql);
                                                                                    while ($produto = $enviaproduto->fetch()){
                                                                                        $prod_nome = $produto['nome_prod'];
                                                                                   }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $prod_id;?></td>
                                                                        <td><?php echo $prod_nome;?></td>
                                                                        <td>R$ <?php echo $prod_valor;?></td>
                                                                        <td><?php echo $prod_cortesia;?></td>
                                                                    </tr>   
                                                                    <?php
                                                                            }
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <!-- Fim do modal para VIZUALIZAR ORÇAMENTOS-->
                                        <?php 
                                            }
                                        ?>
                                    </td>
                                </tr>
                            
                            <?php 
                                } 
                            ?>
                                </table>
                        </div>
                        
                        
                        
                            
                        <div id="direita">
                            Testando
                        </div>
                
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