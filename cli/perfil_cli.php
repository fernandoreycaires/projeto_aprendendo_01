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
        $razao = $perfil['razao_c'];
     } 

    //RECEBE CPF VINDO DA TELA HOME_CLI
     $recebeid = isset($_POST['recebeid'])?$_POST['recebeid']:'Vazio';
     $clicpf = isset($_POST['cpfcli'])?$_POST['cpfcli']:'';
     $receberg = isset($_POST['rgcli'])?$_POST['rgcli']:'';
     $recebecn = isset($_POST['cncli'])?$_POST['cncli']:'';
     $msgerro = isset($_POST['erro'])?$_POST['erro']:'';

    //BUSCA DADOS DO CLIENTE COM O CPF, RG ou CERT. NASC. INFORMADO ACIMA
    $clisql = "SELECT * FROM clientes WHERE cpf = '".$clicpf."' OR rg = '".$receberg."' OR certnasc = '".$recebecn."' OR id = '".$recebeid."'  limit 1";
    $enviacli = $cx->query ($clisql);

    while ($cli = $enviacli->fetch()){

        $cliid = $cli['id'];
        $clicpfl = $cli['cpf'];
        $clirg = $cli['rg'];
        $clicn = $cli['certnasc'];
        $clinome = $cli['nome'];
        $clinasc = $cli['nascimento'];
        $clisexo = $cli['sexo'];
        $clicivil = $cli['estadocivil'];
        $cliprof = $cli['prof'];
        $clicel1 = $cli['cel1'];
        $clicel2 = $cli['cel2'];
        $clitel = $cli['tel'];
        $cliemail = $cli['email'];

        $clinomemae = $cli['nome_mae'];
        $clicpfmae = $cli['cpf_mae'];
        $clinomepai = $cli['nome_pai'];
        $clicpfpai = $cli['cpf_pai'];

        $clirespnome = $cli['respnome'];
        $clirespcel = $cli['respcel'];
        $cliresptel = $cli['resptel'];

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

     //MODIFICANBDO VARIAVEL SEXO
        if ($clisexo =='M'){
            $sexo = 'Masculino';
        }else if ($clisexo == 'F'){
            $sexo = 'Feminino';
        }

     //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL CPF 
        $cpfn = substr_replace($clicpfl, '.', 3, 0);
        $cpfn = substr_replace($cpfn, '.', 7, 0);
        $cpfn = substr_replace($cpfn, '-', 11, 0);

        $cpfmae = substr_replace($clicpfmae, '.', 3, 0);
        $cpfmae = substr_replace($cpfmae, '.', 7, 0);
        $cpfmae = substr_replace($cpfmae, '-', 11, 0);

        $cpfpai = substr_replace($clicpfpai, '.', 3, 0);
        $cpfpai = substr_replace($cpfpai, '.', 7, 0);
        $cpfpai = substr_replace($cpfpai, '-', 11, 0);

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
        $rgn = substr_replace($clirg, '.', 2, 0);
        $rgn = substr_replace($rgn, '.', 6, 0);
        $rgn = substr_replace($rgn, '-', 10, 0);

    // CALCULAR A IDADE 
        // Separa em dia, mês e ano
        list($ano, $mes, $dia ) = explode('-', $clinasc);
        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        // Descobre a unix timestamp da data de nascimento do fulano
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

        // Depois apenas fazemos o cálculo já citado :)
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        //print $idade;
    //FIM DO CALCULO DE IDADE

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
        $cel1n = substr_replace($clicel1, '(', 0, 0);
        $cel1n = substr_replace($cel1n, ')', 3, 0);
        $cel1n = substr_replace($cel1n, '-', 9, 0);
        $cel1n = substr_replace($cel1n, ' ', 4, 0);
        $cel1n = substr_replace($cel1n, ' ', 6, 0);

        $cel2n = substr_replace($clicel2, '(', 0, 0);
        $cel2n = substr_replace($cel2n, ')', 3, 0);
        $cel2n = substr_replace($cel2n, '-', 9, 0);
        $cel2n = substr_replace($cel2n, ' ', 4, 0);
        $cel2n = substr_replace($cel2n, ' ', 6, 0);

        $fixon = substr_replace($clitel, '(', 0, 0);
        $fixon = substr_replace($fixon, ')', 3, 0);
        $fixon = substr_replace($fixon, '-', 8, 0);
        $fixon = substr_replace($fixon, ' ', 4, 0);

        $respceln = substr_replace($clirespcel, '(', 0, 0);
        $respceln = substr_replace($respceln, ')', 3, 0);
        $respceln = substr_replace($respceln, '-', 9, 0);
        $respceln = substr_replace($respceln, ' ', 4, 0);
        $respceln = substr_replace($respceln, ' ', 6, 0);

        $respteln = substr_replace($cliresptel, '(', 0, 0);
        $respteln = substr_replace($respteln, ')', 3, 0);
        $respteln = substr_replace($respteln, '-', 8, 0);
        $respteln = substr_replace($respteln, ' ', 4, 0);

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
        <meta charset="UTF-8">
        <title>ADM Consultório</title>
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/clientes.css" rel="stylesheet" type="text/css"/>
        <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
        <link href='../_css/bootstrap.min.css' rel='stylesheet'>
        <style>
            
            
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
        <script src='../_javascript/funcoes.js'></script>
        
        </head>
    <body>
        <div class="container-fluid theme-showcase estilo" role="main">
            <div class="logo1"></div>
            <header class="cabecalho">
                <a href="home_cli.php" type="button" class="dropdownvoltar">Voltar</a>
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
                    <h1 align="center">Perfil de Clientes</h1>
                    <h4 align="center"><?php echo $msgerro;?></h4>
                    
                    <form method="post" action="cli_atend.php" target="_self">
                        <input type="hidden" name="id" value="<?php echo $cliid; ?>">
                    <p align="right"><button type="submit" class="btn btn-xm btn-success">Abrir Atendimento</button></p>
                    </form>
            </div>
            
            <div class="row">
                    <div class="col-md-12">
                        
                        <!--DADOS PESSOAIS-->
                        <div id="dadospessoais">    
                            <table class="table">
                                <thead>
                                <th colspan="2">
                                    <h4 align="center">Dados Pessoais</h4>
                                    <h3><?php echo $clinome; ?><h3>
                                </th>    
                                </thead>
                                <tr><td>CPF:</td><td><?php echo $cpfn; ?></td></tr>
                                <tr><td>RG:</td><td><?php echo $rgn; ?></td></tr>
                                <tr><td>Cert. Nasc.:</td><td><?php echo $clicn; ?></td></tr>
                                <tr><td>Nascimento:</td><td><?php echo "$dia/$mes/$ano"?></td></tr>
                                <tr><td>Idade:</td><td><?php echo "$idade anos de idade";?></td></tr>
                                <tr><td>Sexo:</td><td><?php echo $sexo;?></td></tr>
                                <tr><td>Estado Civil:</td><td><?php echo $clicivil;?></td></tr>
                                <tr><td>Profissão:</td><td><?php echo $cliprof;?></td></tr>
                            </table>
                            <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaldadospessoais">Editar Dados Pessoais</button></p>
                        </div>    
                        
                        <!--DADOS PARA CONTATO-->
                        <div id="dadoscontato">    
                            <table class="table">
                                <thead>
                                <th colspan="2"><h4 align="center">Dados para Contato</h4></th>    
                                </thead>
                                <tr><td>Telefone:</td><td><?php echo $fixon;?></td></tr>
                                <tr><td>Celular (Opção 1):</td><td><?php echo $cel1n;?></td></tr>
                                <tr><td>Celular (Opção 2):</td><td><?php echo $cel2n;?></td></tr>
                                <tr><td>E-Mail:</td><td><?php echo $cliemail;?></td></tr>
                            </table>
                            <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalcontato">Editar Contato</button></p>
                        </div>
                        
                        <!--DADOS DOS RESPONSAVEIS-->
                        <div id="responsavel">
                            <table class="table">
                                <thead>
                                <th colspan="2"><h4 align="center">Dados do Responsavel (Opcional)</h4></th>    
                                </thead>
                                <tr><td>Mãe:</td><td><?php echo $clinomemae;?></td></tr>
                                <tr><td>CPF(Mãe):</td><td><?php echo $cpfmae;?></td></tr>
                                <tr><td>Pai:</td><td><?php echo $clinomepai;?></td></tr>
                                <tr><td>CPF(Pai):</td><td><?php echo $cpfpai;?></td></tr>
                                <tr><td>Nome (Autorizado):</td><td><?php echo $clirespnome;?></td></tr>
                                <tr><td>Celular:</td><td><?php echo $respceln;?></td></tr>
                                <tr><td>Telefone:</td><td><?php echo $respteln;?></td></tr>
                            </table>
                            <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalresponsavel">Editar Dados do Responsavel</button></p>
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
                                            <form method="post" action="perfil_cli.php">
                                                <input type="hidden" name="recebeid" value="<?php echo $cliid;?>">
                                                <input type="text" name="tCep" onkeypress="return onlynumber();" class="form-control-cep" placeholder="Somente números" value="<?php echo $exibir_cep; ?>"> 
                                                &nbsp;<button type="submit" class="btn btn-xs btn-primary">Buscar CEP</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <form method="post" action="edit_endereco.php">
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
                        <!--DADOS DO CONVENIO-->
                        <div id="dadosconvenio">
                            <table class="table">
                                <thead>
                                    <th colspan="4"><h4 align="center">Dados do Convênio</h4></th>    
                                </thead>
                                <thead>
                                    <th>Empresa</th><th>Tipo/Modelo</th><th>Cartão</th><th>Ação</th>
                                </thead>
                                <?php
                                    $convsql = "SELECT * FROM convenio WHERE id_cli = '".$cliid."'";
                                    $enviaconvsql = $cx->query ($convsql);
                                        while ($conv = $enviaconvsql->fetch()){
                                            $conv_id = $conv['id_conv'];
                                            $cliconv = $conv['empresa'];
                                            $clitipoconv = $conv['tipo'];
                                            $clicart = $conv['num_cart'];
                                ?>
                                <tr>
                                    <td><?php echo $cliconv;?></td>
                                    <td><?php echo $clitipoconv;?></td>
                                    <td><?php echo $clicart;?></td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalconv<?php echo $conv_id;?>">Editar</button><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalconvdel<?php echo $conv_id;?>">Apagar</button>
                                        <!-- MODAL REFERENTE A EDITAR CONVENIO -->
                                            <div class="modal fade" id="modalconv<?php echo $conv_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title text-center" id="myModalLabel">Editar Dados do Convênio</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="edit_convenio.php" method="post">
                                                                <table class="table">
                                                                    <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                                                    <input type="hidden" value="<?php echo $conv_id;?>" name="tConvID">
                                                                    <tr><td>Convenio:</td><td><input type="text" name="tConv" class="form-control" value="<?php echo $cliconv;?>"></td></tr>
                                                                    <tr><td>Tipo / Modelo:</td><td><input type="text" name="tTipo" class="form-control" value="<?php echo $clitipoconv;?>"></td></tr>
                                                                    <tr><td>Cartão:</td><td><input type="text" name="tNcart" class="form-control" value="<?php echo $clicart;?>"></td></tr>
                                                                    <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar</button></td></tr>
                                                                </table>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        <!-- Fim do modal para EDITAR CONVENIO -->
                                        <!-- MODAL REFERENTE A EXCLUIR CONVENIO -->
                                            <div class="modal fade" id="modalconvdel<?php echo $conv_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title text-center" id="myModalLabel">DELETAR CONVÊNIO</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="del_convenio.php" method="post">
                                                                <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                                                <input type="hidden" value="<?php echo $conv_id;?>" name="tConvID">
                                                                <p align="center">Convenio: <?php echo $cliconv;?></p>
                                                                <p align="center"><button type="submit" class="btn btn-sm btn-danger">Excluir</button></p>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        <!-- Fim do modal para EXCLUIR CONVENIO -->
                                    </td>
                                </tr>
                                <?php
                                        }
                                ?>
                            </table>
                            <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalconvenio">Inserir Convênio</button></p>
                        </div>
                    </div>
                </div>
                
            <div class="col-md-12">
                <!--EXIBIÇÃO E/OU CADASTRO DOS DEPENDENTES-->
                <div>
                    <table class="table">
                        <thead>
                            <th colspan="6">
                                <h4 align="center">Dados do(s) Dependente(s)</h4>
                            </th>
                            <tr>
                                <th>Parentesco:</th>
                                <th>Nome:</th>
                                <th>Sexo:</th>
                                <th>Nascimento:</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <?php 
                                //BUSCA INFORMAÇÕES DE DEPENDENTES
                                $sqldepend = "SELECT * FROM clientes WHERE cpf_mae != '' and cpf_mae = '".$clicpfl."' or cpf_pai != '' and cpf_pai = '".$clicpfl."'";
                                $buscadepend = $cx->query($sqldepend);
                                while ($dp = $buscadepend->fetch()){
                                    $iddep = $dp['id'];
                                    $nomedep = $dp['nome'];
                                    $sexodep = $dp['sexo'];
                                    $nascdep = $dp['nascimento'];
                                    

                                    //ARRUMA SEXO PARA EXIBIÇÃO
                                    if($sexodep == "F"){
                                        $sexodep = "Feminino";
                                        $sx = "F";
                                        $parent = "Filha";
                                    } else if ($sexodep == "M"){
                                        $sexodep = "Masculino";
                                        $sx = "M";
                                        $parent = "Filho";
                                    }

                                    // CALCULAR A IDADE 
                                        // Separa em dia, mês e ano
                                        list($anod, $mesd, $diad ) = explode('-', $nascdep);
                                        // Descobre que dia é hoje e retorna a unix timestamp
                                        $hojed = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                        // Descobre a unix timestamp da data de nascimento do fulano
                                        $nascimentod = mktime(0, 0, 0, $mesd, $diad, $anod);

                                        // Depois apenas fazemos o cálculo já citado :)
                                        $idaded = floor((((($hojed - $nascimentod) / 60) / 60) / 24) / 365.25);
                                        //print $idade;
                                    //FIM DO CALCULO DE IDADE

                                ?>
                        <tr>
                            <td><?php echo $parent;?></td>
                            <td><?php echo $nomedep;?></td>
                            <td><?php echo $sexodep;?></td>
                            <td><?php echo "$diad/$mesd/$anod - $idaded anos de idade.";?></td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modaldeldepend<?php echo $iddep;?>">Excluir</button>
                                        <!-- MODAL REFERENTE À EXCLUIR DE DEPENDENTE -->
                                                <div class="modal fade" id="modaldeldepend<?php echo $iddep;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">Apagar Dependente</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="del_depend.php">
                                                                    <input type="hidden" value="<?php echo $clicpfl;?>" name="tCpf">
                                                                    <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                                                    <input type="hidden" value="<?php echo $iddep;?>" name="iddep">
                                                                    <p align="center"> Deseja realmete apagar o dependente </p>
                                                                    <p align="center"><span class="banco"> <?php echo $nomedep;?></span></p>
                                                                    <p align="center"> <button type="submit" class="btn btn-sm btn-danger">Excluir</button> </p>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                        <!-- Fim do modal para EXCLUIR DEPENDENTES -->
                            </td>
                            
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            
            <!-- MODAL REFERENTE À EDIÇÃO DE DADOS PESSOAIS -->
                <div class="modal fade" id="modaldadospessoais" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Editar Dados Pessoais</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <form action="edit_dadospessoais.php" method="post">
                                        <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                        <tr><td>CPF:</td><td><input type="text" name="tCpf" class="form-control" value="<?php echo $clicpfl;?>"></td></tr>
                                        <tr><td>RG:</td><td><input type="text" name="tRG" class="form-control" value="<?php echo $clirg; ?>"></td></tr>
                                        <tr><td>Cert. Nasc.:</td><td><input type="text" name="tCN" class="form-control" value="<?php echo $clicn; ?>"></td></tr>
                                        <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" value="<?php echo $clinome;?>"></td></tr>
                                        <tr><td>Nascimento:</td><td><input type="date" name="tNasc" class="form-control" value="<?php echo $clinasc;?>"></td></tr>
                                        <tr><td>Sexo:</td><td>
                                                <select name="tSexo" class="form-control">
                                                    <option value="<?php echo $clisexo;?>"><?php echo $sexo;?></option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Feminino</option>
                                                </select>
                                            </td></tr>
                                        <tr><td>Estado Civil:</td><td>
                                                <select name="tEst" class="form-control">
                                                    <option selected><?php echo $clicivil;?></option>
                                                    <option>Solteiro(a)</option>
                                                    <option>Casado(a)</option>
                                                    <option>União Estavel</option>
                                                    <option>Divorciado(a)</option>
                                                    <option>Viúvo(a)</option>
                                                </select>
                                            </td></tr>
                                        <tr><td>Profissão:</td><td><input type="text" name="tProf" class="form-control" value="<?php echo $cliprof;?>"></td></tr>
                                        <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
                <!-- Fim do modal para DADOS PESSOAIS -->
                
                
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
                                    <form action="edit_contato.php" method="post">
                                        <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                        <input type="hidden" value="<?php echo $clicpf;?>" name="tCpf">
                                        <tr><td>Celular (Opção 1):</td><td><input type="text" name="tCel1" class="form-control" value="<?php echo $clicel1;?>"></td></tr>
                                        <tr><td>Celular (Opção 2):</td><td><input type="text" name="tCel2" class="form-control" value="<?php echo $clicel2;?>"></td></tr>
                                        <tr><td>Telefone Fixo:</td><td><input type="text" name="tFixo" class="form-control" value="<?php echo $clitel;?>"></td></tr>
                                        <tr><td>E-Mail:</td><td><input type="mail" name="tMail" class="form-control" value="<?php echo $cliemail;?>"></td></tr>
                                        <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
                <!-- Fim do modal para CONTATOS -->
                
                <!-- MODAL REFERENTE DADOS DOS RESPONSAVEIS -->
                <div class="modal fade" id="modalresponsavel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Dados do Responsável</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <form action="edit_responsavel.php" method="post">
                                        <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                        <tr><td>Mãe:</td><td><input type="text" name="tMae" class="form-control" value="<?php echo $clinomemae;?>"></td></tr>
                                        <tr><td>CPF(Mãe):</td><td><input type="text" name="tCPFMae" class="form-control" value="<?php echo $clicpfmae;?>"></td></tr>
                                        <tr><td>Pai:</td><td><input type="text" name="tPai" class="form-control" value="<?php echo $clinomepai;?>"></td></tr>
                                        <tr><td>CPF(Pai):</td><td><input type="text" name="tCPFPai" class="form-control" value="<?php echo $clicpfpai;?>"></td></tr>
                                        <tr><td>Nome:</td><td><input type="text" name="tRespnome" class="form-control" value="<?php echo $clirespnome;?>"></td></tr>
                                        <tr><td>Celular:</td><td><input type="text" name="tRespcel" class="form-control" value="<?php echo $clirespcel;?>"></td></tr>
                                        <tr><td>Telefone Fixo:</td><td><input type="text" name="tRespfixo" class="form-control" value="<?php echo $cliresptel;?>"></td></tr>
                                        <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
                <!-- Fim do modal para DADOS DO RESPONSAVEL -->
                
                <!-- MODAL REFERENTE AO ENDEREÇO -->
                <div class="modal fade" id="modalendereco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Dados do Responsável</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <form action="edit_endereco.php" method="post">
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
                
                <!-- MODAL REFERENTE AO CONVENIO -->
                <div class="modal fade" id="modalconvenio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Dados do Convênio</h4>
                            </div>
                            <div class="modal-body">
                                <form action="cad_convenio.php" method="post">
                                    <table class="table">
                                        <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                        <tr><td>Convenio:</td><td><input type="text" name="tConv" class="form-control" placeholder="Empresa do Convênio" ></td></tr>
                                        <tr><td>Tipo / Modelo:</td><td><input type="text" name="tTipo" class="form-control" placeholder="Tipo ou modelo do contrato " ></td></tr>
                                        <tr><td>Cartão:</td><td><input type="text" name="tNcart" class="form-control" placeholder="Numero do cartão do convenio" ></td></tr>
                                        <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Inserir</button></td></tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>  
                <!-- Fim do modal para CONVENIO -->
                
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
