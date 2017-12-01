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
    
    public function show_register_form()
    {
        $content = array(
            'title' => 'Registrieren',
            'page_title' => 'Ferienpass-Konto erstellen',
        );
        TemplateEngine::getInstance()->smarty->assign($content);
        TemplateEngine::getInstance()->smarty->display('register_form.html');        
    }
    
    public function show_error_message($page_title, $h1, $alert_title, $alert_body)
    {
        $content = array(
            'page_title' => "{$page_title}",
            'h1' => "{$h1}",
            'alert_title' => "{$alert_title}",
            'alert_body' => "{$alert_body}"
        );
        $this->smarty->assign($content);
        $this->smarty->display('error_message.html');
    }
}