$(document).ready(function () {



    //scroll to content
    $('.img-box-scroll-btn').on('click', function() {
        $('html, body').animate({
            scrollTop: $('.image-box').height() - $('.navbar').height() - 30,
        }, 500);
    });


    
})