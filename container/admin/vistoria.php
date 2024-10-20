<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  // header('Location:login.html');x
  //sempre verificar rota para a pagina de login
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
  <link rel="stylesheet" href="../dist/css/pages/vistorias.css?v=0.8781">
  <script src="../dist/packages/jquery/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../src/js/projetos.js"></script>
  <script src="../src/js/vistoria.js?v=0.8"></script>
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
        <?php include('../src/includes/components/quick_navigation.php') ?>
        <!-- <a href="nova_vistoria.php" class="new-pendency">
          <i class="fi fi-bs-plus"></i>
          Adicionar Vistoria
        </a>
        <hr> -->


        <div class="vistorias-container">
          <div class="vistorias-container__header">
            <h4 class="title">Vistorias Agendadas</h4>
          </div>
          <?php
          require_once('../src/api/database.php');

          $db = new Database();
          $pdo = $db->Connect();

          // Iniciando a consulta SQL
          $sql = "SELECT * FROM vistorias";

          // Adicionando filtros
          $filters = [];
          $params = [];

          if (isset($_GET['obra'])) {
            $filters[] = "p.obra = :obra";
            $params[':obra'] = $_GET['obra'];
          }

          if (isset($_GET['status'])) {
            $filters[] = "p.status = :status";
            $params[':status'] = $_GET['status'];
          }

          if (isset($_GET['data'])) {
            // Supondo que você tem um campo de data na tabela e está lidando com diferentes intervalos de datas
            switch ($_GET['data']) {
              case 'Hoje':
                $filters[] = "DATE(p.created_at) = CURDATE()";
                break;
              case 'Ontem':
                $filters[] = "DATE(p.created_at) = CURDATE() - INTERVAL 1 DAY";
                break;
              case 'Esta Semana':
                $filters[] = "WEEK(p.created_at) = WEEK(CURDATE()) AND YEAR(p.created_at) = YEAR(CURDATE())";
                break;
            }
          }

          if (isset($_GET['departamento'])) {
            $filters[] = "d.name = :departamento";
            $params[':departamento'] = $_GET['departamento'];
          }

          // Adicionando os filtros à consulta SQL
          if (count($filters) > 0) {
            $sql .= " WHERE " . implode(" AND ", $filters);
          }

          $stmt = $pdo->prepare($sql);

          foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
          }

          try {
            $stmt->execute();
            $result = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $result[] = $row;
            }
          } catch (PDOException $e) {
            echo $e;
          }

          foreach (array_reverse($result) as $vistoria) {
          ?>
            <div class="vistoria">
              <div class="vistoria-header">
                <div class="vistoria-header__info vistoria-header__info--apto">
                  <span class="info-title">APTO</span>
                  <span class="info-text">
                    <?php echo $vistoria['apto'] ?>
                  </span>
                </div>
                <div class="vistoria-header__info vistoria-header__info--date">
                  <span class="info-title">Data</span>
                  <span class="info-text">
                    21/10/24
                  </span>
                </div>
                <div class="vistoria-header__info vistoria-header__info--hour">
                  <span class="info-title">Horario</span>
                  <span class="info-text">
                    8H
                  </span>
                </div>
              </div>
              <div class="vistoria-checklist">
                <button class="vistoria-checklist__item status-toggle status-pendente <?php echo $vistoria['pintura'] == true ? 'status-ok' :  'status-pendente' ?>"
                  data-id="<?php echo $vistoria['id'] ?>"
                  data-field="pintura"
                  data-status="<?php echo $vistoria['pintura'] ?>">
                  pintura
                </button>
                <button class="vistoria-checklist__item status-toggle status-pendente <?php echo $vistoria['eletrica'] == true ? 'status-ok' :  'status-pendente' ?>"
                  data-id="<?php echo $vistoria['id'] ?>"
                  data-field="eletrica"
                  data-status="<?php echo $vistoria['eletrica'] ?>">
                  Eletrica
                </button>
                <button class="vistoria-checklist__item status-toggle status-pendente <?php echo $vistoria['metais'] == true ? 'status-ok' :  'status-pendente' ?> "
                  data-id="<?php echo $vistoria['id'] ?>"
                  data-field="metais"
                  data-status="<?php echo $vistoria['metais'] ?>">
                  Metais
                </button>
                <button class="vistoria-checklist__item status-toggle <?php echo $vistoria['limpeza'] == true ? 'status-ok' :  'status-pendente' ?>"
                  data-id="<?php echo $vistoria['id'] ?>"
                  data-field="limpeza"
                  data-status="<?php echo $vistoria['limpeza'] ?>">
                  Limpeza
                </button>
              </div>
              <div class="vistoria-obs">
                <span><b>Obs.:</b> nenhuma observação</span>
              </div>
            </div>
          <?php
          }
          ?>

        </div>
      </div>

    </div>


  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>