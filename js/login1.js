$(document).ready(function () {
  $error = $(
    '<center><h2 class = "text-danger bg-danger">Please Register first !<h2></center>'
  );
  $error1 = $(
    '<center><h2 class = "text-danger">Please fill up the field<h2></center>'
  );
  $("#login1").click(function () {
    $error.remove();
    $error1.remove();
    $faculty = $("#faculty").val();
    if ($faculty == "") {
      $error1.appendTo("#error");
    } else {
      $.post("check1.php", { faculty: $faculty }, function (show) {
        if (show == "Success") {
          $.ajax({
            type: "POST",
            url: "login1.php",
            data: {
              faculty: $faculty,
            },
            success: function (result) {
              $result = $(
                '<h2 class = "text-warning">You have been login:</h2>' + result
              ).appendTo("#result");
              $("#faculty").val("");
              setTimeout(function () {
                $result.remove();
              }, 1000);
            },
          });
        } else {
          $("#faculty").val("");
          $error.appendTo("#error");
        }
      });
    }
  });
});
