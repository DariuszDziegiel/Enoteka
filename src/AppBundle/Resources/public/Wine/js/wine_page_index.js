//Background modal
var LoaderBg = {
    element: null,
    add: function (element, text) {
        this.element = element;
        $('<div />').addClass('loading-bg-absolute').appendTo(element).show();
        $('<div />').html((typeof text !== 'undefined'? text + '<br />': '') + '<img src="/web/images/loading_circle.gif" />').addClass('loading-bg-modal-absolute').appendTo(element);
    },
    remove: function () {
        $('.loading-bg-absolute').remove();
        $('.loading-bg-modal-absolute').remove();
    }
};

//Wine Filter
var WineFilter = {
    filter: function () {
        LoaderBg.add($('body'), '<b>TRWA FILTROWANIE</b>');
        $('.remove-filter-btn-wrapper').fadeIn();
        $.ajax({
            method: 'POST',
            url: Routing.generate('wine_page_filter'),
            dataType: 'html',
            data: $('#wine-filter-form').serialize()
        })
            .done(function(data) {
                $('.wines-container').html(data);
                LoaderBg.remove();
            })
            .fail(function() {
                alert('Błąd filtrowania');
            });
    }
};

$(document).ready(function () {
    var minYear = parseInt($('#year-range-min').val());
    var maxYear = parseInt($('#year-range-max').val());

    //year range slider
    $('#year-range-slider').slider({
        range: true,
        min: minYear,
        max: maxYear,
        values: [minYear, maxYear],
        slide: function(event, ui ) {
            $('#year-range').val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
            $('#year-range-min').val(ui.values[0]);
            $('#year-range-max').val(ui.values[1]);
        },
        change: function (event, ui) {
            WineFilter.filter();
        }
    });

    //init year range values
    $('#year-range').val($("#year-range-slider").slider("values", 0 ) +
        " - " + $("#year-range-slider").slider("values", 1 ) );
    $('#year-range-min').val($('#year-range-slider').slider("values", 0 ));
    $('#year-range-max').val($('#year-range-slider').slider("values", 1 ));


    var minPrice = parseInt($('#price-range-min').val());
    var maxPrice=  parseInt($('#price-range-max').val());

    //price range slider
    $('#price-range-slider').slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        step: 1,
        slide: function( event, ui ) {
            $('#price-range').val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
            $('#price-range-min').val(ui.values[0]);
            $('#price-range-max').val(ui.values[1]);
        },
        change: function (event, ui) {
            WineFilter.filter();
        }
    });

    //init price range values
    $('#price-range').val($("#price-range-slider").slider("values", 0 ) +
        " - " + $("#price-range-slider").slider("values", 1 ) );
    $('#price-range-min').val($('#price-range-slider').slider("values", 0));
    $('#price-range-max').val($('#price-range-slider').slider("values", 1));

    //checkboxes filter
    $('#wine-filter-form input[type="checkbox"]').on('change', function () {
        WineFilter.filter();
    })


    $('body').on('click', '.remove-filter-btn',function () {
        $('#wine-filter-form')[0].reset();
        WineFilter.filter();
        $('.remove-filter-btn-wrapper').fadeOut();
    })


})