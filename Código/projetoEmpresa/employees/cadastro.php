<?php

if (count($_POST) > 0 && isset($_POST)) {

    include '../actions/autoload.php';

    $sing = new Cadastro();

    $conf_senha = $_POST['conf-senha'];
    $cpf = $_POST['cpf'];
    $errors = $sing->sing_up($_POST, $conf_senha,$cpf);
}


include('../inc/header.php');
?>


<div class="form-sing d-flex flex-column justify-content-center align-items-center">
    <div id="mensagem">

        <?php if (isset($errors) && is_array($errors) && count($errors) > 0) :
            foreach ($errors as $errors) :
                echo $errors;
                echo '<br>';

            endforeach;
        endif;
        ?>

    </div>
    <div class="text-dark ">
        <div class="sing">
            <h4 class="text-center">Cadastro de funcionários</h4>
            <form method="POST">

                <div class="row">
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control cpf" type="text" name="cpf" id="cpf" placeholder="000.000.000-00" maxlength="14">
                            <label class="form-label" for="form8Example1">CPF:</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Email input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="full_name" id="nome">
                            <label class="form-label" for="form8Example2">Nome completo:</label>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="username" id="nome_usuario">
                            <label class="form-label" for="form8Example3">Nome de usuário:</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control" type="email" name="email" id="email">
                            <label class="form-label" for="form8Example4">E-mail:</label>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <!-- Email input -->
                        <div class="form-outline">
                            <input class="form-control" type="password" name="senha" id="senha">
                            <label class="form-label" for="form8Example5">Senha:</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Email input -->
                        <div class="form-outline">
                            <input class="form-control" type="password" name="conf-senha" id="senha">
                            <label class="form-label" for="form8Example5">Confirmar senha:</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col">
                        <select for="" class="form-select" name="fb">
                            <option>Selecione...</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <label class="form-label" for="form8Example5">Administrador:</label>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-outline-dark">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="text-center m-4">
    <a href="employees" class="btn btn-warning">Voltar</a>
</div>


<script type="text/javascript" src="../script/jquery.js"></script>
<script type="text/javascript" src="../script/acesso.js"></script>

<?php
include '../inc/footer.php';
?>