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
                    
                        <h4 align="center">Cliente CNPJ</h4>    
                        <div class="row">
                            <div class="col-md-12">
                                <p align="center">Consultar, alterar e adicionar dados de empresas(CNPJ) no sistema</p>
                                <h3 align="center"><?php echo $msg;?></h3>
                                <p>
                                    <form method="post" action="com_cadcnpj.php">
                                        <input type="text" name="tBusca" autofocus="" placeholder="Consulte por CNPJ" required="" class="filtro">&nbsp;&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-sm btn-warning">Buscar</button>&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalcadcnpj">Adicionar</button>
                                    </form>
                                </p>
                                <br>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Razão Social</th>
                                            <th>CNPJ</th>
                                            <th>Telefone</th>
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
                                            $mostra_sql = "SELECT * FROM cnpj WHERE cnpj_c like '%".$b."%' OR razao_c like '%".$b."%' order by razao_c ";
                                            $mostra = $cx->query($mostra_sql);

                                            //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                            while ($dados = $mostra->fetch()) {
                                                $id_c = $dados['id_c'];
                                                $razaocli = $dados['razao_c'];
                                                $fantasiacli = $dados['nfantasia_c'];
                                                $unidadecli = $dados['unidade'];
                                                $emailcli = $dados['email_c'];
                                                $sitecli = $dados['site_c'];
                                                $tel1cli = $dados['tel1_c'];
                                                $tel2cli = $dados['tel2_c'];

                                                //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
                                                $cnpjcli = $dados['cnpj_c'];
                                                $cnpjn = substr_replace($cnpjcli, '.', 2, 0);
                                                $cnpjn = substr_replace($cnpjn, '.', 6, 0);
                                                $cnpjn = substr_replace($cnpjn, '/', 10, 0);
                                                $cnpjn = substr_replace($cnpjn, '-', 15, 0);
                                                
                                                //MODIFICANDO TELEFONE FIXO PARA EXIBIÇÃO
                                                $fixo1n = substr_replace($tel1cli, '(', 0, 0);
                                                $fixo1n = substr_replace($fixo1n, ')', 3, 0);
                                                $fixo1n = substr_replace($fixo1n, '-', 8, 0);
                                                $fixo1n = substr_replace($fixo1n, ' ', 4, 0);  
                                                
                                                $fixo2n = substr_replace($tel2cli, '(', 0, 0);
                                                $fixo2n = substr_replace($fixo2n, ')', 3, 0);
                                                $fixo2n = substr_replace($fixo2n, '-', 8, 0);
                                                $fixo2n = substr_replace($fixo2n, ' ', 4, 0);
                                                ?>
                                        <tr>
                                            <input type="hidden" name="envia" value="<?php echo $id_c; ?>">
                                            <td><?php echo $razaocli; ?></td>
                                            <td><?php echo $cnpjn; ?></td>
                                            <td><?php echo $fixo1n; ?></td>
                                            <td><?php echo $emailcli; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalcli<?php echo $id_c;?>">Exibir</button>

                                                <!-- MODAL REFERENTE À VIZUALIZAR CNPJ -->
                                                        <div class="modal fade" id="modalcli<?php echo $id_c;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title text-center" id="myModalLabel">Dados do Cliente</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                                <tr><td>CNPJ:</td><td colspan="2"><?php echo $cnpjn; ?></td></tr>
                                                                                <tr><td>Nome Fantasia:</td><td colspan="2"><?php echo $fantasiacli; ?></td></tr>
                                                                                <tr><td>Razão Social:</td><td colspan="2"><?php echo $razaocli; ?></td></tr>
                                                                                <tr><td>Unidade:</td><td colspan="2"><?php echo $unidadecli; ?></td></tr>
                                                                                <tr><td>Telefone 1:</td><td colspan="2"><?php echo $fixo1n; ?></td></tr>
                                                                                <tr><td>Telefone 2:</td><td colspan="2"><?php echo $fixo2n; ?></td></tr>
                                                                                <tr><td>Site:</td><td colspan="2"><?php echo $sitecli; ?></td></tr>
                                                                                <tr><td>E-Mail:</td><td colspan="2"><?php echo $emailcli; ?></td></tr>

                                                                                <tr><td colspan="3" align="center">
                                                                            <form action="com_perfilcnpj.php" method="post">
                                                                                <input type="hidden" value="<?php echo $id_c; ?>" name="idcnpj">
                                                                                <button type="submit" class="btn btn-xs btn-primary">Vizualizar Cadastro</button>
                                                                            </form>
                                                                                    </td></tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                <!-- Fim do modal da vizualização CNPJ -->
                                            </td>
                                        </tr>
                                        <?php    
                                                }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- MODAL REFERENTE À ADICIONAR NOVO CNPJ -->
                        <div class="modal fade" id="modalcadcnpj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Cadastrar Novo Cliente</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <form action="cad_cnpj.php" method="post">
                                                <tr><td>CNPJ:</td><td><input type="text" name="tCNPJ" class="form-control" required=""></td></tr>
                                                <tr><td>Razão Social:</td><td><input type="text" name="tRS" class="form-control" required=""></td></tr>
                                                <tr><td>Nome Fantasia:</td><td><input type="text" name="tFant" class="form-control"></td></tr>
                                                <tr><td>Unidade:</td><td><input type="text" name="tUni" class="form-control"></td></tr>
                                                <tr><td>Telefone (Opção 1):</td><td><input type="text" name="Tel1" class="form-control"></td></tr>
                                                <tr><td>Telefone (Opção 2):</td><td><input type="text" name="Tel2" class="form-control"></td></tr>
                                                <tr><td>Telefone (Opção 3):</td><td><input type="text" name="Tel3" class="form-control"></td></tr>
                                                <tr><td>E-Mail:</td><td><input type="mail" name="tMail" class="form-control"></td></tr>
                                                <tr><td>Pagina Web:</td><td><input type="text" name="tWeb" class="form-control"></td></tr>
                                                <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar e Continuar</button></td></tr>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!-- Fim do modal para adicionar CNPJ -->
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
