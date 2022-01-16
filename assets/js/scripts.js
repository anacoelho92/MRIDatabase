function submit($btnSubmit, $formName) {
  $($btnSubmit).on("click", function () {
    var $this = $(this); // submit button selector using ID
    var $caption = $this.html(); // We store the html content of the submit button
    var form = $formName; // defined the #form ID
    var formData = $(form).serializeArray(); // serialize the form into array
    var route = $(form).attr("action"); // get the route using attribute action

    // Ajax config
    $.ajax({
      type: "POST", // we are using POST method to submit the data to the server side
      url: route, // get the route value
      data: formData, // our serialized array data for server side
      beforeSend: function () {
        // We add this before send to disable the button once we submit it so that we prevent the multiple click
        $this.attr("disabled", true).html("Processing...");
      },
      success: function (response) {
        var answer = JSON.parse(response);
        switch (answer.status_response) {
          case "success":
            $this.attr("disabled", false).html($caption);
            Swal.fire({
              icon: "success",
              title: "Good Job!",
              text: answer.message_response,
            });
            resetForm(form);
            break;

          case "error":
            $this.attr("disabled", false).html($caption);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: answer.message_response,
            });
            break;
        }
      },
    });
  });
}
function submitSubject() {
  submit("#btnSubmitSub", "#subjectForm");
}

function submitGroup() {
  submit("#btnSubmitGroup", "#groupForm");
}

function submitProject() {
  submit("#btnSubmitProject", "#projectForm");
}

function submitScanner() {
  submit("#btnSubmitScanner", "#scannerForm");
}

function submitScan() {
  submit("#btnSubmitScan", "#scanForm");
}

function submitScale() {
  submit("#btnSubmitScale", "#scaleForm");
}

function submitBioMeasure() {
  submit("#btnSubmitBioMeasure", "#bioMeasureForm");
}

function resetForm(selector) {
  $(selector)[0].reset();
}

function search() {
  $("#btnSubjectSearch").on("click", function () {
    // var $this = $(this); // submit button selector using ID
    // var $caption = $this.html(); // We store the html content of the submit button
    var form = "#searchSubForm"; // defined the #form ID
    var formData = $(form).serializeArray(); // serialize the form into array
    var route = $(form).attr("action"); // get the route using attribute action

    if (!empty(formData)) {
      // Ajax config
      $.ajax({
        type: "POST", // we are using POST method to submit the data to the server side
        url: route, // get the route value
        data: formData, // our serialized array data for server side

        success: function (data) {
          $("#search_result").html(data);
          $("#search_result").css("display", "block");
        },
      });
    } else {
      $("#search_result").css("display", "none");
    }
  });
}

$(document).ready(function () {
  // General function to submit form
  submit();

  // Specific functions to submit each specific form
  submitSubject();
  submitGroup();
  submitProject();
  submitScanner();
  submitScan();
  submitScale();
  submitBioMeasure();

  // Function to search database
  search();
});
