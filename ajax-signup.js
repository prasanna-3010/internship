$(document).ready(function () {
    $("#signup-button").click(function () {
        // Serialize form data
        var formData = $("#signup-form").serialize();

        // Send an AJAX POST request to process-signup.php
        $.ajax({
            type: "POST",
            url: "process-signup.php",
            data: formData,
            success: function (response) {
                // Handle the server's response
                if (response === "success") {
                    // Redirect to signup-success.html on success
                    window.location.href = "signup-success.html";
                } else {
                    // Display an error message on failure
                    alert("Error: " + response);
                }
            },
            error: function () {
                // Handle AJAX errors
                alert("AJAX request failed");
            }
        });
    });
});
