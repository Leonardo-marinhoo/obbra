<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location:login.html');
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
  <link rel="stylesheet" href="./dist/css/main.css" />
  <link rel="stylesheet" href="./dist/css/projetos.css">
  <link rel="stylesheet" href="./dist/css/pages/index.css">
  <script src="./dist/packages/jquery/jquery.js"></script>
  <script src="./src/js/projetos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.7.570/pdf.min.js"></script>
  <script src="./src/js/components/sidebar.js"></script>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
</head>

<body>
  <div class="pdf_view" id="pdf_view">
    <button id="close-btn">X</button>
    <canvas id="pdf-canvas"></canvas>
  </div>
  <div class="layout-row">
    <?php include('./src/includes/components/sidebar.php'); ?>

    <div class="layout-column">
      <?php include('./src/includes/components/header.php'); ?>

      <div class="container">
        <ul class="pages">
          <!-- <li class="pages__item pages__item--blue">
            <a class="link_container" href="admin/obras.php">
              <div class="infos">
                <h3 class="title">
                  Obras
                </h3>
                <span class="subtitle">
                  -/- Página em construção -\-
                  DASHBOARD | MÉTRICAS | FERRAMENTAS
                </span>
              </div>
              <div class="icon">
                <i class="fi fi-ts-building"></i>
              </div>
            </a>
          </li> -->
          <li class="pages__item pages__item--red">
            <a class="link_container" href="admin/pendencias.php">
              <div class="infos">
                <h3 class="title">
                  Pendências
                </h3>
                <span class="subtitle">
                  OBRA | VISTORIAS | EMPREITEIRAS
                </span>
              </div>
              <div class="icon">
                <i class="fi fi-ts-list-check"></i>
              </div>
            </a>
          </li>
          <li class="pages__item pages__item--black">
            <a class="link_container" href="admin/checklist.php">
              <div class="infos">
                <h3 class="title">
                  CHECKLIST
                </h3>
                <span class="subtitle">
                  ETAPAS | APTOS | CRONOGRAMA
                </span>
              </div>
              <div class="icon">
                <i class="fi fi-tr-draw-square"></i>
              </div>
            </a>
          </li>
          <li class="pages__item pages__item--orange">
            <a class="link_container" href="cliente/projetos.php">
              <div class="infos">
                <h3 class="title">
                  Projetos
                </h3>
                <span class="subtitle">
                  MODIFICAÇÕES | PVTO TIPO | DEFINIÇÕES
                </span>
              </div>
              <div class="icon">
                <i class="fi fi-tr-master-plan"></i>
              </div>
            </a>
          </li>

          <li class="pages__item pages__item--green">
            <a class="link_container" href="admin/obra_pendencias.php">
              <div class="infos">
                <h3 class="title">
                  Funcionários
                </h3>
                <span class="subtitle">
                  Faltas | Hora-Extra | Atividades
                </span>
              </div>
              <div class="icon">
                <i class="fi fi-ts-triangle-person-digging"></i>
              </div>
            </a>
          </li>
          <li class="pages__item pages__item--purple">
            <a class="link_container" href="admin/obra_pendencias.php">
              <div class="infos">
                <h3 class="title">
                  Diário de Obras
                </h3>
                <span class="subtitle">
                  Visitas | Entregas | Atividades
                </span>
              </div>
              <div class="icon">
                <i class="fi fi-ts-notes"></i>
              </div>
            </a>
          </li>
        </ul>

      </div>


    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>