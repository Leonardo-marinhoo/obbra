<nav class="navbar">
  <div class="navbar__branding">
    <img
      src="../src/images/obbra-logo.png"
      alt=""
      class="navbar__branding__logo" />
    <!-- <i data-bs-toggle="collapse" data-bs-target="#navbar" role="button" class="fi fi-ss-menu-burger mobile-icon"></i> -->
    <i id="sidebar__btn" class="fi fi-ss-menu-burger mobile-icon"></i>

  </div>
  <ul class="navbar__links" id="navbar">
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