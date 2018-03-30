$(document).ready(function() {

    APP_RESERVATION_BAR.init();


    //scroll to content
    $('.img-box-scroll-btn').on('click', function() {
        $('html, body').animate({
            scrollTop: $('.image-box').height() - $('.navbar').height() - 30,
        }, 500);
    });



    $('.gallery-slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        variableWidth: true,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev"><span class="glyphicon glyphicon-chevron-left"></span></button>',
        nextArrow: '<button type="button" class="slick-next"><span class="glyphicon glyphicon-chevron-right"></span></button>',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    
    
    
})