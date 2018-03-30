$(document).ready(function() {

    $('.gallery-preview-images').each(function () {
        $(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery:{
                enabled:true
            }
        });
    });
    
})