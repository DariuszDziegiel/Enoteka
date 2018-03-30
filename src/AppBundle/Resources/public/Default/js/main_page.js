$(document).ready(function () {

    $('.menu-item').on('shown.bs.dropdown', function () {
        if ($('#video-txt').is(':visible')) {
            $('#video-txt').hide();
        }
    });

    $('.menu-item').on('hidden.bs.dropdown', function () {
        if (!$('#video-txt').is(':visible')) {
            $('#video-txt').show();
        }
    })

    $('[data-toggle="popover"]').popover({
        trigger: 'hover | focus',
        placement: 'top',
        template: 	'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3></div>',
        html: true
    });

    //check if html video is supported
    var isHTML5Video = (typeof(document.createElement('video').canPlayType) != 'undefined') ? true : false;
    if (!isHTML5Video) {
        $('#video-buttons').hide();
    }

    $('#bgvidMuteBtn').on('click', function () {
       var video = document.getElementById('bgvid');
       if (video.muted) {
           video.muted = false;
           video.volume = .2;
           //video.currentTime = 10;
           $(this).addClass('unmute-video');
           $(this).html('<span class="glyphicon glyphicon-volume-off"></span>');
       } else {
           video.muted = true;
           $(this).removeClass('unmute-video');
           $(this).html('<span class="glyphicon glyphicon-volume-up"></span>');
       }
    });

    $('#video-fullscreen-btn').on('click', function () {
        $('#video-txt').fadeToggle();
        $('#main-image-text-box').fadeToggle();
    })

    $('.video-time-button').on('click', function () {
        var video = document.getElementById('bgvid');
        video.currentTime = $(this).data('time');
    });

    var video = document.getElementById('bgvid');
    video.play();
    video.ontimeupdate = function () {
        var currentTime = video.currentTime;
        $('.video-time-button').removeClass('active');
        if (currentTime <= 39) {
            $('#video-button-1').addClass('active');
        }
        if (currentTime > 39 && currentTime <= 75) {
            $('#video-button-2').addClass('active');
        }
        if (currentTime > 75 && currentTime <= 127) {
            $('#video-button-3').addClass('active');
        }
        if (currentTime > 127) {
            $('#video-button-4').addClass('active');
        }
    }

    $("img.lazy").lazyload({
        effect : "fadeIn",
    });

    /**$("#main-image").vegas({
        slides: [
            { src: APP_WEB + "/images/main_slider/wines.jpg",
                video: {
                    src: [
                        APP_WEB + "/video/Enoteka_1.webm",
                        APP_WEB + "/video/Enoteka_1.mp4",
                    ],
                    loop: true,
                    mute: true
                }
            },
        ],
        overlay: true,
        animation: 'kenburns',
    });**/

    /*$('.parallax-window.parallax-section-hotel').parallax({
        imageSrc: APP_WEB + 'upload/parallax/parallax_1.jpg'
    });*/

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
            scrollTop: $('.image-box').height() + 20,
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

/**
$(function() {
    // Find all YouTube videos
    var $allVideos = $("#bgvid"),
    // The element that is fluid width
    $fluidEl = $("body");
    // Figure out and save aspect ratio for each video
    $allVideos.each(function() {
        $(this)
            .data('aspectRatio', this.height / this.width)
            // and remove the hard coded width/height
            .removeAttr('height')
            .removeAttr('width');
    });

    // When the window is resized
    // (You'll probably want to debounce this)
    $(window).resize(function() {
        var newWidth = $fluidEl.width();
        // Resize all videos according to their own aspect ratio
        $allVideos.each(function() {
            var $el = $(this);
            $el
                .width(newWidth)
                .height(newWidth * $el.data('aspectRatio'));
        });
        // Kick off one resize to fix all videos on page load
    }).resize();
});
**/