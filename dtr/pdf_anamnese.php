<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    
    $acesso = "SELECT cu.cpf_vinc, cnpj_vinc, razao_c,tel1_c,cep_c,logradouro_c,numerolog_c,complemento_c,bairro_c,cidade_c,estado_c,email_c,site_c FROM cnpj_user cu JOIN cnpj c ON cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '" . $cnpj . "' AND pass='" . $pass . "' AND usuario='" . $user . "'";
    $acesso_user = $cx->query($acesso);
    while ($perfil = $acesso_user->fetch()) {
        $cpf_user_doc = $perfil['cpf_vinc'];
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
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
    $cnpjn = substr_replace($cnpju, '.', 2, 0);
    $cnpjn = substr_replace($cnpjn, '.', 6, 0);
    $cnpjn = substr_replace($cnpjn, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn, '-', 15, 0);
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CEP"
    $cnpjceppn = substr_replace($cnpjcep, '-', 5, 0);
    
    //BUSCA DADOS DO MEDICO (USUARIO)
    $sql_doc = "SELECT nome,tipo_doc,crm FROM clientes WHERE cpf = '".$cpf_user_doc."' LIMIT 1";          
    $envia_sql_doc = $cx->query($sql_doc);
    while ($dados_doc = $envia_sql_doc->fetch()) {
        $doc_nome = $dados_doc['nome'];
        $doc_tipo = $dados_doc['tipo_doc'];
        $doc_doc = $dados_doc['crm'];
    }
    
    $idcliente = $_POST['id_cli'];
    
    $sql_cli = "SELECT * FROM clientes WHERE id = '".$idcliente."'"; //         
    $envia_sql_cli = $cx->query($sql_cli);
    while ($dados_cli = $envia_sql_cli->fetch()) {
        $cli_nome = $dados_cli['nome'];
        $cli_cpf = $dados_cli['cpf'];
        $cli_rg = $dados_cli['rg'];
        $cli_cn = $dados_cli['certnasc'];
        $cli_nasc = $dados_cli['nascimento'];
        $cli_sexo = $dados_cli['sexo'];
        $cli_estcivil = $dados_cli['estadocivil'];
        $cli_prof = $dados_cli['prof'];
        $cli_cel1 = $dados_cli['cel1'];
        $cli_tel = $dados_cli['tel'];
        $cli_email = $dados_cli['email'];
    }
    
    //-------------------------------------------------
    //CALCULANDO IDADE
    // Separa em dia, mês e ano
    list($ano, $mes, $dia) = explode('-', $cli_nasc);

    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    //print $idade;
    //FIM DO CALCULO DE IDADE
    //-------------------------------------------------
    
        
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CEP"
    $cnpjceppn = substr_replace($cnpjcep, '-', 5, 0);

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
    $cpfn = substr_replace($cli_cpf, '.', 3, 0);
    $cpfn = substr_replace($cpfn, '.', 7, 0);
    $cpfn = substr_replace($cpfn, '-', 11, 0);
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
    $rgn = substr_replace($cli_rg, '.', 2, 0);
    $rgn = substr_replace($rgn, '.', 6, 0);
    $rgn = substr_replace($rgn, '-', 10, 0);


    
    if ($cli_cpf != ''){
        $documento = "CPF";
        $docinfo = $cpfn;
    } else if ($cli_rg != ''){
        $documento = "RG";
        $docinfo = $rgn;
    } else{
        $documento = "";
        $docinfo = "";
    }
    
    $dataatual = date('d/m/Y');
    $horaatual = date('H:i');
 
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
        <style>
            .form-control {
                background-color: rgb(255,255,255);
                color: rgb(38,42,48);
                width: 100%;
                height:18px;
                padding:6px 12px;
                font-size:14px;
                line-height:1.42857143;
                border:1px solid #ccc;
                border-radius:4px;
                -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                }
            
            
                
        </style>
    </head>
    <body>
        <header>
                <h4>".$razao."</h4>
        </header>
        <div id='pdf'>
                <table>
                    <tr><td class='negrito'>Paciente:</td><td> ".$cli_nome." </td><td class='negrito'>".$documento.":</td><td> ".$docinfo." </td></tr>
                    <tr><td class='negrito'>Data:</td><td> $dataatual - $horaatual </td></tr>
                    <tr><td class='negrito'>Med. Responsável:</td><td> ".$doc_nome."  ".$doc_tipo.": ".$doc_doc."  </td></tr>
                    </div>
                </table>
                
                <hr>
                <table>
                    <tr><td colspan='4' style='text-align: center;'>DADOS BÁSICOS </td></tr>
                    <tr><td>Religião:</td><td colspan='3'><input type='text' class='form-control'></td></tr>
                    <tr><td>Numero de Filhos:</td><td><input type='text' class='form-control'></td><td>Numero de Irmão:</td><td><input type='text' class='form-control'></td></tr>
                    <tr><td>Médico que encaminhou:</td><td><input type='text' class='form-control'></td><td>Profissional que encaminhou:</td><td><input type='text' class='form-control'></td></tr>
                    <tr><td>Problemas com álcool/drogas? </td><td >SIM <input type='checkbox' > NÃO <input type='checkbox'></td></tr>
                    <tr><td>Se sim, porque ? </td><td colspan='3'><textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Fuma? </td><td colspan='3'> SIM <input type='checkbox' > NÃO <input type='checkbox' ></td></tr>
                    <tr><td>Sono: </td><td colspan='3' style='border-top: solid #333333 0.5px;'> BOM &nbsp; <input type='checkbox' > NORMAL &nbsp; <input type='checkbox' > MAU &nbsp; <input type='checkbox' ></td></tr>
                    <tr><td>Como nos conheceu ? </td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>DADOS DOS PAIS </td></tr>
                    <tr><td>Pai Nome:</td><td><input type='text' class='form-control' ></td><td>Pai Idade:</td><td><input type='text' class='form-control'></td></tr>
                    <tr><td>Pai Profissão:</td><td><input type='text' class='form-control'></td><td>Pai Instrução:</td><td><input type='text' class='form-control'></td></tr>
                    <tr><td>Mãe Nome:</td><td><input type='text' class='form-control'></td><td>Mãe Idade:</td><td><input type='text' class='form-control'></td></tr>
                    <tr><td>Mãe Profissão:</td><td><input type='text' class='form-control'></td><td>Mãe Instrução:</td><td><input type='text' class='form-control'></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>QUEIXA </td></tr>
                    <tr><td>Queixa Pricipal:</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Inicio da queixa:</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Súbita ou progressiva :</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Quais mudanças que ocorreram/ o que afetou:</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Sintomas:</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Queixa Secundária:</td><td colspan='3'><textarea type='text' class='form-control'></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>HISTÓRIA CLINICA </td></tr>
                    <tr><td>Doença Crônica:</td><td colspan='3'><textarea class='form-control'></textarea></td></tr>
                    <tr><td>Toma Medicamentos?</td><td style='border-top: solid #333333 0.5px;'> SIM <input type='checkbox' > NÃO <input type='checkbox' ></td><td colspan='2'>Quais : <textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Já teve problemas cardiacos ?</td><td style='border-top: solid #333333 0.5px;'> SIM <input type='checkbox' > NÃO <input type='checkbox' ></td><td colspan='2'>Qual : <textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>É Diabético ?</td><td style='border-top: solid #333333 0.5px;'> SIM <input type='checkbox' > NÃO <input type='checkbox' ></td><td colspan='2'>Tipo : <textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Ocorrência de epilepsia? </td><td style='border-top: solid #333333 0.5px;'> SIM <input type='checkbox' > NÃO <input type='checkbox' ></td><td colspan='2'>Quando : <textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Casos de internação :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Enfrentamento :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Sintomas fisicos e/ou psicologicos :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Psicoterapia/fono/fisio/neuro/psiquiatria :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Hábitos alimentares :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td colspan='4' style='text-align: center;'>HISTÓRIA CLINICA / CRIANÇA OU ADOLESCENTE</td></tr>
                    <tr><td>Condições de nascimento :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Desenvolvimento Neuropsicomotor :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Doenças infantis :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Casos de convulções, epilepsia, desmaios etc:</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>HISTÓRIA FAMILIAR</td></tr>
                    <tr><td>Composição Familiar (Genograma) :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Dinamica Familiar :</td><td colspan='3'> <textarea type='text' name='tDinFam' class='form-control' ></textarea></td></tr>
                    <tr><td>Eventos significativos :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Rede de apoio :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>HISTÓRIA SOCIAL </td></tr>
                    <tr><td colspan='4'><textarea type='text' class='form-control-textarea'></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>DADOS ESCOLARES </td></tr>
                    <tr><td>Casos de reprovação:</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Áreas de dificuldade:</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Hábitos de estudo:</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>HIPNOTERAPIA</td></tr>
                    <tr><td>Alguém já tentou o hipnotizar?:</td><td colspan='3'> SIM <input type='checkbox' > NÃO <input type='checkbox' ></td></tr>
                    <tr><td>Quem? :</td><td colspan='3'><textarea type='text' class='form-control' ></textarea></td></tr>
                    <tr><td>Motivo :</td><td colspan='3'> <textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Você acredita que foi hipnotizado?</td><td colspan='3'> SIM <input type='checkbox' > NÃO <input type='checkbox' > NÃO SEI <input type='checkbox' ></td></tr>
                    <tr><td>Por quê? </td><td colspan='3'><textarea type='text' class='form-control'></textarea></td></tr>
                    <tr><td>Motivos para buscar ajuda com a hipnose: :</td><td colspan='3'><textarea type='text' class='form-control'></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>CONSIDERAÇÕES FINAIS </td></tr>
                    <tr><td colspan='4'><textarea type='text' class='form-control-textarea'></textarea></td></tr>

                    <tr><td colspan='4' style='text-align: center;'>SUGESTÃO DE ENCAMINHAMENTO </td></tr>
                    <tr><td colspan='4'><textarea type='text'></textarea></td></tr>


                </table>                                                      
            
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