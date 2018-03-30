// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};


$(document).ready(function() {

    var $collectionHolder;
    var $newLinkLi = $('<div></div>');
    // Get the ul that holds the collection of forms
    $collectionHolder = $('.base-room-formulas-wrapper');
    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $('#base-room-formula-add-btn').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        // add a new tag form (see next code block)
        addFormulaForm($collectionHolder, $newLinkLi);
    });

    function addFormulaForm($collectionHolder, $newLinkLi) {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormDiv = $('<div class="form-group new-formula-wrapper"></div>').append(newForm);
        // also add a remove button, just for this example
        $newFormDiv.append('<button type="button" class="btn btn-sm btn-danger remove-formula pull-right" >' +
            '<span class="glyphicon glyphicon-remove"></span> Usuń' +
            '</button>');
        $newFormDiv.append('<hr />');
        $newLinkLi.before($newFormDiv);
    }

    $collectionHolder.on('click', '.remove-formula', function(e) {
        e.preventDefault();
        if (!confirm('Usunąć wybrany wzór ?')) {
            return;
        }
        $(this).closest('.form-group').remove();
        return false;
    });

    
    $('.uploadify-files-wrapper, .document-files-wrapper').on('click', '.remove-file-btn', function () {
        var fileId = $(this).data('file-id');
        bootbox.confirm(Translator.trans('msg.file_remove_confirm'), function(result) {
            if (!result) {
                return;
            }
            LoaderBg.add('body', 'Trwa kasowanie pliku');
            $.ajax({
                method: 'GET',
                url: Routing.generate('rs_room_file_remove', {id: fileId}),
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
                url: Routing.generate('rs_room_file_sort'),
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