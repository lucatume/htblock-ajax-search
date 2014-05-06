<?php
namespace ajaxsearch;

use tad\wrappers\headway\BlockSettings as Settings;
use tad\wrappers\ThemeSupport;

class Block extends \HeadwayBlockAPI {

    public $id = 'ajaxsearch';
    public $name = 'Headway Block - AJAX search';
    public $options_class = '\ajaxsearch\BlockOptions';
    public $description = 'AJAX-powered Headway themes search block.';

    public static function init_action($block_id, $block) 
    {
        // maybe add HTML5 search form support
        $enable5 = Settings::on($block)->enableHtml5;
        if ($enable5) {
            ThemeSupport::addSupport('html5', array('search-form'));
        }
    }


    // public static function enqueue_action($block_id, $block, $original_block = null)
    // {

    // }


    // public static function dynamic_css($block_id, $block, $original_block = null)
    // {

    // }


    // public static function dynamic_js($block_id, $block, $original_block = null)
    // {

    // }

    // public function setup_elements() {
    //     $this->register_block_element(array(
    //         'id' => 'element1-id',
    //         'name' => 'Element 1 Name',
    //         'selector' => '.my-selector1',
    //         'properties' => array('property1', 'property2', 'property3'),
    //         'states' => array(
    //             'Selected' => '.my-selector1.selected',
    //             'Hover' => '.my-selector1:hover',
    //             'Clicked' => '.my-selector1:active'
    //             )
    //         ));
    // }

    public function content($block) {
        // deactivate Headway Widget filter to avoid
        // inline JS events
        remove_filter('get_search_form', array('HeadwayWidgets', 'search_form'), 10);
        // add a filter to append a custom data to this specific search form
        $id = $block['id'];
        add_filter('get_search_form', function($form) use($id) {
            if(!$id) {
                return;
            }
            $rep = sprintf('$1 data-blockId="%d"', $id);
            return preg_replace("/(<form)/uis", $rep, $form);
        });
        get_search_form();
        // restore the filter after that
        add_filter('get_search_form', array('HeadwayWidgets', 'search_form'), 10);
    }
}