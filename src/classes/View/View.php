<?php
namespace M151\View;

use M151\TemplateEngine;

class View
{
    protected $view;

    public function __construct()
    {
        $this->view = TemplateEngine::getInstance();
        $this->view = $this->view->smarty;
    }
}