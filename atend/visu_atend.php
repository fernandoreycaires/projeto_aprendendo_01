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


//RECEBE VALORES DE HOME_ATEND.PHP
$atendimento = isset($_POST['id'])?$_POST['id']:'erro';
$id_pac = isset($_POST['idpac'])?$_POST['idpac']:'Não Informado';
$cpf_paciente = isset($_POST['cpf'])?$_POST['cpf']:'Não Informado';
$cpf_rg = isset($_POST['rg'])?$_POST['rg']:'Não Informado';
$cpf_cn = isset($_POST['cn'])?$_POST['cn']:'Não Informado';
$status = isset($_POST['status'])?$_POST['status']:'erro';
$ocultar = isset($_POST['ocultar'])?$_POST['ocultar']:'';

//BUSCA INFORMAÇÕES NA TABELA CLIENTES, COM A REFERENCIA DO ID E DOS DOCUMENTOS
$selectcpf = "SELECT * FROM clientes WHERE id = '".$id_pac."' OR cpf !='' AND cpf = '".$cpf_paciente."' OR rg !='' AND rg = '".$cpf_rg."' OR certnasc != '' AND certnasc = '".$cpf_cn."'";
$enviaselectcpf = $cx->query ($selectcpf);
while ($cpfdados = $enviaselectcpf->fetch()){
    $cpf_id = $cpfdados['id'];
    $cpf_cpf = $cpfdados['cpf'];
    $rg = $cpfdados['rg'];
    $cn = $cpfdados['certnasc'];
    $cpf_nome = $cpfdados['nome'];
    $cpf_nasc = $cpfdados['nascimento'];
}

//BUSCA INFORMAÇÕES NA TABELA DE ATENDIMENTO, COM A REFERENCIA DO ID
$selectatend = "SELECT * FROM atendimento WHERE id_atend = '".$atendimento."'";
$enviaselectatend = $cx->query ($selectatend);
while ($atenddados = $enviaselectatend->fetch()){
    $atend_nome = $atenddados['nome'];
    $atend_inihora = $atenddados['ini_hora'];
    $atend_dia = $atenddados['ini_data'];
    $atend_conv = $atenddados['convenio'];
    $atend_dtr = $atenddados['doutor'];
    $atend_obs = $atenddados['obs'];
}

//ARRUMANDO PONTOS E HIFENS PARA EXIBIR O CPF
$pac_cpfn = substr_replace($cpf_paciente, '.', 3, 0);
$pac_cpfn = substr_replace($pac_cpfn, '.', 7, 0);
$pac_cpfn = substr_replace($pac_cpfn, '-', 11, 0);

//ARRUMA A VARIAVEL DATA PARA SER EXIBIDA 
// Separa em dia, mês e ano
list($ano, $mes, $dia) = explode('-', $atend_dia);
list($anonasc, $mesnasc, $dianasc) = explode('-', $cpf_nasc);

//VERIFICA SE USUARIO JÁ ESTA CADASTRADO NO SISTEMA, CASO NÃO ESTEJA EMITE UMA MENSAGEM PARA O UTILIZADOR E UTILIZA OS DADOS CADASTRADO NA TABELA ATENDIMENTO
if ($cpf_id == ""){
    $nomeutil = $atend_nome;
    $convutil = $atend_conv; 
    $message = 'PACIENTE NÃO CADASTRADO NO SISTEMA, RECOMENDAMOS QUE EXECUTE O CADASTRAMENTO DO MESMO PARA MELHOR UTILIZAÇÃO';
}else{
    $nomeutil = $cpf_nome;
    $convutil = $cpf_conv;
}


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
                <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
		<link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/jquery.min.js'></script>
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
                </style>
                
	</head>
	<body>
                <div class="container-fluid theme-showcase estilo" role="main">
                    <div class="logo1"></div>
                    <header class="cabecalho">
                        <a href="home_atend.php" type="button" class="dropdownvoltar">Voltar</a>
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
				<h1 align="center">Ficha de Atendimento</h1>
			</div>
			<div class="row">
				<div class="col-md-12">
                                    
                                            <table class="table">

                                                <thead>
                                                    <tr>
                                                        <th colspan="4">Atendimento: <?php echo $atendimento; ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td>Hora da abertura:</td><td><?php echo "$atend_inihora"; ?></td><td>Dia:</td><td><?php echo "$dia/$mes/$ano"; ?></td></tr>
                                                    <tr><td>Paciente:</td><td  colspan="3"><?php echo $nomeutil; ?></td></tr>
                                                    <tr><td>Dt. Nascimento:</td><td><?php echo "$dianasc/$mesnasc/$anonasc "; ?></td><td>CPF:</td><td><?php echo $pac_cpfn; ?></td></tr>
                                                    <tr><td>Doutor:</td><td><?php echo $atend_dtr; ?></td><td>Status: </td><td><?php echo $status; ?></td></tr>
                                                    <tr><td>Observação</td><td colspan="3"><p><?php echo $message; ?></p><p><?php echo $atend_obs; ?></p></td></tr>
                                                </tbody>
                                            </table>
                                    <form method="post" action="encerrar_atend.php">
                                        <input type="hidden" value="ENCERRADO PELA RECEPÇÃO" name="obs">
                                        <input type="hidden" value="<?php echo $atendimento; ?>" name="id">
                                            <p>
                                                <span class="<?php echo $ocultar;?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Encerrar Atendimento</button>&nbsp;
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modaleditar">Editar</button>
                                                </span>
                                            </p>
                                    </form>
                                </div>
			</div>
                    
                    
                        <!-- MODAL REFERENTE À EDITAR ATENDIMENTO -->
                        <div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title text-center" id="myModalLabel">Editar Atendimento <?php echo $atendimento; ?></h4>
                                    </div>

                                    <div class="modal-body">
                                        <form method="post" action="edit_atend.php">
                                            <input type="hidden" name='atendimento' value="<?php echo $atendimento; ?>">
                                            <table class="table">
                                                <tr><td>Nome:</td><td><input type="text" class="form-control" value="<?php echo $atend_nome;?>" name="nome"></td></tr>
                                                <tr><td>CPF: </td><td><input type="text" class="form-control" value="<?php echo $cpf_paciente;?>" name="cpf"></td></tr>
                                                <tr><td>RG: </td><td><input type="text" class="form-control" value="<?php echo $rg;?>" name="rg"></td></tr>
                                                <tr><td>Cert. Nasc.: </td><td><input type="text" class="form-control" value="<?php echo $cn;?>" name="cn"></td></tr>
                                            </table>
                                            <p align="center"><button type="submit" class="btn btn-xm btn-primary">Salvar</button></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim do modal da edição -->
                        
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