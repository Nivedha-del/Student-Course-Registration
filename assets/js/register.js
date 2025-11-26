// assets/js/register.js

$(function () {
  $("#registerForm").on("submit", function (e) {
    e.preventDefault(); // stop normal form submit

    const formData = {
      full_name: $("input[name='full_name']").val(),
      email: $("input[name='email']").val(),
      password: $("input[name='password']").val(),
      confirm_password: $("input[name='confirm_password']").val()
    };

    $("#registerMsg").removeClass().text("Please wait...");

    $.ajax({
      url: "../assets/php/register.php",   // go to PHP file
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (res) {
        if (res.success) {
          $("#registerMsg")
            .addClass("text-success")
            .text(res.message);

          // after success, go to login page
          setTimeout(function () {
            window.location.href = "login.html";
          }, 1500);
        } else {
          $("#registerMsg")
            .addClass("text-danger")
            .text(res.message);
        }
      },
      error: function () {
        $("#registerMsg")
          .addClass("text-danger")
          .text("Server error");
      }
    });
  });
});
