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
  <link rel="stylesheet" href="../dist/css/main.css" />
  <link rel="stylesheet" href="../dist/css/projetos.css">
  <link rel="stylesheet" href="../dist/css/pages/index.css">
  <script src="../dist/packages/jquery/jquery.js"></script>
  <script src="../src/js/projetos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.7.570/pdf.min.js"></script>
  <script src="../../src/js/components/sidebar.js"></script>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-thin-rounded/css/uicons-thin-rounded.css'>
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
          <h4 class="page-info__title">Selecione a Obra:</h4>
        </div>

      </div>


    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>