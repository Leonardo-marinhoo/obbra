
$(document).ready(function () {

    let searchParam = new URLSearchParams(window.location.search);
    let context_id = searchParam.get('id');
    let checklist_container = $('#checklist-container');


    function fetchData() {
        $.ajax({
            url: '../src/api/schedule.php',
            type: "POST",
            data: JSON.stringify({
                'action': 'getSchedule',
                'stmt_data': {
                    'id': context_id,
                }

            }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                // console.log(response);
                showData(JSON.parse(response));
            },
            error: function (error) {
                console.log(error);
            }
        })
    }

    function showData(json_data) {
        console.log(json_data);
        let schedule_elements = {
            title: $('#schedule-title'),
            description: $('#schedule-description'),
            start_date: $('#schedule-start-date'),
            end_date: $('#schedule-end-date'),
            sstatus: $('#schedule-status'),

        }

        schedule_elements.title.html(json_data['schedule_name']);
        schedule_elements.description.html(json_data['description']);
        schedule_elements.start_date.html(json_data['start_date']);
        schedule_elements.end_date.html(json_data['end_date']);
        schedule_elements.sstatus.html(json_data['status']);




    }

    function newTask() {
        let modal = $('#task_modal');
        let input_field = {
            task_name: $('#new-task-name').val(),
            task_description: $('#new-task-description').val(),
        }

        $.ajax({
            url: '../src/api/schedule.php',
            type: "POST",
            data: JSON.stringify({
                'action': 'createTask',
                'stmt_data': {
                    "schedule_id": context_id,
                    "task_name": input_field.task_name,
                    "task_description": input_field.task_description
                }

            }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                // console.log(response);
                fetchTask();
            },
            error: function (error) {
                console.log(error);
            }
        })

        modal.modal('hide');
    }
    function fetchTask() {
        $.ajax({
            url: '../src/api/schedule.php',
            type: "POST",
            data: JSON.stringify({
                'action': 'fetchChildTask',
                'stmt_data':{
                    'schedule_id':context_id
                }

            }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                // console.log(response);
                createTableElement(response);
            },
            error: function (error) {
                console.log(error);
            }
        })
    }
    function updateTaskStatus(element) {
        let task_status = element.value;
        let task_id = element.getAttribute("data-task-id");

        $.ajax({
            url: '../src/api/schedule.php',
            type: "POST",
            data: JSON.stringify({
                'action': 'updateTaskStatus',
                'stmt_data': {
                    'id': task_id,
                    'status': task_status

                }

            }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                // console.log(response);
                // fetchTask(); CRIAR ALGUM OUTRO METODO PARA NAO LIMPAR A TABLE DIRETO NO HTML POIS A DATATABLE BUGA DEVIDO AO SEU PARAMETRO 'DATA'. 
                //ENTÃO PRECISO DE UM METODO QUE MANIPULE SEU ATRIBUTO DATA E ATUALIZE ATRAVES DE SUA FUNÇÃO DRAW().
            },
            error: function (error) {
                console.log(error);
            }
        })
    }

    function createTableElement(json_data) {

        //CRIAR CONDIÇÃO PARA VERIFICAR SE DATATABLE JA FOI INICIADA E LIMPAR checklist_container QUANDO ADD TASK
        checklist_container.html("");
        let data = JSON.parse(json_data);

        data.forEach(element => {
            let tableElement = document.createElement("tr");
            tableElement.innerHTML = (
                `
            <td  class='task-title'>
              <a href="">${element.task_name}</a>
            </td>
            <td class="task-actions">
                <select data-task-id="${element.id}" class="form-select" aria-label="Default select example">
                    <option selected>${element.status}</option>
                    <option value="Concluído"">Concluído</option>
                    <option value="Pausado">Pausado</option>
                    <option value="Em Progresso">Em Progresso</option>
                    <option value="Pendências">Pendências</option>
                </select>
            </td>
            `

            )
            checklist_container.append(tableElement);
        });
        //configurar os selects para atualizar a tabela quando o valor mudar
        let selects = $('.form-select');
        Array.from(selects).forEach((select) => {
            select.addEventListener('change', () => {
                updateTaskStatus(select);
            });
        });


        // if (!table_initialized) {
        //     dtable = new DataTable("#atividades-table", {
        //         lengthMenu: [4, 8, 16, 32, 64, 128],
        //         language: {
        //             info: 'Mostrando página _PAGE_ de _PAGES_',
        //             infoEmpty: 'Nenhum Cronograma Disponível.',
        //             infoFiltered: '(filtered from _MAX_ total records)',
        //             lengthMenu: 'Ver _MENU_ Cronogramas por página.',
        //             zeroRecords: 'Nada Encontrado.',
        //             search: 'Pesquisar',
        //             paginate: {
        //                 "first": "Primeiro",
        //                 "last": "Ultimo",
        //                 "next": "Próximo",
        //                 "previous": "Anterior"
        //             },
        //         }
        //     });
        //     table_initialized = true;
        // }


    }
    function clear_container(){
        checklist_container.html("");
    }
    // fetchData();
    if(context_id){
        clear_container();
        fetchTask();
    }
});

// async function updateTaskStatus(element) {
//     let task_status = element.value;
//     let task_id = element.getAttribute("data-task-id");

//     const response = fetch('../src/api/schedule.php', {
//         method: 'POST',
//         mode: "cors",
//         credentials: "same-origin",
//         headers: {
//             "Content-Type": "application/json",
//         },
//         body: JSON.stringify({
//             'action': 'updateTaskStatus',
//             'stmt_data': {
//                 'id': task_id,
//                 'status': task_status

//             }
//         }),
//     })

//     response.then(() => {
//         alert("Status atualizado para: " + task_status);
//     })
// }