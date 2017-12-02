<?php
namespace M151\Controller;

class LogoutController extends Controller
{
    public function logout()
    {
        $this->session->logout();
        $this->redirect_to("home");
    }
}