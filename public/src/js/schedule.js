$(document).ready(function () {

    const table_body = $("#cronogramas > tbody");
    



    function fetch_folders(parent_id) {
        $.ajax({
            url: 'src/api/schedule.php',
            type: "POST",
            data: JSON.stringify({
                'query': 'fetch_folders',
                'stmt_data':{
                    'parent_id': parent_id
                }

            }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                render_folders(response);
            },
            error: function (error) {
                console.log(error);
            }
        })
    }
    function render_folders(json_data) {
        let data = JSON.parse(json_data);
        data.forEach(element => {
            let tableElement = document.createElement("tr");
            tableElement.innerHTML = (
                `
                <td>${element.id}</td>
                <td>
                  <a href="">${element.schedule_name}</a>
                  <br>
                  <small>Desde: ${element.start_date}</small>
                </td>
                <td class="task-progress" data-schedule_id="${element.id}">
                  <div class="progress progress-sm">
                    <div class="progress-bar" style="width:50%;"></div>
                  </div>
                  <small class="progress-percentage">50% Completo</small>
                </td>
                <td class="task-status">
                  <span class="badge text-bg-warning rounded-pill">${element.status}</span>
                </td>
                <td class="task-actions">
                  <a href="scheduleview.php?id=${element.id}" class="btn btn-primary btn-sm text-white d-inline-flex align-items-center ">
                    <i class="fi fi-sr-folder icon mx-2"></i>
                    Ver
                  </a>
                </td>`
            )
            $(table_body).append(tableElement);
        });

        data.forEach(folder=>{

        });


        // setProgressStatus();

    }
    function setProgressStatus() {
        let progress_bars = $('.task-progress');
        Array.from(progress_bars).forEach(bar => {
            let schedule_id = bar.getAttribute('data-schedule_id');
            $.ajax({
                url: 'src/api/schedule.php',
                type: "POST",
                data: JSON.stringify({
                    'action': 'fetchChildTask',
                    'stmt_data': {
                        'schedule_id': schedule_id
                    }

                }),
                headers: {
                    "Acess-Control-Allow-Methods": "POST, GET",
                    "Content-Type": "application/json",
                },
                success: function (response) {
                    // console.log(response);
                    let data = JSON.parse(response);
                    if (data.length >= 1) {
                        let total_tasks = data.length;
                        let finished_tasks = 0;
                        let progress;
                        data.forEach((task) => {
                            if (task.status === 'Concluído') { finished_tasks++; }
                        });
                        progress = (finished_tasks / total_tasks * 100).toFixed(2);
                        console.log(progress);
                        bar.innerHTML = `
                        <div class="progress progress-sm">
                            <div class="progress-bar" style="width:${progress}%;"></div>
                        </div>
                        <small class="progress-percentage" value="${progress}" >${progress}% Completo</small>`;
                    } else {
                        bar.innerHTML = `
                        <div class="progress progress-sm">
                            <div class="progress-bar" style="width:0%;"></div>
                        </div>
                        <small class="progress-percentage" >0% Completo</small>`
                    }

                },
                error: function (error) {
                    // console.log('');
                }
            })

        });
        let dtable = new DataTable("#cronogramas", {
            lengthMenu: [4, 8, 16, 32, 64, 128],
            language: {
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Nenhum Cronograma Disponível.',
                infoFiltered: '(filtered from _MAX_ total records)',
                lengthMenu: 'Ver _MENU_ Cronogramas por página.',
                zeroRecords: 'Nada Encontrado.',
                search: 'Pesquisar',
                paginate: {
                    "first": "Primeiro",
                    "last": "Ultimo",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
            },
            order:[[0,'desc']]
        });
    }
    function newSchedule() {
        let modal = $('#schedule_modal');
        let input_field = {
            schedule_name: $('#new-schedule-name').val(),
            schedule_description: $('#new-schedule-description').val(),
            start_date: $('#new-schedule-start-date').val(),
            end_date: "",
            status: "Em Progresso",
            manager_id: "",
            members_id: ""
        }

        $.ajax({
            url: 'src/api/schedule.php',
            type: "POST",
            data: JSON.stringify({
                "action": "createSchedule",
                "stmt_data": {
                    "schedule_name": input_field.schedule_name,
                    "description": input_field.schedule_description,
                    "start_date": input_field.start_date,
                    "end_date": input_field.end_date,
                    "status": input_field.status,
                    "manager_id": input_field.manager_id,
                    "members_id": input_field.members_id
                }

                }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                // console.log(response);
                location.reload();
            },
            error: function (error) {
                console.log(error);
            }
        })

        modal.modal('hide');
    }

    fetch_folders();


});
