$(document).ready(function() {
    function removeError() {
        $("#" + $(this)[0].id + "Error").html(" ");
    }

    $("#email").focusin(removeError);
    $("#password").focusin(removeError);

    $("#form").submit(function (event) {
        var validationFailed = false;
        var email = $("#email").val().trim().toLowerCase();
        var password = $("#password").val().trim();

        if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) {
            $("#passwordError").html("Enter valid Password (Should contain at least one special character, number and upper case letters)");
            validationFailed = true;
        }

        if (!email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/)) {
            $("#emailError").html("Enter valid Email");
            validationFailed = true;
        }

        if (validationFailed) {
            event.preventDefault();
        }
    })
});