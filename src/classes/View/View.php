<?php
namespace M151\View;

use M151\TemplateEngine;

abstract class View
{
    protected $view;

    public function __construct($subfolder)
    {
        $this->view = TemplateEngine::getInstance();
        $this->view = $this->view->smarty;
        $templateDirs = $this->view->getTemplateDir();
        $numbersOfTemplateDirs = count($templateDirs);
        if($numbersOfTemplateDirs > 0)
        {
           if($numbersOfTemplateDirs == 1)
           {
               $this->templateDir = $templateDirs[0].$subfolder;
           }
           else
           {
               // doesn't support more than one directory per view class
           }
        }
        else
        {
            $this->view->show_error_message(
                "config error",
                "es wurde kein Templateordner gefunden",
                "Konfigurationsfehler:",
                "Wenden Sie sich an den Administrator"
            );
        }
    }
}