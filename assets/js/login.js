// assets/js/login.js
$(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    const email = $("#email").val().trim();
    const password = $("#password").val();

    $("#loginMsg").removeClass("text-danger text-success").text("");

    $.ajax({
      url: "../assets/php/login.php",
      type: "POST",
      data: { email, password },
      dataType: "json", // tell jQuery that we expect JSON
      success: function (res) {
        console.log("login.php response:", res);

        // if for some reason it still arrives as string, try to parse
        if (typeof res === "string") {
          try {
            res = JSON.parse(res);
          } catch (e) {
            console.error("JSON parse error:", res);
            $("#loginMsg")
              .addClass("text-danger")
              .text("Server error (bad JSON).");
            return;
          }
        }

        if (res.success) {
          // store basic info
          localStorage.setItem("user_id", res.user_id);
          localStorage.setItem("full_name", res.full_name);
          localStorage.setItem("email", res.email);

          // store Redis session token
          if (res.token) {
            localStorage.setItem("session_token", res.token);
          }

          $("#loginMsg")
            .removeClass("text-danger")
            .addClass("text-success")
            .text(res.message || "Login successful");

          setTimeout(function () {
            window.location.href = "profile.html";
          }, 800);
        } else {
          $("#loginMsg")
            .removeClass("text-success")
            .addClass("text-danger")
            .text(res.message || "Login failed");
        }
      },
      error: function () {
        
        $("#loginMsg").removeClass("text-success").addClass("text-danger").text("Server error(AJAX)");
      },
    });
  });
});
