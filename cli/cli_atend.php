<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

$pacid = isset($_POST['id'])?$_POST['id']:'';

$pac = "SELECT id, nome, cpf, rg, certnasc, cel1 FROM clientes WHERE id = '".$pacid."'";
$pacenviabanco = $cx->query($pac);
while ($pacrec = $pacenviabanco->fetch()){ 
    $cliid = $pacrec['id'];
    $clinome = $pacrec['nome'];
    $clicpf = $pacrec['cpf'];
    $clirg = $pacrec['rg'];
    $clicn = $pacrec['certnasc'];
    $clicel = $pacrec['cel1'];
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
                    <style>
                        
                        .form-control {
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
                                    <h1 align="center">Abertrura da Ficha de Atendimento</h1>
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" action="cad_atend.php">
                                            <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4"><p><span class="banco"><?php echo date('d/m/Y H:i'); ?></span></p>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr><td>Nome:</td><td><input type="text" name="tNome" class="form-control" value="<?php echo $clinome ?>"></td></tr>
                                                        <tr><td>CPF:</td><td><input type="text" name="tCpf" class="form-control" value="<?php echo $clicpf ?>"></td></tr>
                                                        <tr><td>RG:</td><td><input type="text" name="tRG" class="form-control" value="<?php echo $clirg ?>"></td></tr>
                                                        <tr><td>Certidão Nascimento:</td><td><input type="text" name="tCN" class="form-control" value="<?php echo $clicn ?>"></td></tr>
                                                        <tr><td>Celular:</td><td><input type="text" name="tCel" class="form-control" value="<?php echo $clicel ?>"></td></tr>
                                                        <tr><td>Convênio:</td>
                                                            <td>
                                                                <select name="tCon" class="form-control" >
                                                                        <?php 
                                                                                $sqlsonv = "SELECT empresa FROM convenio WHERE id_cli = '".$cliid."'";
                                                                                $enviasqlconv = $cx->query($sqlsonv);
                                                                                while ($conv = $enviasqlconv->fetch()){ 
                                                                        ?>
                                                                            <option value="<?php echo $conv['empresa'];?>"><?php echo $conv['empresa']; ?></option>
                                                                        <?php        
                                                                        }
                                                                        ?>
                                                                            <option value="Não Informado" >Não Informar</option>
                                                                </select>
                                                            </td></tr>
                                                        <tr><td>Retorno:</td><td><input type="RADIO" name="tRet" id="sim" VALUE="S"><label for="sim" > SIM</label>
                                                                <input type="RADIO" name="tRet" id="nao" VALUE="N" checked><label for="nao" > NÃO</label></td></tr>
                                                        <tr><td>Doutor:</td>
                                                            <td>
                                                                <select name="tCrm" class="form-control" required="">
                                                                            <option></option>
                                                                        <?php 
                                                                                $doc = "SELECT nome_u, crm FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' and crm != ''";
                                                                                $docenviabanco = $cx->query($doc);
                                                                                while ($docrecebe = $docenviabanco->fetch()){ 
                                                                        ?>
                                                                            <option value="<?php echo $docrecebe['crm'];?>"><?php echo $docrecebe['nome_u']; ?></option>
                                                                        <?php        
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </td></tr>
                                                        <tr><td>Observação:</td><td><input type="text" name="tObs" class="form-control" value="<?php echo $atend_obs;?>"></td></tr>
                                                        <tr><td><br></td><td><br></td></tr>
                                                        
                                                    </tbody>
                                                    
                                            </table>
                                            <input type="hidden" value="<?php echo $cliid; ?>" name="idpac">
                                            <p align='center'><button type="submit" class="btn btn-sm btn-success" >Confirmar</button>&nbsp;&nbsp;&nbsp;
                                                <a href="home_cli.php" class="btn btn-sm btn-danger">Cancelar</a></p>
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
