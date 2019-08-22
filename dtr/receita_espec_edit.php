<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

                $id          =$_POST['id_rec_espec'];
                $data	     =$_POST['data'];
                $hora	     =$_POST['hora'];
                $atendimento =$_POST['atend'];
                $remedio1    =$_POST['remedio1'];
                $tipouso1    =$_POST['tipouso1'];
                $modouso1    =$_POST['modouso1'];
                $obs1	     =$_POST['obsrec1'];
                $remedio2    =$_POST['remedio2'];
                $tipouso2    =$_POST['tipouso2'];
                $modouso2    =$_POST['modouso2'];
                $obs2	     =$_POST['obsrec2']; 
                $remedio3    =$_POST['remedio3']; 
                $tipouso3    =$_POST['tipouso3'];
                $modouso3    =$_POST['modouso3'];
                $obs3	     =$_POST['obsrec3'];
                $remedio4    =$_POST['remedio4'];
                $tipouso4    =$_POST['tipouso4'];
                $modouso4    =$_POST['modouso4'];
                $obs4	     =$_POST['obsrec4'];
                

                // CRIA COMANDO SQL
                $sql = "UPDATE receita_especial SET data = '".$data."', hora = '".$hora."', remedio1 = '".$remedio1."', tipouso1 = '".$tipouso1."', modouso1 = '".$modouso1."', obs1 = '".$obs1."',remedio2 = '".$remedio2."', tipouso2 = '".$tipouso2."', modouso2 = '".$modouso2."', obs2 = '".$obs2."',remedio3 = '".$remedio3."', tipouso3 = '".$tipouso3."', modouso3 = '".$modouso3."', obs3 = '".$obs3."',remedio4 = '".$remedio4."', tipouso4 = '".$tipouso4."', modouso4 = '".$modouso4."', obs4 = '".$obs4."' WHERE id_rec_espec = '".$id."'";
                // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
                $q = $cx->query ($sql);

                if ($q) {
                        ?>
                        <!DOCTYPE html>
                        <html lang="pt-br">
                            
                            <body>
                                <form method="post" name="salvadiag" id="salvadiag" action="diagnostico.php">
                                    <input type="hidden" name="atendimento" value="<?php echo $atendimento;?>" id="atendenvia">
                                </form>
                            </body>
                            <script type="text/javascript">
                                document.salvadiag.submit()
                            </script>
                        </html>
                        <?php
                        
                } else {
                    $message = 'OCORREU UM ERRO AO EFETUAR O CADASTRO ! ';
                }
                echo "<h1> $message </h1>";
           
}else{
    header("location:../index.php");
}
?>