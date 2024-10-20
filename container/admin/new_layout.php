<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Obbra</title>
  <link rel="stylesheet" href="../dist/css/main.css" />
</head>

<body>
  <div class="layout-row">
    <nav class="navbar">
      <div class="navbar__branding">
        <img
          src="../src/images/obbra-logo.png"
          alt=""
          class="navbar__branding__logo" />
          <i data-bs-toggle="collapse" data-bs-target="#navbar" role="button" class="fi fi-ss-menu-burger mobile-icon"></i>
      </div>
      <ul class="navbar__links collapse-horizontal" id="navbar">
        <li class="navbar__links__item--label">
          <span>Informações</span>
        </li>
        <li class="navbar__links__item">
          <i class="fi fi-rs-home icon"></i>
          <a href="">Painel de Controle</a>
        </li>
        <li class="navbar__links__item--label">
          <span>Páginas</span>
        </li>
        <li class="navbar__links__item">
          <i class="fi fi-rs-screen icon"></i>
          <a href="">Departamentos</a>
        </li>
        <li class="navbar__links__item">
          <i class="fi fi-rs-build icon"></i>
          <a href="">Obras</a>
        </li>
        <li class="navbar__links__item--label">
          <span>Engenharia</span>
        </li>
        <li class="navbar__links__item">
          <i class="fi fi-ts-invite icon"></i>
          <a href="">ADM</a>
        </li>
        <li class="navbar__links__item--collapse" data-bs-toggle="collapse" role="button" data-bs-target="#collapseExample">
          <div class="collapse-link">
            <i class="fi fi-rs-employees icon"></i>
            <a href="">Encarregados</a>
            <i class="fi fi-ts-angle-small-down collapse-icon"></i>
          </div>
          <div class="collapse-body collapse" id="collapseExample">
            <ul class="collapse-body__links">
              <li class="collapse-body__links__item">
                <i class="fi fi-ts-arrow-turn-down-right icon"></i>
                <a href="">Lista de Encarregados</a>
              </li>
              <li class="collapse-body__links__item">
                <i class="fi fi-ts-arrow-turn-down-right icon"></i>
                <a href="">Cadastrar Novo</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
    <div class="layout-column">
      <header class="header">
        <div class="container">
          <div class="header__user">
            <img src="../src/images/icons/active.png" alt="" class="header__user__notification">
            <img src="../src/images/man.png" class="header__user__avatar"></img>
            <span class="header__user__name">Leonardo Marinho</span>
            <div class="header__user__actions dropdown">
              <button
                class="btn btn-secondary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"></button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Logout</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
              </ul>
            </div>
          </div>
        </div>
      </header>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>