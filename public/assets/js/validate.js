const password_input = document.querySelector("#password_input");
const login_password_input = document.querySelector("#login_password_input");
const password_input2 = document.querySelector("#Confirmpassword");
const password_eye = document.querySelector("#password_eye");
const login_password_eye = document.querySelector("#login_password_eye");
const confirmPasswordeye = document.querySelector("#cpassword_eye");
let loweruppercase = document.querySelector(".loweruppercase div");

let numbercase = document.querySelector(".numbercase div");
let specialcase = document.querySelector(".specialcase div");
let numcharacter = document.querySelector(".numcharacter div");
const ValidateEmailFilter = (/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
const emailBlockReg = /^([\w-\.]+@(?!uk.com)(?!sail.com)([\w-]+\.)+[\w-]{2,4})?$/;

function passStrength(pass){

    if(pass.length>7){

        numcharacter.classList.add("icon_valid");
        numcharacter.classList.remove("icon_invalid");
    }else{

        numcharacter.classList.remove("icon_valid");
        numcharacter.classList.add("icon_invalid");
    }
    if(pass.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)){
        loweruppercase.classList.add("icon_valid");
        loweruppercase.classList.remove("icon_invalid");
    }else{
        loweruppercase.classList.remove("icon_valid");
        loweruppercase.classList.add("icon_invalid");
    }
    if(pass.match(".*\\d.*")){
        numbercase.classList.add("icon_valid");
        numbercase.classList.remove("icon_invalid");
    } else {
        numbercase.classList.remove("icon_valid");
        numbercase.classList.add("icon_invalid");
    }
    if(pass.match(/[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/)){

        specialcase.classList.add("icon_valid");
        specialcase.classList.remove("icon_invalid");
    }else{
        specialcase.classList.remove("icon_valid");
        specialcase.classList.add("icon_invalid");
    }
}
    
var password = document.getElementById('password_input');
let random_password = document.querySelector('#random_password');
var passwordLength = 14;
var passwordVal = "";

window.onload = function loadPassword() {

    let randomGenerateChars = "B&vp3hSMQQsu#sR2+mTJx6kf6kHhHk^nNceWW_$=tEG#";

    for (var i = 0; i < passwordLength; i++) {
        let randomNumber = Math.floor(Math.random() * randomGenerateChars.length);
        passwordVal += randomGenerateChars.substring(randomNumber, randomNumber + 1);
    }

}; 


$(document).ready(function () {
    $('.alert__close').click(function (e) {
        $('.base_error_msg_container').hide();
    });
    $('.base_error_msg_container').hide();
    $(".loader").hide();
    $('#password_eye').click(function (e) {
        if (password_input.type == "password") {
            password_input.type = "text";
            password_eye.classList.add("fa-eye");
            password_eye.classList.remove("fa-eye-slash");
        } else if (password_input.type == "text") {
            password_input.type = "password";
            password_eye.classList.add("fa-eye-slash");
            password_eye.classList.remove("fa-eye");
        }
    });
    $('#login_password_eye').click(function (e) {
        if (login_password_input.type == "password") {
            login_password_input.type = "text";
            login_password_eye.classList.add("fa-eye");
            login_password_eye.classList.remove("fa-eye-slash");
        } else if (login_password_input.type == "text") {
            login_password_input.type = "password";
            login_password_eye.classList.add("fa-eye-slash");
            login_password_eye.classList.remove("fa-eye");
        }
    });
    $('#cpassword_eye').click(function (e) {
        if (password_input2.type == "password") {
            password_input2.type = "text";
            confirmPasswordeye.classList.add("fa-eye");
            confirmPasswordeye.classList.remove("fa-eye-slash");
        } else if (password_input2.type == "text") {
            password_input2.type = "password";
            confirmPasswordeye.classList.add("fa-eye-slash");
            confirmPasswordeye.classList.remove("fa-eye");
        }
    });
    $("#password_input").keyup(function () {
        let pass = document.getElementById("password_input").value;
        let pass2 = document.getElementById("Confirmpassword").value;
        $(".pmsg").hide();
        if (pass2 != "" || pass2 != null) {
            if (pass != pass2) {
                document.getElementById("registerButton").setAttribute("disabled", "disabled");
                document.getElementById("registerButton").classList.remove('active');
                document.getElementById("registerButton").classList.add('inactive');
            } else {
                document.getElementById("registerButton").removeAttribute("disabled");
                document.getElementById("registerButton").classList.remove('inactive');
                document.getElementById("registerButton").classList.add('active');
            }
        } else {
            if (pass2 == pass) {
                document.getElementById("registerButton").removeAttribute("disabled");
                document.getElementById("registerButton").classList.remove('inactive');
                document.getElementById("registerButton").classList.add('active');
            } else {
                document.getElementById("registerButton").setAttribute("disabled", "disabled");
                document.getElementById("registerButton").classList.remove('active');
                document.getElementById("registerButton").classList.add('inactive');
            }
        }
        passStrength(pass);
    });
    $("#Confirmpassword").keyup(function () {
        let pass1 = document.getElementById("password_input").value;
        let pass2 = document.getElementById("Confirmpassword").value;
        if (pass1 == "" || pass1 == null) {
            $(".pmsg").fadeIn().text("Please enter new password.*");
            return false;
        } else {
        
            if (pass2 == pass1) {
                document.getElementById("registerButton").removeAttribute("disabled");
                document.getElementById("registerButton").classList.remove('inactive');
                document.getElementById("registerButton").classList.add('active');
            } else {
                document.getElementById("registerButton").setAttribute("disabled", "disabled");
                document.getElementById("registerButton").classList.remove('active');
                document.getElementById("registerButton").classList.add('inactive');
            }
            $(".pmsg").hide();
        }
    });
   
    $('#registerButton').click(function (e) {
        e.preventDefault(0)
        let __name = $("input#fullname").val();
        let __email = $("input#email").val();
        let __dateofbirth = $("input#dbo").val();
        let __usercv= $("input#cv").val();
        let __password = $("input#password_input").val();
        let __confirmpassword = $("input#Confirmpassword").val();
        let __address = $("textarea#address").val();
        if (__name == "") {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please enter your name.*");
            $("input#fullname").focus();
            return false;
        }
        
        if (__email == "") {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please enter your email.*");
            $("input#email").focus();
            return false;
        }else if (__email !="" || __email !=null) {
            if (!ValidateEmailFilter.test(__email)) {
                $('.base_error_msg_container').show();
                $('.alert__message').show().text("Invalid email address..! Please enter a valid email address.*");
                $(".pmsg").hide();
                $("input#email").focus();
                return false;
            }
        }
        if (__dateofbirth == "") {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please enter your date of birth.*");
            $("input#dbo").focus();
            return false;
        }
        var _mobile = $('input#mobile').val()
        if (_mobile =="") {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please enter your telephone/mobile number*");
            $("input#mobile").focus();
            return false;
        }
        let formdata = new FormData();
        let files = $("input#cv")[0].files;
		let extension = __usercv.substr(__usercv.lastIndexOf('.') + 1).toLowerCase();
		let allowedExtensions =  ['doc', 'docx', 'pdf'];
        if (files.length ==0) {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please upload your resume/cv.*");
            $("input#cv").focus();
            return false;
        }else if (allowedExtensions.indexOf(extension) === -1) {
			$('.base_error_msg_container').show();
            $('.alert__message').show().text("Invalid file Format. Only" + allowedExtensions.join(', ') + " are allowed");
            $("input#cv").focus();
			return false;
		}
        if (__password == "") {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please enter your password.*");
            $("input#password_input").focus();
            return false;
        }
        if (__confirmpassword == "") {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please Re-type your password for confirmation.*");
            $("input#Confirmpassword").focus();
            return false;
        }
        if (__password !=__confirmpassword) {
            $(".cmsg").fadeIn().text("Both password are not the same*");
            $("input#Confirmpassword").focus();
            return false;
        }
        if (__address.trim() =="") {
            $('.base_error_msg_container').show();
            $('.alert__message').show().text("Please enter your address*");
            $("textarea#address").focus();
            return false;
        }
        formdata.append('name',__name);
        formdata.append('email', __email);
        formdata.append('mobile', _mobile);
        formdata.append('dbo',__dateofbirth);
        formdata.append('password',__password);
        formdata.append('confirmpassword',__confirmpassword);
        formdata.append('address',__address);
        formdata.append('file',files[0]);    
        
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            data: formdata, // our data object
            url: root_base+'AuthController/register',
            cache: false,
            dataType: 'text',
            contentType: false,
            processData: false,
        }).then((response) => {
            var rep = JSON.parse(response)
            if (rep.status == 200) {
                $('.base_error_msg_container').hide();
                $('.alert__message').empty()
                setTimeout(function () {
                    window.location.replace(root_base+'auth/login');
                }, 0);
            } else {
                $('.alert__message').empty()
                $('.base_error_msg_container').show();
                $('.alert__message').show().text(rep.message);
                $("input#email").focus();
            }
        }).fail((xhr, error) => {
            var catch_error = xhr.responseText
            var errormessage = JSON.parse(catch_error).message
            $('.alert__message').empty()
            if (xhr.status == 405) {
                $('.base_error_msg_container').show();
                $('.alert__message').show().text(errormessage);
                $("input#email").focus();
                return false;
            }
        });
    });

    $('#loginButton').click(function (e) {
        e.preventDefault(0)
        $('.base_error_msg_container').hide();
        let __email = $("input#email").val();
        let __password = $("input#login_password_input").val();
       
        if (__email == "") {
            $(".emsg").fadeIn().text("Please enter your email.*");
            $(".pmsg").hide();
            $("input#email").focus();
            return false;
        } else if (__email !="" || __email !=null) {
            if (!ValidateEmailFilter.test(__email)) {
                $(".emsg").fadeIn().text("Invalid Email Address..! Please Enter A Valid Email Address.*");
                $(".pmsg").hide();
                $("input#email").focus();
                return false;
            }
        }
        if (__password == "") {
            $(".emsg").hide()
            $(".pmsg").fadeIn().text("Please enter your password.*");
            $("input#login_password_input").focus();
            return false;
        }
         
        if (__email !="" || __email !=null && __password !="" && __password !=null) {
            const data = { "email": __email, "password": __password };
            // 
            $(".loader").show();
            $(".text").text("Logging in");
            $(".emsg").hide()
            $(".pmsg").hide()
            // 
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                dataType: 'JSON',
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(data), // our data object
                url: root_base+'AuthController/login',
                processData: false,
                encode: true,
                crossOrigin: true,
                async: true,
                crossDomain: true,
                headers: {'Content-Type': 'application/json', "X-Requested-With": "XMLHttpRequest",},
            }).then((response) => {
                //user is logged in successfully in the back-end
                if (response.status == 200) {
                    setTimeout(function () {
                        window.location.replace(root_base);
                    }, 0);
                } else {
                    $('.emsg').empty();
                    $('.pmsg').hide();
                    $(".loader").hide();
                    $(".text").text("Login");
                    $('.base_error_msg_container').show();
                    $('.alert__message').show().text(response.message);
                    $("input#email").focus();

                    $(".loader").hide();
                    $(".text").text("Login");
                    return false;                    
                }
            }).fail((xhr, error) => {
                var catch_error = xhr.responseJSON
                if (catch_error.status == 409 || catch_error.status == 406 || catch_error.status == 403 || catch_error.status == 405) {
                    $('.emsg').empty();
                    $('.pmsg').hide();
                    $(".loader").hide();
                    $(".text").text("Login");
                    $('.base_error_msg_container').show();
                    $('.alert__message').show().text(catch_error.error);
                    $("input#email").focus();
                    return false;
                } 
            });
        }
    });
});
