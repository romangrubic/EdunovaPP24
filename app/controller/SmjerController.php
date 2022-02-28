<?php

class SmjerController extends AutorizacijaController
{
    // Putanja do phtml datoteke
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'smjer' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'smjerovi'=>Smjer::read(),
            'css'=> '<link rel="stylesheet" href="' . App::config('url') . 'public/css/smjerindex.css">'
        ]);
    }
}