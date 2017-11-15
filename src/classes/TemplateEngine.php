<?php 

namespace M151;

class TemplateEngine
{
    private static $_inst;

    public $smarty = null;

    private function __construct()
    {
        $this->smarty = new \Smarty();
        $this->loadConfig();
    }

    private function loadConfig()
    {
        $this->smarty->setTemplateDir(dirname(__FILE__).'/../engine/templates/');
        $this->smarty->setCompileDir(dirname(__FILE__).'/../engine/templates_c');
        $this->smarty->setConfigDir(dirname(__FILE__).'/../engine/configs/');
        $this->smarty->setCacheDir(dirname(__FILE__).'/../engine/cache/');
    }

    public static function getInstance()
    {
        if(!static::$_inst)
        {
            static::$_inst = new TemplateEngine();
        }
        return static::$_inst;
    }
}