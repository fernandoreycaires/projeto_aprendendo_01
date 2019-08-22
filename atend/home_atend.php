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
     
    //RECEBE DADOS DO FILTRO
    $filtrodata = isset($_POST['tNasc'])?$_POST['tNasc']:'';
    if ($filtrodata == ''){
        $filtrodata = date('Y-m-d');
        $exibirdata = '(Hoje)';
    }
    
    $filtrodoc = isset($_POST['filtro_crm'])?$_POST['filtro_crm']:'';
    if ($filtrodoc == ''){
        $filtrosql = "SELECT * FROM atendimento WHERE cnpj = '".$cnpju."' AND ini_data = '".$filtrodata."' order by ini_hora";
        $relatconvenio = "SELECT convenio, COUNT(*) FROM atendimento WHERE cnpj = '".$cnpju."' AND ini_data = '".$filtrodata."' GROUP BY convenio ORDER BY convenio ";
    } else {
        $filtrosql = "SELECT * FROM atendimento WHERE cnpj = '".$cnpju."' AND ini_data = '".$filtrodata."' and crm = '".$filtrodoc."' order by ini_hora";
        $relatconvenio = "SELECT convenio, COUNT(*) FROM atendimento WHERE cnpj = '".$cnpju."' AND ini_data = '".$filtrodata."' and crm = '".$filtrodoc."' GROUP BY convenio ORDER BY convenio ";
    }
    
    $atendimento = isset($_POST['tAtend'])?$_POST['tAtend']:'';
    if ($atendimento != ''){
        $filtrosql = "SELECT * FROM atendimento WHERE cnpj = $cnpju and id_atend = $atendimento";
        $relatconvenio = "SELECT convenio, COUNT(*) FROM atendimento WHERE cnpj = $cnpju and id_atend = $atendimento  GROUP BY convenio";
    }
    
    // Separa em dia, mês e ano
    list($ano,$mes,$dia ) = explode('-', $filtrodata);
            
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Atendimento</title>
                <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
                <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
                <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
                <link href='../_css/bootstrap.min.css' rel='stylesheet'>
                <script src='../_javascript/bootstrap.min.js'></script>
                <script src='../_javascript/jquery.min.js'></script>
                <style>
                    .filtro {
                        background-color: rgba(38,42,48,1);
                        color: rgb(255,255,255);
                        width: 190px;
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
                    
                    .listaverde{
                        font-size: 11pt;
                        color: rgb(255,255,255);
                        background-color: rgba(0,77,0,.3);
                    }

                    .listavermelha{
                        font-size: 11pt;
                        color: rgb(255,255,255);
                        background-color: rgba(102,0,0,.3);
                    }
                    
                    /* ALTERA AS CONFIGURAÇÕES de plano de fundo da janela modal*/
                    .modal-backdrop {
                        background-color: #1C1C1C;
                    }

                    /* ALTERA AS CONFIGURAÇÕES de conteudo da Janela Modal */
                    .modal-content {
                        background-color: rgb(38,42,48);
                    }
                    
                </style>
	</head>
	<body>
                <div class="container-fluid theme-showcase estilo" role="main">
                    <div class="logo1"></div>
                    <header class="cabecalho">
                        <a href="#" type="button" onclick="window.close()" class="dropdownvoltar">Voltar</a>
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
				<h1 align="center">Atendimentos <?php echo "$exibirdata";?> <?php echo "$dia / $mes / $ano"?></h1>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table">
                                                <thead>
                                                
                                                        <tr>
                                                            <th colspan="8">
                                                                <form method="post" action="home_atend.php">Doutor: 
                                                                        <select name="filtro_crm" class="filtro">
                                                                            <option value="">Todos</option>
                                                                                <?php 
                                                                                $doc = "SELECT nome_u, crm FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' and crm != ''";
                                                                                $docenviabanco = $cx->query($doc);
                                                                                while ($docrecebe = $docenviabanco->fetch()){
                                                                                ?>
                                                                            <option value="<?php echo $docrecebe['crm'];?>"><?php echo $docrecebe['nome_u'];?></option>
                                                                                <?php 
                                                                                }
                                                                                ?>  
                                                                        </select>
                                                                    Data:&nbsp; <input type="date" class="filtro" name="tNasc">
                                                                    Atendimento:&nbsp;<input type="text" class="filtro" name="tAtend">
                                                                    <input type="submit" class="btn btn-sm btn-warning" value="Filtrar">
                                                                </form>
                                                            </th>  
                                                            <th>
                                                                <a href="novo_atend.php" class="btn btn-sm btn-primary" >Novo Atendimento</a>
                                                            </th>
                                                        </tr>
                                                
							<tr>
								<th>Atendimento</th>
								<th>Paciente</th>
                                                                <th>CPF</th>
                                                                <th>RG</th>
                                                                <th>Chegada</th>
                                                                <th>Retorno</th>
                                                                <th>Doutor</th>
                                                                <th>Status</th>
								<th>Ação</th>
							</tr>
						</thead>
						<tbody>
                                                            <?php 
                                                            
                                                            
                                                            //BUSCA INFORMAÇÕES DA TABELA ATENDIMENTO
                                                            $atend_sql = $filtrosql;
                                                            $atend_acesso = $cx->query ($atend_sql);
                                                            while ($atend = $atend_acesso->fetch()){ 
                                                            
                                                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
                                                            $pac_cpf = $atend['cpf'];
                                                            $pac_cpfn = substr_replace($pac_cpf, '.', 3, 0);
                                                            $pac_cpfn = substr_replace($pac_cpfn, '.', 7, 0);
                                                            $pac_cpfn = substr_replace($pac_cpfn, '-', 11, 0);
                                                            
                                                            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
                                                            $pac_rg = $atend['rg'];
                                                            $rgn = substr_replace($pac_rg, '.', 2, 0);
                                                            $rgn = substr_replace($rgn, '.', 6, 0);
                                                            $rgn = substr_replace($rgn, '-', 10, 0);
                                                            
                                                            //ARRUMA A VARIAVEL RETORNO PARA SIM OU NÃO
                                                            $retorno = $atend['retorno'];
                                                            if ($retorno == 'N'){
                                                                $ret = 'NÃO';
                                                            }else if ($retorno == 'S'){
                                                                $ret = 'SIM';
                                                            }
                                                            
                                                            //BUSCA INFORMAÇÃO NO BANCO PARA ALIMENTAR A VARIAVEL STATUS
                                                            $fim = $atend['fim_hora'];
                                                            if ($fim == ''){
                                                                $status = 'AGUARDANDO SER ATENDIDO';
                                                                $ocultar = '';
                                                            } else {
                                                                $status = 'ATENDIDO';
                                                                $ocultar = 'oc';
                                                            }
                                                            
                                                            // MODIFICANDO AS CORES DAS LINHAS DA TABELA, PARA IDENTIFICAÇÃO VISUAL DE QUEM FALTA ATENDER E QUEM JÁ FOI ATENDIDO

                                                            if ($status == 'AGUARDANDO SER ATENDIDO'){
                                                                $cor_classe = 'listavermelha';
                                                            }else{
                                                                $cor_classe = 'listaverde';
                                                            }
                                                            ?>
                                                                <tr class="<?php echo $cor_classe;?>">
                                                                        <td><?php echo $atend['id_atend']; ?></td>
									<td><?php echo $atend['nome']; ?></td>
                                                                        <td><?php echo $pac_cpfn;?></td>
                                                                        <td><?php echo $rgn;?></td>
                                                                        <td><?php echo $atend['ini_hora']; ?></td>
                                                                        <td><?php echo $ret ?></td>
                                                                        <td><?php echo $atend['doutor'];?></td>
                                                                        <td><?php echo $status ?></td>
									<td>
                                                                            <form method='post' action='visu_atend.php'>
                                                                                <input type='hidden' value ='<?php echo $atend['id_pac']; ?>' name ='idpac'>
                                                                                <input type='hidden' value ='<?php echo $atend['cpf']; ?>' name ='cpf'>
                                                                                <input type='hidden' value ='<?php echo $pac_rg; ?>' name ='rg'>
                                                                                <input type='hidden' value ='<?php echo $atend['certnasc']; ?>' name ='cn'>
                                                                                <input type='hidden' value ='<?php echo $atend['id_atend']; ?>' name ='id'>
                                                                                <input type='hidden' value ='<?php echo $status; ?>' name ='status'>
                                                                                <input type='hidden' value ='<?php echo $ocultar; ?>' name ='ocultar'>
                                                                                    <button type="submit" class="btn btn-xs btn-primary">Visualizar</button>
                                                                                    <span class="<?php echo $ocultar;?>">
                                                                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modaldeletar<?php echo $atend['id_atend']; ?>">Excluir</button>
                                                                                    </span>
                                                                            </form>
                                                                                    <!-- MODAL REFERENTE À DELETAR ATENDIMENTO -->
                                                                                    <div class="modal fade" id="modaldeletar<?php echo $atend['id_atend'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                    <h4 class="modal-title text-center" id="myModalLabel">Deletar Atendimento <?php echo $atend['id_atend']; ?></h4>
                                                                                                </div>

                                                                                                <div class="modal-body">
                                                                                                    <form method="post" action="del_atend.php">
                                                                                                        <input type="hidden" name='atendimento' value="<?php echo $atend['id_atend'];?>">
                                                                                                        <p align="center">Deseja excluir o atendimento de <span class="banco"><?php echo $atend['nome'];?></span></p>
                                                                                                        <p align="center"><button type="submit" class=" btn btn-xm btn-danger">Excluir</button></p>
                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Fim do modal do delete -->
                                                                                    
									</td>
                                                                </tr>
                                                                
							<?php } ?>
						</tbody>
                                        </table>
                                    <p>
                                    <form method="post" action="pdf_relat_atend.php" target="_blank">
                                            <input type='hidden' value ='<?php echo "$dia / $mes / $ano"?>' name ='filtrodata'>
                                            <input type="hidden" value="<?php echo $filtrosql;?>" name="filtro">
                                            <input type="hidden" value="<?php echo $relatconvenio;?>" name="relatconvenio">
                                            <input type="submit" class="btn btn-sm btn-info" value="Gerar PDF">
                                        </form>
                                    </p>
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
