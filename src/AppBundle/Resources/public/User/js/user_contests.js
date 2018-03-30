$(document).ready(function () {

    $("img.lazy").lazyload({
        effect: 'fadeIn'
    });

    $('[data-toggle="tooltip"]').tooltip({
        html: true
    });

    //Countdown
    $('.contest-time-left').each(function (elem) {
        $(this).countdown($(this).data('contest-date-to'), function(event) {
            if (event.elapsed) {
                $(this).html('<b class="bg-danger">Zakończony</b>');
            } else {
                if (!event.offset.totalDays) {
                    $(this).text(event.strftime('%-Hh:%-Mm:%Ss'));
                } else {
                    $(this).text(event.strftime('%-D dni %-Hh:%-Mm:%Ss'));
                }
            }
        })
            .on('update.countdown', function (event) {
                if (!event.offset.totalDays) {
                    $(this).text(
                        event.strftime('%-Hh:%-Mm:%Ss')
                    );
                }
                //Red time color if less than 24 hours left
                if (!event.offset.totalDays && event.offset.totalHours < 24) {
                    $(this).addClass('text-danger');
                }
            })
            .on('finish.countdown', function (event) {
                $(this).html('<b>Zakończony</b>');
            });
    })


    $('.arena-contest-participations').magnificPopup({
        delegate: 'a.image-href',
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    $('.contest-winner').magnificPopup({
        delegate: 'a',
        type: 'image'
    });
    

})