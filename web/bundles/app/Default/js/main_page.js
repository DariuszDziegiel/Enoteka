$(document).ready(function () {

    $("img.lazy").lazyload({
        effect : "fadeIn",
    });


    /*$('.parallax-window.parallax-section-hotel').parallax({
        imageSrc: APP_WEB + 'upload/parallax/parallax_1.jpg'
    });*/

    $('#fullpage').fullpage({
        scrollBar: true,
        //anchors: ['start', 'hotel', 'packages', 'conference'],
        //menu: '#menuSections',
        navigation: true,
        navigationPosition: 'right',
        navigationTooltips: ['Start', 'Hotel', 'Pakiety', 'Konferencje', 'Restauracja', 'Stopka'],
        showActiveTooltip: false,
        autoScrolling: false,
        fitToSection: false,
        afterLoad: function() {
         
        },
        onLeave: function () {
            
        }
    });

    //arena contest images lazy loading

    /**$('.gallery-wrapper').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });*/


    $('.packages-slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
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


    //scroll to content
    $('.img-box-scroll-btn').on('click', function() {
        $('html, body').animate({
            scrollTop: $('.image-box').height() - 10,
        }, 500);
        /**$(window).scrollTo($('#main-content-scroll'), 1500, {
            'offset': {top: 20}
        });**/
    });



});


/** $(window).on('scroll', function () {
    var velocity = 0.5;
    var pos = $(window).scrollTop();
    $('.image-box-pic').each(function() {
        var $element = $(this);
        // subtract some from the height b/c of the padding
        var height = $element.height()-18;
        $(this).css('backgroundPosition', '50% ' + Math.round((height - pos) * velocity) +  'px');
    });
}) **/

