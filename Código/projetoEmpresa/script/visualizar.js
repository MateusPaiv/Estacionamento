async function visUser(id) {

    const dados = await fetch('../dashboard/visualizar.php?id=' + id);
    const resposta = await dados.json();
    console.log(resposta);
    if (!resposta['status']) {
        document.getElementById('mensagem').innerHTML = resposta['msg'];
    } else {

       /*  document.getElementById("nomeUsuario").innerHTML = "<div class ='text-center'><b>Cliente</b><br><span class ='fw-bolder'>Nome:</span> " + resposta['dados'].nome_cliente + "<br> <span class ='fw-bolder'>Placa:</span> " + resposta['dados'].placa + "<br><span class ='fw-bolder'>Modelo:</span> " + resposta['dados'].modelo + "</div>"; */
        Swal.fire(
            'Cliente',
            "<div class ='text-center'><span class ='fw-bolder'>Nome:</span> " + resposta['dados'].nome_cliente + "<br> <span class ='fw-bolder'>Placa:</span> " + resposta['dados'].placa + "<br><span class ='fw-bolder'>Modelo:</span> " + resposta['dados'].modelo + "</div> ",
            'info'
          )
          
    }

}