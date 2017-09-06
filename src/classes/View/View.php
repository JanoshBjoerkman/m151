<?php
namespace M151\View;

class View {
    protected $_data = [];
    protected $_viewFile = null;

    public $contentType = 'text/html';

    public function __construct($viewFile) 
    {
        $this->_viewFile = $viewFile;
    }

    public function assign($key, $value) 
    {
        $this->_data[$key] = $value;
    }

    public function render()
     {
        header('Content-Type: '.$this->contentType);
        echo $this->fetch();
    }

    public function fetch() 
    {
        $path = realpath(__DIR__.'/../../views');
        $file = realpath($path.'/'.$this->_viewFile);
        if (!file_exists($file)) 
        {
            throw new \Exception('View file not found: '.$file.' in '.$path);
        }
        extract($this->_data);
        ob_start();
        include($file);
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }
}

