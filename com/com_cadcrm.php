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
                <link href="../_css/clientes.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/com.css" rel="stylesheet" type="text/css"/>
                <link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <style>
                    .filtro {
                        background-color: rgba(38,42,48,1);
                        color: rgb(255,255,255);
                        width: 300px;
                        height:34px;
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
                        <!--MENU DE NAVEGAÇÃO -->
                        <?php echo $menunav; ?>
                        
                        <h4 align="center">Cadastro de Doutores</h4>     
                        <div class="row">
                        <div class="col-md-12">
                            <p align="center">Consultar, alterar e adicionar doutores/médicos no cadastro</p>
                            <h3 align="center"><?php echo $msg;?></h3>
                            <p>
                                <form method="post" action="com_cadcrm.php">
                                    <input type="text" name="tBusca" autofocus="" placeholder="Consulte por CPF ou Nome ou CRM" required="" class="filtro">&nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-sm btn-warning">Buscar</button>&nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalcadcli">Adicionar</button>
                                </form>
                            </p>
                            <br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Data Nascimento</th>
                                        <th>Celular</th>
                                        <th>E-Mail</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                        // Pega os dados enviados por POST de home_cli
                                        $b = "";
                                        $b = isset($_POST["tBusca"]) ? $_POST["tBusca"] : "Busca não informada";

                                        //VAI BUSCAR INFORMAÇÕES DO BANCO DE DADOS
                                        $mostra_sql = "SELECT * FROM clientes where nome = '".$b."' or cpf = '".$b."' or crm = '".$b."' order by nome";
                                        $mostra = $cx->query($mostra_sql);

                                        //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                        while ($dados = $mostra->fetch()) {
                                            $id = $dados['id'];
                                            $sexo = $dados['sexo'];
                                            $tipodoc = $dados['tipo_doc'];
                                            $crm = $dados['crm'];
                                            $crmuf = $dados['estado_crm'];
                                            $crmarea = $dados['area_m'];

                                            //MODIFICANDO E ACRESCENTANDO A VARIAVEL SEXO
                                            if ($sexo = 'M'){
                                                $sexo = 'Masculino';
                                            } else if($sexo = 'F'){
                                                $sexo = 'Feminino';
                                            }

                                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                            $cpfbusca = $dados['cpf'];
                                            $cpfn = substr_replace($cpfbusca, '.', 3, 0);
                                            $cpfn = substr_replace($cpfn, '.', 7, 0);
                                            $cpfn = substr_replace($cpfn, '-', 11, 0);

                                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CELULAR"
                                            $celular = $dados['cel1'];
                                            $cel1n = substr_replace($celular, '(', 0, 0);
                                            $cel1n = substr_replace($cel1n, ')', 3, 0);
                                            $cel1n = substr_replace($cel1n, '-', 9, 0);
                                            $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                            $cel1n = substr_replace($cel1n, ' ', 6, 0);

                                            $fixo=$dados['tel'];
                                            $fixon = substr_replace($fixo, '(', 0, 0);
                                            $fixon = substr_replace($fixon, ')', 3, 0);
                                            $fixon = substr_replace($fixon, '-', 8, 0);
                                            $fixon = substr_replace($fixon, ' ', 4, 0);

                                            //ARRUMANDO DATA DE NASCIMENTO E CALCULANDO A IDADE
                                            $nasc = $dados['nascimento'];
                                            // CALCULAR A IDADE 
                                            // Separa em dia, mês e ano
                                            list($ano, $mes, $dia ) = explode('-', $nasc);
                                            // Descobre que dia é hoje e retorna a unix timestamp
                                            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                            // Descobre a unix timestamp da data de nascimento do fulano
                                            $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

                                            // Depois apenas fazemos o cálculo já citado :)
                                            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                                            //print $idade;
                                            //FIM DO CALCULO DE IDADE
                                            ?>
                                    <tr>
                                        <input type="hidden" name="envia" value="<?php echo $id; ?>">
                                        <td><?php echo $dados['nome']; ?></td>
                                        <td><?php echo $cpfn; ?></td>
                                        <td><?php echo "$dia/$mes/$ano - $idade anos de idade."; ?></td>
                                        <td><?php echo $cel1n; ?></td>
                                        <td><?php echo $dados['email']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalcli<?php echo $id;?>">Exibir</button>

                                            <!-- MODAL REFERENTE À VIZUALIZAR CLIENTE/DOUTOR -->
                                                    <div class="modal fade" id="modalcli<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title text-center" id="myModalLabel">Dados do Cliente</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table">
                                                                            <tr><td>CPF:</td><td colspan="2"><?php echo $cpfn; ?></td></tr>
                                                                            <tr><td>Paciente:</td><td colspan="2"><?php echo $dados['nome']; ?></td></tr>
                                                                            <tr><td>Nascimento:</td><td colspan="2"><?php echo "$dia/$mes/$ano - $idade anos de idade."; ?></td></tr>
                                                                            <tr><td>Sexo:</td><td colspan="2"><?php echo "$sexo"; ?></td></tr>
                                                                            <tr><td>Estado Civil:</td><td colspan="2"><?php echo $dados['estadocivil']; ?></td></tr>
                                                                            <tr><td>Profissão:</td><td colspan="2"><?php echo $dados['prof']; ?></td></tr>
                                                                            <tr><td><?php echo $tipodoc;?>:</td><td colspan="2"><?php echo $crm; ?></td></tr>
                                                                            <tr><td>Órgão Emissor:</td><td colspan="2"><?php echo $crmuf; ?></td></tr>
                                                                            <tr><td>Área de Atuação:</td><td colspan="2"><?php echo $crmarea; ?></td></tr>
                                                                            <tr><td>Celular:</td><td colspan="2"><?php echo $cel1n; ?></td></tr>
                                                                            <tr><td>Telefone Fixo:</td><td colspan="2"><?php echo $fixon; ?></td></tr>
                                                                            <tr><td>E-Mail:</td><td colspan="2"><?php echo $dados['email']; ?></td></tr>
                                                                            
                                                                            <tr><td colspan="3" align="center">
                                                                        <form action="com_perfil.php" method="post">
                                                                            <input type="hidden" value="<?php echo $cpfbusca; ?>" name="cpfcli">
                                                                            <button type="submit" class="btn btn-xs btn-primary">Vizualizar Cadastro</button>
                                                                        </form>
                                                                                </td></tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                            <!-- Fim do modal da vizualização CLIENTE/DOUTOR -->
                                        </td>
                                    </tr>
                                    <?php    
                                            }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- MODAL REFERENTE À ADICIONAR NOVO CLIENTE/DOUTOR -->
                    <div class="modal fade" id="modalcadcli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title text-center" id="myModalLabel">Cadastrar Novo Cliente</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <form action="cad_doc.php" method="post">
                                            <tr><td>CPF:</td><td><input type="text" name="tCpf" class="form-control" required=""></td></tr>
                                            <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" required=""></td></tr>
                                            <tr><td>Nascimento:</td><td><input type="date" name="tNasc" class="form-control"></td></tr>
                                            <tr><td>Sexo:</td><td>
                                                    <select name="tSexo" class="form-control">
                                                        <option selected>Selecione</option>
                                                        <option value="M">Masculino</option>
                                                        <option value="F">Feminino</option>
                                                    </select>
                                                </td></tr>
                                            <tr><td>Estado Civil:</td><td>
                                                    <select name="tEst" class="form-control">
                                                        <option selected>Selecione</option>
                                                        <option>Solteiro(a)</option>
                                                        <option>Casado(a)</option>
                                                        <option>União Estavel</option>
                                                        <option>Divorciado(a)</option>
                                                        <option>Viúvo(a)</option>
                                                    </select>
                                                </td></tr>
                                            <tr><td>Profissão:</td><td><input type="text" name="tProf" class="form-control"></td></tr>
                                            <tr><td>Tipo do Documento:</td><td><input type="text" name="tTipo" class="form-control" placeholder="CRM, CRP ..."></td></tr>
                                            <tr><td>Numero Documento:</td><td><input type="text" name="tCRM" class="form-control"></td></tr>
                                            <tr><td>Orgão Emissor:</td><td><input type="text" name="tUFCRM" class="form-control"></td></tr>
                                            <tr><td>Área de Atuação:</td><td><input type="text" name="tArea" class="form-control"></td></tr>
                                            <tr><td>Celular:</td><td><input type="text" name="tCel" class="form-control"></td></tr>
                                            <tr><td>Telefone Fixo:</td><td><input type="text" name="tFixo" class="form-control"></td></tr>
                                            <tr><td>E-Mail:</td><td><input type="mail" name="tMail" class="form-control"></td></tr>
                                            <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                        </form>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <!-- Fim do modal para adicionar CLIENTE/DOUTOR -->
                    
                    </div>
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
