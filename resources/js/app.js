require('./bootstrap');

$('#report-form').submit(function(event) {
    event.preventDefault();

    $.ajax({
        type: 'POST',
        url: "/report-paste",
        data: $('#report-form').serialize(),
        success: function(response) {
            $('#report-form')[0].reset();
            alert('Жалоба отправлена на модерацию');
        },
        error: function(jqXHR, status, error) {
            console.log(error);
            alert('Произошла ошибка');
        }
    });
});
