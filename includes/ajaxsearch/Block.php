<?php
namespace ajaxsearch;

use tad\wrappers\headway\BlockSettings as Settings;
use tad\wrappers\ThemeSupport;
use tad\utils\Script;
use tad\utils\JsObject;
use chen\SimpleHtmlDom;

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


    public static function enqueue_action($block_id, $block, $original_block = null)
    {
        $settings = new Settings($block);
        if (!$settings->activateAjax) {
            return;
        }
        $handle = 'ajaxSearch';
        $src = Script::suffix(AJAXSEARCH_BLOCK_URL . 'assets/js/ajax_search.js');
        $deps = array('jquery-ajaxifySubmit');
        wp_enqueue_script($handle, $src, $deps);
        // retrieve this block settings
        if ($original_block) {
            $block = $original_block;
        }
        // print the options object to the page
        if (!$settings->data) {
            return;
        }
        $objectName = 'ajaxSearchOptions' . $block_id;
        JsObject::on($settings->data)->localize($handle, $objectName);
    }


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
        $f = function($form) use($id) {
            if(!$id) {
                return;
            }
            $rep = sprintf('$1 data-block-id="%d"', $id);
            return preg_replace("/(<form)/uis", $rep, $form);
        };

        // the function will set the labels, submit texts, and placeholder
        $settings= Settings::on($block);
        $g = function($form) use($settings){
            $html = SimpleHtmlDom::on($form);
            if ($settings->labelText) {
                $var = $html->find('label', 0)->innertext = $settings->labelText;
            }
            if ($settings->placeholderText) {
                $var = $html->find('input[type="text"]', 0)->placeholder = $settings->placeholderText;
            }
            if ($settings->submitText) {
                $var = $html->find('input[type="submit"]', 0)->value = $settings->submitText;
            }
            return $html->save();
        };
        add_filter('get_search_form', $f);
        add_filter('get_search_form', $g);
        get_search_form();
        // restore the filter after that
        remove_filter( 'get_search_form', $f );
        remove_filter( 'get_search_form', $g );
        add_filter('get_search_form', array('HeadwayWidgets', 'search_form'), 10);
    }
}