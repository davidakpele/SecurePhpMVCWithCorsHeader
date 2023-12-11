import auth from './context/validation';


$('document').ready(function () {
    $('#logout_user').click(function (e) {
        var MyAuthObject = new auth();
        e.preventDefault();
        MyAuthObject.logout();
    });

    $('.dlsingle').click(function () {
        // Get the element by its ID
        var inputelement = document.getElementById('spanaction');
        // Get the value of the data-id attribute
        var dataIdValue = inputelement.getAttribute('data-action-id');
        console.log(dataIdValue);
    })
})

 $(document).ready(function() {
    $('#iz').hide();
    $('#chk_all').on('change', function() {
        let inputs = $(".checkboxid");
        var count = 0;
        let boolx = [];
        for (let i = 0; i < inputs.length; i++) {
            let type = inputs[i].getAttribute("type");
            if (type == "checkbox") {
                if (this.checked) {
                    count++;
                    $('#iz').fadeIn();
                    boolx.push(inputs[i].value);
                    inputs[i].checked = true;
                } else {
                    $('#iz').hide();
                    inputs[i].checked = false;
                }
            }
        }
        document.getElementById("deletebadge").innerHTML = count;
        const ConsData = {
            "DataId": boolx
        };
        let data = JSON.stringify(ConsData);
        const element = document.getElementById('delete__Btn')
        element.addEventListener("click", () => {
            Swal.fire({
                title: "Are you sure?",
                text: "Data will be deleted!",
                type: "question",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                background: '#fff',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonText: 'Yes, Delete!',
                // using theN & done promise callback
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        dataType: 'JSON',
                        contentType: "application/json; charset=utf-8",
                        data: data, // our data object
                        url: root_base+'UserController/deleteUser', // the url where we want to POST
                        processData: false,
                        encode: true,
                        crossOrigin: true,
                        async: true,
                        crossDomain: true,
                        headers: {'Content-Type': 'application/json'},
                    }).done((response) => {
                        if (response.status == 200) {
                            Swal.fire('Deleted!', response.message, response.status);
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 300);
                        } else {
                            Swal({
                                title: "Failed",
                                text: "No data selected",
                                type: "error",
                                color: '#716add',
                                background: '#fff',
                                backdrop: `rgba(0,0,123,0.4)`,
                                timer: 2500,
                                });
                        }
                    }).fail((xhr, status, error) => {
                        Swal.fire('Oops...',
                            'Something went wrong with ajax !',
                            'error');
                    });
                } else {
                    return false;
                }
            });
        });
    });

    $('.checkboxid').on('change', function() {
        $('#iz').hide();
        let items = document.querySelectorAll('.checkboxid');
        let StringData = [];
        let count = 0;
        for (var i in items) {
            if (items[i].checked) {
                count++;
            }
        }
        if (count == 1) {
            $('#iz').fadeIn();
            for (var i = 0; i < items.length; i++) {
                if (items[i].checked) {
                    StringData.push(items[i].value);
                    document.getElementById("deletebadge").innerHTML = count;
                }
            }
        } else if (count > 1) {
            $('#iz').fadeIn();
            for (var i = 0; i < items.length; i++) {
                if (items[i].checked) {
                    StringData.push(items[i].value);
                    document.getElementById("deletebadge").innerHTML = count;
                }
            }
        } else {
            $('#iz').hide();
            items[i].checked = false;
        }
        const ConsData = {
            "DataId": StringData
        };
        let data = JSON.stringify(ConsData);
        const element = document.getElementById('delete__Btn')
        element.addEventListener("click", () => {
            Swal.fire({
                title: "Are you sure?",
                text: "Data will be deleted!",
                type: "question",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                background: '#fff',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonText: 'Yes, Delete!',
                // using theN & done promise callback
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        dataType: 'JSON',
                        contentType: "application/json; charset=utf-8",
                        data: data, // our data object
                        url: root_base+'UserController/deleteUser', // the url where we want to POST
                        processData: false,
                        encode: true,
                        crossOrigin: true,
                        async: true,
                        crossDomain: true,
                        headers: {'Content-Type': 'application/json'},
                    }).done((response) => {
                        if (response.status == 200) {
                            Swal.fire('Deleted!', response.message,
                                response.status);
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 300);
                        } else {
                            Swal({
                                title: "Failed",
                                text: "No data selected",
                                type: "error",
                                color: '#716add',
                                background: '#fff',
                                backdrop: `rgba(0,0,123,0.4)`,
                                timer: 2500,
                                });
                        }
                    }).fail((xhr, status, error) => {
                            Swal({
                                title: "Failed",
                                text: "No data selected",
                                type: "error",
                                color: '#716add',
                                background: '#fff',
                                backdrop: `rgba(0,0,123,0.4)`,
                                timer: 2500,
                            });
                    });
                } else {
                    return false;
                }
            });
        });
    });
 });
