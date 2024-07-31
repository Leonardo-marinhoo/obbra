<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout template</title>

    <link rel="stylesheet" href="./src/css/globalStyle.css">
    <link rel="stylesheet" href="./src/packages/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/packages/DataTables/datatables.css">
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
                        <h5 class="page-title me-3 pe-3">Hora Extra</h5>
                        <li class="breadcrumb-item"><a href="#">Início</a></li>
                        <li class="breadcrumb-item"><a href="#">Funcionários</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hora Extra</li>
                    </ol>
                </nav>
  
            </div>
        </div>


    </div>

    <script src="./src/packages/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./src/packages/bootstrap/js/"></script>
</body>

</html>