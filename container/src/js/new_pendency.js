$(document).ready(function () {
  function start() {
    $("#summernote").summernote({
      placeholder: "Consertar Rejunte da cozinha....",
      tabsize: 2,
      height: 180,
      toolbar: [
        ["style", ["style"]],
        ["font", ["bold", "underline", "clear"]],
        ["color", ["color"]],
        ["para", ["ul", "ol", "paragraph"]],
        ["table", ["table"]],
        ["insert", ["link", "picture", "video"]],
        ["view", ["fullscreen", "codeview", "help"]],
      ],
    });

    $("#submit-btn").on("click", function () {
      submit();
    });
  }
  function submit() {
    let pendencia = {
      subject: $("#name").val(),
      department_id: $("#department").val(),
      obra: $("#obra").val(),
      description: $("#summernote").summernote("code"),
      priority: $('input[name="priority"]:checked').val(),
      status: "Pendente",
      user_id: "",
    };
    //get session and then create on response
    $.ajax({
      url: "../src/api/session.php",
      type: "POST",
      data: JSON.stringify({
        request_type: "get_session",
      }),
      headers: {
        "Content-Type": "application/json",
      },
      success: function (session) {
        let data = JSON.parse(session);
        pendencia.user_id = data["user_id"];

        $.ajax({
          url: "../src/api/pending_issues.php",
          type: "POST",
          data: JSON.stringify({
            request_type: "create_pendency",
            stmt_data: pendencia,
          }),
          headers: {
            "Content-Type": "application/json",
          },
          success: function (response) {
            Swal.fire({
              title: "Sucesso",
              text: "Pendência Registrada !",
              icon: "success",
            });
          },
          error: function (error) {
            console.log(error);
          },
        });
      },
      error: function (error) {
        console.log(error);
      },
    });
  }

  start();
});
