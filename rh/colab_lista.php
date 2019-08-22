<?php
    session_start();
    include '../_php/cx.php';
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
     
    $data_atual = date('Y-m-d');
    
    $msg_erro = isset ($_POST['erro'])?$_POST['erro']:"";
     
     
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
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <style>
                    a {
                        color: #D3D3D3;
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
				<h1 align="center">Colaboradores </h1>
			</div>
			<div class="row">
				<div class="col-md-12">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li role="presentation" class="active"><a href="#" target="_self">Colaboradores</a></li>
                                        <li role="presentation"><a href="colab_cad.php" target="_self">Cadastrar Usuário</a></li>
                                    </ul>
                                </div>
			</div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 align="center"><?php echo $msg_erro;?></h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="8"><h4 align="center">Doutores</h4></th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Doc. Num.</th>
                                            <th>Area Espec.</th>
                                            <th>Celular</th>
                                            <th>Email</th>
                                            <th colspan="2">Ação</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    
                                    //VAI BUSCAR INFORMAÇÕES DO BANCO DE DADOS
                                    $mostra_sql = "SELECT * FROM cnpj_user u JOIN cnpj c ON u.cnpj_vinc = c.cnpj_c JOIN clientes ON u.cpf_vinc = clientes.cpf WHERE u.cnpj_vinc = '".$cnpj."' and u.crm !='' ORDER BY clientes.nome";
                                    $mostra = $cx->query ($mostra_sql);

                                    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                    while ($dados = $mostra->fetch()){
                                        $id = $dados['id'];
                                        $cel1 = $dados['cel1'];
                                        $cpf = $dados['cpf'];
                                        $tipodoc = $dados['tipo_doc'];
                                        $crm = $dados['crm'];

                                        $cel1n = substr_replace($cel1, '(', 0, 0);
                                        $cel1n = substr_replace($cel1n, ')', 3, 0);
                                        $cel1n = substr_replace($cel1n, '-', 9, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 6, 0);

                                        $cpfn = substr_replace($cpf, '.', 3, 0);
                                        $cpfn = substr_replace($cpfn, '.', 7, 0);
                                        $cpfn = substr_replace($cpfn, '-', 11, 0);
                                        
                                        ?>

                                    
                                        <tr class="<?php echo $cor_classe;?>">
                                                    <input type='hidden' value ="<?php echo $id;?>" name ='envia'>
                                                    <td><?php echo $dados['nome'];?></td>
                                                    <td><?php echo $cpfn;?></td>
                                                    <td><?php echo $crm;?></td>
                                                    <td><?php echo $dados['area_m'];?></td>
                                                    <td><?php echo $cel1n;?></td>
                                                    <td><?php echo $dados['email'];?></td>
                                                    <td>
                                                        <button type='button' class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaleditdoc<?php echo $id;?>">Editar</button>
                                                            <!-- MODAL REFERENTE À EDITAR DOUTOR -->
                                                                <div class="modal fade" id="modaleditdoc<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title text-center" id="myModalLabel">Editar Dados do Doutor</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <table class="table">
                                                                                    <form action="edit_colab.php" method="post">
                                                                                        <input type="hidden" value="<?php echo $id;?>" name="tID">
                                                                                        <tr><td>CPF:</td><td><?php echo $cpfn;?></td></tr>
                                                                                        <tr><td>Nome:</td><td><?php echo $dados['nome'];?></td></tr>
                                                                                        <tr><td>Área de Atuação:</td><td><input type="text" name="tProf" class="form-control" value="<?php echo $dados['prof'];?>"></td></tr>
                                                                                        <tr><td>Celular:</td><td><input type="text" name="tCel1" class="form-control" value="<?php echo $cel1;?>"></td></tr>
                                                                                        <tr><td>E-Mail:</td><td><input type="mail" name="tEmail" class="form-control" value="<?php echo $dados['email'];?>"></td></tr>
                                                                                        <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar</button></td></tr>
                                                                                    </form>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            <!-- Fim do modal para EDITAR DOUTOR -->
                                                    </td>
                                                    </td>
                                                    <td>
                                                        <button type='button' class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modaldeldoc<?php echo $id;?>">Excluir</button>
                                                        <!-- MODAL REFERENTE À EXCLUIR DOUTOR -->
                                                                <div class="modal fade" id="modaldeldoc<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title text-center" id="myModalLabel">Excluir Doutor</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="del_colab.php" method="post">
                                                                                        <input type="hidden" value="<?php echo $dados['id_u_cnpj'];?>" name="tID">
                                                                                        <p align="center">Certeza que deseja deletar o usuário </p>
                                                                                        <p align="center"><?php echo $dados['nome'];?></p>
                                                                                        <p align="center">CPF: <?php echo $cpfn;?></p>
                                                                                        <p align="center"><button type="submit" class="btn btn-sm btn-danger">Excluir</button></p>
                                                                                    </form>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            <!-- Fim do modal para EXCLUIR DOUTOR -->
                                                    </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    
                                </table>
                                <table class="table">
                                    <thead>
                                        <thead>
                                        <tr>
                                            <th colspan="7"><h4 align="center">Colaboradores</h4></th>
                                        </tr>
                                    </thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Area</th>
                                            <th>Celular</th>
                                            <th>Email</th>
                                            <th colspan="2">Ação</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    
                                    //VAI BUSCAR INFORMAÇÕES DO BANCO DE DADOS
                                    $mostra_sql = "SELECT * FROM cnpj_user u JOIN cnpj c ON u.cnpj_vinc = c.cnpj_c JOIN clientes ON u.cpf_vinc = clientes.cpf WHERE u.cnpj_vinc = '".$cnpj."' AND u.crm is null OR u.cnpj_vinc = '".$cnpj."' AND u.crm = '' ORDER BY clientes.nome";
                                    $mostra = $cx->query ($mostra_sql);

                                    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
                                    while ($dados = $mostra->fetch()){
                                        $id = $dados['id'];
                                        $cel1 = $dados['cel1'];
                                        $cpf = $dados['cpf'];

                                        $cel1n = substr_replace($cel1, '(', 0, 0);
                                        $cel1n = substr_replace($cel1n, ')', 3, 0);
                                        $cel1n = substr_replace($cel1n, '-', 9, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 4, 0);
                                        $cel1n = substr_replace($cel1n, ' ', 6, 0);

                                        $cpfn = substr_replace($cpf, '.', 3, 0);
                                        $cpfn = substr_replace($cpfn, '.', 7, 0);
                                        $cpfn = substr_replace($cpfn, '-', 11, 0);
                                        
                                        ?>

                                    
                                        <tr class="<?php echo $cor_classe;?>">
                                                    <input type='hidden' value ="<?php echo $id;?>" name ='envia'>
                                                    <td><?php echo $dados['nome'];?></td>
                                                    <td><?php echo $cpfn;?></td>
                                                    <td><?php echo $dados['prof'];?></td>
                                                    <td><?php echo $cel1n;?></td>
                                                    <td><?php echo $dados['email'];?></td>
                                                    <td>
                                                        <button type='button' class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaleditcolab<?php echo $id;?>">Editar</button>
                                                            <!-- MODAL REFERENTE À EDITAR COLABORADOR -->
                                                                <div class="modal fade" id="modaleditcolab<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title text-center" id="myModalLabel">Editar Dados do Colaborador</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <table class="table">
                                                                                    <form action="edit_colab.php" method="post">
                                                                                        <input type="hidden" value="<?php echo $id;?>" name="tID">
                                                                                        <tr><td>CPF:</td><td><?php echo $cpfn;?></td></tr>
                                                                                        <tr><td>Nome:</td><td><?php echo $dados['nome'];?></td></tr>
                                                                                        <tr><td>Área de Atuação:</td><td><input type="text" name="tProf" class="form-control" value="<?php echo $dados['prof'];?>"></td></tr>
                                                                                        <tr><td>Celular:</td><td><input type="text" name="tCel1" class="form-control" value="<?php echo $cel1;?>"></td></tr>
                                                                                        <tr><td>E-Mail:</td><td><input type="mail" name="tEmail" class="form-control" value="<?php echo $dados['email'];?>"></td></tr>
                                                                                        <tr><td colspan="2" align="center"><button type="submit" class="btn btn-sm btn-primary">Salvar</button></td></tr>
                                                                                    </form>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            <!-- Fim do modal para EDITAR COLABORADOR -->
                                                    </td>
                                                    <td>
                                                        <button type='button' class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modaldelcolab<?php echo $id;?>">Excluir</button>
                                                        <!-- MODAL REFERENTE À EXCLUIR COLABORADOR -->
                                                                <div class="modal fade" id="modaldelcolab<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title text-center" id="myModalLabel">Excluir Colaborador</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="del_colab.php" method="post">
                                                                                        <input type="hidden" value="<?php echo $dados['id_u_cnpj'];?>" name="tID">
                                                                                        <p align="center">Certeza que deseja deletar o usuário </p>
                                                                                        <p align="center"><?php echo $dados['nome'];?></p>
                                                                                        <p align="center">CPF: <?php echo $cpfn;?></p>
                                                                                        <p align="center"><button type="submit" class="btn btn-sm btn-danger">Excluir</button></p>
                                                                                    </form>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            <!-- Fim do modal para EXCLUIR COLABORADOR -->
                                                    </td>
                                                
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    
                                </table>
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