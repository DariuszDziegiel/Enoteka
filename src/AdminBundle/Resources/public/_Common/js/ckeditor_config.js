/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here.
    // For complete reference see:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config
    config.entities = false;
    config.language = 'pl';
    //config.uiColor = '#AADC6E';
    config.width = '100%';
    config.removePlugins = 'find,forms,iframe';
    config.extraPlugins = 'autogrow,tableresize,justify,embed,font,btgrid';
    config.extraAllowedContent = 'audio[*]';
    config.enterMode = CKEDITOR.ENTER_BR;
    config.fontSize_sizes = '80%;90%;100%;110%;120%;130%;140%;150%;160%;170%;180%;190%;200%';
    config.fontSize_defaultLabel = '100%';
    config.autoGrow_onStartup = true;
    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
        { name: 'clipboard',   groups: [ 'clipboard', 'undo'] },
        { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
        { name: 'links' },
        { name: 'insert' },
        { name: 'forms' },
        { name: 'tools' },
        { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'others' },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'styles' },
        { name: 'colors' },
        { name: 'about' }
    ];
    
    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    config.removeButtons = 'Table,Subscript,Superscript,Font,Styles,Indent,Outdent';
    // Set the most common block elements.
    config.format_tags = 'p;h2;h3;h4;h5;h6';

    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';
};