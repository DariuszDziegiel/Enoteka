var APP_RESERVATION_BAR = {
    currentScrollTop: $(window).scrollTop(),
    
    init: function () {
        APP_RESERVATION_BAR.scrollPositionControl(this.currentScrollTop);
        this.onScroll();
    },
    
    onScroll: function () {
        $(window).scroll(function () {
            var currentScrollTop = $(window).scrollTop();
            APP_RESERVATION_BAR.scrollPositionControl(currentScrollTop);
        });
    },

    scrollPositionControl: function (currentScrollTop) {
        if (currentScrollTop) {
            $('.reservation-bar').css('position', 'fixed').animate({
                bottom: '0',
                left: '0',
                right: '0'
            }, 1)
        } else {
            $('.reservation-bar').css('position', 'absolute').animate({
                bottom: '0px',
                left: '0',
                right: '0'
            }, 1)
        }
    }


}