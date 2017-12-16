<?php
namespace M151\Controller;

use M151\Http\Request;

class ResourceController extends Controller
{
    protected $PATH_JS;

    public function __construct()
    {
        $this->PATH_JS = dirname(__DIR__)."../../js/";
        parent::__construct();
    }

    public function admin_js()
    {
        $this->session->refresh();
        if($this->adminAndLoggedInCheck())
        {
            header("Content-type: text/javascript");
            readfile($this->PATH_JS."admin_script.js"); 
        }
    }
}