$(document).ready(function () {
  const checklist_container = $("#checklist-container");
  let searchParam = new URLSearchParams(window.location.search);
  let context_id = searchParam.get("id");

  if (context_id) {
    fetch_tasks();
  } else {
    fetch_schedules();
  }

  $("#add-schedule").click(function () {
    new_schedule();
  });

  function fetch_schedules() {
    $.ajax({
      url: "../src/api/schedule.php",
      type: "POST",
      data: JSON.stringify({
        action: "fetchSchedule",
      }),
      headers: {
        "Acess-Control-Allow-Methods": "POST, GET",
        "Content-Type": "application/json",
      },
      success: function (response) {
        // console.log(response);
        create_schedule_element(response);
      },
      error: function (error) {
        console.log(error);
      },
    });
  }
  function create_schedule_element(json_data) {
    let data = JSON.parse(json_data);
    console.log(data);
    data.forEach((element) => {
      if (element.status === null) {
        element.status = "Em Progresso";
      }
      let tableElement = document.createElement("div");
      tableElement.classList.add("schedule");
      tableElement.innerHTML = `
                <div class="schedule-border"></div>
                <div class="schedule-container">
                    <div class="schedule-info">
                      <a href="?id=${element.id}">${element.schedule_name}</a>
                    </div>
                    <div class="schedule-progress">
                      <div class="progress" data-schedule_id="${element.id}"></div>
                    </div>
                    <div class="schedule-icon">
                      <i class="fi fi-ss-angle-right"></i>
                    </div>
                </div>
                `;
      $(tableElement).on("click", function () {
        window.location.href = `?id=${element.id}`;
      });
      $(checklist_container).append(tableElement);
    });

    set_progress();
    // $(checklist_container).DataTable();
  }
  function set_progress() {
    let progress_bars = $(".progress");

    Array.from(progress_bars).forEach((bar) => {
      let schedule_id = bar.getAttribute("data-schedule_id");
      $.ajax({
        url: "../src/api/schedule.php",
        type: "POST",
        data: JSON.stringify({
          action: "fetchChildTask",
          stmt_data: {
            schedule_id: schedule_id,
          },
        }),
        headers: {
          "Acess-Control-Allow-Methods": "POST, GET",
          "Content-Type": "application/json",
        },
        success: function (response) {
          let data = JSON.parse(response);
          if (data.length >= 1) {
            let total_tasks = data.length;
            let finished_tasks = 0;
            let progress;
            data.forEach((task) => {
              if (task.status === "checked") {
                finished_tasks++;
              }
            });
            progress = ((finished_tasks / total_tasks) * 100).toFixed(2);

            var progressbar = new ProgressBar.Circle(bar, {
              color: "#red",
              // This has to be the same size as the maximum width to
              // prevent clipping
              strokeWidth: 11,
              trailWidth: 11,
              easing: "easeInOut",
              duration: 1400,
              text: {
                autoStyleContainer: true,
              },
              from: { color: "#e84427", width: 11 },
              to: { color: "#32a852", width: 11 },
              // Set default step function for all animate calls
              step: function (state, circle) {
                circle.path.setAttribute("stroke", state.color);
                circle.path.setAttribute("stroke-width", state.width);

                var value = Math.round(circle.value() * 100);
                if (value === 0) {
                  circle.setText("");
                } else {
                  circle.setText(value);
                }
              },
            });
            if (progress > 0) {
              progressbar.animate(progress / 100);
            } else {
              // progressbar.animate(0.01);
              // bar.innerHTML = "<div class='red-square'></div>";
            }
          } else {
            bar.innerHTML = `
                        <div class="progress">
                            <div class="progress-bar" style="width:0%;"></div>
                        </div>
                        <small class="progress-percentage" >0%</small>`;
          }
        },
        error: function (error) {
          // console.log('');
        },
      });
    });
    // let dtable = new DataTable("#cronogramas", {
    //     lengthMenu: [4, 8, 16, 32, 64, 128],
    //     language: {
    //         info: 'Mostrando página _PAGE_ de _PAGES_',
    //         infoEmpty: 'Nenhum Cronograma Disponível.',
    //         infoFiltered: '(filtered from _MAX_ total records)',
    //         lengthMenu: 'Ver _MENU_ Cronogramas por página.',
    //         zeroRecords: 'Nada Encontrado.',
    //         search: 'Pesquisar',
    //         paginate: {
    //             "first": "Primeiro",
    //             "last": "Ultimo",
    //             "next": "Próximo",
    //             "previous": "Anterior"
    //         },
    //     },
    //     order:[[0,'desc']]
    // });
  }
  function fetch_tasks() {
    $.ajax({
      url: "../src/api/schedule.php",
      type: "POST",
      data: JSON.stringify({
        action: "fetchChildTask",
        stmt_data: {
          schedule_id: context_id,
        },
      }),
      headers: {
        "Acess-Control-Allow-Methods": "POST, GET",
        "Content-Type": "application/json",
      },
      success: function (response) {
        // console.log(response);
        create_task_element(response);
      },
      error: function (error) {
        console.log(error);
      },
    });
  }
  function create_task_element(json_data) {
    //CRIAR CONDIÇÃO PARA VERIFICAR SE DATATABLE JA FOI INICIADA E LIMPAR checklist_container QUANDO ADD TASK
    clear_container();
    let data = JSON.parse(json_data);

    data.forEach((element) => {
      let tableElement = document.createElement("div");
      tableElement.classList.add("task");
      tableElement.innerHTML = `
        <div  class='task-info'>
          <span>${element.task_name}</span>
        </div>
        <div class="task-actions">
          <input class="checkbox" data-task_id="${element.id}" ${element.status} type="checkbox">
        </div>
        `;
      checklist_container.append(tableElement);
    });
    //configurar os selects para atualizar a tabela quando o valor mudar
    let checkbox = $(".checkbox");
    Array.from(checkbox).forEach((input) => {
      input.addEventListener("change", () => {
        update_task_status(input);
      });
    });
  }
  function update_task_status(element) {
    let task_status;
    if (element.checked === true) {
      task_status = "checked";
    } else {
      task_status = "pendente";
    }
    let task_id = element.getAttribute("data-task_id");
    $.ajax({
      url: "../src/api/schedule.php",
      type: "POST",
      data: JSON.stringify({
        action: "update_task_status",
        stmt_data: {
          id: task_id,
          status: task_status,
        },
      }),
      headers: {
        "Acess-Control-Allow-Methods": "POST, GET",
        "Content-Type": "application/json",
      },
      success: function (response) {},
      error: function (error) {
        console.log(error);
      },
    });
  }

  function new_schedule() {
    let modal = $("#schedule_modal");
    let input_field = {
      schedule_name: $("#new-schedule-name").val(),
      schedule_description: $("#new-schedule-description").val(),
      start_date: $("#new-schedule-start-date").val(),
      end_date: "",
      status: "Em Progresso",
      manager_id: "",
      members_id: "",
    };

    $.ajax({
      url: "../src/api/schedule.php",
      type: "POST",
      data: JSON.stringify({
        action: "createSchedule",
        stmt_data: {
          schedule_name: input_field.schedule_name,
          description: input_field.schedule_description,
          start_date: input_field.start_date,
          end_date: input_field.end_date,
          status: input_field.status,
          manager_id: input_field.manager_id,
          members_id: input_field.members_id,
        },
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
      },
    });

    modal.modal("hide");
  }
  function clear_container() {
    checklist_container.html("");
  }
});
