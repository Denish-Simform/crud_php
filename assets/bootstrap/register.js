var checkArr = ["credit", "debit", "upi"];
var checknum = [];
var imgArr = [];
$(document).ready(function () {
    
    var table = $('#mytable').DataTable({
        "language": {
            "emptyTable": "No data available"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "fetchdata.php",
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "phone" },
            { "data": "email" },
            { "data": "gender" },
            {
                "mData": "image",
                "mRender": function (data, type, full) {
                    return "<img src='assets/storedImages/" + data + "' alt='userImage' class='table-image'>";
                }
            },
            { "data": "paymentmethod" },
            { "data": "country" },
            { "data": "state" },
            {
                "mData": "action",
                "mRender": function (data, type, full) {
                    return "<button class='btn-primary me-2 action-btn' id='" + data + "' ><a href='register.php?id=" + data + "'>Update</a></button><button class='btn-danger action-btn' id='" + data + "' onclick='confirmDelete(" + data + ")'>Delete</button>";
                }
            }
        ]
    });

    function removeError() {
        $("#" + $(this)[0].id + "Error").html(" ");
    }

    // update 
    if ($("input.cardDetails:checked")) {
        let className = $("input.cardDetails:checked").val();
        if (className != undefined) {
            checknum.push(className);
        }
        $("." + className).removeClass("none");
    } else if (!$("input.cardDetails:checked")) {
        let className = $(this)[0].value;
        console.log(typeof (className));
        if (checknum.includes(className)) {
            let i = checknum.indexOf(className);
            checknum.splice(i, 1);
        }
        $("." + className).addClass("none");
    }
    $(".cardDetails").value = checknum;

    $(".cardDetails").change(function () {
        $("#paymentError").html(" ");
        if ($(this).is(":checked")) {
            let className = $(this)[0].value;
            checknum.push(className);
            $("." + className).removeClass("none");
            $("." + className).addClass("block");
        } else if (!$(this).checked) {
            let className = $(this)[0].value;
            console.log(typeof (className));
            if (checknum.includes(className)) {
                let i = checknum.indexOf(className);
                checknum.splice(i, 1);
            }
            $("." + className).removeClass("block");
            $("." + className).addClass("none");
        }
        $(".cardDetails").value = checknum;
    });

    $(":input").focus(function () {
        $(this).addClass("focus-input");
    })

    $(":input").focusout(function () {
        $(this).removeClass("focus-input");
    })

    $("#image").change(function () {
        let len = this.files.length;
        $("#" + $(this)[0].id + "Error").html(" ");
        $(".imageContainer").empty();
        for (let i = 0; i < len; i++) {
            let img = "<img src='#' alt='#' id='showimg" + (i + 1) + "' >";
            $(".imageContainer").append(img);
            if (this.files && this.files[i]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#showimg' + (i + 1)).attr('src', e.target.result).addClass("show-im");
                    imgArr.push(e.target.result);
                };

                reader.readAsDataURL(this.files[i]);
            }
        }
    });

    $("#country").change(function () {
        let countryname = $("#country option:selected").val();
        $("#" + $(this)[0].id + "Error").html("");
        $.ajax({
            method: "POST",
            url: "/crud_php/getstate.php",
            datatype: "json",
            data: { data: countryname },
            success: function (data) {
                $("#state").html(data);
            }
        });
    });

    $("#cnfpassword").keyup(function () {
        var password = $("#password").val().trim();
        var cnfpassword = $("#cnfpassword").val().trim();
        if (password != cnfpassword) {
            $("#cnfpasswordError").html("Please enter the same password as above");
        } else {
            $("#cnfpasswordError").html("");
        }
    })

    $("#name").keypress(removeError);
    $("#phone").keyup(removeError);
    $("#email").keyup(removeError);
    $("#password").keyup(removeError);
    $("#state").change(removeError);
    $("#cname").keyup(removeError);
    $("#cnumber").keyup(removeError);
    $("#dname").keyup(removeError);
    $("#dnumber").keyup(removeError);
    $("#uname").keyup(removeError);
    $("#uid").keyup(removeError);
    $(".gender").change(function () {
        $("#genderError").html(" ");
    });
    setTimeout(function () {
        table.destroy();
        table = $('#mytable').DataTable();
    }, 2000);
})


