
$(document).ready(function () {
    
    $('#newsletter-form-wrapper').on('click', '#newsletter-form-save', function (e) {
        e.preventDefault();
        $('.newsletter-loader').html('<img src="' + APP_WEB + 'images/loading_circle.gif">');
        $.ajax({
            method: 'POST',
            url:    $('#newsletter-form').attr('action'),
            dataType: 'json',
            data:     $('#newsletter-form').serialize(),
        })
            .done(function (data) {
                $('#newsletter-form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                $('.newsletter-loader').html('');
                $('#newsletter-form-body, #newsletter-form-save').fadeOut();
            })
            .fail(function (data, textStatus, errorThrown) {
                if (typeof data.responseJSON !== 'undefined') {
                    $('#newsletter-form-body').html(data.responseJSON.form);
                    //$('#newsletter-form-message').html('<div class="alert alert-danger">' + data.responseJSON.message + '</div>');
                    console.log(data.responseJSON);
                } else {
                    alert(errorThrown);
                }
                $('.newsletter-loader').html('');
            })
    });
    
    
})