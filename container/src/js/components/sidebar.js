$(document).ready(function () {
  let navbar = $("#navbar");
  let open_btn = $("#sidebar__btn");
  let is_mobile = navbar.css("visibility") === "hidden"; //retorna true or false
  let status = false;

  if (is_mobile) {
    open_btn.on("click", function () {
      toggle_nav();
    });

    navbar.css("visibility", "hidden");
    navbar.css("width", "0");
    navbar.css("height", "0")
  }

  function toggle_nav() {
    if (status == true) {
      navbar.css("visibility", "visible");
      navbar.css("width", "100vw");
      navbar.css("height", "100vh")
      status = false;
    } else {
      navbar.css("width", "0");
      navbar.css("height", "0")
      navbar.css("visibility", "hidden");
      

      status = true;
    }
  }
});
