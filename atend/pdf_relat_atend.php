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
    $nfantasia = $perfil['nfantasia_c'];
    $telefone = $perfil['tel1_c'];
    $logradouro = $perfil['logradouro_c'];
    $numlog = $perfil['numerolog_c'];
    $comp = $perfil['complemento_c'];
    $bairro = $perfil['bairro_c'];
    $cidade = $perfil['cidade_c'];
    $estado = $perfil['estado_c'];
    $site = $perfil['site_c'];
    
 }  

 //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "TELEFONE" strlen($variavel) usado para contar quantidade de caracteres na variavel
    if (strlen($telefone) == 10 ){
        $telefonen = substr_replace($telefone, '(', 0, 0);
        $telefonen = substr_replace($telefonen, ')', 3, 0);
        $telefonen = substr_replace($telefonen, '-', 8, 0);
        $telefonen = substr_replace($telefonen, ' ', 4, 0);
    } elseif (strlen($telefone) == 11 ) {
        $telefonen = substr_replace($telefone, '(', 0, 0);
        $telefonen = substr_replace($telefonen, ')', 3, 0);
        $telefonen = substr_replace($telefonen, '-', 9, 0);
        $telefonen = substr_replace($telefonen, ' ', 4, 0);
        $telefonen = substr_replace($telefonen, ' ', 6, 0);
    }
 

            
 
$data = date('d/m/Y H:i'); 

//ZERANDO CONTADOR DE LINHAS
$i = 0;
//RECEBE SELECT JA PRONTO DE home_atend.php
$filtrodata = isset ($_POST['filtrodata'])?$_POST['filtrodata']:'';
$relat_convenio = $_POST['relatconvenio'];
$filtrosql = isset ($_POST['filtro'])?$_POST['filtro']:'';

$conv_sql = $relat_convenio;
$envia_relat = $cx->query ($conv_sql);
    while ($convenio = $envia_relat->fetch()){ 
        $convenios .= "<tr><td>".$convenio['convenio']."</td><td>".$convenio['COUNT(*)']."</td></tr>";
    }

//BUSCA INFORMAÇÕES DA TABELA ATENDIMENTO
$atend_sql = $filtrosql;
$atend_acesso = $cx->query ($atend_sql);
    while ($atend = $atend_acesso->fetch()){ 
            
            //INCREMENTANDO A VARIAVEL CONTADOR
            $i++;
            
            //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
            $pac_cpf = $atend['cpf'];
            $pac_cpfn = substr_replace($pac_cpf, '.', 3, 0);
            $pac_cpfn = substr_replace($pac_cpfn, '.', 7, 0);
            $pac_cpfn = substr_replace($pac_cpfn, '-', 11, 0);
            
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
            } else {
                $status = 'ATENDIDO';
            }
            
            $listaatend .= "<tr>"."<td>". $i ."</td>"."<td>".$atend['nome']."</td>"."<td>".$pac_cpfn."</td>"."<td>".$atend['convenio']."</td>"."<td>".$ret."</td>"."<td>".$atend['doutor']."</td>"."<td>".$atend['crm']."</td>"."</tr>";
            
    }
  

  
/* Carrega a classe DOMPdf */
require_once("../_pdf/dompdf_config.inc.php");

/* Cria a instância */
$dompdf = new DOMPDF();

/* Carrega o HTML */
$dompdf->load_html("
<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <title>ADM Consultório</title>
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <link href='../_css/dtr_pdf.css' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <header>
                <h4>$nfantasia</h4>
        </header>
        <div id='pdf'>
                <table>
                    <tr><td class='negrito'>Operador:</td><td> $nome </td></tr>
                    <tr><td class='negrito'>Data de emissão:</td><td> $data </td></tr>
                </div>
                </table>
                <h1>LISTA DE ATENDIMENTOS</h1>
                <p> do dia: $filtrodata </p>
                <hr>
                <table>
                <tr>
                    <td class='negrito'>Num.</td>
                    <td class='negrito'>Paciente</td>
                    <td class='negrito'>CPF</td>
                    <td class='negrito'>Convênio</td>
                    <td class='negrito'>Retorno</td>
                    <td class='negrito'>Doutor</td>
                    <td class='negrito'>CRM</td>
                </tr>
                ".$listaatend."                                                      
                </table>
                <br>
                <table>
                    <tr>
                        <td>CONVENIOS</td>
                        <td>QUANTIDADE</td>
                    </tr>
                    ".$convenios."
                </table>
        </div>
        <footer>
                <p class='centralizar'>$nfantasia</p>
                <p class='centralizar'>$logradouro, $numlog $comp - $bairro - $cidade - $estado , Tel.:$telefonen </p>
                <p class='centralizar'>$site</p>
        </footer>
    </body>
</html>");


/* Renderiza */
$dompdf->render();

/* Exibe */
$dompdf->stream(
    "frsystem.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => false /* Para download, altere para true */
    )
);

}else{
    header("location:../index.php");
}
?>