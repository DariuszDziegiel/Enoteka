//default setting for datepicker
/**$.datepicker.setDefaults({
    dateFormat: 'yy-mm-dd',
    firstDay: 1,
    monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Pazdziernik','Listopad','Grudzień'],
    monthNamesShort: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Pazdziernik','Listopad','Grudzień'],
    dayNames: ['Nd','Pn','Wt','Śr','Cz','Pt','Sb'],
    dayNamesShort: ['Nd','Pn','Wt','Śr','Cz','Pt','Sb'],
    dayNamesMin: ['Nd','Pn','Wt','Śr','Cz','Pt','Sb']
});**/

var MENU = {
    load: function () {
        var pos = $(window).scrollTop();
        if (pos) {
            $('.navbar').addClass('navbar-bg');
            $('.navbar').addClass('navbar-sticky-top');
            $('.page-logo').addClass('page-logo-sticky-top');
        } else {
            $('.navbar').removeClass('navbar-bg');
            $('.navbar').removeClass('navbar-sticky-top');
            $('.page-logo').removeClass('page-logo-sticky-top');
        }
    }
};




$(document).ready(function() {

    //MENU.load();

    $('img.lazy-load').lazyload({
        effect : "fadeIn"
    });

    /**
    $("body").vegas({
        slides: [
            { src: "upload/cms_page_background/marantz.jpg" },
            { src: "upload/cms_page_background/devialet.jpg" },
            { src: "upload/cms_page_background/zestaw.jpg" }
        ],
        delay: 15000,
        overlay: APP_VENDOR + 'vegas/dist/overlays/05.png'
    });
     **/

    
 
    //privacy policy
    $('#privacy-policy-close').click(function() {
        $('#privacy-policy-box').slideUp();
        $.cookie('privacy_policy_close', true , {expires: 365});
    })

    //scroll to page top
    $('#return-to-top').click(function() {
        $(window).scrollTo($('body'), 1500);
    });
    
    /*var knp = new KnpPaginatorAjax();
    knp.init({
        'loadMoreText': 'Load More', //load more text
        'loadingText': 'Loading..', //loading text
        'elementsSelector': '.news-wrapper', //this is where the script will append and search results
        'paginationSelector': 'ul.pagination', //pagination selector
    });*/

    /**
    $('#news').on('click', 'ul.pagination a', function (e) {
        e.preventDefault();
        $(this).append('<img src="' + APP_WEB + 'images/loading_circle.gif">');
        var url = $.url($(this).attr('href'));
        $.ajax({
            type: "GET",
            url: Routing.generate('news_pagination', {page: url.param('page')}),
        })
            .done(function(msg) {
                $('#news-container').html(msg);
                //$('#nees ul.pagination li').removeClass('active');
                //$(this).closest('li').addClass('active');
            });
    })
     **/
    
    
    /*
    $('[data-toggle="popover"]').popover({
        html:       true,
        placement: 'auto',
    });
    */



    //calendars
    /**
    $('#tbArrivalDate').datepicker({
        minDate:0,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#tbDepartureDate" ).datepicker( "option", "minDate", selectedDate );
        },
        beforeShow: function() {
        },
        onSelect: function() {
        }
    });

    $('#tbDepartureDate').datepicker({
        minDate:0,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#tbArrivalDate" ).datepicker( "option", "maxDate", selectedDate );
        }
    });


    $('#date_arrival_addon').on('click', function() {
        $('#tbArrivalDate').datepicker('show');
    })

    $('#date_checkout_addon').on('click', function() {
        $('#tbDepartureDate').datepicker('show');
    })
     **/
    
    setTimeout(function() {
        $('.img-box-txt-fade').fadeIn();
    }, 250);


})


$(window).on('scroll', function () {
   //MENU.load();
});

