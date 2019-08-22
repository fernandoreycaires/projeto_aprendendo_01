<?php
    include "_php/cx.php";

    $msg = false;
    
    /*
        Aula = https://www.youtube.com/watch?v=iNm86iordCQ
        strtolower = converte tudo para minusculo
        substr (-4) = verifica de traz pra frente os ultimos 4 caracteres - para pegar qual o tipo do arquivo
        $_FILES = Variavel do PHP que trabalha com arquivos
        md5() = função para criptografar nome (neste caso sendo usado para gerar nomes randomicos e não dar duplicidade)
        NOW() = função que pega a data e hora atual 
    */
    
    
    if(isset($_FILES['arquivo'])){
        $extensao = strtolower(substr($_FILES['arquivo']['name'], -4)); // pega a extensão do arquivo 
        $novo_nome = md5(time()).$extensao; //define o nome do arquivo
        $diretorio = "upload12/"; // define o diretório para onde enviaremos o arquivo
        
        move_uploaded_file($_FILES['arquivo']['tmp_name'],$diretorio.$novo_nome); //efetua o upload
        
        print $diretorio.$novo_nome;
        
        $sql_code = "INSERT INTO imagens (codigo, arquivo, dia) VALUES (null, '$novo_nome', NOW())";
        $q = $cx->query ($sql_code);
        
        if($q){
            $msg = "Arquivo enviado com sucesso !";
        }else{
            $msg = "Falha ao enviar documento";
        }
    }


?>
<h1>Upload de arquivos</h1>
<?php  if($msg != false) echo "<p> $msg </p>"; ?>
<!-- enctype="multipart/form-data" =  tipo de tag para se trabalhar com manuseio de arquivos  -->
<form action="upload.php" method="post" enctype="multipart/form-data">
    Arquivo: <input type="file" required="" name="arquivo">
    <input type="submit" value="Salvar" >
</form>
