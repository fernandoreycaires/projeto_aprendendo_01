function val(){
    if(document.indexForm.tCNPJ.value==""){
        alert("Por favor preencha o campo CNPJ");
        document.indexForm.tCNPJ.focus();
        return false;
    }else{
        if(document.indexForm.tUser.value==""){
        alert("Por favor preencha o campo USUARIO");
        document.indexForm.tUser.focus();
        return false;
        }else{
            if(document.indexForm.tPass.value==""){
            alert("Por favor preencha o campo SENHA");
            document.indexForm.tPass.focus();
            return false;
            }
        }
    }
}

