<html>

<head>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="assets/img/favicon-16x16.png" type="image/x-icon">
    <title>Login - EstacioneAqui</title>
</head>

<body id="bg-login" style="overflow-y: hidden;">
    <section>
        <div class="text-center rounded" id="mensagem">
        </div>
        <div class="form-login d-flex justify-content-center align-items-center rounded">
            <div class="text-white p-2 bg-white rounded">
                <div class="login">
                    <h4 class="text-center text-dark fs-3 fw-bold">Login</h4>
                    <form id="form_login">
                        <div class="mt-4">
                            <input class="form-control " type="email" name="email" placeholder="E-mail" id="email">
                        </div>

                        <div class="mt-4">
                            <input class="form-control " type="password" name="senha" placeholder="Senha" id="senha">
                        </div>
                        <div class="text-center">
                            <button class="learn-more mt-5" id="entrar" type="submit">
                                <span class="circle" aria-hidden="true">
                                    <span class="icon arrow"></span>
                                </span>
                                <span class="button-text">Entrar</span>
                            </button>
                           
                        </div>
                    </form>

                </div>
            </div>
        </div>
        
    </section>


    <script type="text/javascript" src="script/jquery.js"></script>
    <script type="text/javascript" src="script/acesso.js"></script>
</body>

</html>