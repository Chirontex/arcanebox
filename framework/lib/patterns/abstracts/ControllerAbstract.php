<?php

namespace Arcanebox\lib\patterns\abstracts;

use Arcanebox\lib\patterns\interfaces\ControllerInterface;

abstract class ControllerAbstract implements ControllerInterface
{

    public $configs, $views, $layouts, $layout_actual, $language_set;

    public function __construct($action, $language)
    {

        $this->configs = $GLOBALS['autoload']->configs_loaded;
        $this->layouts = $GLOBALS['autoload']->layouts_catalog;
        $this->views = $GLOBALS['autoload']->views_catalog;
        $this->layout_actual = $this->chooseLayout();
        $this->language_set = $language;

        if (method_exists($this, $action)) $this->$action();
        else $this->not_found();

    }

    public function chooseLayout()
    {

        return 'Hello';

    }

    public function render($aspects)
    {
        
        if (!(isset($aspects['layout']))) $aspects['layout'] = $this->layout_actual;

        $view_path_original = $this->views[$aspects['layout']][$aspects['view']];

        if ($this->language_set === 'default') {

            $language = '';
            $view_path = $view_path_original;

        } else {

            $language = $this->language_set;
            $view_filename_length = iconv_strlen($aspects['view']) + 4;
            $view_path = substr($view_path_original, 0, -$view_filename_length).$language.'/'.substr($view_path_original, -$view_filename_length);

        }

        if (isset($this->layouts[$language.$this->layout_actual])) $layout_name = $language.$this->layout_actual;
        else $layout_name = $this->layout_actual;

        $view = $this->configs['Domain']['framework_folder'].$view_path;

        if (!(file_exists($view))) $view = $this->configs['Domain']['framework_folder'].$view_path_original;

        include_once $this->configs['Domain']['framework_folder'].$this->layouts[$layout_name];

    }

    public function index()
    {

        $this->render([
            'view' => 'index'
        ]);

    }

    public function not_found()
    {

        $this->render([
            'view' => 'not_found'
        ]);

    }

}
