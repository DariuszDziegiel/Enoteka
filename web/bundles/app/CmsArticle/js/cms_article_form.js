$(document).ready(function() {

    //Event date
    $('body').on('focus', '#cms_article_date, #cms_article_createdAt', function (e) {
        e.preventDefault();
        $(this).datepicker({
            dateFormat: 'yy-mm-dd',
            //minDate: 0,
            //changeYear: true, changeMonth: true, minDate: 0,
        });
    })


    $('.uploadify-files-wrapper, .document-files-wrapper').on('click', '.remove-file-btn', function () {
        var fileId = $(this).data('file-id');
        bootbox.confirm(Translator.trans('msg.file_remove_confirm'), function(result) {
            if (!result) {
                return;
            }
            LoaderBg.add('body', 'Trwa kasowanie pliku');
            $.ajax({
                method: 'GET',
                url: Routing.generate('cms_article_file_remove', {id: fileId}),
                dataType: 'json'
            })
                .done(function(data) {
                    if (data.success) {
                        $('.uploadify-file[data-file-id=' + fileId + ']').fadeOut();
                    } else {
                        alert(Translator.trans('msg.file_remove_error'));
                    }
                    LoaderBg.remove();
                })
                .fail(function() {
                    alert(Translator.trans('msg.file_remove_error'));
                    LoaderBg.remove();
                });
        });
    })







});