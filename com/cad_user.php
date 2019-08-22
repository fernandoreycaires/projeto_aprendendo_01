<?php  
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


 
//RECEBENDO E ENVIANDO PARA BANCO DADOS DE NOVO USUARIO
$idcnpj = $_POST['idcnpj'];
$cad_nome = isset($_POST['cad_nome'])?$_POST['cad_nome']:'';
$cad_usu = isset($_POST['cad_usu'])?$_POST['cad_usu']:'';
$cad_pass = isset($_POST['pass_usu'])?$_POST['pass_usu']:'';
$cad_cn = isset($_POST['cad_cnpj_user'])?$_POST['cad_cnpj_user']:'';
$cad_cli = isset($_POST['tCli'])?$_POST['tCli']:'';
$cad_dtr = isset($_POST['tDoc'])?$_POST['tDoc']:'N';
$cad_cal = isset($_POST['tCal'])?$_POST['tCal']:'';
$cad_atm = isset($_POST['tAtm'])?$_POST['tAtm']:'';
$cad_con = isset($_POST['tCon'])?$_POST['tCon']:'';
$cad_dp = isset($_POST['tDp'])?$_POST['tDp']:'';
$cad_adm = isset($_POST['tAdm'])?$_POST['tAdm']:'';
$cad_fin = isset($_POST['tFin'])?$_POST['tFin']:'';
$cad_come = isset($_POST['tCome'])?$_POST['tCome']:'';
$cad_sys = isset($_POST['tSys'])?$_POST['tSys']:'';
$cad_cai = isset($_POST['tCaixa'])?$_POST['tCaixa']:'N';
$cad_mai = isset($_POST['tMai'])?$_POST['tMai']:'N';
$cad_cpf = isset($_POST['cad_cpf'])?$_POST['cad_cpf']:'';
$cad_crm = isset($_POST['cad_crm'])?$_POST['cad_crm']:'';
$cad_cor = isset($_POST['tCor'])?$_POST['tCor']:'';

//CRIANDO REFERERENCIA, PARA UTILIZAR NA AGENDA, ATRAVEZ DAS CORES

if ($cad_cor == "#070d48"){
    $referencia = "a";
}
    else if ($cad_cor == "#480747"){
            $referencia = "b";
    }
        else if ($cad_cor == "#892c03"){
                $referencia = "c";
        }
            else if ($cad_cor == "#063e06"){
                     $referencia = "d";
            }
                else if ($cad_cor == "#3e3d06"){
                         $referencia = "e";
                }
                    else if ($cad_cor == "#3e060a"){
                             $referencia = "f";
                    }
                        else if ($cad_cor == "#063e21"){
                                 $referencia = "g";
                        }
                            else if ($cad_cor == "#121413"){
                                     $referencia = "h";
                            }
                                else if ($cad_cor == "#051a1d"){
                                         $referencia = "i";
                                }
                                    else if ($cad_cor == "#1c051c"){
                                             $referencia = "j";
                                    }
                                        else if ($cad_cor == ""){
                                                 $referencia = "";
                                        }

          
    //COMANDO PARA VERIFICAR SE CPF JÁ EXISTE COMO USUARIO NESTE CNPJ
    $checarsql = "SELECT cpf_vinc FROM cnpj_user WHERE cnpj_vinc = '".$cad_cn."' and cpf_vinc = '".$cad_cpf."'";
    $checar_user = $cx->query ($checarsql);
    while ($userc = $checar_user->fetch()){
        $checacpf = $userc['cpf_vinc'];

    }
    if ($checacpf == ""){
        
                //PREPARANDO COMANDO SQL PARA CADASTRAR NOVO USUARIO NO BANCO BANCO
                $sql_cad = "INSERT INTO cnpj_user (nome_u , usuario , pass , cnpj_vinc , crm , cor , cli , dtr , cal, con, dp, adm, fin, com, sys, atend, caixa, mai, cpf_vinc, referencia) values ('{$cad_nome}' , '{$cad_usu}' , '{$cad_pass}' , '{$cad_cn}' , '{$cad_crm}' , '{$cad_cor}' , '{$cad_cli}' , '{$cad_dtr}' , '{$cad_cal}' , '{$cad_con}' , '{$cad_dp}' , '{$cad_adm}' , '{$cad_fin}' , '{$cad_come}', '{$cad_sys}', '{$cad_atm}', '{$cad_cai}', '{$cad_mai}' , '{$cad_cpf}' , '{$referencia}')";

                //ENVIANDO COMANDO PARA O BANCO                    
                $query_cad = $cx->query ($sql_cad);
                if ($query_cad) {
                $msg_cad = "USUÁRIO DO COLABORADOR CADASTRADO COM SUCESSO ! ";
                    ?>
                    <!DOCTYPE html>
                    <html lang="pt-br">
                        <body>
                            <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpjuser.php">
                                <input type="hidden" name="idcnpj" value="<?php echo $idcnpj;?>" >
                                <input type="hidden" name="erro" value="<?php echo $msg_cad;?>">
                            </form>
                        </body>
                        <script type="text/javascript">
                            document.salvacli.submit();
                        </script>
                    </html>
                    <?php
                } else {
                $msg_cad = "OCORREU UM ERRO AO CADASTRAR O USUÁRIO ! ";
                    ?>
                    <!DOCTYPE html>
                        <html lang="pt-br">
                            <body>
                                <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpjuser.php">
                                    <input type="hidden" name="idcnpj" value="<?php echo $idcnpj;?>" >
                                    <input type="hidden" name="erro" value="<?php echo $msg_cad;?>">
                                </form>
                            </body>
                            <script type="text/javascript">
                                document.salvacli.submit();
                            </script>
                        </html>
                    <?php
                }
        }else{
            $msg_cad = "USUÁRIO JÁ CADASTRADO";
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <body>
                    <form method="post" name="salvacli" id="salvacli" action="com_perfilcnpjuser.php">
                        <input type="hidden" name="idcnpj" value="<?php echo $idcnpj;?>" >
                        <input type="hidden" name="erro" value="<?php echo $msg_cad;?>">
                    </form>
                </body>
                <script type="text/javascript">
                    document.salvacli.submit();
                </script>
            </html>
            <?php
        }
        
    
        
}else{
    header("location:../index.php");
}
?>