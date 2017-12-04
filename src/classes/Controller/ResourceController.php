<?php
namespace M151\Controller;

use M151\Http\Request;

class ResourceController extends Controller
{
    protected $PATH_JS;

    public function __construct()
    {
        $this->PATH_JS = dirname(__DIR__)."../../js/";
    }

    public function own_js()
    {
        header("Content-type: text/javascript");
        readfile($this->PATH_JS."script.js"); 
    }
}