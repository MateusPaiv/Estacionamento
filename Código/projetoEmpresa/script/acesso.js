$(function () {
    $("button#entrar").on("click", function (e) {
        e.preventDefault();

        // VAL :  método embutido em jQuery que é usado para retornar ou definir o valor do atributo para os elementos selecionados.
        var email = $("form#form_login #email").val();
        var senha = $("form#form_login #senha").val();
        if (email.trim() == "" || senha.trim() == "") {
            $("div#mensagem").html("Preencha todos os campos!")
        } else {
            $.ajax({
                url: "actions/Login.php",
                type: "POST",
                //parametros, objetos com um campo 
                data: {
                    email: email,
                    senha: senha
                },
                success: function (retorno) {
                    retorno = JSON.parse(retorno);

                    if (retorno["erro"]) {
                        $("div#mensagem").html(retorno["mensagem"])
                    } else {
                        window.location = 'dashboard/index.php';
                    }
                },

                error: function () {
                    $("div#mensagem").html("Ocorreu um erro durante a soliciação com o servidor");
                }
            });
        }
    });
});

