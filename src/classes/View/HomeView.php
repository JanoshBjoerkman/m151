<?php
namespace M151\View;

class HomeView extends View
{
    public function show_home($content)
    {
        $this->view->assign($content);
        $this->view->display('home.html');
    }

    public function show_entry_point($content)
    {
        $this->view->assign($content);
        $this->view->display('entry_point.html');
    }
}