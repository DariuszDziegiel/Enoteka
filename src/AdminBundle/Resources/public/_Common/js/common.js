
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
}

// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};


$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip({
        html: true
    });
    
    //default setting for datepicker
    $.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Pazdziernik','Listopad','Grudzień'],
        monthNamesShort: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Pazdziernik','Listopad','Grudzień'],
        dayNames: ['Nd','Pn','Wt','Sr','Cz','Pt','Sb'],
        dayNamesShort: ['Nd','Pn','Wt','Sr','Cz','Pt','Sb'],
        dayNamesMin: ['Nd','Pn','Wt','Sr','Cz','Pt','Sb']
    });

    /*$('.dateFuture').datepicker({
        minDate:0,
        numberOfMonths: 3
     });*/

    $('.date').datepicker({
        numberOfMonths: 3
    });

    //Select the last edited language
    var a2lixLocaleTabSelected = $.cookie('a2lix-locale-tab-selected');
    if (typeof a2lixLocaleTabSelected != 'undefined') {
        //$('.a2lix-locale-tab[data-locale=' + a2lixLocaleTabSelected+ ']').click();
    }

    $('.a2lix-locale-tab').on('click', function() {
        var locale = $(this).attr('data-locale');
        $.cookie('a2lix-locale-tab-selected', locale);
    });
    
    $('#form-submit-bottom-btn').click(function() {
        $('.btn-form-save').click();
    });
    //open

    //SAVE selected category number
    $('.admin-menu-category').click(function() {
        $('.admin-menu-category').removeClass('selected-category').removeClass('open');
        $.cookie('admin-menu-category', $(this).attr('data-index'), { path: '/admin' });
    })

    $('.admin-menu .dropdown').on('hidden.bs.dropdown', function (e) {
        $('.admin-menu-category').removeClass('selected-category');
        $('.admin-menu-category[data-index=' +$(this).attr('data-index')+ ']').addClass('selected-category');
        return false;
    });

    //active menu category
    $('.admin-menu-category').removeClass('selected-category');
    $('.admin-menu-category[data-index=' +$.cookie('admin-menu-category')+ ']').addClass('selected-category');

    //active tab panel
    $('.form-nav-tabs li a[data-tab=' +$.cookie('form-tab-selected')+ ']').tab('show');
    $('.form-nav-tabs li a[data-tab=' +$.cookie('form-tab-selected')+ ']').append('<div class="selected"></div>');

    //SAVE selected table panel && VALIDATION
    $('.form-nav-tabs li').click(function() {
        /*var prevTabSelected = '#'+ $.cookie('form-tab-selected');
         if ($(prevTabSelected+' input').jqBootstrapValidation("hasErrors")) {
         bootbox.alert('<h2>Uzupełnij pola formularza zgodnie z wyświetlanymi komunikatami</h2>');
         return false;
         }*/
        $('.form-nav-tabs > li > a > .selected').hide();
        $(this).find('a').append('<div class="selected"></div>');
        $.cookie('form-tab-selected', $(this).find('a').attr('data-tab'));
    })


    //Go to tab BTn
    $('.go-to-tab-btn').click(function() {
        $('a[data-toggle=tab][data-tab=' +$(this).attr('data-tab')+ ']').click();
    });

    //logout btn click and confirm action
    $('.logout-btn').click(function(e) {
        var href = $(this).attr('href');
        bootbox.dialog({
            message: "Czy na pewno chcesz się wylogować ?",
            title: "&nbsp;",
            buttons: {
                no: {
                    label: "Nie",
                    className: "btn-danger",
                    callback: function() {
                        e.preventDefault();
                    }
                },
                yes: {
                    label: "Tak",
                    className: "btn-success",
                    callback: function() {
                        window.location.href = href;
                    }
                }
            }
        })
        e.preventDefault();
    });

    //remove btn confirmation
    $('.btn-remove').on('click',function (e) {
        var href = $(this).attr('href');
        bootbox.dialog({
            message: "Usunąć wybrany rekord ?",
            title: "&nbsp;",
            buttons: {
                no: {
                    label: "Nie",
                    className: "btn-danger",
                    callback: function() {
                        e.preventDefault();
                    }
                },
                yes: {
                    label: "Tak",
                    className: "btn-success",
                    callback: function() {
                        window.location.href = href;
                    }
                }
            }
        })
        e.preventDefault();
    })
    
    
    
});