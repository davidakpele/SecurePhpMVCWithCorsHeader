const isEditData = () => {
    let ClassVal = $("#ClassVal").val();
    let Classname1 = $("#Classname1").val();
    let Classname2 = $("#Classname2").val();
    let CombinedData = $('#CombinedData').val();
    let parent = $("#parent").val();
    let editid = $('#sid').val();
    let data = {
        'id': editid,
        'Parent': parent,
        'ClassVal': ClassVal,
        'Classname1': Classname1,
        'Classname2': Classname2,
        'CombinedData': CombinedData,
    };
    let stringify = JSON.stringify(data);
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        dataType: 'JSON',
        contentType: "application/json; charset=utf-8",
        data: stringify, // our data object
        url: base_url + 'Admin/resetDATA?action=isSaveEdit', // the url where we want to POST
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
        if (response.status == false) {
            $(".invalid1").addClass('has-error');
            $('#ClassVal').focus();
            $('.help-block1').show().html(response.message);
            $(".invalid2").removeClass('has-error');
            $('.help-block2').hide();
            $(".invalid3").removeClass('has-error');
            $('.help-block3').hide();
            $(".invalid4").removeClass('has-error');
            $('.help-block4').hide();
        } else if (response.status == true) {
            $(".invalid").removeClass('has-error');
            $('.help-block').hide();
            $('#ClassVal').val("");
            $('#Classname1').val("");
            $('#Classname2').val("");
            $('#CombinedData').val("");
            Swal({
                "title": "Successful",
                "text": response.message,
                "type": "success"
            });
            setTimeout(() => {
                window.location.reload(true);
            }, 1000);
        } else {
            if (response.status1 == false) {
                $(".invalid1").addClass('has-error');
                $('#ClassVal').focus();
                $('.help-block1').show().html(response.message);
            } else {
                $(".invalid1").removeClass('has-error');
                $('.help-block1').hide();
            }
            if (response.status2 == false) {
                $(".invalid2").addClass('has-error');
                $('#Classname1').focus();
                $('.help-block2').show().html(response.message);
            } else {
                $(".invalid2").removeClass('has-error');
                $('.help-block2').hide();
            }
            if (response.status3 == false) {
                $(".invalid1").addClass('has-error');
                $('#Classname2').focus();
                $('.help-block3').show().html(response.message);
            } else {
                $(".invalid3").removeClass('has-error');
                $('.help-block3').hide();
            }
            if (response.status4 == false) {
                $(".invalid4").addClass('has-error');
                $('#CombinedData').focus();
                $('.help-block4').show().html(response.message);
            } else {
                $(".invalid4").removeClass('has-error');
                $('.help-block4').hide();
            }
            return false;
        }
    }).fail((xhr, error) => {
        Swal({
            "title": "Error",
            "text": response.message,
            "type": "error"
        });
    });
}

const isReset = () => {
    $("#Classname2").hide();
    $(".select_default").show();
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        dataType: 'JSON',
        contentType: "application/json; charset=utf-8",
        data: {class_subject_id:1}, // our data object
        url: base_url + 'Admin/resetDATA?action=get_classes', // the url where we want to POST
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
        $('#ClassVal').empty();
        response = response.data;
        $('#ClassVal').append('<option value="">--Choose--</option>');
         response.forEach(function (CallRecieve) {
             $('#ClassVal').append('<option value="' + CallRecieve.ClassID + '">' + CallRecieve.Title + '</option>')
         });
    }).fail((error) => {
        console.log(error);
    })
}
$(document).ready(function ($) {
    $("#select_default").hide();
     $("#ClassVal").change(function () {
         let ClassVal = $("#ClassVal").val();
         let i = $('#CombinedData').val();
         let Classname1 = $("#Classname1").val();
         let Classname2 = $("#Classname2").val();
         if (ClassVal == "") {
             $("#Classname1").empty();
             $("#Classname1").val('');
         } else {
             $('#Classname1').val('(' + ClassVal + '00L)');
         }
         if (i != "") {
             let c = '(' + ClassVal + '00L)';
             $('#CombinedData').val(c + Classname2);
         }
     });
     $("#Classnamep").change(function () {
         let ClassVal = $("#ClassVal").val();
         let Classname1 = $("#Classname1").val();
         let Classname2 = $("#Classnamep").val();
         if (Classname2 == "") {
             $("#CombinedData").empty();
             $("#CombinedData").val('');
         } else {
             let Classname2 = $("#Classnamep").val();
             $('#CombinedData').val(Classname1 + Classname2);
         }
     });
 });