<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>

    <link rel="stylesheet" href="./src/packages/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/css/globalStyle.css">
    <!-- <link rel="stylesheet" href="./src/css/dashboard.css"> -->
</head>

<body>
    <header class="navbar sticky-top bg-red flex-md-nowrap py-2 shadow">
        <a class="navbar-brand col-lg-2 me-0 px-3 fs-6 p-2 text-white bg-body-primary header-title" href="#">OBBRA</a>
        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fi fi-bs-menu-burger"></i>
                </button>
            </li>
        </ul>

    </header>

    <div class="container-fluid">
        <div class="cards">
            <div class="cards-header mt-3">
                <h6>MENU</h6>
            </div>
            <div class="row row-cols-2 mx-auto gap-2 justify-content-center">
                <div class="card bg-red col-md-2">
                    <img src="./src/images/icons/funcionarios.png" alt="" class="card-img-top">
                    <div class="card-body text-light">
                        <div class="card-title">
                            <h6>Funcionários</h6>
                        </div>
                        <div class="card-text">
                            <p>Hora-Extra e Ficha de Registro</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    </div>

    <script src="./src/packages/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>