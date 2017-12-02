<?php
namespace M151\Controller;

use M151\Http\Request;
use M151\Application;
use M151\Model\AccountModel;

class ManageController extends Controller
{
    public function manage_home()
    {
        $this->session->refresh();
        if($this->session->isLoggedIn() && $this->session->isAdmin())
        {
            $content = array(
                
            );
            $this->view->smarty->assign();
            $this->view->smarty->display();
        }
        else
        {
            // user is not admin
            $this->redirect_to("home");
        }
    }
}