// assets/js/login.js

$(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault(); // stop normal submit

    const email = $("input[name='email']").val();
    const password = $("input[name='password']").val();

    $("#loginMsg").removeClass().text("Please wait...");

    $.ajax({
      url: "../assets/php/login.php",
      method: "POST",
      data: { email: email, password: password },
      dataType: "json",
      success: function (res) {
        if (res.success) {
          $("#loginMsg").addClass("text-success").text(res.message);

          // 🔴 IMPORTANT: send user_id in URL to profile page
          setTimeout(function () {
            window.location.href =
              "profile.html?user_id=" + encodeURIComponent(res.user_id);
          }, 800);
        } else {
          $("#loginMsg").addClass("text-danger").text(res.message);
        }
      },
      error: function () {
        $("#loginMsg")
          .addClass("text-danger")
          .text("Server error");
      }
    });
  });
});