$("#form").submit(function (event) {
    var validationFailed = false;
    var update = $("#update").val();
    var name = $("#name").val().trim().toLowerCase();
    var phone = $("#phone").val();
    var email = $("#email").val().trim().toLowerCase();
    var password = $("#password").val().trim();
    var passwordDisabled = 0;
    if ($("#password").is(":disabled")) {
        passwordDisabled = 1;
    }
    var gender = $(".gender:checked").val();
    var img = imgArr;
    var nonUpdatedImage = 0;
    if ($(".imageContainer").find(".show-im").length > 0) {
        nonUpdatedImage = 1;
    }
    var payment = checknum;
    var country = $("#country").val();
    var state = $("#state").val();
    if (payment.length < 1) {
        $("#paymentError").html("Please select a payment method");
        validationFailed = true;
    }

    if (img.length < 1 && nonUpdatedImage == 0) {
        $("#imageError").html("Please select images");
        validationFailed = true;
    }

    if (gender == null) {
        $("#genderError").html("Please select your gender");
        validationFailed = true;
    }

    if (country == null) {
        $("#countryError").html("Please select your country");
        validationFailed = true;
    }

    if (state == null) {
        $("#stateError").html("Please select your state");
        validationFailed = true;
    }

    if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/) && passwordDisabled == 0) {
        $("#passwordError").html("Enter valid Password (Should contain at least one special character, number and upper case letters)");
        validationFailed = true;
    }
    let data = {
        name: name,
        phone: phone,
        email: email,
    };
    let globalRegex = {
        rules: {
            name: /^[a-zA-Z\s]{4,}$/,
            phone: /^[0-9]{10,}$/,
            email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
        },
        message: {
            name: 'Enter valid Name (Minimum length should be 4)',
            phone: 'Enter valid Phone Number',
            email: 'Enter valid Email (Minimum length should be 6)',
        }
    };
    if (payment.includes("credit")) {
        var cname = $("#cname").val().trim().toLowerCase();
        var cnumber = $("#cnumber").val().trim();
        data.cname = cname;
        data.cnumber = cnumber;
        globalRegex.rules.cname = /^[a-zA-Z\s]{4,}$/;
        globalRegex.rules.cnumber = /^[0-9]{16}$/;
        globalRegex.message.cname = 'Enter valid Name (Minimum length should be grater than 4)';
        globalRegex.message.cnumber = 'Enter valid Credit card Number (Length must be 16)';
    };
    if (payment.includes("debit")) {
        var dname = $("#dname").val().trim().toLowerCase();
        var dnumber = $("#dnumber").val().trim();
        data.dname = dname;
        data.dnumber = dnumber;
        globalRegex.rules.dname = /^[a-zA-Z\s]{4,}$/;
        globalRegex.rules.dnumber = /^[0-9]{16}$/;
        globalRegex.message.dname = 'Enter valid Name (Minimum length should be grater than 4)';
        globalRegex.message.dnumber = 'Enter valid Debit card Number (Length must be 16)';
    };
    if (payment.includes("upi")) {
        var uname = $("#uname").val().trim().toLowerCase();
        var uid = $("#uid").val().trim();
        data.uname = uname;
        data.uid = uid;
        globalRegex.rules.uname = /^[a-zA-Z\s]{4,}$/;
        globalRegex.rules.uid = /^[0-9A-Za-z.-]{2,30}@[a-zA-Z]{2,10}$/;
        globalRegex.message.uname = 'Enter valid Name (Minimum length should be 4)';
        globalRegex.message.uid = 'Enter valid UPI ID';
    };
    for (attribute in data) {
        if (!data[attribute].match(globalRegex.rules[attribute])) {
            $("#" + attribute + "Error").html(globalRegex.message[attribute]);
            validationFailed = true;
        }
    }
    if (validationFailed) {
        event.preventDefault();
        return false;
    }
});

function confirmDelete(id) {
    var result = confirm("Are you sure you want to delete?");
    if (result == true) {
        $.ajax({
            type: "GET",
            url: "/crud_php/action.php",
            data: { "id": id },
            success: function () {
                window.location.reload();
            }
        })
    } else {
        return false;
    }
}

function resetForm() {
    window.location.reload();
}
