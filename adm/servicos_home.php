<?php 
session_start();
include '../_php/cx.php';
include 'adm_menunav.php';
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
                <link rel="shortcut icon" href="_imagens/Logo_FRC_1.ico" type="image/x-icon" />
                <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
                <link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <style>
                        .form-control-menor {
                            background-color: rgba(38,42,48,1);
                            color: rgb(255,255,255);
                            width: 80%;
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
                        
                        
                        /*DIV ESQUERDA E DIREITA*/
                        div#esquerda{
                            float: left;
                            width: 47%;
                        }
                        
                        div#direita{
                            float: right;
                            width: 50%;
                        }
                        
                        .produto{
                            display: block;
                            position: relative;
                            border: 1px rgb(85,87,91) solid;
                            border-radius: 10px;
                            width: 100%;
                            margin: 8px;
                            padding: 5px;
                            font-size:14px;
                            box-shadow: 0px 0px 15px rgba(85,87,91,.5);
                            background-color: rgba(40,40,40,.8);
                        }
                        
                        .produto:hover{
                            box-shadow: 0px 0px 10px rgba(255,255,255,0.5);
                            -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                            -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                            transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
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
                                <h1 align="center">Administração</h1>
                        </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $menunav; ?>
                        <br>
                        
                        <h4 align="center">Serviços e Produtos </h4>
                        <h3 align="center"><?php echo $msg;?></h3>
                        <div id="esquerda">
                            <h4 align="center"> Cadastro de produtos e serviços <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalnovo">Novo</button></h4>
                                <?php 
                                //BUSCA DADOS DO CLIENTE COM O ID informado
                                    $prodsql = "SELECT * FROM produto ORDER BY id_prod DESC ";
                                    $enviaprod = $cx->query ($prodsql);

                                    while ($prod = $enviaprod->fetch()){
                                        $prodid = $prod['id_prod'];
                                        $prodnome = $prod['nome_prod'];
                                        $proddesc = $prod['descr_prod'];
                                        $prodvalor = $prod['valor_prod'];
                                        
                                        //ARRUMANDO A PONTUAÇÃO DA MOEDA
                                       $prodvalor = number_format($prodvalor, 2, ',', '.');
                                ?>
                        <div class="produto">
                            <p><span class="tema">ID: </span>&nbsp;<?php echo $prodid;?></p>
                            <p><span class="tema">Produto / Serviço:</span>&nbsp;<?php echo $prodnome;?></p>
                            <p><span class="tema">Descrição:</span>&nbsp;<?php echo $proddesc;?></p>
                            <p><span class="tema">Valor (R$):</span>&nbsp;<span class="banco"><?php echo "R$ $prodvalor";?></span></p>
                            </div>
                                <?php
                                    } 
                                ?>    
                            </table>
                        </div>
                        
                        <div id="direita">
                            <p align="center">Ainda não sei o que colocar deste lado !</p>
                        </div>
                        
                        <!-- MODAL REFERENTE À ADIÇÃO DE NOVO PRODUTO -->
                        <div class="modal fade" id="modalnovo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Editar Dados da Empresa</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <form action="cad_produto.php" method="post">
                                                <tr><td>Nome do Produto:</td><td><input type="text" name="tProd" class="form-control" value="<?php echo $clifantasia;?>"></td></tr>
                                                <tr><td>Descrição Detalhada:</td><td><input type="text" name="tDesc" class="form-control" value="<?php echo $clicnpj;?>"></td></tr>
                                                <tr><td>Valor:</td><td>R$&nbsp;&nbsp;<input type="text" name="tValor" class="form-control-menor" value="<?php echo $clirazao;?>"></td></tr>
                                                <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar</button></td></tr>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!-- Fim do modal para NOVO PRODUTO -->
                        
                        
                        
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
}else{
    header("location:../index.php");
}
?>
