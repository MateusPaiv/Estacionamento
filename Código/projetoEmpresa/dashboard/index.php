<?php include '../inc/header.php'; ?>

<div class="home">


    <div class="home-content">

        <div class="overview-boxes">
            <div class="box ">
                <div class="right-side">
                    <?php
                    $query = $conexao->prepare("SELECT count(status) as status_vaga FROM vagas where status = '1'");
                    $query->execute();

                    $status_vaga = $query->fetch(PDO::FETCH_ASSOC);


                    ?>
                    <div class="box-topic">Número totais de vagas preenchidas</div>
                    <div class="number"><?= $status_vaga['status_vaga'] ?></div>

                </div>
                <i class="bi bi-check2-all cart"></i>
            </div>
            <div class="box">
                <div class="right-side">
                    <?php
                    $query = $conexao->prepare("SELECT count(status) as status_vaga FROM vagas where status = '1' and vaga_id <= 49");
                    $query->execute();

                    $status_vaga_cadastrados = $query->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="box-topic">Vagas para clientes frequentes</div>
                    <div class="number"><?= $status_vaga_cadastrados['status_vaga'] ?></div>

                </div>
                <i class='bi bi-check2-all cart two'></i>
            </div>
            <div class="box">
                <div class="right-side">
                    <?php
                    $query = $conexao->prepare("SELECT count(status) as status_vaga FROM vagas where status = '1' and vaga_id >= 50");
                    $query->execute();

                    $status_vaga_n_cadastrados = $query->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="box-topic">Vagas para clientes</div>
                    <div class="number"><?= $status_vaga_n_cadastrados['status_vaga'] ?></div>

                </div>
                <i class='bi bi-check2-all cart three'></i>
            </div>
            <?php if ($adm) { ?>
                <div class="box">
                    <div class="right-side">

                        <?php
                        $date = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                        $today = $date->format("d/m/Y");

                        $query = $conexao->prepare("SELECT sum(valor) as valor_total FROM movimentos where data_entrada = '$today' ");
                        $query->execute();

                        $valueToday = $query->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="box-topic">Retorno de hoje</div>
                        <?php if ($valueToday['valor_total'] == '') { ?>
                            <div class="number"><?= 'R$ 0,00' ?></div>
                        <?php } else { ?>
                            <div class="number"><?= 'R$' . $valueToday['valor_total'] .',00'   ?></div>
                        <?php } ?>
                        <i class="bi bi-cash-stack cart four"></i>

                    </div>
                </div>
            <?php } ?>
        </div>
        <a href="../parking" class="button-fixed  text-center"><button class="text-light"><i class='bi bi-p-circle icon '></i></button></a>

        <div class="text-center rounded" id="mensagem-info">

            <span id="nomeUsuario"> </span>
            <span id="modeloUsuario"></span>
            <span id="placaUsuario"></span>
        </div>
        <?php



        $query = $conexao->prepare("SELECT * FROM vagas order by vaga_id limit 51 ");
        $query->execute();

        $dadosVagaNaoCad = $query->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <div class="sales-boxes ">
            <div class="recent-sales box bg-light ">
                <div class="title">Vagas para clientes frequentes</div>
                <div class="sales-details">
                    <ul class="details me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 0 && $vagas['vaga_id'] < 11) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 10 && $vagas['vaga_id'] < 21) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 20 && $vagas['vaga_id'] < 31) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 30 && $vagas['vaga_id'] < 41) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details  me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 40 && $vagas['vaga_id'] < 51) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                </div>

            </div>
            <?php

            $query = $conexao->prepare("SELECT * FROM vagas  where vaga_id > 50 order by vaga_id ");
            $query->execute();

            $dadosVagaNaoCad = $query->fetchAll(PDO::FETCH_ASSOC);

            ?>
            <div class="recent-sales box bg-light ">
                <div class="title">Vagas para clientes</div>
                <div class="sales-details">
                    <ul class="details me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {
                            if ($vagas['vaga_id'] > 49 && $vagas['vaga_id'] < 61) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 60 && $vagas['vaga_id'] < 71) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 70 && $vagas['vaga_id'] < 81) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details  me-3 ">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 80 && $vagas['vaga_id'] < 91) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                    <ul class="details  me-3">

                        <?php foreach ($dadosVagaNaoCad as $vagas) {

                            if ($vagas['vaga_id'] > 90 && $vagas['vaga_id'] < 101) {
                                if ($vagas['status'] == '1') { ?>
                                    <li class="p-3 bg-danger bg-gradient text-white text-center rounded" onclick="visUser(<?= $vagas['vaga_id'] ?>)" style="cursor:pointer;">
                                        <?= $vagas['vaga_id'] ?>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="p-3 bg-success bg-gradient text-white text-center rounded"><?= $vagas['vaga_id'] ?></li>
                        <?php }
                            }
                        } ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="../script/visualizar.js"></script>
<?php include '../inc/footer.php'; ?>