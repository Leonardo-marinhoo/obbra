$(document).ready(function () {
  let status_elements = $(".status-toggle");
  function start() {
    setup_events();
  }

  function setup_events() {
    //CONFIG <badges> ELEMENTS
    Array.from(status_elements).forEach((element) => {
      $(element).on("click", function () {
        let vistoria_id = $(element).data("id");
        let vistoria_field = $(element).data("field");
        let vistoria_status = $(element).data("status");

        if (vistoria_status == true) {
          $(element).removeClass("status-ok");
          $(element).addClass("status-pendente");
          $(element).data("status", "0");
          vistoria_status = $(element).data("status"); 
        } else {
          $(element).removeClass("status-pendente");
          $(element).addClass("status-ok");
          $(element).data("status", "1");
          vistoria_status = $(element).data("status");
        }

        update_status(vistoria_status, vistoria_id, vistoria_field);
      });
    });
  }

  function update_status(vistoria_status, vistoria_id, vistoria_field) {
    $.ajax({
      url: "../src/api/pending_issues.php",
      type: "POST",
      data: JSON.stringify({
        request_type: "update_status_vistoria",
        stmt_data: {
          status: vistoria_status,
          id: vistoria_id,
          field: vistoria_field,
        },
      }),
      headers: {
        "Content-Type": "application/json",
      },
      success: function (response) {
        console.log(response);
      },
      error: function (error) {
        console.log(error);
      },
    });
  }
  function delete_pendency(vistoria_id) {
    Swal.fire({
      title: "Deletar Pendência ?",
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: "Sim",
      denyButtonText: `Não`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.ajax({
          url: "../src/api/pending_issues.php",
          type: "POST",
          data: JSON.stringify({
            request_type: "delete_pendency",
            stmt_data: {
              id: vistoria_id,
            },
          }),
          headers: {
            "Content-Type": "application/json",
          },
          success: function (response) {
            Swal.fire("Pendência deletada !", "", "success");
            // Swal.fire(response, "", "success");
          },
          error: function (error) {
            console.log(error);
          },
        });
      } else if (result.isDenied) {
        Swal.fire("Operação Cancelada", "", "info");
      }
    });
  }

  start();
});
