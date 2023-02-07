$('#auth-form').submit(function (e) {
    e.preventDefault();
    let message = $('#message')
    let form = $('#auth-form')
    $.ajax({
        type: "POST",
        url: 'app/auth.php',
        data: $(this).serialize(),
        success: function (response) {
            let jsonData = JSON.parse(response);
            if (jsonData.success === 1) {
                let alert = $('<div>')
                    .addClass('alert alert-success')
                    .text(jsonData.message)
                message.html(alert)
                form.html('');
            } else {
                let list = $('<div>')
                    .addClass('alert alert-danger')
                jsonData.errors.forEach((error) => {
                    $('<li/>')
                        .text(error)
                        .appendTo(list);
                })
                message.html(list)
            }
        },
        error: function () {
            message.html('<div class="alert alert-danger">Error Sending<div>')
        }
    });
});

$(function() {
    $("form[name='registration']").validate({
        rules: {
            name: "required",
            surname: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            },
            passwordConfirmation: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            name: "Please enter your name",
            surname: "Please enter your surname",
            password: {
                required: "Please provide a password",
            },
            passwordConfirmation: {
                required: "Please provide a password confirmation",
                equalTo: "Password should match"
            },
            email: "Please enter a valid email address"
        },
    });
});