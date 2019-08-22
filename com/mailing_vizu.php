<?php 
session_start();
include '../_php/cx.php';
include 'com_menunav.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "select cu.nome_u from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
    $acesso_user = $cx->query ($acesso);

    while ($perfil = $acesso_user->fetch()){
        $nome = $perfil['nome_u'];
     } 
 
$msg = $_POST['msg'];
$id_m = $_POST['id_m'];

//BUSCA DADOS DO CLIENTE COM O ID informado
$clisql = "SELECT * FROM mailing WHERE id_m = '".$id_m."' limit 1";
$enviacli = $cx->query ($clisql);

while ($cli = $enviacli->fetch()){
    $cliid = $cli['id_m'];
    $clirazao = $cli['razao'];
    $clifantasia = $cli['nfan'];
    $cliuni = $cli['unidade'];
    $clicnpj = $cli['cnpj'];
    $clitel1 = $cli['tel1'];
    $clitel2 = $cli['tel2'];
    $clitel3 = $cli['tel3'];
    $cliemail = $cli['email'];
    $cliweb = $cli['web'];
    
    $cliinserido = $cli['inserido'];
    $clinome = $cli['nome'];
    $clicpf = $cli['cpf'];
    $clicrm = $cli['crm'];
    $cliarea = $cli['area_m'];
    
    $clicep = $cli['cep'];
    $clilogra = $cli['logradouro'];
    $clinum = $cli['numerolog'];
    $clicomp = $cli['complemento'];
    $clibairro = $cli['bairro'];
    $clicid = $cli['cidade'];
    $cliuf = $cli['estado'];

    
 } 
 
 //VERIFICA SE O CEP ESTA CADASTRADO PARA MUDAR O MODO DE EXIBIÇAO DA DIV DO CEP PARA O MOO DE INSERÇÃO
    if ($clicep == '' and $clilogra == ''){
        $ocultaend = "oc";
        $ocultacep = "";
    }else if ($clicep == '' and $clilogra != '' or $clicep != '' and $clilogra == '' or $clicep != '' and $clilogra != ''){
        $ocultaend = "";
        $ocultacep = "oc";
    }
 
 //ARRUMAR CEP PARA EXIBIÇÃO
    $ceppn = substr_replace($clicep, '-', 5, 0);
 
//MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
    $cnpjn = substr_replace($clicnpj, '.', 2, 0);
    $cnpjn = substr_replace($cnpjn, '.', 6, 0);
    $cnpjn = substr_replace($cnpjn, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn, '-', 15, 0);
    
//MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
    $cpfn = substr_replace($clicpf, '.', 3, 0);
    $cpfn = substr_replace($cpfn, '.', 7, 0);
    $cpfn = substr_replace($cpfn, '-', 11, 0);
 
    
//MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL TELEFONE FIXO
    $fixo1n = substr_replace($clitel1, '(', 0, 0);
    $fixo1n = substr_replace($fixo1n, ')', 3, 0);
    $fixo1n = substr_replace($fixo1n, '-', 8, 0);
    $fixo1n = substr_replace($fixo1n, ' ', 4, 0);  

    $fixo2n = substr_replace($clitel2, '(', 0, 0);
    $fixo2n = substr_replace($fixo2n, ')', 3, 0);
    $fixo2n = substr_replace($fixo2n, '-', 8, 0);
    $fixo2n = substr_replace($fixo2n, ' ', 4, 0);
    
    $fixo3n = substr_replace($clitel3, '(', 0, 0);
    $fixo3n = substr_replace($fixo3n, ')', 3, 0);
    $fixo3n = substr_replace($fixo3n, '-', 8, 0);
    $fixo3n = substr_replace($fixo3n, ' ', 4, 0);
    
    //MODIFICANDO A DATA
    list($ano, $mes, $dia) = explode('-', $cliinserido);
    
    
    //FUNÇÃO BUSCA CEP
    function buscaCep($cep){
    global $retorno;
    $resultado = @file_get_contents("http://republicavirtual.com.br/web_cep.php?cep=".$cep."&formato=query_string");
    $resultado = urldecode($resultado);
    $resultado = utf8_encode($resultado);

    $resultado = parse_str($resultado,$retorno);
    return($retorno);
    }
    
    buscaCep($_POST["tCep"]);
    $exibir_cep = $_POST["tCep"];
    // FINAL DA FUNÇÃO BUSCA CEP

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
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/jquery.min.js'></script>
                
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
                                    <li role="presentation" class="active">
                                        <form method="post" action="mailing_vizu.php">
                                            <input type="hidden" value="<?php echo $id_m;?>" name="id_m">
                                            <button type="submit" id="navegador">Dados do Cadastrado</button>
                                        </form>
                                    </li>
                                    <li role="presentation">
                                        <form method="post" action="mailing_obs.php">
                                            <input type="hidden" value="<?php echo $id_m;?>" name="id_m">
                                            <button type="submit" id="navegador">Observações e Negociações</button>
                                        </form>
                                    
                                </ul>
                            </div>
                        </div>
                        
                        <h4 align="center">Mailing Vizualizar </h4>
                        <p align='center'>Ultima atualização do cadastro: <?php echo "$dia/$mes/$ano";?></p>
                        <h3 align="center"><?php echo $msg;?></h3>
                                <!--DADOS da empresa ou contato-->
                                    <div id="dadosempresa">    
                                        <table class="table">
                                            <thead>
                                            <th colspan="2">
                                                <h4 align="center">Dados do Cadastrado</h4>
                                                <h3><?php echo "$clifantasia"; ?><h3>
                                            </th>    
                                            </thead>
                                            <tr><td>ID:</td><td><?php echo $cliid; ?></td></tr>
                                            <tr><td>CNPJ:</td><td><?php echo $cnpjn; ?></td></tr>
                                            <tr><td>Razão Social:</td><td><?php echo $clirazao;?></td></tr>
                                            <tr><td>Unidade:</td><td><?php echo $cliuni;?></td></tr>
                                            <tr><td>Nome:</td><td><?php echo $clinome;?></td></tr>
                                            <tr><td>CRM:</td><td><?php echo $clicrm;?></td></tr>
                                            <tr><td>CPF:</td><td><?php echo $cpfn;?></td></tr>
                                            <tr><td>Área:</td><td><?php echo $cliarea;?></td></tr>
                                        </table>
                                        <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaldadosempresa">Editar Dados da Empresa</button></p>
                                    </div>    

                                    <!--DADOS PARA CONTATO-->
                                    <div id="dadoscontato">    
                                        <table class="table">
                                            <thead>
                                            <th colspan="2"><h4 align="center">Dados para Contato</h4></th>    
                                            </thead>
                                            <tr><td>Telefone (Opção 1):</td><td><?php echo $fixo1n;?></td></tr>
                                            <tr><td>Telefone (Opção 2):</td><td><?php echo $fixo2n;?></td></tr>
                                            <tr><td>Telefone (Opção 3):</td><td><?php echo $fixo3n;?></td></tr>
                                            <tr><td>E-Mail:</td><td><?php echo $cliemail;?></td></tr>
                                            <tr><td>Pagina Web:</td><td><?php echo $cliweb;?></td></tr>
                                        </table>
                                        <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalcontato">Editar Contato</button></p>
                                    </div>

                                    <!--ENDEREÇO-->
                                    <div class="<?php echo $ocultaend;?>">
                                        <div id="dadosendereco" >
                                            <table class="table">
                                                <thead>
                                                <th colspan="2"><h4 align="center">Endereço</h4></th>    
                                                </thead>
                                                <tr><td>CEP:</td><td><?php echo $ceppn;?></td></tr>
                                                <tr><td>Logradouro:</td><td><?php echo $clilogra;?>, &nbsp;<?php echo $clinum;?></td></tr>
                                                <tr><td>Complemento:</td><td><?php echo $clicomp;?></td></tr>
                                                <tr><td>Bairro:</td><td><?php echo $clibairro;?></td></tr>
                                                <tr><td>Cidade:</td><td><?php echo $clicid;?></td></tr>
                                                <tr><td>Estado:</td><td><?php echo $cliuf;?></td></tr>
                                            </table>
                                            <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalendereco">Editar Endereço</button></p>
                                        </div>
                                    </div>
                                    <div class="<?php echo $ocultacep;?>">
                                        <div id="dadosendereco">
                                            <table class="table">
                                                <thead>
                                                <th colspan="2"><h4 align="center">Cadastrar Endereço</h4></th>    
                                                </thead>
                                                <tr>
                                                    <td>CEP:</td>
                                                    <td>
                                                        <form method="post" action="mailing_vizu.php">
                                                            <input type="hidden" value="<?php echo $cliid;?>" name="id_m">
                                                            <input type="text" name="tCep" class="form-control-cep" placeholder="Somente números" value="<?php echo $exibir_cep; ?>"> 
                                                            &nbsp;<button type="submit" class="btn btn-xs btn-primary">Buscar CEP</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <form method="post" action="edit_mailing_end.php">
                                                    <input type="hidden" value="<?php echo $exibir_cep; ?>" name="tCep" >
                                                    <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                                    <tr><td>Logradouro:</td><td><input type="text" class="form-control-endereco" name="tLogra" value="<?php echo $retorno['tipo_logradouro']." ".$retorno['logradouro']; ?>"></td></tr> 
                                                    <tr><td>Numero:</td><td><input type="text" class="form-control-endereco" name="tNum"></td></tr>
                                                    <tr><td>Complemento:</td><td><input type="text" class="form-control-endereco"name="tComp"></td></tr>
                                                    <tr><td>Bairro:</td><td><input type="text" class="form-control-endereco"name="tBai" value="<?php echo $retorno['bairro']; ?>"></td></tr>
                                                    <tr><td>Cidade:</td><td><input type="text" class="form-control-endereco" name="tCid" value="<?php echo $retorno['cidade']; ?>"></td></tr>
                                                    <tr><td>Estado:</td><td>
                                                                            <select name="tUF" class="form-control-uf" >
                                                                                <option selected><?php echo $retorno['uf']; ?></option>
                                                                                <option>AC</option>
                                                                                <option>AL</option>
                                                                                <option>AP</option>
                                                                                <option>AM</option>
                                                                                <option>BA</option>
                                                                                <option>CE</option>
                                                                                <option>DF</option>
                                                                                <option>ES</option>
                                                                                <option>GO</option>
                                                                                <option>MA</option>
                                                                                <option>MT</option>
                                                                                <option>MS</option>
                                                                                <option>MG</option>
                                                                                <option>PA</option>
                                                                                <option>PB</option>
                                                                                <option>PR</option>
                                                                                <option>PE</option>
                                                                                <option>PI</option>
                                                                                <option>RJ</option>
                                                                                <option>RN</option>
                                                                                <option>RS</option>
                                                                                <option>RO</option>
                                                                                <option>RR</option>
                                                                                <option>SC</option>
                                                                                <option>SP</option>
                                                                                <option>SE</option>
                                                                                <option>TO</option>
                                                                            </select> 
                                                                        </td>
                                                    </tr>
                                                    <tr><td colspan="2"><p align="center"><button type="submit" class="btn btn-xs btn-primary">Salvar</button></p></td></tr>
                                                </form>
                                            </table>
                                        </div>
                                    </div>


                            </div>
                        </div>

                    <!-- MODAL REFERENTE À EDIÇÃO DE DADOS DA EMPRESA -->
                        <div class="modal fade" id="modaldadosempresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Editar Dados da Empresa</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <form action="edit_mailing_dados.php" method="post">
                                                <input type="hidden" value="<?php echo $id_m;?>" name="tID">
                                                <tr><td>Nome Fantasia:</td><td><input type="text" name="tFant" class="form-control" value="<?php echo $clifantasia;?>"></td></tr>
                                                <tr><td>CNPJ:</td><td><input type="text" name="tCNPJ" class="form-control" value="<?php echo $clicnpj;?>"></td></tr>
                                                <tr><td>Razão Social:</td><td><input type="text" name="tRS" class="form-control" value="<?php echo $clirazao;?>"></td></tr>
                                                <tr><td>Unidade:</td><td><input type="text" name="tUni" class="form-control" value="<?php echo $cliuni;?>"></td></tr>
                                                <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" value="<?php echo $clinome;?>"></td></tr>
                                                <tr><td>CRM:</td><td><input type="text" name="tCRM" class="form-control" value="<?php echo $clicrm;?>"></td></tr>
                                                <tr><td>CPF:</td><td><input type="text" name="tCPF" class="form-control" value="<?php echo $clicpf;?>"></td></tr>
                                                <tr><td>Area:</td><td><input type="text" name="tArea" class="form-control" value="<?php echo $cliarea;?>"></td></tr>
                                                <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!-- Fim do modal para DADOS DA EMPRESA -->


                        <!-- MODAL REFERENTE À EDIÇÃO DOS CONTATOS -->
                        <div class="modal fade" id="modalcontato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Editar Dados para contato</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <form action="edit_mailing_contato.php" method="post">
                                                <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                                <tr><td>Telefone (Opção 1):</td><td><input type="text" name="tel1" class="form-control" value="<?php echo $clitel1;?>"></td></tr>
                                                <tr><td>Telefone (Opção 2):</td><td><input type="text" name="tel2" class="form-control" value="<?php echo $clitel2;?>"></td></tr>
                                                <tr><td>Telefone (Opção 3):</td><td><input type="text" name="tel3" class="form-control" value="<?php echo $clitel3;?>"></td></tr>
                                                <tr><td>E-Mail:</td><td><input type="mail" name="tMail" class="form-control" value="<?php echo $cliemail;?>"></td></tr>
                                                <tr><td>Pagina Web:</td><td><input type="mail" name="tWeb" class="form-control" value="<?php echo $cliweb;?>"></td></tr>
                                                <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!-- Fim do modal para CONTATOS -->


                        <!-- MODAL REFERENTE AO ENDEREÇO -->
                        <div class="modal fade" id="modalendereco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Edição do Endereço da Empresa</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <form action="edit_mailing_end.php" method="post">
                                                <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                                <tr><td>CEP:</td><td><input type="text" name="tCep" class="form-control" value="<?php echo $clicep;?>"></td></tr>
                                                <tr><td>Logradouro:</td><td><input type="text" name="tLogra" class="form-control" value="<?php echo $clilogra;?>"></td></tr>
                                                <tr><td>Número:</td><td><input type="text" name="tNum" class="form-control" value="<?php echo $clinum;?>"></td></tr>
                                                <tr><td>Complemento:</td><td><input type="text" name="tComp" class="form-control" value="<?php echo $clicomp;?>"></td></tr>
                                                <tr><td>Bairro:</td><td><input type="text" name="tBai" class="form-control" value="<?php echo $clibairro;?>"></td></tr>
                                                <tr><td>Cidade:</td><td><input type="text" name="tCid" class="form-control" value="<?php echo $clicid;?>"></td></tr>
                                                <tr><td>Estado:</td><td><input type="text" name="tUF" class="form-control" value="<?php echo $cliuf;?>"></td></tr>
                                                <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!-- Fim do modal para ENDEREÇO -->
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

