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

    $atendimento = isset($_POST['id'])?$_POST['id']:'erro';
    $obs = isset($_POST['obs'])?$_POST['obs']:'erro';
    $data_atual = date('Y-m-d');
    $hora_atual = date('H:i:s');
    
    //BUSCA INFORMAÇÕES NA TABELA DE ATENDIMENTO, COM A REFERENCIA DO ID
    $selectatend = "SELECT fim_hora, fim_data, obs FROM atendimento WHERE id_atend = '".$atendimento."'";
    $enviaselectatend = $cx->query ($selectatend);
    while ($atenddados = $enviaselectatend->fetch()){
        $atend_fimhora = $atenddados['fim_hora'];
        $atend_fimdata = $atenddados['fim_data'];
        $obs_banco = $atenddados['obs'];
    }
    
    $obsadd = $obs_banco."   ".$obs;
            
        if ($atend_fimhora == '' and $atend_fimdata == ''){

            //PREPARANDO COMANDO SQL PARA SER ENVIADO PARA BANCO
                $sql_cad = "UPDATE atendimento SET fim_data = '".$data_atual."', fim_hora = '".$hora_atual."', obs = '".$obsadd."' WHERE id_atend = '".$atendimento."' limit 1";

            //ENVIANDO COMANDO PARA O BANCO                    
                $query_cad = $cx->query ($sql_cad);
                if ($query_cad) {
                header("location:home_atend.php");
                } else {
                $msg_cad = "OCORREU UM ERRO AO ABRIR A TABELA DE ATENDIMENTO ! ";
                }
        }else{
            $message = "ESTA FICHA, DESTE PACIENTE, JÁ ESTA ENCERRADA";
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
                                    <h1 align="center">Encerrando de Atendimento</h1>
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                            <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4"><p>Atendimento: <?php echo $atendimento; ?></p>
                                                                            <p><?php echo $message;?></p></th>
                                                        </tr>
                                                    </thead>
                                                    
                                            </table>
                                            <p><a href="home_atend.php" class="btn btn-sm btn-success">Entendi</a></p>
                                    </div>
                            </div>
                        <br>
                        <footer id="rodape">
                            <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                            <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                        </footer>
                    </div>


      </body>
    </html>
    <?php
    }else{
        header("location:../index.php");
    }
?>