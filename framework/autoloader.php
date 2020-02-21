<?php

namespace Arcanebox;

class Autoloader
{
    public $configs_loaded, $models_loaded, $views_catalog, $layouts_catalog;

    public function __construct() {

        $this->loadInterfaces();
        $this->loadAbstracts();
        $this->loadConfigs();
        $this->loadControllers();
        $this->loadModels();
        $this->catalogLayouts();
        $this->catalogViews();

    }

    public function loadConfigs()
    {

        $this->configs_loaded = array();
        $configs_load = opendir(__DIR__."/configs");

        while ($config = readdir($configs_load)) {

            if (substr($config, -4) === '.php') {

                include_once __DIR__.'/configs/'.$config;

                $config_classname = '\Arcanebox\configs\\'.substr($config, 0, -4);
                $config_entrance = new $config_classname;
                $config_initialization = $config_entrance->initialization();
                $this->configs_loaded[substr($config_classname, 19)] = $config_initialization;

            }

        }

        closedir($configs_load);
    }

    public function loadAbstracts()
    {

        $abstracts_load = opendir(__DIR__."/lib/patterns/abstracts");

        while ($abstract = readdir($abstracts_load)) {

            if (substr($abstract, -12) === 'Abstract.php') {

                include_once __DIR__.'/lib/patterns/abstracts/'.$abstract;

            }

        }

        closedir($abstracts_load);
    }

    public function loadInterfaces()
    {
        
        $interfaces_load = opendir(__DIR__."/lib/patterns/interfaces");

        while ($interface = readdir($interfaces_load)) {

            if (substr($interface, -13) === 'Interface.php') {

                include_once __DIR__.'/lib/patterns/interfaces/'.$interface;

            }

        }

        closedir($interfaces_load);

    }

    public function loadControllers()
    {

        $controllers_load = opendir(__DIR__."/controllers");

        while ($controller = readdir($controllers_load)) {

            if (substr($controller, -14) === 'Controller.php') {

                include_once __DIR__.'/controllers/'.$controller;

            }

        }

        closedir($controllers_load);

    }

    public function loadModels()
    {

        $this->models_loaded = array();

        $models_load = opendir(__DIR__."/models");

        while ($model = readdir($models_load)) {

            if (substr($model, -4) === '.php') {

                include_once __DIR__.'/models/'.$model;

                $model_name = substr($model, 0, -4);

                $this->models_loaded[$model_name] = '/views/'.$model_name.'/';

            }

        }

        closedir($models_load);

    }

    public function catalogViews()
    {

        if (!(isset($models_loaded))) {

            $this->loadModels();

        }

        $this->views_catalog = array();

        $models = array_keys($this->models_loaded);

        for ($i = 0; $i < count($models); $i++) {

            $model_name = $models[$i];

            $model_views = array();

            $views_scan = opendir(__DIR__.$this->models_loaded[$model_name]);

            while ($view = readdir($views_scan)) {

                if (substr($view, -4) === '.php') {

                    $model_views[substr($view, 0, -4)] = $this->models_loaded[$model_name].$view;

                }

            }

            closedir($views_scan);

            $this->views_catalog[$model_name] = $model_views;

        }

    }

    public function catalogLayouts()
    {

        $this->layouts_catalog = array();

        $layouts_scan = opendir(__DIR__."/layouts");

        while ($layout = readdir($layouts_scan)) {

            if (substr($layout, -10) === 'Layout.php') {

                $this->layouts_catalog[substr($layout, 0, -10)] = '/layouts/'.$layout;

            }

        }

        closedir($layouts_scan);

    }

}
