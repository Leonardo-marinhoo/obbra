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
    <div class="modal fade" id="hora_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Informações do Funcionário</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Nome</span>
                        <input disabled id="employee_name" type="text" class="form-control  w-50" placeholder="Nome">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Função</span>
                        <input disabled id="employee_function" type="text" class="form-control" placeholder="Função">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Equipe</span>
                        <input disabled id="employee_equipe" type="text" class="form-control"
                            placeholder="Ex: Ferragem">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">ID</span>
                        <input disabled id="employee_id" type="text" class="form-control" placeholder="Id">
                        <span class="input-group-text ms-1" id="basic-addon1">Data</span>
                        <input id="employee_date" type="date" class="w-25 form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Obs</span>
                        <input id="employee_obs" type="text" class="form-control" placeholder="Obs">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Horas</span>
                        <input id="employee_hours" type="number" class="form-control" placeholder="Horas Extra">
                        <span class="input-group-text" id="basic-addon1">Obra</span>
                        <input id="employee_obra" type="text" list="obras_options" class="form-control"
                            placeholder="Obra">
                        <datalist id="obras_options">
                            <option value="Ed.Tulum">Ed.Tulum</option>
                            <option value="Ed.Lucca">Ed.Lucca</option>
                            <option value="Ed.Guaeca">Ed.Guaeca</option>
                            <option value="Ed.Taiba">Ed.Taiba</option>
                        </datalist>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="hour_submit" type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">Enviar</button>
                </div>

            </div>
        </div>
    </div>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="hour_toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1500">
            <div class="toast-header">
                <img src="./src/images/icons/yes_9426997.png" class="rounded me-2" alt="...">
                <strong class="me-auto">OBBRA</strong>
                <small>1 second ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hora-Extra Enviada !
            </div>
            <div class="my-progress">
                <div class="my-progress-wrapper">
                    <div class="my-progress-bar decreasing"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row container-fluid g-0 p-0 m-0">
        <?php include('./src/components/header.php'); ?>
        <?php include('./src/components/sidebar.php'); ?>

        <div class="sidebar-wrapper col-2 d-none d-lg-block"></div>
        <div class="content-container container-fluid flex-column">
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
            <div class="white-panel container-fluid">

                <ul class="nav nav-tabs nav-pills" id="employees_tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" role="tab" class="nav-link " data-bs-toggle="pill"
                            data-bs-target="#horas_tab">Hora Extra</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" role="tab" class="nav-link " data-bs-toggle="pill"
                            data-bs-target="#historico_tab">Histórico</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" role="tab" class="nav-link active " data-bs-toggle="pill"
                            data-bs-target="#resume_tab">Fechamento</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" role="tab" class="nav-link " data-bs-toggle="pill"
                            data-bs-target="#escala_tab">Escala Guardas</button>
                    </li>
                </ul>

                <div class="tab-content" id="employees_tab">
                    <div class="tab-pane fade show py-3" id="horas_tab" role="tabpanel" tabindex="0">
                        <div class="row mx-auto gap-2 justify-content-center pb-5">
                            <span class="my-2">Selecione o Funcionário</span>
                            <div class="col-md-9 table-responsive">
                                <table id="employees_table"
                                    class="table table-hover align-middle table-striped table-bordered text-center">
                                    <thead class="text-center">
                                        <th class="px-5">Funcionário</th>
                                        <th class="px-1">Função</th>
                                        <th class="px-1">Equipe</th>
                                    </thead>
                                    <tbody id="employees_table_body" class="align-middle">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show py-3" id="historico_tab" role="tabpanel" tabindex="0">
                        <div class="row mx-auto gap-2 justify-content-center pb-5">
                            <span class="my-2">Histórico de Hora Extra</span>
                            <div class="col-md-9 table-responsive">
                                <table id="history_table"
                                    class="table table-hover table-striped table-bordered text-center">
                                    <thead class="text-center">
                                        <th class="px-5">Funcionário</th>
                                        <th class="px-1">Função</th>
                                        <th>Horas</th>
                                        <th>OBS</th>
                                        <th>Obra</th>
                                        <th>Data</th>
                                    </thead>
                                    <tbody class="align-middle">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active py-3" id="resume_tab" role="tabpanel" tabindex="0">
                        <div class="row mx-auto gap-2 justify-content-center pb-5">
                            <span class="my-2">Fechamento > Soma de Horas</span>
                            <div class="col-md-9 table-responsive">
                                <table id="resume_table"
                                    class="table table-hover table-striped table-bordered text-center">
                                    <thead class="text-center">
                                        <th class="px-5">Funcionário</th>
                                        <th class="w-auto px-1">Função</th>
                                        <th class="px-1">Equipe</th>
                                        <th>Horas</th>
                                    </thead>
                                    <tbody class="align-middle">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>



    </div>

    <script src="./src/packages/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./src/packages/bootstrap/js/"></script>
</body>

</html>