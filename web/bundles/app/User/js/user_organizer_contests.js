$(document).ready(function () {

    
    $('.contest-winner-select-btn').on('click', function (e) {
        if (!confirm("Czy na pewno wybrać zwycięski projekt?")) {
            e.preventDefault();
            return false;
        }
    })

})