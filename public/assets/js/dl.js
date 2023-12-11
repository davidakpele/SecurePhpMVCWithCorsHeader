
 juioDT =(id)=>{
    //set static array
    let boolx = [];
    //push the student id inside our array
    boolx.push(id);
    //nutralize data
    const ConsData = { "DataId": boolx };
    //stringify data
    let data = JSON.stringify(ConsData);
    //asking is sure to proceed delete process
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
        // if yes button is clicked, using then & done promise callback
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
                        Swal('Success', response.message, 'success');
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 500);
                } else {
                    Swal({
                        title: "Failed",
                        text: "Delete Processing Failed..",
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
}