$(document).ready(function () {
  let pending_issues = $(".pendencia");
  let pendency_actions = $(".pendency-action");
  function start() {
    setup_events();
  }
  async function new_pendency(params) {

  }

  function setup_events() {
    //CONFIG <select> ELEMENTS
    Array.from(pending_issues.find("select")).forEach((element) => {
      let old_value = $(element).val();
      $(element).on("change", function () {
        let pendency_id = $(element).data("id");
        let new_value = $(element).val();

        $(element).removeClass(old_value);
        $(element).addClass(new_value);
        old_value = new_value;

        if ($(element).data("type") == "status") {
          update_status(new_value, pendency_id);
        } else {
          update_priority(new_value, pendency_id);
        }
      });
    });

    //CONFIG DROPDOWN ELEMENTS (view, edit & delete)
    Array.from(pendency_actions).forEach((action) => {
      let action_type = $(action).data("type");
      let pendency_id = $(action).data("id");

      $(action).on("click", function () {
        switch (action_type) {
          case "delete":
            delete_pendency(pendency_id);
            break;
        }
      });
    });
  }
  function update_priority(new_value, pendency_id) {
    $.ajax({
      url: "../src/api/pending_issues.php",
      type: "POST",
      data: JSON.stringify({
        request_type: "update_priority",
        stmt_data: {
          priority: new_value,
          id: pendency_id,
        },
      }),
      headers: {
        "Content-Type": "application/json",
      },
      success: function (response) {},
      error: function (error) {
        console.log(error);
      },
    });
  }
  function update_status(new_value, pendency_id) {
    $.ajax({
      url: "../src/api/pending_issues.php",
      type: "POST",
      data: JSON.stringify({
        request_type: "update_status",
        stmt_data: {
          status: new_value,
          id: pendency_id,
        },
      }),
      headers: {
        "Content-Type": "application/json",
      },
      success: function (response) {},
      error: function (error) {
        console.log(error);
      },
    });
  }
  function delete_pendency(pendency_id) {
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
              id: pendency_id,
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
