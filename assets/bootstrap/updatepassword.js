$(document).ready(function() {
    function removeError() {
        $("#" + $(this)[0].id + "Error").html(" ");
    }
    $("#cnfpassword").keyup(function () {
        var password = $("#password").val().trim();
        var cnfpassword = $("#cnfpassword").val().trim();
        if (password != cnfpassword) {
            $("#cnfpasswordError").html("Please enter the same password as above");
        } else {
            $("#cnfpasswordError").html("");
        }
    })
    $("#cnfpassword").focusin(removeError);
    $("#password").focusin(removeError);
    $("#form").submit(function (event) {
        var validationFailed = false;
        var password = $("#password").val().trim().toLowerCase();
        var password = $("#password").val().trim();
        if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) {
            $("#passwordError").html("Enter valid Password (Should contain at least one special character, number and upper case letters)");
            validationFailed = true;
        }
        if (validationFailed) {
            event.preventDefault();
        }
    })
});

function goBack() {
    window.location.href = "login.php";
}