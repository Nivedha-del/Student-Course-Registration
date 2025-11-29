console.log("Profile JS loaded");

$(function () {

  const token = localStorage.getItem("session_token");

  // If no token at all → go back to login
  if (!token) {
    alert("Session expired. Please login again.");
    window.location.href = "login.html";
    return;
  }

  // Helper: handle session errors from PHP
  function handleSessionError(res) {
    if (!res.success && res.message && res.message.toLowerCase().includes("session")) {
      alert(res.message);
      localStorage.removeItem("session_token");
      window.location.href = "login.html";
      return true;
    }
    return false;
  }

  // 1) LOAD PROFILE DATA
  $.post(
    "../assets/php/profile.php",
    { action: "load", token: token },
    function (res) {
      try {
        if (typeof res === "string") res = JSON.parse(res);
      } catch (e) {
        console.error("Parse error (load)", e, res);
        alert("Server error while loading profile.");
        return;
      }

      if (handleSessionError(res)) return;

      if (res.success && res.data) {
        const d = res.data;

        $("#full_name").val(d.full_name || "");
        $("#email").val(d.email || "");
        $("#age").val(d.age || "");
        $("#dob").val(d.dob || "");
        $("#contact").val(d.contact || "");

        if (d.courses) {
          try {
            const selected = JSON.parse(d.courses);
            selected.forEach(function (c) {
              $("input[name='courses'][value='" + c + "']").prop("checked", true);
            });
          } catch (e) {
            console.log("Cannot parse courses", e);
          }
        }

        if (d.semester) {
          $("#semester").val(d.semester);
        }
      } else {
        alert(res.message || "Failed to load profile");
      }
    },
    "json"
  );

  // 2) UPDATE PROFILE
  $("#profileForm").on("submit", function (e) {
    e.preventDefault();

    $.post(
      "../assets/php/profile.php",
      {
        action: "update_profile",
        token: token,
        full_name: $("#full_name").val(),
        age: $("#age").val(),
        dob: $("#dob").val(),
        contact: $("#contact").val()
      },
      function (res) {
        try {
          if (typeof res === "string") res = JSON.parse(res);
        } catch (e) {
          console.error("Parse error (update_profile)", e, res);
          alert("Server error while updating profile.");
          return;
        }

        if (handleSessionError(res)) return;

        alert(res.message || "Profile updated");
      },
      "json"
    );
  });

  // 3) SAVE COURSES
  $("#courseForm").on("submit", function (e) {
    e.preventDefault();

    const courses = $("input[name='courses']:checked")
      .map(function () {
        return this.value;
      })
      .get();

    $.post(
      "../assets/php/profile.php",
      {
        action: "save_courses",
        token: token,
        courses: courses,
        semester: $("#semester").val()
      },
      function (res) {
        try {
          if (typeof res === "string") res = JSON.parse(res);
        } catch (e) {
          console.error("Parse error (save_courses)", e, res);
          alert("Server error while saving courses.");
          return;
        }

        if (handleSessionError(res)) return;

        alert(res.message || "Courses saved");
      },
      "json"
    );
  });

  // 4) LOGOUT BUTTON (front-end)
  $("#logoutBtn").on("click", function () {
    localStorage.clear();
    window.location.href = "login.html";
  });
});
