// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};


$(document).ready(function() {

    $('.uploadify-files-wrapper, .document-files-wrapper').on('click', '.remove-file-btn', function () {
        var fileId = $(this).data('file-id');
        bootbox.confirm(Translator.trans('msg.file_remove_confirm'), function(result) {
            if (!result) {
                return;
            }
            LoaderBg.add('body', 'Trwa kasowanie pliku');
            $.ajax({
                method: 'GET',
                url: Routing.generate('cms_static_page_file_remove', {id: fileId}),
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



    //sort cms article images
    $('.uploadify-files-wrapper').sortable({
        helper: fixHelper,
        //placeholder: "ui-state-highlight",
        update : function () {
            serial = $(this).sortable('serialize');
            LoaderBg.add('body', 'Trwa zmiana kolejności');
            $.ajax({
                url: Routing.generate('cms_static_page_file_sort'),
                type: "POST",
                dataType: 'json',
                data:  {
                    serial: serial
                },
                error: function(){
                    LoaderBg.remove();
                    bootbox.alert("Bład sortowania");
                },
                success:function(){
                    LoaderBg.remove();
                    bootbox.alert('Kolejność została zmieniona');
                    //$('#ajax_refresh_and_loading').click();
                }
            });
        }
    });

    





});