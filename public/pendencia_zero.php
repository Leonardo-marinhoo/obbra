<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Layout template</title>

    <link rel="stylesheet" href="./src/css/globalStyle.css" />
    <link
      rel="stylesheet"
      href="./src/packages/bootstrap/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="./src/packages/DataTables/datatables.css" />
    <link rel="stylesheet" href="./src/css/pendencia_zero.css" />
    <script src="./src/packages/jquery/jquery.js"></script>
    <script src="./src/packages/DataTables/datatables.js"></script>
    <script src="./src/js/employees/employees.js"></script>
  </head>

  <body>
    <div class="d-flex flex-row container-fluid g-0 p-0 m-0">
      <?php include('./src/components/header.php'); ?>
      <?php include('./src/components/sidebar.php'); ?>

      <div class="sidebar-wrapper col-2 d-none d-lg-block"></div>
      <div class="content-container container-fluid">
        <div class="row px-3 py-4">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <h5 class="page-title me-3 pe-3">PENDÊNCIA-ZERO</h5>
              <li class="breadcrumb-item"><a href="#">Início</a></li>
              <li class="breadcrumb-item"><a href="#">Obra</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                Pendência-zero
              </li>
            </ol>
          </nav>
        </div>
        <div class="pendencias-container container-fluid p-0 g-0">
          <h2 class="container-title red-text mb-5">Etapas da Obra</h2>
          <div class="pendencia mb-2">
            <div class="pendencia-icon">
                <i class="fi fi-ss-folder-tree folder-icon"></i>
            </div>
            <div class="pendencia-info">
              <h5 class="pendencia-title m-0">Apartamentos</h5>
              <p class="pendencia-description m-0">Descrição da etapa 1</p>
            </div>
          </div>
          <div class="pendencia mb-2">
            <div class="pendencia-icon">
              <i class="fi fi-sr-usd-circle icon"></i>
            </div>
            <div class="pendencia-info">
              <h5 class="pendencia-title m-0">APTO 61</h5>
              <p class="pendencia-description m-0">Descrição da etapa 1</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="./src/packages/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./src/packages/bootstrap/js/"></script>
  </body>
</html>
