var checkArr = ["credit", "debit", "upi"];
var checknum = [];
var imgArr = [];
$(document).ready(function () {
    $(".cardDetails").change(function () {
        if ($(this).is(":checked")) {
            let className = $(this)[0].value;
            console.log(checkArr.indexOf(className));
            checknum.push(className);
            $("." + className).removeClass("none");
        } else if (!$(this).checked) {
            let className = $(this)[0].value;
            console.log(typeof (className));
            if (checknum.includes(className)) {
                let i = checknum.indexOf(className);
                console.log(i);
                checknum.splice(i, 1);
                console.log(checknum);
            }
            $("." + className).addClass("none");
        }
        console.log(checknum);
    });

    $(":input").focus(function () {
        $(this).addClass("focus-input");
    })

    $(":input").focusout(function () {
        $(this).removeClass("focus-input");
    })

    $("#image").change(function () {
        let len = this.files.length;
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
        console.log(countryname);
        $.ajax({
            method: "POST",
            url: "../getstate.php",
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
            console.log(password);
            console.log(cnfpassword);
            $("#cnfpasswordError").html("Please enter the same password as above");
        } else {
            $("#cnfpasswordError").html("");
        }
    })
    // form validation
    // $("#form").validate({
    //     rules: {
    //         name: {
    //             required: true,
    //             minlength: 2
    //         },
    //         phone: {
    //             required: true,
    //             number: true,
    //             minlength: 6
    //         },
    //         email: {
    //             required: true,
    //             email: true,
    //             minlength: 6
    //         },
    //         password: {
    //             required: true,
    //             minlength: 8
    //         },
    //         cnfpassword: {
    //             required: true,
    //             minlength: 8,
    //             equalTo: "#password"
    //         },
    //         gender: {
    //             required: true
    //         },
    //         img: {
    //             required: true,
    //             accept: "jpg|jpeg|png|gif"
    //         },
    //         payment: {
    //             required: true
    //         },
    //         country: {
    //             required: true
    //         },
    //         state: {
    //             required: true
    //         },
    //         cname: {
    //             required: true
    //         }
    //     },
    //     messages: {
    //         name: {
    //             required: "Please enter your name",
    //             minlength: "Your name must consist of at least 2 characters",

    //         },
    //         phone: {
    //             required: "Please enter your phone number",
    //             number: "Please enter valid phone number",
    //             minlength: "Your phone number must consist of at least 6 characters",
    //         },
    //         email: {
    //             required: "Please enter your email",
    //             email: "Please enter valid email",
    //             minlength: "Your email must consist of at least 6 characters",
    //         },
    //         password: {
    //             required: "Please enter your password",
    //             minlength: "Your password must consist of at least 8 characters"
    //         },
    //         cnfpassword: {
    //             required: "Please enter your password",
    //             minlength: "Your password must consist of at least 8 characters",
    //             equalTo: "Please enter the same password as above"
    //         },
    //         gender: {
    //             required: "Please select your gender"
    //         },
    //         img: {
    //             required: "Please select your image",
    //             accept: "Please select valid image"
    //         },
    //         payment: {
    //             required: "Please select your payment method"
    //         },
    //         country: {
    //             required: "Please select your country"
    //         },
    //         state: {
    //             required: "Please select your state"
    //         },
    //         cname: {
    //             required: "Please enter your cname",
    //             errorLabelContainer: '.error-validate'

    //         }
    //     },

    //     // errorPlacement: function (error, element) {
    //     //     console.log("here");
    //     //     if (element.attr("name") == "name") {
    //     //         $("#nameError").html(error);
    //     //     } else if (element.attr("name") == "phone") {
    //     //         $("#phoneError").html(error);
    //     //     }
    //     // },

    //     // errorElement : 'span',

    //     submitHandler: function (form) {
    //         form.submit();
    //     }
    // });


})


// $("#form").submit(function (event) {
function checkdata() {

    // event.preventDefault();
    var name = $("#name").val().trim().toLowerCase();
    var phone = $("#phone").val().trim();
    var email = $("#email").val().trim().toLowerCase();
    var password = $("#password").val().trim();
    var gender = $(".gender:checked").val();
    var img = imgArr;
    var payment = checknum;
    var country = $("#country").val();
    var state = $("#state").val();
    console.log(payment.length);
    console.log(img.length);
    if (payment.length < 1) {
        $("#paymentError").html("Please select a payment method");
    }

    if (img.length < 1) {
        $("#imageError").html("Please select images");
    }

    if (gender == null) {
        $("#genderError").html("Please select your gender");
    }

    if (country == null) {
        $("#countryError").html("Please select your country");
    }

    if (state == null) {
        $("#stateError").html("Please select your state");
    }

    let data = {
        name: name,
        phone: phone,
        email: email,
        password: password,
    };

    let globalRegex = {
        rules: {
            name: /^[a-zA-Z\s]{4,}$/,
            phone: /^[0-9]{10}$/,
            email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
            password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
        },
        message: {
            name: 'Enter valid Name (Minimum length should be grater than 4)',
            phone: 'Enter valid Phone Number (Minimum length should be grater than 10)',
            email: 'Enter valid Email (Minimum length should be grater than 6)',
            password: 'Enter valid Password (Should contain at least one special character, number and upper case letters)'
        }
    };

    if (payment.includes("credit")) {
        var cname = $("#cname").val().trim().toLowerCase();
        var cnumber = $("#cnumber").val().trim();
        data.cname = cname;
        data.cnumber = cnumber;
        globalRegex.rules.cname = /^[a-zA-Z\s]{4,}$/;
        globalRegex.rules.cnumber = /^[0-9]{10,}$/;
        globalRegex.message.cname = 'Enter valid Name (Minimum length should be grater than 4)';
        globalRegex.message.cnumber = 'Enter valid Credit card Number (Minimum length should be grater than 10)';
    };
    if (payment.includes("debit")) {
        var dname = $("#dname").val().trim().toLowerCase();
        var dnumber = $("#dnumber").val().trim();
        data.dname = dname;
        data.dnumber = dnumber;
        globalRegex.rules.dname = /^[a-zA-Z\s]{4,}$/;
        globalRegex.rules.dnumber = /^[0-9]{10,}$/;
        globalRegex.message.dname = 'Enter valid Name (Minimum length should be grater than 4)';
        globalRegex.message.dnumber = 'Enter valid Debit card Number (Minimum length should be grater than 10)';
    };
    if (payment.includes("upi")) {
        var uname = $("#uname").val().trim().toLowerCase();
        var uid = $("#uid").val().trim();
        data.uname = uname;
        data.uid = uid;
        globalRegex.rules.uname = /^[a-zA-Z\s]{4,}$/;
        globalRegex.rules.uid = /^[0-9]{10,}$/;
        globalRegex.message.uname = 'Enter valid Name (Minimum length should be grater than 4)';
        globalRegex.message.uid = 'Enter valid Phone Number (Minimum length should be grater than 10)';
    };

    for (attribute in data) {
        console.log(data[attribute]);
        if (!data[attribute].match(globalRegex.rules[attribute])) {
            $("#" + attribute + "Error").html(globalRegex.message[attribute]);
        }
    }

    // form.submit;
    // form.reset();

}
