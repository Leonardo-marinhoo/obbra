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
  <link rel="stylesheet" href="../dist/css/pages/pendencias.css">
  <script src="../dist/packages/jquery/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../src/js/projetos.js"></script>
  <script src="../src/js/pending_issues.js"></script>
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
        <div class="page-hero">
          <h1>Pendências</h1>
          <div class="page-hero__subtitle">
            <hr>
            <small>Obra</small>
            <hr>
          </div>
        </div>
        <a href="nova_pendencia.php" class="new-pendency">
          <i class="fi fi-bs-plus"></i>
          Adicionar Pendência
        </a>
        <hr>
        <div class="filter-tab">
          <span class="tab-title">Filtros:</span>
          <div class="dropdown">
            <div class="icon">
              <i class="fi fi-bs-house-building"></i>
            </div>
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Obra
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="?obra=Ed.Tulum">Ed.Tulum</a></li>
              <hr>
              <li><a class="dropdown-item" href="?obra=Ed.Taiba">Ed.Taiba</a></li>
              <hr>
              <li><a class="dropdown-item" href="?obra=Ed.Guaeca">Ed.Guaeca</a></li>
            </ul>
          </div>
          <div class="dropdown">
            <div class="icon">
              <i class="fi fi-bs-battery-exclamation"></i>
            </div>
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Status
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="?status=Pendente">Pendente</a></li>
              <li><a class="dropdown-item" href="?status=Resolvendo">Resolvendo</a></li>
              <li><a class="dropdown-item" href="?status=Concluído">Concluído</a></li>
            </ul>
          </div>
          <!-- <div class="dropdown">
            <div class="icon">
              <i class="fi fi-bs-calendar-check"></i>
            </div>
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Data
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="?data=Hoje">Hoje</a></li>
              <li><a class="dropdown-item" href="?data=Ontem">Ontem</a></li>
              <li><a class="dropdown-item" href="?data=Esta Semana">Esta Semana</a></li>
            </ul>
          </div> -->
          <div class="dropdown">
            <div class="icon">
              <i class="fi fi-bs-department-structure"></i>
            </div>
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Departamento
            </button>
            <ul class="dropdown-menu">
              <?php
              require_once('../src/api/database.php');

              $db = new Database();
              $pdo = $db->Connect();
              $stmt = $pdo->prepare("SELECT name FROM departments");

              try {
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo '<li><a class="dropdown-item" href="?departamento=' . urlencode($row['name']) . '">' . htmlspecialchars($row['name']) . '</a></li>';
                }
              } catch (PDOException $e) {
                echo $e;
              }
              ?>
            </ul>
          </div>
        </div>

        <div class="pendencias-container">

          <!-- <div class="pendencia">
            <div class="pendencia__header">
              <h2 class="title">Hall andar 12</h2>
              <span class="date">22/09/24</span>
            </div>
            <div class="pendencia__body">
              <span class="description">Trocar Piso que está quebrado</span>
            </div>
            <div class="pendencia__footer">
              <select class="form-select Normal" aria-label="Default select example">
                <option value="1">Alta</option>
                <option value="2">Normal</option>
                <option value="3">Baixa</option>
              </select>
              <select class="form-select" aria-label="Default select example">
                <option value="1">Pendente</option>
                <option value="2">Resolvendo</option>
                <option value="3">Concluido</option>
              </select>
              <div class="dropdown">
                <div class="icon">
                  <i class="fi fi-br-menu-burger"></i>
                </div>
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#"><i class="fi fi-rr-edit"></i> Editar</a></li>
                  <li><a class="dropdown-item" href="#"><i class="fi fi-bs-menu-dots"></i>Ver</a></li>
                  <hr>
                  <li><a class="dropdown-item" href="#"><i class="fi fi-bs-delete-document"></i>Excluir</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="pendencia">
            <div class="pendencia__header">
              <h2 class="title">Hall terreo</h2>
              <span class="date">22/09/24</span>
            </div>
            <div class="pendencia__body">
              <span class="description">Trocar Piso que está quebrado</span>
            </div>
            <div class="pendencia__footer">
              <select class="form-select Alta" aria-label="Default select example">
                <option value="1">Alta</option>
                <option value="2">Normal</option>
                <option value="3">Baixa</option>
              </select>
              <select class="form-select" aria-label="Default select example">
                <option value="1">Pendente</option>
                <option value="2">Resolvendo</option>
                <option value="3">Concluido</option>
              </select>
              <div class="dropdown">
                <div class="icon">
                  <i class="fi fi-br-menu-burger"></i>
                </div>
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#"><i class="fi fi-rr-edit"></i> Editar</a></li>
                  <li><a class="dropdown-item" href="#"><i class="fi fi-bs-menu-dots"></i>Ver</a></li>
                  <hr>
                  <li><a class="dropdown-item" href="#"><i class="fi fi-bs-delete-document"></i>Excluir</a></li>
                </ul>
              </div>
            </div>
          </div> -->
          <?php
          require_once('../src/api/database.php');

          $db = new Database();
          $pdo = $db->Connect();

          // Iniciando a consulta SQL
          $sql = "SELECT p.*, u.name AS name, u.surname AS surname, d.name as department_name
        FROM pending_issues p
        JOIN users u ON p.user_id = u.id
        JOIN departments d ON p.department_id = d.id";

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

          foreach (array_reverse($result) as $pendency) {
          ?>
            <div class="pendencia pendencia--<?php echo $pendency['priority'] ?>" id="pendencia-<?php echo $pendency['id'] ?>">
              <div class="pendencia__header">
                <h2 class="title"><?php echo $pendency['subject']; ?></h2>
                <span class="date"><?php echo $pendency['obra']; ?></span>
                <span class="autor"><i class="fi fi-ss-user"></i><?php echo $pendency['name'] . " " . $pendency['surname']; ?></span>
              </div>
              <div class="pendencia__body">
                <span class="description"><?php echo $pendency['description']; ?></span>
              </div>
              <div class="pendencia__footer">
                <select class="form-select <?php echo $pendency['priority']; ?>" data-type="priority" data-id="<?php echo $pendency['id']; ?>" aria-label="Default select example">
                  <option value="Alta" <?php echo $pendency['priority'] == 'Alta' ? 'selected' : '' ?>>Alta</option>
                  <option value="Normal" <?php echo $pendency['priority'] == 'Normal' ? 'selected' : '' ?>>Normal</option>
                  <option value="Baixa" <?php echo $pendency['priority'] == 'Baixa' ? 'selected' : '' ?>>Baixa</option>
                </select>
                <select class="form-select <?php echo $pendency['status'] ?>" data-type="status" data-id="<?php echo $pendency['id']; ?>" aria-label="Default select example">
                  <option value="Pendente" <?php echo $pendency['status'] == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                  <option value="Resolvendo" <?php echo $pendency['status'] == 'Resolvendo' ? 'selected' : '' ?>>Resolvendo</option>
                  <option value="Concluido" <?php echo $pendency['status'] == 'Concluido' ? 'selected' : '' ?>>Concluido</option>
                </select>
                <div class="dropdown dropdown--border">
                  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="icon">
                      <i class="fi fi-br-menu-burger"></i>
                    </div>
                  </button>
                  <ul class="dropdown-menu">
                    <li><button class="dropdown-item pendency-action" data-type="edit" data-id="<?php echo $pendency['id'] ?>"><i class="fi fi-rr-edit"></i> Editar</button></li>
                    <li><button class="dropdown-item pendency-action" data-type="view" data-id="<?php echo $pendency['id'] ?>"><i class="fi fi-bs-menu-dots"></i>Ver</button></li>
                    <hr>
                    <li><button class="dropdown-item pendency-action" data-type="delete" data-id="<?php echo $pendency['id'] ?>"><i class="fi fi-bs-delete-document"></i>Excluir</button></li>
                  </ul>
                </div>
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