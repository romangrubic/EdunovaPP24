<?php

class PolaznikController extends AutorizacijaController
{
    private $viewDir='privatno' . DIRECTORY_SEPARATOR . 'polaznik' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index');
    }
}