import auth from './context/validation';

$(document).ready(($) => {
    //hide messages 
    $(".statusMsg").hide();
    //on submit
    $('#user_info').submit(function(e) {
        e.preventDefault();
        let id = $('#id').val();
        let name = $('#name').val();
        let mobile = $('#mobile').val();
        let dob = $('#dob').val();
        let email = $('#email').val();
        let address = $('#address').val();
       
        if (name == "") {
            $(".statusMsg").fadeIn().html("<span style='margin-left:30px'>&nbsp;&nbsp; Enter your name.</span> ");
            $("#name").focus()
            return false;
        }
        if (mobile == "") {
            $(".statusMsg").fadeIn().html("<span style='margin-left:30px'>&nbsp;&nbsp; Enter your telephone/mobile number.</span> ");
            $("#mobile").focus()
            return false;
        }
        if (dob == "") {
            $(".statusMsg").fadeIn().html("<span style='margin-left:30px'>&nbsp;&nbsp; Enter your date of birth.</span> ");
            $("#dob").focus()
            return false;
        }
        if (address == "") {
            $(".statusMsg").fadeIn().html("<span style='margin-left:30px'>&nbsp;&nbsp; Enter your address.</span> ");
            $("#address").focus()
            return false;
        }
        const data = { "id": id, "name": name, "mobile": mobile, "dob": dob, "email": email, "address":address };
    
        let btn = $('#btn-info');
        btn.attr('disabled', 'disabled').text('Process...');
        
        $.ajax({
            type: 'POST',// define the type of HTTP verb we want to use (POST for our form)
            dataType: 'JSON',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(data),// our data object
            url: root_base+'UserController/updateUser',// the url where we want to POST
            processData: false,
            encode: true,
            crossOrigin: true,
            async: true,
            crossDomain: true,
            headers: {
                'Access-Control-Allow-Methods': '*',
                "Access-Control-Allow-Credentials": true,
                "Access-Control-Allow-Headers": "Access-Control-Allow-Headers, Origin, X-Requested-With, Content-Type, Accept, Authorization",
                "Access-Control-Allow-Origin": "*",
                "Control-Allow-Origin": "*",
                "cache-control": "no-cache",
                'Content-Type': 'application/json'
            },
        }).then((response) => {
            if (response.status) {
                 Swal({
                    "title": "Successful",
                    "text": response.mesg,
                    "type": "success"
                 });
              btn.attr('disabled', 'disabled').text('Change info');
              //btn.removeAttr('disabled', 'disabled').text('Change Password');
            } else {
                Swal({
                    "title": "Failed",
                    "text": response.error,
                    "type": "error"
                });
            }
        }).fail((xhr, error) => {
            $("#errorMessage").fadeIn().text('Oops...Server is down! error');
        });
    });

 
    //userlevel
    $('#isUpdataPassword').submit(function (e) {
        e.preventDefault();
        let id = $('#id').val();
        let old = $('#old').val();
        let newpass = $('#new').val();
        let confirm = $('#new_confirm').val();
         const data = {
            "id": id,
            "old": old,
            "new": newpass,
            "confirmpassword":confirm
         };
         let c_i = JSON.stringify(data);
         let btn = $('#btn-pass');

         $.ajax({
             type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
             dataType: 'JSON',
             contentType: "application/json; charset=utf-8",
             data: c_i, // our data object
             url: root_base + 'UserController/changepass', // the url where we want to POST
             processData: false,
             encode: true,
             crossOrigin: true,
             async: true,
             crossDomain: true,
             headers: {'Content-Type': 'application/json'}, 
         }).then((response) => {
             if (response.status == true) {
                 $(".oji1").removeClass('has-error');
                 $('.help-block1').hide();
                 $(".oji2").removeClass('has-error');
                 $('.help-block2').hide();
                 $(".oji3").removeClass('has-error');
                 $('.help-block3').hide();
                 $('#old').val('');
                 $('#new').val('');
                 $('#new_confirm').val('');
                 Swal({
                     "title": "Successful",
                     "text": response.message,
                     "type": "success"
                 });
                 btn.attr('disabled', 'disabled').text('Process...');
                 btn.attr('disabled', 'disabled').text('Updated');
                 //btn.removeAttr('disabled', 'disabled').text('Updated');
             } else {
                if (response.status2 == false) {
                    $(".oji1").addClass('has-error');
                    $('.help-block1').show().html(response.message);
                } else {
                    $(".oji1").removeClass('has-error');
                    $('.help-block1').hide();
                }
                 if (response.status3 == false) {
                    $(".oji2").addClass('has-error');
                    $('.help-block2').show().html(response.message);
                } else {
                    $(".oji2").removeClass('has-error');
                    $('.help-block2').hide();
                }
                if (response.status4 == false) {
                    $(".oji3").addClass('has-error');
                    $('.help-block3').show().html(response.message);
                 } else {
                    $(".oji3").removeClass('has-error');
                    $('.help-block3').hide();
                 }
                 return false;
             }
         }).fail((xhr, error) => {
             $("#errorMessage").fadeIn().text('Oops...Server is down! error');
         });
        
    });
    //userlevel
    $('#user_level').submit(function(e) {
        e.preventDefault();
          let id = $('#id').val();
          let level = $('#level').val();
          let username = $('#level option:selected').attr('data-username');
        if (id == "") {
            $(".statusMsg").fadeIn().html("<span style='margin-left:30px'>&nbsp;&nbsp; Please Provide The User ID Number.</span> ");
            $("#id").focus()
            return false;
        }
        if (level == "") {
            $(".statusMsg").fadeIn().html("<span style='margin-left:30px'>&nbsp;&nbsp; Please Select The User Level.</span> ");
            $("#level").focus()
            return false;
        }
        const data = { "id": id, "role":level, "username":username};
        let RouteUserDateToPhp = JSON.stringify(data);
        console.log(data);
        let btn = $('#btn-level');
        btn.attr('disabled', 'disabled').text('Process...');
        
        $.ajax({
            type: 'POST',// define the type of HTTP verb we want to use (POST for our form)
            dataType: 'JSON',
            contentType: "application/json; charset=utf-8",
            data: RouteUserDateToPhp,// our data object
            url: root_base+'edituserlevel',// the url where we want to POST
            processData: false,
            encode: true,
            crossOrigin: true,
            async: true,
            crossDomain: true,
            headers: {'Content-Type': 'application/json'},
        }).then((response) => {
            if (response.status) {
                 Swal({
                    "title": "Successful",
                    "text": response.mesg,
                    "type": "success"
                 });
              btn.attr('disabled', 'disabled').text('Change info');
              //btn.removeAttr('disabled', 'disabled').text('Change Password');
            } else {
                Swal({
                    "title": "Failed",
                    "text": response.error,
                    "type": "error"
                });
            }
        }).fail((xhr, error) => {
            $("#errorMessage").fadeIn().text('Oops...Server is down! error');
        });
    });


    $('#logout_user').click(function (e) {
        var MyAuthObject = new auth();
        e.preventDefault();
        MyAuthObject.logout();
    });

});