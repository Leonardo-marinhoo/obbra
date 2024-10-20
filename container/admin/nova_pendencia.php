<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location:../login.html');
    // sempre verificar rota para a pagina de login
} else {
    // echo "<script> alert(" . $_SESSION['user_id'] . ")</script>";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Obbra</title>
    <link rel="stylesheet" href="../dist/css/main.css">
    <link rel="stylesheet" href="../dist/css/projetos.css">
    <link rel="stylesheet" href="../dist/css/pages/nova_pendencia.css">
    <script src="../dist/packages/jquery/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../src/js/projetos.js"></script>
    <script src="../src/js/new_pendency.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.7.570/pdf.min.js"></script>
    <script src="../../src/js/components/sidebar.js"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>

    <!-- Imports summernote (texteditor) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body>
    <div class="pdf_view" id="pdf_view">
        <button id="close-btn">X</button>
        <canvas id="pdf-canvas"></canvas>
    </div>
    <div class="layout-row">
        <?php include('../src/includes/components/sidebar.php'); ?>

        <div class="layout-column">
            <?php include('../src/includes/components/header.php'); ?>

            <div class="container">
                <div class="page-info">
                    <div class="page-info__icon">
                        <i class="fi fi-ss-house-chimney"></i>
                    </div>
                    <h4 class="page-info__title"><a href="pendencias.php">Pendências > </a>Nova Pendência</h4>
                </div>

                <form class="pendency-form" action="" class="pendency-form">
                    <div class="input-field">
                        <label for="">Titulo</label>
                        <input type="text" placeholder="APTO 21" id="name" class="form-input">
                    </div>
                    <hr>
                    <div class="input-field">
                        <label for="">Departamento</label>
                        <select name="" id="department">
                            <option value="none">Selecione um Departamento</option>
                            <?php
                            require_once('../src/api/database.php');

                            $db = new Database();
                            $pdo = $db->Connect();
                            $stmt = $pdo->prepare("SELECT * FROM departments");

                            try {
                                $stmt->execute();
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo $e;
                            }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div class="input-field">
                        <label for="">Obra</label>
                        <select name="" id="obra">
                            <option value="none">Selecione uma Obra</option>
                            <option value="Ed.Tulum">Ed.Tulum</option>
                            <option value="Ed.Guaeca">Ed.Guaeca</option>
                            <option value="Ed.Taiba">Ed.Taiba</option>


                            <?php
                            // require_once('../src/api/database.php');

                            // $db = new Database();
                            // $pdo = $db->Connect();
                            // $stmt = $pdo->prepare("SELECT name FROM departments");

                            // try {
                            //     $stmt->execute();
                            //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            //         echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                            //     }
                            // } catch (PDOException $e) {
                            //     echo $e;
                            // }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div class="input-field input-field--row">
                        <label class="input-title" for="">Prioridade</label>
                        <label class="radio-label">
                            <input type="checkbox" name="priority" value="Alta" /> Alta
                        </label>
                        <label class="radio-label">
                            <input checked type="checkbox" name="priority" value="Normal" /> Normal
                        </label>
                        <label class="radio-label">
                            <input type="checkbox" name="priority" value="Baixa" /> Baixa
                        </label>
                    </div>

                    <hr>
                    <div class="input-field">
                        <label for="">Descrição</label>
                        <textarea id="summernote" name="editordata"></textarea>
                    </div>
                    <button id="submit-btn" class="submit-btn" type="reset">Enviar</button>
                </form>


            </div>

        </div>


    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>