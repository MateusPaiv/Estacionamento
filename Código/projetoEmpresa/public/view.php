<?php

if (count($_POST) > 0 && isset($_POST)) {

    include '../actions/autoload.php';

    $sing = new AtualizarPerfil();


    $nome = addslashes($_POST['full_name']);
    $usuario = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $conf_senha = addslashes($_POST['conf-senha']);
    $id = $_GET['func_id'];


    $errors = $sing->updatePerfil($nome, $usuario, $email, $senha, $conf_senha, $id);
}


include('../inc/header.php');

$up = new AtualizarPerfil();

$id = $_GET['func_id'];

$user = $up->fetch($id);

if (isset($_GET['up'])) { ?>
    <script>
           Swal.fire(
            'Funcionário',
            "Atualizado com sucesso",
            'success'
          )
    </script>
<?php }

?>


<div class="form-sing d-flex flex-column justify-content-center align-items-center">
    <div id="mensagem">

        <?php if (isset($errors) && is_array($errors) && count($errors) > 0) :
            foreach ($errors as $errors) :
                if ($errors == 'Atualizado com sucesso') { ?>
                    <div class="bg-light text-success text-center">
                        <?= $errors ?>
                    </div>
        <?php
                } else {

                    echo $errors;
                    echo '<br>';
                }

            endforeach;
        endif;
        ?>

    </div>

    <div class="text-dark ">
        <div class="sing">
            <h4 class="text-center">Atualizar seu perfil</h4>
            <form method="POST">

                <div class="row">
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="username" id="nome_usuario" value="<?= $user['nome_usuario'] ?>">
                            <label class="form-label" for="form8Example3">Nome de usuário:</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Email input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="full_name" id="nome" value="<?= $user['nome'] ?>">
                            <label class="form-label" for="form8Example2">Nome completo:</label>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">

                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control" type="email" name="email" id="email" value="<?= $user['email'] ?>">
                            <label class="form-label" for="form8Example4">E-mail:</label>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <!-- Email input -->
                        <div class="form-outline">
                            <input class="form-control" type="password" name="senha" id="senha" value="<?= $user['senha'] ?>">
                            <label class="form-label" for="form8Example5">Senha:</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Email input -->
                        <div class="form-outline">
                            <input class="form-control" type="password" name="conf-senha" id="senha" value="<?= $user['senha'] ?>">
                            <label class="form-label" for="form8Example5">Confirmar senha:</label>
                        </div>
                    </div>

                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-outline-dark" id="sing">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
    </form>

</div>
<div class="text-center m-4">
    <a href="../dashboard" class="btn btn-outline-warning">Voltar</a>
</div>


<script type="text/javascript" src="../script/jquery.js"></script>
<script type="text/javascript" src="../script/acesso.js"></script>

<?php
include '../inc/footer.php';
?>