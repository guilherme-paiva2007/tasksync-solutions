<?php include "../config.php";?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Criar Tarefa - TaskSync</title>
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
                <h1>Adicione uma tarefa</h1>
                <form action="<?= createUrl("/server/entrar") ?>" method="post" id="login-form">
                    <div class="labelContainer">
                        <label for="input-descricao">Descrição:</label>
                        <input type="text" name="descricao" id="input-descricao">
                    </div>
                    <div class="labelContainer">
                        <label for="input-setor">Setor:</label>
                        <input type="text" name="setor" id="input-setor">
                    </div>
                    <div class="labelContainer">
                        <label for="input-prioridade">Prioridade:</label>
                        <select name="prioridade" id="input-prioridade" style="width: 100%;">
                            <option value="baixa">Baixa</option>
                            <option value="media">Média</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                    <hr>
                    <button type="submit">Salvar</button>
                </form>
            </section>
        </main>
        <script>
            const form = document.getElementById("login-form");
            form.addEventListener("submit", event => {
                event.preventDefault();
                if (!form.descricao.value || !form.setor.value || !form.prioridade.value) return Swal.fire({
                    icon: "error",
                    title: "Campos faltando",
                    text: "Preencha todos os campos para registrar"
                });
                const formdata = new FormData();
                formdata.append("descricao", form.descricao.value);
                formdata.append("setor", form.setor.value);
                formdata.append("prioridade", form.prioridade.value);
                formdata.append("status", "a fazer");
                formdata.append("action", "POST");
                fetch("<?= createUrl("/server/tarefas") ?>", { method: "POST", body: formdata }).then(resp => resp.json()).then(json => {
                    if (json.status === "error") {
                        Swal.fire({
                            icon: "error",
                            title: "Houve um erro...",
                            text: json.message
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Tarefa registrada!"
                        }).then(() => {
                            window.location.href = "<?php createUrl("/tarefas") ?>"
                        })
                    }
                });
            });
        </script>
    </body>
</html>