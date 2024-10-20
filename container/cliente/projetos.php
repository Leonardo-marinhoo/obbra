<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Obbra</title>
  <link rel="stylesheet" href="../dist/css/main.css" />
  <link rel="stylesheet" href="../dist/css/projetos.css">
  <script src="../dist/packages/jquery/jquery.js"></script>
  <script src="../src/js/projetos.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.7.570/pdf.min.js"></script>
  <script src="../src/js/components/sidebar.js"></script>
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
        <?php include('../src/includes/components/quick_navigation.php') ?>
        <div class="page-hero">
          <h1>PROJETOS</h1>
          <div class="page-hero__subtitle">
            <hr>
            <small>PDF</small>
            <hr>
          </div>
        </div>
        <div class="breadcumb">
          <img src="../src/images/icons/db.png">
          <span class="breadcumb__title">Projetos /</span>
          <span class="folder__name" id="folder__name"></span>
        </div>
        <div class="file_explorer" id="file-explorer">
        </div>

      </div>


    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>