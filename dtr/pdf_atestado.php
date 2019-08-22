<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    
    $acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '" . $cnpj . "' and pass='" . $pass . "' and usuario='" . $user . "'";
        $acesso_user = $cx->query($acesso);
        while ($perfil = $acesso_user->fetch()) {
            $cnpju = $perfil['cnpj_vinc'];
            $razao = $perfil['razao_c'];
            $telefone = $perfil['tel1_c'];
            $cnpjcep = $perfil['cep_c'];
            $cnpjlogradouro = $perfil['logradouro_c'];
            $cnpjnumlog = $perfil['numerolog_c'];
            $cnpjcomp = $perfil['complemento_c'];
            $cnpjbairro = $perfil['bairro_c'];
            $cnpjcidade = $perfil['cidade_c'];
            $cnpjestado = $perfil['estado_c'];
            $cnpjemail = $perfil['email_c'];
            $cnpjsite = $perfil['site_c'];
        }
    
    
    $atend = $_POST['atendimento'];
    $atest = $_POST['atestado'];
    
    //BUSCA NO BANCO NA TABELA his_med AS INFORMAÇÕES REFERENTES AO NUMERO DO atendimento
    $mostra_sqlh = "SELECT ciddiv,cidcod,ciddesc FROM his_med where atendimento = '".$atend."' and cnpj = '".$cnpj."'";
    $mostrah = $cx->query($mostra_sqlh);
    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
    while ($dadosh = $mostrah->fetch()) {
        $ciddiv = $dadosh['ciddiv'];
        $cidsubcat = $dadosh['cidcod'];
        $ciddesc = $dadosh['ciddesc'];
    }
    if ($ciddiv == 'S') {
            $ciddiv = "Autorizo a divulgação do CID (Classificação internacional de Doenças)"."<br>"."<span class='negrito'>".$cidsubcat." - ".$ciddesc."</span>";
        } else if ($ciddiv == 'N') {
            $ciddiv = "Não autorizo a divulgação do CID (Classificação internacional de Doenças)";
        }
    
    //BUSCA INFORMAÇÕES DA TABELA atestados
    $atestsql = "SELECT * FROM atestados WHERE atendimento = '".$atend."' and id_atest = '".$atest."'";
        $atestsqlexec = $cx->query($atestsql);
        while ($atestado = $atestsqlexec->fetch()) {
            
            $nome = $atestado['nome_pac'];
            $cpf = $atestado['cpf_pac'];
            $rg = $atestado['rg_pac'];
            $cn = $atestado['certnasc'];
            $dataatual = $atestado['data_atual'];
            $horaatual = $atestado['hora_atual'];
            $dataini = $atestado['data_ini'];
            $horaini = $atestado['hora_ini'];
            $tipo = $atestado['tipo_doc'];
            $crm = $atestado['crm'];
            $doutor = $atestado['nome_doc'];
            $atestid = $atestado['id_atest'];
            $dias = $atestado['dias_afastado'];
            $atestadodesc = $atestado['atestado'];
        }
        
        if ($dias == 0){
            $descricaoatest = "Deverá retornar ao serviço";
        } else if ($dias >= 1){
            $descricaoatest = "Deverá pernacer afastado de suas atividades por ".$dias." dia(s) a contar desta data.";
        }
        
    //ARRUMA DATA PARA EXIBIR 
    list($anoatual, $mesatual, $diaatual) = explode('-', $dataatual);
    list($anoini, $mesini, $diaini) = explode('-', $dataini);
        
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
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CEP"
    $cnpjceppn = substr_replace($cnpjcep, '-', 5, 0);

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
    $cpfn = substr_replace($cpf, '.', 3, 0);
    $cpfn = substr_replace($cpfn, '.', 7, 0);
    $cpfn = substr_replace($cpfn, '-', 11, 0);
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
    $rgn = substr_replace($rg, '.', 2, 0);
    $rgn = substr_replace($rgn, '.', 6, 0);
    $rgn = substr_replace($rgn, '-', 10, 0);

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
    $cnpjn = substr_replace($cnpju, '.', 2, 0);
    $cnpjn = substr_replace($cnpjn, '.', 6, 0);
    $cnpjn = substr_replace($cnpjn, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn, '-', 15, 0);
    
    if ($cpf != ''){
        $documento = "CPF";
        $docinfo = $cpfn;
    } else if ($rg != ''){
        $documento = "RG";
        $docinfo = $rgn;
    } else{
        $documento = "";
        $docinfo = "";
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
        <link href='../_css/dtr_pdf.css' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <header>
                <h4>".$razao."</h4>
        </header>
        <div id='pdf'>
                <table>
                    <tr><td class='negrito'>".$documento.":</td><td> ".$docinfo." </td><td class='negrito'>Atendimento:</td><td> ".$atend." </td></tr>
                    <tr><td class='negrito'>Paciente:</td><td> ".$nome." </td></tr>
                    <tr><td class='negrito'>Data:</td><td> $diaatual/$mesatual/$anoatual - $horaatual </td></tr>
                    <tr><td class='negrito'>Med. Responsável:</td><td> ".$doutor." ".$tipo.": ".$crm."  </td></tr>
                    </div>
                </table>
                
                <hr>
                <h1>ATESTADO</h1>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Declaro para os devidos fins, que o (a) Sr.(a): <span class='negrito'>".$nome."</span> 
                    atendimento <span class='negrito'> ".$atend." </span> esteve neste local do dia <span class='negrito'>$diaini/$mesini/$anoini</span>, das <span class='negrito'>".$horaini."</span> às<span class='negrito'>".$horaatual."</span> do dia <span class='negrito'>$diaatual/$mesatual/$anoatual</span></p>
                <br>
                <p> O Paciente </p>
                <!--Check Box-->
                <p>".$descricaoatest."</p>
                <h4>Observações:</h4>
                <p>".$ciddiv."</p> 
                    
                    <div id='asspaciente'>
                        <!--Espaço para assinatura do paciente-->
                        <p>_____________________________________________</p>
                        <p>Assinatura do Paciente ou Responssavel Legal </p>
                    </div>
                <p>Data: $diaatual/$mesatual/$anoatual - $horaatual</p>
                <br><br>
                    
                    <div id='assdoutor'>
                        <!--Espaço para carimbo e assinatura do Dr.-->
                        <p>______________________________________________________________</p>
                        <p>Assinatura e carimbo <span class='negrito'>Dr(a).: ".$doutor." ".$tipo.": ".$crm." </span></p>
                    </div>                                                       
            
        </div>
        <footer>
                <p class='centralizar'>".$razao."</p>
                <p class='centralizar'>".$cnpjlogradouro.", ".$cnpjnumlog." </p>
                <p class='centralizar'>".$cnpjbairro." - ".$cnpjcidade." - ".$cnpjestado." - ".$cnpjceppn." , Tel.:".$telefonen."</p>
                <p class='centralizar'>".$cnpjsite." - ".$cnpjemail." </p>
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
