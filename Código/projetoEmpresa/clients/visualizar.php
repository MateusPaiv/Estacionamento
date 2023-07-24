<?php
include('../inc/header.php');

?>

<div class="d-flex justify-content-center mt-5">


    <?php

    $id = $_GET['clie_id'];
    $query = $conexao->prepare("SELECT veiculos.*, clientes.nome_completo from veiculos inner join clientes on veiculos.veic_clie_id = clientes.clie_id WHERE clie_id = '$id'");
    $query->execute();

    $user = $query->fetchAll(PDO::FETCH_ASSOC);
    if (count($user) > 0) {
        foreach ($user as $key => $value) :

            $usuario_atual = $user[$key];

    ?>

            <div class="row">
                <div class="text-center mt-3">
                    <div class="card text-center bg-dark me-2 ms-2" style="width: 18rem;">
                        <div class="card-body text-light">
                            <h5 class="card-title">Carro</h5>
                            <span class="fw-bold">Cliente:</span> <?= $usuario_atual['nome_completo'] ?><br>

                            <span class="fw-bold">Placa:</span> <?= $usuario_atual['placa']   ?><br>

                            <span class="fw-bold">Modelo:</span> <?= $usuario_atual['modelo']   ?><br>

                            <span class="fw-bold">Cor: </span> <?= $usuario_atual['cor']   ?><br>

                            <span class="fw-bold">Ano:</span> <?= $usuario_atual['ano']   ?>
                        </div>
                    </div>

                </div>
            </div>


        <?php endforeach; ?>
    <?php } else { ?>
        <p class="fw-bold text-center">Nenhum veículo cadastrado</p>
    <?php } ?>

</div>
<div class="text-center mt-4">
    <button class="text-center"><a href="../clients" class="btn btn-warning">Voltar para tabela</a></button>
</div>
<div class="text-center mt-4">
    <button class="text-center"><a href="../veiculos" class="btn btn-warning"><i class="bi bi-car-front"></i> Cadastrar veículo</a></button>
</div>





<?php
include '../inc/footer.php';
?>