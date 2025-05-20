<?php include "../config.php";?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Entrar - TaskSync</title>
        <link rel="stylesheet" href="<?php createUrl("/assets/css/styles.css") ?>">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="shortcut icon" href="<?= createUrl("/favicon.ico") ?>" type="image/png">
    </head>
    <body class="centerContainer">
        <main>
            <section class="section-main-form">
                <div style="display: flex; justify-content: center; margin-top: 12px">
                    <img src="<?= createUrl("/favicon.ico") ?>" alt="" style="height: 96px; width: 140px; object-fit: cover;">
                </div>
                <h1>Bem-vindo à TaskSync!</h1>
                <form action="<?= createUrl("/server/entrar") ?>" method="post" id="login-form">
                    <div class="labelContainer">
                        <label for="input-email">E-mail:</label>
                        <input type="email" name="email" id="input-email">
                    </div>
                    <div class="labelContainer">
                        <label for="input-senha">Senha:</label>
                        <input type="password" name="senha" id="input-senha">
                    </div>
                    <hr>
                    <button type="submit">Entrar</button>
                    <a href="<?= createUrl("/cadastrar") ?>">Não tem conta? Cadastre-se agora.</a>
                </form>
            </section>
        </main>
        <script>
            const form = document.getElementById("login-form");
            form.addEventListener("submit", event => {
                event.preventDefault();
                if (!form.email.value || !form.senha.value) return Swal.fire({
                    icon: "error",
                    title: "Campos faltando",
                    text: "Preencha todos os campos para entrar"
                });
                const formdata = new FormData();
                formdata.append("email", form.email.value);
                formdata.append("senha", form.senha.value);
                fetch("<?= createUrl("/server/entrar") ?>", { method: "POST", body: formdata }).then(resp => resp.json()).then(json => {
                    if (json.status === "error") {
                        Swal.fire({
                            icon: "error",
                            title: "Houve um erro...",
                            text: json.message
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Sessão iniciada!"
                        }).then(() => {
                            window.location.href = "<?php createUrl("/tarefas") ?>"
                        })
                    }
                });
            });
        </script>
    </body>
</html>