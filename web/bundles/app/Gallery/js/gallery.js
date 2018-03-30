$(document).ready(function() {
    
    $("img.lazy").lazyload({
        effect : "fadeIn",
    });

    /*
    $('#fullpage').fullpage({
        afterLoad: function() {
        },
        onLeave: function () {
        }
    });
    */

    $('.gallery-slider').slick({
        centerMode: true,
        dots: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        variableWidth: true,
        adaptiveHeight: true,
        mobileFirst: true,
        prevArrow: '<button type="button" class="slick-prev"><span class="glyphicon glyphicon-chevron-left"></span></button>',
        nextArrow: '<button type="button" class="slick-next"><span class="glyphicon glyphicon-chevron-right"></span></button>',
        responsive: [
            {
                breakpoint: 1170,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });



    $(window).on('resize orientationchange', function() {
        $('.gallery-slider').slick('resize');
    });


    $('.gallery-slider').imagesLoaded()
        .always( function( instance ) {
            console.log('all images loaded');
        })
        .done( function( instance ) {
            //console.log('all images successfully loaded');
            $('.loading-gallery-overlay').fadeOut();
        })
        .fail( function() {
            //console.log('all images loaded, at least one is broken');
            $('.loading-gallery-overlay').fadeOut();
        })
        .progress( function( instance, image ) {
            var result = image.isLoaded ? 'loaded' : 'broken';
            console.log( 'image is ' + result + ' for ' + image.img.src );
        });


})

