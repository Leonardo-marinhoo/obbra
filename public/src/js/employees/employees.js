$(document).ready(function () {

    let employees_table = $('#employees_table');
    let history_table = $('#history_table');
    let resume_table = $('#resume_table');
    let context_employee = {
        id: "",
        Nome: "",
        Função: "",
        Equipe: ""
    }
    let employees_array;


    function setup_modal_events() {
        $('#hora_modal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let input_field = {
                employee_name: $('#employee_name'),
                employee_function: $('#employee_function'),
                employee_id: $('#employee_id'),
                employee_date: $('#employee_date'),
                employee_obs: $('#employee_obs'),
                employee_hours: $('#employee_hours'),
                employee_obra: $('#employee_obra'),
                employee_equipe: $('#employee_equipe'),
                submit_btn: $('#hour_submit'),
            }
            let hour_toast = $('#hour_toast');
            let toast_bs = bootstrap.Toast.getOrCreateInstance(hour_toast);

            input_field.employee_name.val(context_employee.Nome);
            input_field.employee_function.val(context_employee.Função);
            input_field.employee_equipe.val(context_employee.Equipe);
            input_field.employee_id.val(context_employee.id);

            input_field.submit_btn.off('click'); //REMOVE THE PREVIOUS EVENT TO PREVENT STACKING EVENTS AND SEND MULTIPLE REQUEST
            input_field.submit_btn.on("click", function () {
                post_extra_hour(input_field);
                toast_bs.show();
            })


        })
    }

    function fetch_employees() {
        $.ajax({
            url: 'src/database/employees.php',
            type: 'POST',
            data: JSON.stringify({
                "request": "fetch_employees",
            }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                employees_array = JSON.parse(response);
                render_employees(JSON.parse(response));
                console.log(employees_array);
            },
            error: function (error) {
                console.log(error);
            }

        })
    }
    function fetch_history() {
        $.ajax({
            url: 'src/database/employees.php',
            type: 'POST',
            data: JSON.stringify({
                "request": "fetch_history",
            }),
            headers: {
                "Acess-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                render_history(JSON.parse(response));
                render_resume(JSON.parse(response),employees_array);

            },
            error: function (error) {
                console.log(error);
            }

        })
    }
    function render_employees(data) {
        data.forEach((employee) => {
            let row = $('<tr>');
            $('<td>').html(`${employee.Nome}`).appendTo(row);
            $('<td>').html(`${employee.Função}`).appendTo(row);
            $('<td>').html(`${employee.Equipe}`).appendTo(row);


            // let buttons = $('<td>').addClass('align-middle');
            // let inner_div = $('<div>').addClass('input-group input-group-md-2 w-100 justify-content-center gap-2');
            // $('<button>').addClass('btn btn-primary').html('Hora Extra').appendTo(inner_div);
            // $('<button>').addClass('btn btn-danger').html('Falta').appendTo(inner_div);

            // buttons.append(inner_div).appendTo(row);
            row.on('click', function () {
                context_employee.id = employee.id;
                context_employee.Nome = employee.Nome;
                context_employee.Função = employee.Função;
                context_employee.Equipe = employee.Equipe;
                $('#hora_modal').modal('show');
            })
            employees_table.append(row);
        });

        new DataTable(employees_table, {
            language: {
                info: 'Página _PAGE_ de _PAGES_',
                infoEmpty: 'Nenhum Registro Encontrado',
                infoFiltered: '(Filtrados _MAX_ de records)',
                lengthMenu: 'Mostrar _MENU_ registros por Página',
                zeroRecords: 'Nenhum resultado'
            },
            lengthMenu: [
                [8, 15, 25, -1],
                [8, 15, 25, 'Todos']
            ]
        });

        fetch_history();

    }
    function render_history(data) {
        data.forEach((employee) => {
            let row = $('<tr>');
            $('<td>').html(`${employee.employee_name}`).appendTo(row);
            $('<td>').html(`${employee.employee_function}`).appendTo(row);
            $('<td>').html(`${employee.employee_hours}`).appendTo(row);
            $('<td>').html(`${employee.employee_obs}`).appendTo(row);
            $('<td>').html(`${employee.employee_obra}`).appendTo(row);
            $('<td>').html(`${employee.employee_date}`).appendTo(row);

            history_table.append(row);
        });

        new DataTable(history_table, {
            language: {
                info: 'Página _PAGE_ de _PAGES_',
                infoEmpty: 'Nenhum Registro Encontrado',
                infoFiltered: '(Filtrados _MAX_ de records)',
                lengthMenu: 'Mostrar _MENU_ registros por Página',
                zeroRecords: 'Nenhum resultado'
            },
            lengthMenu: [
                [8, 15, 25, -1],
                [8, 15, 25, 'Todos']
            ]
        });
    }
    function render_resume(history, arr_employees) {
        
        arr_employees.forEach((employee)=>{
            let employee_history = history.filter(employee_data => employee_data.employee_id === employee.id);
            let horas = 0;
            employee_history.forEach((result)=>{
                horas += parseInt(result.employee_hours);
            })
            let row = $('<tr>');
            $('<td>').html(`${employee.Nome}`).appendTo(row);
            $('<td>').html(`${employee.Função}`).appendTo(row);
            $('<td>').html(`${employee.Equipe}`).appendTo(row);

            $('<td>').html(`${horas}`).appendTo(row);
            
            if(horas>0) {
                resume_table.append(row);
            }
            // console.log('Funcionario: '+ employee.Nome + '  Horas: ' + horas);
        })

        new DataTable(resume_table, {
            language: {
                info: 'Página _PAGE_ de _PAGES_',
                infoEmpty: 'Nenhum Registro Encontrado',
                infoFiltered: '(Filtrados _MAX_ de records)',
                lengthMenu: 'Mostrar _MENU_ registros por Página',
                zeroRecords: 'Nenhum resultado'
            },
            lengthMenu: [
                [8, 15, 25, -1],
                [8, 15, 25, 'Todos']
            ]
        });
   

    }
    function post_extra_hour(input_field) {
        console.log('enviando horas');
        $.ajax({
            url: 'src/database/employees.php',
            type: 'POST',
            data: JSON.stringify({
                "request": "extra_hour",
                "stmt_data": {
                    "employee_id": input_field.employee_id.val(),
                    "employee_name": input_field.employee_name.val(),
                    "employee_function": input_field.employee_function.val(),
                    "employee_date": input_field.employee_date.val(),
                    "employee_obs": input_field.employee_obs.val(),
                    "employee_hours": input_field.employee_hours.val(),
                    "employee_obra": input_field.employee_obra.val(),
                    "employee_equipe": input_field.employee_equipe.val(),
                }
            }),
            headers: {
                "Access-Control-Allow-Methods": "POST, GET",
                "Content-Type": "application/json",
            },
            success: function (response) {
                console.log(response);
                console.log('enviado');
            }
        })

    }



    setup_modal_events();
    fetch_employees();
});