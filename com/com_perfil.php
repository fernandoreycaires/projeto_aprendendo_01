<?php
session_start();
include '../_php/cx.php';
include 'com_menunav.php';
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
 $clicpf = isset($_POST['cpfcli'])?$_POST['cpfcli']:'';
 $msgerro = isset($_POST['erro'])?$_POST['erro']:'';
 
//BUSCA DADOS DO CLIENTE COM O CPF INFORMADO ACIMA
$clisql = "SELECT * FROM clientes WHERE cpf = '".$clicpf."' limit 1";
$enviacli = $cx->query ($clisql);

while ($cli = $enviacli->fetch()){
    $cliid = $cli['id'];
    $clinome = $cli['nome'];
    $clinasc = $cli['nascimento'];
    $clisexo = $cli['sexo'];
    $clicivil = $cli['estadocivil'];
    $cliprof = $cli['prof'];
    $clicel1 = $cli['cel1'];
    $clicel2 = $cli['cel2'];
    $clitel = $cli['tel'];
    $cliemail = $cli['email'];
    
    $clirespnome = $cli['respnome'];
    $clirespcel = $cli['respcel'];
    $cliresptel = $cli['resptel'];
    
    $tipodoc = $cli['tipo_doc'];
    $crm = $cli['crm'];
    $crmuf = $cli['estado_crm'];
    $crmarea = $cli['area_m'];
    
    $clicep = $cli['cep'];
    $clilogra = $cli['logradouro'];
    $clinum = $cli['numerolog'];
    $clicomp = $cli['complemento'];
    $clibairro = $cli['bairro'];
    $clicid = $cli['cidade'];
    $cliuf = $cli['estado'];
    
    $cliconv = $cli['convenio_empresa'];
    $clicart = $cli['convenio_numcartao'];
    
 } 
 
 //VERIFICA SE O CEP ESTA CADASTRADO PARA MUDAR O MODO DE EXIBIÇAO DA DIV DO CEP PARA O MOO DE INSERÇÃO
    if ($clicep == ''){
        $ocultaend = "oc";
        $ocultacep = "";
    }else{
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
 
 //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
    $cpfn = substr_replace($clicpf, '.', 3, 0);
    $cpfn = substr_replace($cpfn, '.', 7, 0);
    $cpfn = substr_replace($cpfn, '-', 11, 0);
 
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
                        
                        <!--DADOS DO DOCUMENTO (CRM)-->
                        <div id="responsavel">
                            <table class="table">
                                <thead>
                                <th colspan="2"><h4 align="center">Documento</h4></th>    
                                </thead>
                                <tr><td><?php echo $tipodoc;?>:</td><td><?php echo $crm;?></td></tr>
                                <tr><td>Órgão Emissor:</td><td><?php echo $crmuf;?></td></tr>
                                <tr><td>Área de Atuação:</td><td><?php echo $crmarea;?></td></tr>
                            </table>
                            <p align="center"><button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalcrm">Editar Documento</button></p>
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
                                            <form method="post" action="com_perfil.php">
                                                <input type="hidden" value="<?php echo $clicpf;?>" name="cpfcli">
                                                <input type="text" name="tCep" class="form-control-cep" placeholder="Somente números" value="<?php echo $exibir_cep; ?>"> 
                                                &nbsp;<button type="submit" class="btn btn-xs btn-primary">Buscar CEP</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <form method="post" action="edit_endereco.php">
                                        <input type="hidden" value="<?php echo $exibir_cep; ?>" name="tCep" >
                                        <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                        <input type="hidden" value="<?php echo $clicpf;?>" name="tCpf">
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
                                        <tr><td>CPF:</td><td><input type="text" name="tCpf" class="form-control" value="<?php echo $clicpf;?>"></td></tr>
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
                
                <!-- MODAL REFERENTE DADOS DO DOCUMENTO (CRM) -->
                <div class="modal fade" id="modalcrm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="myModalLabel">Documento</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <form action="edit_crm.php" method="post">
                                        <input type="hidden" value="<?php echo $cliid;?>" name="tID">
                                        <input type="hidden" value="<?php echo $clicpf;?>" name="tCpf">
                                        <tr><td>Tipo:</td><td><input type="text" name="tTipo" class="form-control" value="<?php echo $tipodoc;?>"></td></tr>
                                        <tr><td>Numero do Documento:</td><td><input type="text" name="tCrm" class="form-control" value="<?php echo $crm;?>"></td></tr>
                                        <tr><td>Órgão Emissor:</td><td><input type="text" name="tCRMUF" class="form-control" value="<?php echo $crmuf;?>"></td></tr>
                                        <tr><td>Área de Atuação:</td><td><input type="text" name="tArea" class="form-control" value="<?php echo $crmarea;?>"></td></tr>
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
                                        <input type="hidden" value="<?php echo $clicpf;?>" name="tCpf">
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
