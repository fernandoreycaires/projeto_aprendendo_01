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

        //RECEBE DADOS novo_atend.php PARA FAZER A ABERTURA DO ATENDIMENTO 
        $atend_nome = isset($_POST['tNome'])?$_POST['tNome']:'0';
        $atend_cpf = isset($_POST['tCpf'])?$_POST['tCpf']:'0';
        $atend_cel = isset($_POST['tCel'])?$_POST['tCel']:'0';
        $atend_ret = isset($_POST['tRet'])?$_POST['tRet']:'0';
        $atend_crm = isset($_POST['tCrm'])?$_POST['tCrm']:'0';
        $atend_conv = isset($_POST['tCon'])?$_POST['tCon']:'0';
        $atend_obs = isset($_POST['tObs'])?$_POST['tObs']:'0';
        $atend_ini_data = date('Y-m-d');
        $atend_ini_hora = date('H:i:s');
        
        // BUSCANDO INFORMAÇÕES DO BANCO REFERENTE AO DOUTOR NA TABELA CNPJ_USER
        $doc = "SELECT nome_u, crm FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' and crm = '".$atend_crm."'";
        $docenviabanco = $cx->query($doc);
        while ($docrecebe = $docenviabanco->fetch()){
        $atend_doc = $docrecebe['nome_u'];
        }

        //CONFIRMAÇÃO PARA O MESMO CPF NÃO TER DOIS ATENDIMENTOS ABERTO COM O MESMO DOUTOR
        $agendamento = "SELECT * FROM atendimento WHERE cpf = '".$atend_cpf."' and crm = '".$atend_crm."' and cnpj = '".$cnpj."'";
        $queryagend = $cx->query ($agendamento);

        while ($atend = $queryagend->fetch()){
            $confirm_cpf= $atend['cpf'];
            $confirm_crm= $atend['crm'];
            $confirm_doc= $atend['doutor'];
            $confirm_ini= $atend['ini_data'];
            $confirm_id = $atend['id_atend'];
            $confirm_fimhora= $atend['fim_hora'];
        }
        if ($confirm_ini != "$atend_ini_data" or $confirm_ini == "" or $confirm_fimhora != ""){

                //PREPARANDO COMANDO SQL PARA SER ENVIADO PARA BANCO
                    $sql_cad = "INSERT INTO atendimento (nome , cpf, cel, convenio , crm , doutor , cnpj , retorno , ini_data, ini_hora, obs) values ('{$atend_nome}' , '{$atend_cpf}' , '{$atend_cel}', '{$atend_conv}' ,'{$atend_crm}' , '{$atend_doc}' , '{$cnpj}' , '{$atend_ret}' , '{$atend_ini_data}', '{$atend_ini_hora}', '{$atend_obs}')";

                //ENVIANDO COMANDO PARA O BANCO                    
                    $query_cad = $cx->query ($sql_cad);

                    if ($query_cad) {
                    header("location:home_atend.php");
                    } else {
                    $msg_cad = "OCORREU UM ERRO AO ABRIR O ATENDIMENTO ! ";
                    }
        }else{
            $confirma = "ESTE PACIENTE JÁ TEM UMA FICHA EM ABERTO COM O DOUTOR(a)";
        }
    
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
            <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>ADM Consultório</title>
                    <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
                    <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
                    <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
                    <link href='../_css/bootstrap.min.css' rel='stylesheet'>
            </head>
            <body>
                    <div class="container-fluid theme-showcase estilo" role="main">
                        
                            <div class="page-header">
                                    <h1 align="center">Abertrura da Ficha de Atendimento</h1>
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                            <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4"><p>Numero do Atendimento:<span class="banco"> <?php echo $confirm_id; ?></span></p>
                                                                <p><?php echo $confirma;?> <span class="banco">&nbsp; <?php echo $confirm_doc; ?></span></p></th>
                                                        </tr>
                                                    </thead>
                                                    
                                            </table>
                                        <p align='center'><a href="home_atend.php" class="btn btn-sm btn-success">Entendi</a></p>
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