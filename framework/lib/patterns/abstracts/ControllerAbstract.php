<?php

namespace Arcanebox\lib\patterns\abstracts;

use Arcanebox\lib\patterns\interfaces\ControllerInterface;

abstract class ControllerAbstract implements ControllerInterface
{

    public $configs, $views, $layouts, $layout_actual, $language_set;

    public function __construct($action, $language)
    {

    	global $autoload;

        $this->configs = $autoload->configs_loaded;
        $this->layouts = $autoload->layouts_catalog;
        $this->views = $autoload->views_catalog;
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

    private function get_title($view)
    {

        $view_data = file_get_contents($view);
        $explode = explode('?>', $view_data, 2);
        $code = substr($explode['0'], 5);

        $code = trim($code);

        if (substr($code, 0, 6) == '$title') {

            $explode_code = explode('=', $code);

            $title = trim($explode_code['1']);

            if (substr($title, -1, 1) == ';') $title = substr($title, 0, -1);

            $title = trim($title, "'\"");

        } else $title = 'Arcanebox';

        return $title;

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
