$(document).ready(function () {
  const urlParams = new URLSearchParams(window.location.search);
  const qr_path = urlParams.get("path");

  if (qr_path) {
    $.ajax({
      url: "../src/api/list_files.php",
      type: "GET",
      data: { path: qr_path },
      success: function (response) {
        $("#file-explorer").html(response);
        $("#folder__name").html(getDirectoryName(qr_path));
      },
      error: function (jqXHR, textStatus, errorThrown) {
        var errorMessage = "An error occurred while loading the directory.\n\n";
        errorMessage += "Status: " + textStatus + "\n";
        errorMessage += "Error: " + errorThrown + "\n";

        if (jqXHR.responseText) {
          errorMessage += "Response: " + jqXHR.responseText + "\n";
        }

        alert(errorMessage);
      },
    });
  } else {
    $.ajax({
      url: "../src/api/list_files.php",
      type: "GET",
      data: { path: "/projetos" },
      success: function (response) {
        $("#file-explorer").html(response);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        var errorMessage = "An error occurred while loading the directory.\n\n";
        errorMessage += "Status: " + textStatus + "\n";
        errorMessage += "Error: " + errorThrown + "\n";

        if (jqXHR.responseText) {
          errorMessage += "Response: " + jqXHR.responseText + "\n";
        }

        alert(errorMessage);
      },
    });
  }
  $("#close-btn").on("click", function () {
    closePdfView();
  });

  $(document).on("click", ".folder", ".file", function () {
    var path = $(this).data("path");
    var type = $(this).data("type");

    if (type === "folder") {
      $.ajax({
        url: "../src/api/list_files.php",
        type: "GET",
        data: { path: path },
        success: function (response) {
          $("#file-explorer").html(response);
        },
        error: function () {
          alert("An error occurred while loading the directory.");
        },
      });
    } else {
      if (path.toLowerCase().endsWith(".pdf")) {
        // window.location.href = "../../uploads/" + path;
        // $("#pdf_view iframe").attr("src", "../uploads/" + path);
        showPdf("../uploads/" + path);
      } else {
        alert("This file is not a PDF.");
      }
    }
  });

  function showPdf(pdfUrl) {
    var canvas = document.getElementById("pdf-canvas");
    var ctx = canvas.getContext("2d");

    pdfjsLib
      .getDocument(pdfUrl)
      .promise.then(function (pdfDoc) {
        pdfDoc.getPage(1).then(function (page) {
          var viewport = page.getViewport({ scale: 1.5 });
          canvas.width = viewport.width;
          canvas.height = viewport.height;

          var renderContext = {
            canvasContext: ctx,
            viewport: viewport,
          };

          page.render(renderContext).promise.then(function () {
            $("#pdf_view").css("display", "flex");
          });
        });
      })
      .catch(function (error) {
        alert("Error loading PDF: " + error.message);
      });
  }
  function closePdfView() {
    //função chamada diretamente no botão
    $("#pdf_view").css("display", "none");
  }
  function getDirectoryName(path) {
    // Remove a barra final do caminho se existir
    path = path.replace(/\/$/, "");

    // Divide o caminho em segmentos
    const segments = path.split("/");

    // Retorna o último segmento, que é o nome do diretório
    return segments.pop();
  }
});
