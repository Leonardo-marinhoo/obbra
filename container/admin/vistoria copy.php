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
  <link rel="stylesheet" href="../dist/css/pages/vistorias.css">
  <script src="../dist/packages/jquery/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../src/js/projetos.js"></script>
  <script src="../src/js/vistoria.js"></script>
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
        <a href="nova_vistoria.php" class="new-pendency">
          <i class="fi fi-bs-plus"></i>
          Adicionar Vistoria
        </a>
        <hr>


        <table class="vistorias-container">
          <thead>
            <th>APTO</th>
            <th>PINTURA</th>
            <th>ELETRICA</th>
            <th>LIMPEZA</th>
            <th>METAIS</th>
          </thead>
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
            <tr>
              <td><?php echo $vistoria['apto'] ?></td>
              <td>
                <div class="status-badge"
                  data-id="<?php echo $vistoria['id'] ?>"
                  data-status="<?php echo $vistoria['pintura'] ?>"
                  data-field="pintura">
                  <div class="icon icon--<?php echo $vistoria['pintura'] ?>"></div>
                  <span class="status"><?php echo $vistoria['pintura'] == true ? "OK" : "P" ?></span>
                </div>
              </td>
              <td>
                <div class="status-badge"
                  data-id="<?php echo $vistoria['id'] ?>"
                  data-status="<?php echo $vistoria['eletrica'] ?>"
                  data-field="eletrica">
                  <div class="icon icon--<?php echo $vistoria['eletrica'] ?>"></div>
                  <span class="status"><?php echo $vistoria['eletrica'] == true ? "OK" : "P" ?></span>
                </div>
              </td>
              <td>
                <div class="status-badge"
                  data-id="<?php echo $vistoria['id'] ?>"
                  data-status="<?php echo $vistoria['limpeza'] ?>"
                  data-field="limpeza">
                  <div class="icon icon--<?php echo $vistoria['limpeza'] ?>"></div>
                  <span class="status"><?php echo $vistoria['limpeza'] == true ? "OK" : "P" ?></span>
                </div>
              </td>
              <td>
                <div class="status-badge"
                 data-id="<?php echo $vistoria['id'] ?>"
                  data-status="<?php echo $vistoria['metais'] ?>"
                  data-field="metais">
                  <div class="icon icon--<?php echo $vistoria['metais'] ?>"></div>
                  <span class="status"><?php echo $vistoria['metais'] == true ? "OK" : "P" ?></span>
                </div>
              </td>
            </tr>
          <?php
          }
          ?>

        </table>
      </div>

    </div>


  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>