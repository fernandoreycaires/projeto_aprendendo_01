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
    $espec_id = $_POST['id_espec'];
    
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
    
    //BUSCA INFORMAÇÕES DA TABELA enc_espec
    $atestsql = "SELECT * FROM enc_espec WHERE atendimento = '".$atend."' and id_enc = '".$espec_id."'";
        $atestsqlexec = $cx->query($atestsql);
        while ($atestado = $atestsqlexec->fetch()) {
            
            $nome = $atestado['nome_pac'];
            $idpac = $atestado['id_cli'];
            $cpf = $atestado['cpf_pac'];
            $rg = $atestado['rg_pac'];
            $cn = $atestado['certnasc'];
            $sx = $atestado['sexo_pac'];
            $dataatual = $atestado['data_atual'];
            $horaatual = $atestado['hora_atual'];
            $tipo = $atestado['tipo_doc'];
            $crm = $atestado['crm'];
            $doutor = $atestado['nome_doc'];
            $encid = $atestado['id_enc'];
            $especialidade = $atestado['especialidade'];
            $nasc = $atestado['data_nasc'];
            $prontuario = $atestado['prontuario'];
            $convenio = $atestado['convenio'];
            $carteira = $atestado['carteira'];
            $respnome= $atestado['respnome'];
        }
        
        if ($sx == "F"){
            $sexo = "Feminino";
        } else if($sx == "M"){
            $sexo = "Masculino";
        }
        
    //-------------------------------------------------
    //CALCULANDO IDADE
    // Separa em dia, mês e ano
    list($ano, $mes, $dia) = explode('-', $nasc);

    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    //print $idade;
    //FIM DO CALCULO DE IDADE
    //-------------------------------------------------
        
    //ARRUMA DATA PARA EXIBIR 
    list($anoatual, $mesatual, $diaatual) = explode('-', $dataatual);
        
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
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <link href='../_css/dtr_pdf.css' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <header>
        <h4>HOSPITAL SALVALUS</h4>
        </header>
        <div id='pdf'>
            <h1>ENCAMINHAMENTO ESPECIALIDADE</h1>
            <table>        
                <tr><td class='negrito'>Paciente:</td><td>".$nome."</td><td class='negrito'>".$documento.":</td><td>".$docinfo."</td></tr> 
                <tr><td class='negrito'>Sexo:    </td><td>".$sexo." </td><td class='negrito'>Dt Nascimento:<td>$dia/$mes/$ano Idade: $idade </td></tr>
                <tr><td class='negrito'>Prontuario:</td><td>".$prontuario."</td><td class='negrito'>Atendimento:</td><td>".$atend."</td></tr>
                <tr><td class='negrito'>Nome do Responsável:</td><td>".$respnome."</td><td class='negrito'>Convênio:</td><td>".$convenio."</td></tr>
                <tr><td class='negrito'>Dt do Atendimento:</td><td>$diaatual/$mesatual/$anoatual</td><td class='negrito'>Carteira:</td><td>".$carteira."</td></tr>
                <tr><td class='negrito'>Med. Responsável:</td><td>".$doutor."   ".$tipo.": ".$crm." </td><td class='negrito'>Cert: Nasc.:</td><td>".$cn."</td></tr>
            </table>        
            <hr>
            <br>
            <p>A especialidade de <span class='negrito'> ".$especialidade."</span> </p>
            <br>
            <p> encaminho <span class='negrito'> ".$nome." </span> </p>
            <br><br>
            <p>$diaatual/$mesatual/$anoatual - $horaatual</p>
            <br>        
            <h4>Observações:</h4>
                <p>".$ciddiv."</p> 
            <div id='assdoutor'>
                <!--Espaço para carimbo e assinatura do Dr.-->
                <p>______________________________________________________________</p>
                <p>Assinatura e carimbo <span class='negrito'>Dr(a).: ".$doutor."  ".$tipo.": ".$crm." </span></p>
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

