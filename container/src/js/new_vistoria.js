$(document).ready(function () {
  function submit() {
    let vistoria = {
      apto: $("#name").val(),
    };
    //get session and then create on response
    $.ajax({
      url: "../src/api/pending_issues.php",
      type: "POST",
      data: JSON.stringify({
        request_type: "create_vistoria",
        stmt_data:vistoria
      }),
      headers: {
        "Content-Type": "application/json",
      },
      success: function (response) {
        Swal.fire({
          title: "Sucesso",
          text: "Vistoria Registrada !",
          icon: "success",
        });
      },
      error: function (error) {
        console.log(error);
      },
    });
  }

  $("#submit-btn").on("click", function () {
    submit();
  });
});
