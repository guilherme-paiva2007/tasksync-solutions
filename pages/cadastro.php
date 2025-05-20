<?php include "../config.php";?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastrar - TaskSync</title>
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
                <h1>Novo por aqui?</h1>
                <form action="<?= createUrl("/server/cadastrar") ?>" method="post" id="login-form">
                    <div class="labelContainer">
                        <label for="input-nome">Nome:</label>
                        <input type="text" name="nome" id="input-nome">
                    </div>
                    <div class="labelContainer">
                        <label for="input-email">E-mail:</label>
                        <input type="email" name="email" id="input-email">
                    </div>
                    <div class="labelContainer">
                        <label for="input-senha">Senha:</label>
                        <input type="password" name="senha" id="input-senha">
                    </div>
                    <hr>
                    <button type="submit">Cadastrar</button>
                </form>
            </section>
        </main>
        <script>
            const form = document.getElementById("login-form");
            form.addEventListener("submit", event => {
                event.preventDefault();
                if (!form.email.value || !form.senha.value || !form.nome.value) return Swal.fire({
                    icon: "error",
                    title: "Campos faltando",
                    text: "Preencha todos os campos para entrar"
                });
                if (form.senha.value.length < 8) return Swal.fire({
                    icon: "error",
                    title: "Senha inválida",
                    text: "A senha deve ter pelo menos 8 caracteres"
                });
                const formdata = new FormData();
                formdata.append("email", form.email.value);
                formdata.append("senha", form.senha.value);
                formdata.append("nome", form.nome.value);
                fetch("<?= createUrl("/server/cadastrar") ?>", { method: "POST", body: formdata }).then(resp => resp.json()).then(json => {
                    if (json.status === "error") {
                        Swal.fire({
                            icon: "error",
                            title: "Houve um erro...",
                            text: json.message
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Conta criada com sucesso!"
                        }).then(() => {
                            window.location.href = "<?php createUrl("/tarefas") ?>"
                        })
                    }
                });
            });
        </script>
    </body>
</html>