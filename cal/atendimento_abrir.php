<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];

 

//RECEBE ID DO AGENDAMENTO E TRATA PARA COLETAR O RESTANTE DAS INFORMAÇÕES 
    
    $valor = isset($_POST['id'])?$_POST['id']:'0';
    $msg = isset($_POST['msg'])?$_POST['msg']:'';
    
    $agendamento = "SELECT * FROM agenda WHERE id_data = '".$valor."'";
    $queryagend = $cx->query ($agendamento);
        while ($atend = $queryagend->fetch()){
            $atend_nome = $atend['nome'];
            $atend_cpf = $atend['cpf'];
            $atend_cel = $atend['cel'];
            $atend_dtr = $atend['doutor'];
            $atend_crm = $atend['crm'];
            $atend_conv = $atend['convenio'];
            $atend_obs = $atend['obs'];
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
                    <style>
                        
                        .form-control {
                            background-color: rgba(38,42,48,1);
                            color: rgb(255,255,255);
                            width: 80%;
                            height:30px;
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
                        
                        .form-control-option {
                            background-color: rgb(38,42,48);
                            color: rgba(255,255,255,1);
                            height:30px;
                            width: 80%;
                            border:1px solid #ccc;
                            border-radius:4px;
                        }
                        
                        .table{
                            width: 750px;
                            margin: 0 auto 15px auto;
                        }
                        
                    </style>
            </head>
            <body>
                    <div class="container-fluid theme-showcase estilo" role="main">
                            <div class="logo1"></div>
                            <div class="page-header">
                                    <h1 align="center">Abertura da Ficha de Atendimento</h1>
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" action="atendimento_cad.php">
                                            <input type="hidden" value="<?php echo $valor;?>" name="id_cal">
                                            <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4">
                                                                <p><span class="banco"><?php echo date('d/m/Y H:i'); ?></span></p>
                                                                <h5 align="center"><?php echo $msg;?></h5>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr><td colspan="2" align="center"><h4> Registre UM dos documentos abaixo</h4> </td></tr>
                                                        
                                                        <tr><td>CPF:</td><td><input type="text" name="tCpf" class="form-control" value="<?php echo $atend_cpf ?>"></td></tr>
                                                        <tr><td>RG:</td><td><input type="text" name="tRG" class="form-control"></td></tr>
                                                        <tr><td>Certidão Nascimento:</td><td><input type="text" name="tCN" class="form-control"></td></tr>
                                                        
                                                        <tr><td colspan="2" align="center"><h4>Dados Minimos para abrir a ficha </h4></td></tr>
                                                        
                                                        <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" value="<?php echo $atend_nome ?>"></td></tr>
                                                        <tr><td>Celular:</td><td><input type="text" name="tCel" class="form-control" value="<?php echo $atend_cel ?>"></td></tr>
                                                            <?php
                                                            //ESTE IF VERIFICA SE NÃO HÁ CPF INFORMADO, E COLOCA UM CAMPO TIPO TEXT
                                                                if ($atend_cpf == ""){
                                                            ?>
                                                        <tr><td>Convênio:</td><td><input type="text" name="tCon" class="form-control" value="<?php echo $atend_conv ?>"></td></tr>
                                                        <?php 
                                                                } else if ($atend_cpf != ""){
                                                                    $clisql = "SELECT id FROM clientes WHERE cpf = '".$atend_cpf."' LIMIT 1";
                                                                    $querycli = $cx->query ($clisql);
                                                                        while ($cli = $querycli->fetch()){
                                                                            $cli_id = $cli['id'];
                                                                        }
                                                                        //ESTE IF VERIFICA SE HÁ CPF INFORMADO, POREM NÃO TEM CADASTRIO NO BANCO, E COLOCA UM CAMPO TIPO TEXT
                                                                           if ($cli_id == ""){
                                                                        ?>
                                                                            <tr><td>Convênio:</td><td><input type="text" name="tCon" class="form-control" value="<?php echo $atend_conv ?>"></td></tr>
                                                                        <?php 
                                                                           } //ESTE IF VERIFICA SE HÁ CPF INFORMADO, E TEM CADASTRO NO BANCO, E COLOCA UM CAMPO TIPO OPTION
                                                                            if($cli_id != ""){
                                                                                ?>
                                                                            
                                                                                <tr><td>Convênio:</td>
                                                                                    <td>
                                                                                        <select name="tCon" class="form-control-option">
                                                                                                <?php 
                                                                                                    $conv_sql = "SELECT empresa FROM convenio WHERE id_cli = '".$cli_id."'";
                                                                                                    $envia_convsql = $cx->query($conv_sql);
                                                                                                        while ($conv = $envia_convsql->fetch()){ 
                                                                                                ?>
                                                                                            <option value="<?php echo $conv['empresa'];?>"><?php echo $conv['empresa']; ?></option>
                                                                                                <?php        
                                                                                                    }
                                                                                                ?>
                                                                                            <option value="Não Informado" >Não Informar</option>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                        }
                                                                } 
                                                        ?>
                                                        <tr><td>Retorno:</td><td><input type="RADIO" name="tRet" id="sim" VALUE="S"><label for="sim" > SIM</label>
                                                                <input type="RADIO" name="tRet" id="nao" VALUE="N" checked><label for="nao" > NÃO</label></td></tr>
                                                        <tr><td>Doutor:</td><td><?php echo $atend_dtr ?><input type="hidden" name="tDoc" value="<?php echo $atend_dtr ?>"></td></tr>
                                                        <tr><td>CRM:</td><td><?php echo $atend_crm ?><input type="hidden" name="tCrm" value="<?php echo $atend_crm ?>"></td></tr>
                                                        <tr><td>Observação:</td><td><input type="text" name="tObs" class="form-control" value="<?php echo $atend_obs;?>"></td></tr>
                                                        <tr><td><br></td><td><br></td></tr>
                                                        
                                                    </tbody>
                                                    
                                            </table>
                                        <p align='center'><button type="submit" class="btn btn-sm btn-success" >Confirmar</button>&nbsp;&nbsp;&nbsp;<a href="home_cal.php" class="btn btn-sm btn-danger">Cancelar</a></p>
                                        </form>
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