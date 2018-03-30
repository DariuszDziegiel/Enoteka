$(document).ready(function() {
    
    $('.cms-slider-delete-btn').on('click', function (e) {
    
        if (!confirm('Czy na pewno usunąć wybrany obraz?')) {
            return false;
            e.preventDefault();
        }
        
    })

    
})