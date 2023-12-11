$(document).ready(function() {
    ajaxcsrf();

    $('#btncek').on('click', function() {
        var token = $('#token').val();
        var idUjian = $(this).data('id');
        if (token === '') {
            Swal('Failed', 'Token must be filled', 'error');
        } else {
            var key = $('#id_ujian').data('key');
            $.ajax({
                url: base_url + 'ujian/cektoken/',
                type: 'POST',
                data: {
                    id_ujian: idUjian,
                    token: token
                },
                cache: false,
                success: function(result) {
                    Swal({
                        "type": result.status ? "success" : "error",
                        "title": result.status ? "Successful" : "Failed",
                        "text": result.status ? "True Token" : "Incorrect Token"
                    }).then((data) => {
                        if (result.status) {
                            location.href = base_url + 'ujian/?key=' + key;
                        }
                    });
                }
            });
        }
    });

    var time = $('.countdown');
    if (time.length) {
        countdown(time.data('time'));
    }
});