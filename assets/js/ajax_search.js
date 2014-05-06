/**
 * Headway Block - AJAX search
 * http://theaveragedev.com
 *
 * Copyright (c) 2014 theAverageDev (Luca Tumedei)
 * Licensed under the GPLv2+ license.
 */

jQuery(document).ready(function($) {
    // create a default options object
    var defaults = {
        loadFromSelector: '.block-type-content .block-content',
        loadToSelector: '.block-type-content'
    }, searchForm = $('form.searchform');
    // bootstrap the plugin on the block 
    searchForm.each(function() {
        var $this = $(this),
            id = $this.data('block-id'),
            options;
        // grab the specific options object
        options = window['ajaxSearchOptions' + id];
        if (!options) {
            options = defaults;
        } else {
            options = $.extend(defaults, options);
        }
        // bootstrap the ajaxifySubmit plugin for this searchform
        $this.ajaxifySubmit(options);
    });
});