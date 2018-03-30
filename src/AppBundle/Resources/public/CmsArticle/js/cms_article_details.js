$(document).ready(function() {
    
    //arena contest images lazy loading
    $('.gallery-file').lazyload({
        effect : "fadeIn"
    });

    $('.main-container').magnificPopup({
        delegate: 'a.img-gallery',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
    

})