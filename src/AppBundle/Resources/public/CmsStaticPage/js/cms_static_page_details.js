
$(document).ready(function () {

 
    //arena contest images lazy loading
    $('.gallery-file').lazyload({
        effect : "fadeIn"
    });

    $('.gallery-files-wrapper').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    /**
    var fixmeTop = $('.fixme').offset().top;       // get initial position of the element
    **/


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





    $('.gallery-slider').imagesLoaded()
        .always( function( instance ) {
            //console.log('all images loaded');
        })
        .done( function( instance ) {
            //console.log('all images successfully loaded');
            $('.loading-images-overlay').fadeOut();
        })
        .fail( function() {
            //console.log('all images loaded, at least one is broken');
            $('.loading-images-overlay').fadeOut();
        })
        .progress( function( instance, image ) {
            //var result = image.isLoaded ? 'loaded' : 'broken';
            //console.log( 'image is ' + result + ' for ' + image.img.src );
        });
    






})



