$(document).ready(function () {
    
    //arena contest images lazy loading
    $("img.lazy-load").lazyload({
        effect : "fadeIn"
    });
    
    $('.gallery-preview-images').each(function () {
        $(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery:{
                enabled: true
            }
        });
    });

})