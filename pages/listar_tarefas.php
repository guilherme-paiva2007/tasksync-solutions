<?php include "../config.php";?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tarefas - TaskSync</title>
        <link rel="stylesheet" href="<?php createUrl("/assets/css/styles.css") ?>">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="shortcut icon" href="<?= createUrl("/favicon.ico") ?>" type="image/png">
    </head>
    <body class="centerContainer" style="height: 100vh">
        <main>
            <section id="mainTarefasContainer">
                <div id="mainHeader">
                    <div class="subColumn">A fazer</div>
                    <div class="subColumn">Fazendo</div>
                    <div class="subColumn">Concluído</div>
                </div>
                <?php
                include "../server/crud_tarefas.php";

                $tarefas = crud_tarefas("GET");
                ?>
                <div id="mainContent">
                    <div class="subColumn">
                        <?php foreach ($tarefas['a fazer'] as $tarefa) {
                            echo "<div>
                                <p>" . $tarefa["descricao"] . "</p>
                            </div>";
                        } ?>
                    </div>
                    <div class="subColumn">
                        <?php foreach ($tarefas['fazendo'] as $tarefa) {
                            echo "<div>
                                <p>" . $tarefa["descricao"] . "</p>
                            </div>";
                        } ?>
                    </div>
                    <div class="subColumn">
                        <?php foreach ($tarefas['concluido'] as $tarefa) {
                            echo "<div>
                                <p>" . $tarefa["descricao"] . "</p>
                            </div>";
                        } ?>
                    </div>
                </div>
            </section>
        </main>
        <style>
            main {
                height: 100%;
            }
            #mainTarefasContainer {
                height: 100%;

                & > div {
                    display: flex;
                    gap: 4px;
                }

                #mainHeader {
                    height: 10%;
                    .subColumn {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: larger;
                    }
                }

                #mainContent {
                    height: 90%;
                    .subColumn {
                        border: 2px solid black;
                    }
                }

                .subColumn {
                    height: 100%;
                    width: 200px;
                }
            }
        </style>
    </body>
</html>