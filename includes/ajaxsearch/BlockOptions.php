<?php
namespace ajaxsearch;

    class BlockOptions extends \HeadwayBlockOptionsAPI {

  public $tabs = array(
        'ajax-settings' => 'AJAX Settings',
        'style-settings' => 'Styling'
        );

    public $inputs = array(

        'ajax-settings' => array(

            'selectors-title' => array(
                'type' => 'heading',
                'name' => 'selectors-title',
                'label' => 'Content Selectors'
                ),

            'selectors-notice' => array(
                'type' => 'notice',
                'name' => 'selectors-notice',
                'notice' => 'Use jQuery selectors syntax here, e.g. "#someSelector > .someOtherSelector"'
                ),

            'load_from_selector' => array(
                'type' => 'textarea',
                'name' => 'load_from_selector',
                'label' => 'loadFrom selector',
                'tooltip' => 'This selector and its content will be loaded in the destination.',
                'default' => '.block-type-content .block-content'
                ),

            'load_to_selector' => array(
                'type' => 'textarea',
                'name' => 'load_to_selector',
                'label' => 'loadTo selector',
                'tooltip' => 'This selector will have its content replaced with the new one.',
                'default' => '.block-type-content'
                ),

            'get_query_from_selector' => array(
                'type' => 'textarea',
                'name' => 'get_query_from_selector',
                'label' => 'Input field selector',
                'tooltip' => 'The jQuery selector to the input used to enter the search terms.',
                'default' => 'input[type="text"]'
                ),

            'query-params-title' => array(
                'type' => 'heading',
                'name' => 'query-params-title',
                'label' => 'Search query parameters'
                ),

            'query-params-notice' => array(
                'type' => 'notice',
                'name' => 'query-params-notice',
                'notice' => 'The block will use WordPress defaults but you are free to adapt these parameters to your needs'
                ),

            'query_separator' => array(
                'type' => 'text',
                'name' => 'query_separator',
                'label' => 'Query separator string',
                'default' => '+'
                ),

            'query_pathname' => array(
                'type' => 'text',
                'name' => 'query_pathname',
                'label' => 'Query pathname',
                'default' => '/?s=',
                'tooltip' => 'The pathname that will be appended to the url to trigger a search',
                ),

            'deep_link' => array(
                'type' => 'checkbox',
                'name' => 'deep_link',
                'label' => 'Allow deep linking',
                'default' => 'true',
                'tooltip' => 'The search url will be saved in the browser history to allow for sharing and later linking',
                ),

            'field-behaviour-title' => array(
                'type' => 'heading',
                'name' => 'field-behaviour-title',
                'label' => 'Search field behaviour'
                ),

            'clear_on_focus' => array(
                'type' => 'checkbox',
                'name' => 'clear_on_focus',
                'label' => 'Clear on focus',
                'default' => 'true',
                'tooltip' => 'The search field will be emptied whenever the user focuses on it',
                ),

            'restor_placeholder_on_blur' => array(
                'type' => 'checkbox',
                'name' => 'restor_placeholder_on_blur',
                'label' => 'Restore placeholder on blur',
                'default' => 'true',
                'tooltip' => 'The search field placeholder will be restored whenever the user moves his focus elsewhere',
                ),

            'live_search' => array(
                'type' => 'checkbox',
                'name' => 'live_search',
                'label' => 'Enable live search',
                'default' => 'true',
                'tooltip' => 'Whenever the user enters more than some chars search will start',
                'toggle' => array(
                    'true' => array(
                        'show' => array('#input-live_search_chars')
                        ),
                    'false' => array(
                        'hide' => array('#input-live_search_chars')
                        )
                    )
                ),

            'live_search_chars' => array(
                'type' => 'integer',
                'name' => 'live_search_chars',
                'label' => 'Live search threshold',
                'default' => '3',
                'tooltip' => 'How many chars will trigger the live search',
                ),

            'callbacks-title' => array(
                'type' => 'heading',
                'name' => 'callbacks-title',
                'label' => 'Callback functions'
                ),

            'callbacks-notice' => array(
                'type' => 'notice',
                'name' => 'callbacks-notice',
                'notice' => 'The block will allow callback functions to be called during its execution. Use JavaScript syntax here, jQuery is available'
                ),

            'submit_clicked' => array(
                'type' => 'textarea',
                'name' => 'submit_clicked',
                'label' => 'submitClicked callback function',
                'tooltip' => 'Either the user clicked the submit input or pressed enter',
                'default' => 'function(evt){}'
                ),

            'before_load' => array(
                'type' => 'textarea',
                'name' => 'before_load',
                'label' => 'beforeLoad callback function',
                'tooltip' => 'An internal link has been clicked, do something before new content is loaded.',
                'default' => 'function($context, $contentArea, oldContent){}'
                ),
            'after_load' => array(
                'type' => 'textarea',
                'name' => 'after_load',
                'label' => 'afterLoad callback function',
                'tooltip' => 'An internal link has been clicked and the new content has been loaded.',
                'default' => 'function($context, $contentArea, newContent){}'
                ),
            'after_fail' => array(
                'type' => 'textarea',
                'name' => 'after_fail',
                'label' => 'afterFail callback function',
                'tooltip' => 'An internal link has been clicked but the content failed to load.',
                'default' => 'function($context, $contentArea, oldContent){}'
                ),
            'on_focus' => array(
                'type' => 'textarea',
                'name' => 'on_focus',
                'label' => 'onFocus callback function',
                'tooltip' => 'The user did focus on the input field',
                'default' => 'function($context, $contentArea, oldContent){}'
                ),
            'on_blur' => array(
                'type' => 'textarea',
                'name' => 'on_blur',
                'label' => 'onBlur callback function',
                'tooltip' => 'The user did remove his focus from the input field',
                'default' => 'function($context, $contentArea, oldContent){}'
                ),
            ),
        'style-settings' => array(
            'queue_default_style' => array(
                'type' => 'checkbox',
                'name' => 'queue_default_style',
                'label' => 'Use default menu style',
                'default' => 'true'
                )
            )
);
    }