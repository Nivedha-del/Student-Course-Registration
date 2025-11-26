// assets/js/profile.js
console.log("Profile JS loaded!");

$(function () {
  // 1) Read user_id from URL: profile.html?user_id=2
  const params = new URLSearchParams(window.location.search);
  const user_id = params.get("user_id");

  if (!user_id) {
    alert("No user information. Please login again.");
    window.location.href = "login.html";
    return;
  }

  // 2) LOAD data from MySQL via profile.php
  $.post(
    "../assets/php/profile.php",
    { action: "load", user_id: user_id },
    function (res) {
      console.log("Load response:", res);
      if (res.success && res.data) {
        const d = res.data;
        $("#full_name").val(d.full_name);
        $("#email").val(d.email);
        $("#age").val(d.age);
        $("#dob").val(d.dob);
        $("#contact").val(d.contact);

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
        console.log("Load failed:", res.message);
      }
    },
    "json"
  );

  // 3) UPDATE PROFILE
  $("#profileForm").on("submit", function (e) {
    e.preventDefault();

    $.post(
      "../assets/php/profile.php",
      {
        action: "update_profile",
        user_id: user_id,
        full_name: $("#full_name").val(),
        age: $("#age").val(),
        dob: $("#dob").val(),
        contact: $("#contact").val()
      },
      function (res) {
        $("#profileMsg")
          .text(res.message)
          .css("color", res.success ? "green" : "red");
      },
      "json"
    );
  });

  // 4) SAVE COURSES
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
        user_id: user_id,
        courses: courses,
        semester: $("#semester").val()
      },
      function (res) {
        $("#courseMsg")
          .text(res.message)
          .css("color", res.success ? "green" : "red");
      },
      "json"
    );
  });

  // 5) LOGOUT
  $("#logoutBtn").on("click", function () {
    window.location.href = "login.html";
  });
});
